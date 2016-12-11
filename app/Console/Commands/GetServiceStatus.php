<?php

namespace App\Console\Commands;

use App\Service;
use App\ServiceStatus;
use App\ServiceUpdate;
use Illuminate\Console\Command;

class GetServiceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-status:get';

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
            $newUpdate = $service->determineServiceUpdate();

            if ($newUpdate->service_status !== $lastUpdate->service_status) {
                $newUpdate->service_status()->associate($this->setStatus($lastUpdate->service_status->status, $newUpdate->service_status->status));
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
        if ($existing == ServiceStatus::STATUS_UP && $new == ServiceStatus::STATUS_DOWN) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_FAILING)->firstOrFail();
        }
        if ($existing == ServiceStatus::STATUS_FAILING && $new == ServiceStatus::STATUS_UP) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_RECOVERING)->firstOrFail();
        }
        if ($existing == ServiceStatus::STATUS_DOWN && $new == ServiceStatus::STATUS_UP) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_RECOVERING)->firstOrFail();
        }
        if ($existing == ServiceStatus::STATUS_RECOVERING && $new == ServiceStatus::STATUS_DOWN) {
            return ServiceStatus::whereStatus(ServiceStatus::STATUS_FAILING)->firstOrFail();
        }
        return ServiceStatus::whereStatus($new)->firstOrFail();
    }
}
