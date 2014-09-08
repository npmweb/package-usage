<?php

namespace NpmWeb\PackageUsage\Controllers;

use View;
use NpmWeb\PackageUsage\Services\PackageUsageServiceInterface;

class PackagesController extends \Controller {

    protected $packages;
    protected $modelName = 'packages';

    public function __construct( PackageUsageServiceInterface $packages )
    {
        $this->packages = $packages;
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

}
