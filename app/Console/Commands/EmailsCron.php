<?php

namespace App\Console\Commands;

use App\Http\Controllers\EmailsController;
use Illuminate\Console\Command;
use App\Models\Queue;


class EmailsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ec = new EmailsController();
        $ec->sendMailFromDatabase();

    }
}
