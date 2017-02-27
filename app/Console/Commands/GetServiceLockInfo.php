<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetServiceLockInfo extends Command
{
    protected $signature = 'service-status:lock-info';

    protected $description = 'Gets details about the current lock if it exists';

    /**
     * Execute the console command
     */
    public function handle()
    {
        $lockId = \Cache::get(GetServiceStatus::LOCK_NAME . '_LOCK_ID');
        if ($lockId !== null) {
            $this->info('Locked: True');
            $this->info('Lock ID: ' . $lockId);
            list(, $dateTime) = explode('_', $lockId);
            $this->info('Lock Created: ' . date('d-M-Y H:i:s', $dateTime));
        } else {
            $this->info('Locked: False');
        }
    }
}
