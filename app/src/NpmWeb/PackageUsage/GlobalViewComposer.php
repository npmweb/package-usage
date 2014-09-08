<?php

namespace NpmWeb\PackageUsage;

use Route;
use NpmWeb\LaravelBase\BaseViewComposer;

class GlobalViewComposer extends BaseViewComposer {

    public function compose($view)
    {
        parent::compose($view);

        $view_data = [
            // add any additional view data here
        ];

        $view->with($view_data);
    }

}
