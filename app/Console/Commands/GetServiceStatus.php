<?php

namespace App\Console\Commands;

use App\Service;
use App\ServiceStatus;
use Illuminate\Console\Command;

class GetServiceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-status:get';
    protected $client;

    const LOCK_NAME = 'ServiceStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the latest service status updates';

    protected function getLock()
    {
        $lockId = uniqid('LOCK_' . time() . '_');
        $currentLockId = \Cache::get(self::LOCK_NAME . '_LOCK_ID', $lockId);

        if ($lockId === $currentLockId) {
            \Cache::forever(self::LOCK_NAME . '_LOCK_ID', $lockId);
            return $lockId;
        } else {
            return null;
        }
    }

    protected function releaseLock($lock)
    {
        \Cache::forget(self::LOCK_NAME . '_LOCK_ID');
    }

    public function handle()
    {
        $lock = $this->getLock();
        if ($lock === null) {
            $this->warn('Another run is in progress, you cannot run two at once');
            return;
        }

        /** @var Service[] $services */
        $services = Service::whereActive(true)->get();

        foreach ($services as $service) {
            $this->info('Getting status for ' . $service->name);

            $lastUpdate = $service->last_update();
            if ($lastUpdate == null) {
                $lastUpdate = $service->createInitialUpdate();
            }

            $this->info('Current status is ' . $lastUpdate->service_status->status);

            $newUpdate = $service->determineServiceUpdate();

            if ($newUpdate->service_status->status !== $lastUpdate->service_status->status) {
                $newUpdate->service_status()->associate($this->setStatus($lastUpdate->service_status->status,
                    $newUpdate->service_status->status));
                $newUpdate->save();
                $this->info('Status for ' . $service->name . ' set to ' . $newUpdate->service_status->status);
            } else {
                $lastUpdate->addToHistory();
                $lastUpdate->response_time = $newUpdate->response_time;
                $newUpdate->delete();
                $lastUpdate->save();
                $this->info('Status for ' . $service->name . ' unchanged');
            }

        }

        $this->releaseLock($lock);
    }

    /**
     * @param string $existing
     * @param string $new
     * @return ServiceStatus
     */
    protected function setStatus($existing, $new)
    {
        $upStatuses = [ServiceStatus::STATUS_UP, ServiceStatus::STATUS_SLOW, ServiceStatus::STATUS_VSLOW];
        $existingUp = in_array($existing, $upStatuses);
        $newUp = in_array($new, $upStatuses);
        if ($existingUp && $new == ServiceStatus::STATUS_DOWN) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_FAILING)->firstOrFail();
        }
        if ($existing == ServiceStatus::STATUS_FAILING && $newUp) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_RECOVERING)->firstOrFail();
        }
        if ($existing == ServiceStatus::STATUS_DOWN && $newUp) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_RECOVERING)->firstOrFail();
        }
        if ($existing == ServiceStatus::STATUS_RECOVERING && $new == ServiceStatus::STATUS_DOWN) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_FAILING)->firstOrFail();
        }
        return ServiceStatus::whereStatus($new)->firstOrFail();
    }
}
