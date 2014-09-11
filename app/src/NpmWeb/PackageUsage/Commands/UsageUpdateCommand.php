<?php namespace NpmWeb\PackageUsage\Commands;

use Config;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use NpmWeb\PackageUsage\Services\PackageUsageServiceInterface;

class UsageUpdateCommand extends Command {

    protected $git;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'usage:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( PackageUsageServiceInterface $service )
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $owner = getenv("BITBUCKET_USER");
        $this->service->updateUsage($owner);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}
