<?php

namespace NpmWeb\PackageUsage\Controllers;

use View;

class MonitorController extends \Controller {

    public function index()
    {
        return View::make('monitor')
            ->with('ip', $_SERVER['SERVER_ADDR']);
    }
}