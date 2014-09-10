<?php

namespace NpmWeb\PackageUsage\Controllers;

use View;
use NpmWeb\PackageUsage\Services\PackageUsageServiceInterface;
use Packagist\Api\Client;

class PackagesController extends \Controller {

    protected $packages;
    protected $modelName = 'packages';

    public function __construct( PackageUsageServiceInterface $packages,
        Client $packagist )
    {
        $this->packages = $packages;
        $this->packagist = $packagist;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return View::make($this->modelName.'.index', [
            'packageUsage' => $this->packages->getUsage(),
        ]);
    }

    public function test()
    {
        d($this->packagist->get('ezyang/htmlpurifier'));
    }

}
