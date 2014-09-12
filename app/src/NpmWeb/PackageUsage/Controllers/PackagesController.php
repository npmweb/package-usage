<?php

namespace NpmWeb\PackageUsage\Controllers;

use DateTime;
use Request;
use Response;
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
        $result = $this->packages->getUsage();
        return View::make($this->modelName.'.index', [
            'username' => getenv('BITBUCKET_USER'),
            'lastUpdated' => new DateTime($result->lastUpdate),
            'packages' => array_values((array)$result->packageUsage),
        ]);
    }

    public function test()
    {
        d($this->packagist->get('ezyang/htmlpurifier'));
    }

}
