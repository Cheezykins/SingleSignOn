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

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the latest service status updates';

    public function handle()
    {
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
                $newUpdate->delete();
                $this->info('Status for ' . $service->name . ' unchanged');
            }


        }
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
