<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use NpmWeb\GitApiClient\GitApiClientInterface;
use NpmWeb\ComposerService\GitRepoComposerService;
use NpmWeb\ComposerService\CompositeComposerService;

class PackageUsage extends Command {

    protected $git;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'package:usage';

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
    public function __construct( GitApiClientInterface $git,
        GitRepoComposerService $gitComposer,
        CompositeComposerService $compositeComposer )
    {
        parent::__construct();

        $this->git = $git;
        $this->gitComposer = $gitComposer;
        $this->compositeComposer = $compositeComposer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $owner = 'npmweb';
        $packageUsage = [];

        $repoNames = $this->git->getReposOwnedBy($owner,'php');

        foreach( $repoNames as $repoName ) {
            $composerConfig = $this->gitComposer->getPackageInfo( "$owner/$repoName", array(
                'repo' => "git@bitbucket.org:$owner/$repoName"
            ));

            // TODO cdn-helper not getting here
            if( isset($composerConfig->type) && 'library' == $composerConfig->type ) {
                echo 'it\'s a library; skipping'."\n";
                continue;
            }

            if(!isset($composerConfig->require)) {
                continue;
            }
            foreach( $composerConfig->require as $packageName => $version ) {
                // if it's php itself, skip it
                if( 'php' == $packageName ) {
                    continue;
                }

                if( !array_key_exists($packageName, $packageUsage) ) {
                    $composer2Config = $this->compositeComposer->getPackageInfo($packageName, array(
                        'repos' => isset($composerConfig->repositories)?$composerConfig->repositories:array(),
                    ));
                    // TODO not getting config for npm ones
                    if( !$composer2Config ) {
                        continue;
                    }
                    $packageUsage[$packageName] = [
                        'name' => $packageName,
                        'description' => $composer2Config->description,
                        'usages' => [],
                    ];
                }
                $packageUsage[$packageName]['usages'][] = $repoName;
            }
        }

        // output
        ksort( $packageUsage, SORT_STRING | SORT_FLAG_CASE );
        foreach( $packageUsage as $package ) {
            echo 'package '.$package['name'].': '.(isset($package['description'])?$package['description']:'')."\n";
            echo 'used in '.count($package['usages']).' repos:'."\n";

            sort($package['usages'], SORT_STRING | SORT_FLAG_CASE); // alphabetical

            foreach( $package['usages'] as $usage ) {
                echo '  '.$usage."\n";
            }
            echo "\n";
        }
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
