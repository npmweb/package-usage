<?php

namespace NpmWeb\PackageUsage\Controllers;

use Auth;
use Input;
use Redirect;
use Request;
use Response;
use View;
use NpmWeb\LaravelBase\Controllers\BaseController;
use NpmWeb\PackageUsage\Services\PackageUsageServiceInterface;

class PackagesController extends BaseController {

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
