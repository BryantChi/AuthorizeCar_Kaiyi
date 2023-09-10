<?php

namespace App\Console\Commands;

use App\Repositories\Admin\DetectionReportRepository;
use Illuminate\Console\Command;

class AuthAutiCheckCronCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:authorize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Authorize auto check';

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
     * @return int
     */
    public function handle()
    {
        $checkAuthorizeStatus = DetectionReportRepository::autoCheckAuthorizedStatus();

        if ($checkAuthorizeStatus) {
            \Log::debug($checkAuthorizeStatus);
            \Log::info('Cron Job has been sucessed.');
        } else {
            \Log::debug($checkAuthorizeStatus);
            \Log::error('Cron Job has fail.');
        }

        return 0;
    }
}
