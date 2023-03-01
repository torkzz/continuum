<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class runTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this is to check if the task is running';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //

        Task::create([
            'name'=> "test running on cron"
        ]);
    }
}
