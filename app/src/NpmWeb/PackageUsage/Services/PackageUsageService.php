<?php namespace NpmWeb\PackageUsage\Services;

use NpmWeb\GitApiClient\GitApiClientInterface;
use NpmWeb\ComposerService\GitRepoComposerService;
use NpmWeb\ComposerService\CompositeComposerService;

class PackageUsageService implements PackageUsageServiceInterface {

    protected $git;
    protected $gitComposer;
    protected $compositeComposer;

    public function __construct( GitApiClientInterface $git,
        GitRepoComposerService $gitComposer,
        CompositeComposerService $compositeComposer )
    {
        $this->git = $git;
        $this->gitComposer = $gitComposer;
        $this->compositeComposer = $compositeComposer;
    }

    /**
     * Recalculates all usages with the latest information in the repos.
     */
    public function updateUsage( $owner ) {
        $packageUsage = [];

        $repos = $this->git->getReposOwnedBy($owner,'php');

        foreach( $repos as $repo ) {
            $repoName = $repo->name;
            $repoUrl = $repo->url;
            $composerConfig = $this->gitComposer->getPackageInfo( "$owner/$repoName", array(
                'repo' => $repoUrl,
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
                        'homepage' => $composer2Config->homepage,
                        'usages' => [],
                    ];
                }
                $packageUsage[$packageName]['usages'][$repoName] = $version;
            }
        }

        // sort results
        ksort( $packageUsage, SORT_STRING | SORT_FLAG_CASE );
        foreach( $packageUsage as &$package ) {
            ksort($package['usages'], SORT_STRING | SORT_FLAG_CASE); // alphabetical
        }

        // save to disk
        $dir = storage_path().'/usage/';
        if( !file_exists($dir) ) { mkdir($dir); }
        $fh = fopen( $dir.'usage.json', 'w' );
        fwrite( $fh, json_encode($packageUsage) );
        fclose($fh);
    }

    /**
     * Retrieves the usage results.
     */
    public function getUsage() {
        $dir = storage_path().'/usage/';
        return json_decode(file_get_contents($dir.'usage.json'));
    }

}
