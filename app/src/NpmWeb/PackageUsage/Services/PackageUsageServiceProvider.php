<?php namespace NpmWeb\PackageUsage\Services;

use Illuminate\Support\ServiceProvider;
use NpmWeb\GitApiClient\GitApiClientInterface;
use NpmWeb\ComposerService\GitRepoComposerService;
use NpmWeb\ComposerService\CompositeComposerService;

class PackageUsageServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PackageUsageServiceInterface::class,
            PackageUsageService::class
        );
    }

}
