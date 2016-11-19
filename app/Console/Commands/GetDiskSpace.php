<?php

namespace App\Console\Commands;

use App\Disk;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GetDiskSpace extends Command
{
    protected $signature = 'diskspace:get';

    protected $description = 'Gets disk space information from Talyn';

    protected $url;

    public function __construct()
    {
        $this->url = env('DISK_SPACE_URL') . '?apikey=' . env('DISK_SPACE_API_KEY');
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info('Getting data from ' . env('DISK_SPACE_URL'));

        $data = file_get_contents($this->url);
        $data = json_decode($data);

        foreach ($data as $diskData) {
            $this->info('Processing disk ' . $diskData->name);
            try {
                $this->info('Trying to find disk in database');
                $disk = Disk::wherePath($diskData->name)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $this->info('No disk found, creating new entry');
                $disk = new Disk();
                $disk->path = $diskData->name;
            }

            $disk->capacity = $diskData->total;
            $disk->free_space = $diskData->free;

            $disk->save();
            $this->info('Disk ' . $diskData->name . ' done');
        }

    }
}
