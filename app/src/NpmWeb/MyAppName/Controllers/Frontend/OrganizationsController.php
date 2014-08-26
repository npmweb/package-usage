<?php

namespace NpmWeb\MyAppName\Controllers\Frontend;

use Auth;
use Input;
use Redirect;
use Request;
use Response;
use View;
use NpmWeb\LaravelBase\Controllers\BaseController;
use NpmWeb\MyAppName\Models\Organization;

class OrganizationsController extends BaseController {

	protected $model;
	protected $modelName = 'organizations';

	public function __construct(Organization $model)
	{
		$this->model = $model;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make($this->modelName.'.index', [
			'organizations' => $this->model->all()
		]);
	}

}
