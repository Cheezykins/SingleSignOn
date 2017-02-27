<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UnlockServiceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-status:lock-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear a current lock if it exists';

    public function handle()
    {
        \Cache::forget(GetServiceStatus::LOCK_NAME . 'LOCK_ID');
        $this->info('Lock deleted');
    }
}
