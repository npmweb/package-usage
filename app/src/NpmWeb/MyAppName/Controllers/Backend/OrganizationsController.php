<?php

namespace NpmWeb\MyAppName\Controllers\Backend;

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
		if( $this->respondTo('json') ) {
			$objs = $this->model->all();
			return Response::json([
				'status' => 'success',
				'models' => $objs->toArray(),
			]);
		} else {
			return View::make($this->modelName.'.index');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$id = Input::old('parent_organization_id');
		$id || $id = Input::get('parent');

		$model = $this->model;
		$model->parent_organization_id = $id;

		return View::make($this->modelName.'.edit',['model'=>$model]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$obj = $this->model;
	    $obj->fill(Input::all());
	    $obj->save();
	    if( $obj->errors()->any() )
	    {
	    	// var_dump($obj->errors());exit;
	        return Redirect::route($this->modelName.'.create')
	            ->withInput()
	            ->withErrors($obj->errors()->all());
	    }
	 
	    return Redirect::route($this->modelName.'.index')
	        ->with('myflash', 'Your record has been created.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$obj = $this->model->findOrFail($id);
		return View::make($this->modelName.'.show',['model'=>$obj]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$obj = $this->model->findOrFail($id);
		return View::make($this->modelName.'.edit',['model'=>$obj]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$obj = $this->model->findOrFail($id);
	    $obj->fill(Input::all());
	    $obj->save();
	    if( $obj->errors()->any() )
	    {
	    	// var_dump($obj->errors());exit;
	        return Redirect::route($this->modelName.'.edit',$id)
	            ->withInput()
	            ->withErrors($obj->errors()->all());
	    }
	 
	    return Redirect::route($this->modelName.'.show', $id)
	        ->with('myflash', 'Your record has been updated.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$obj = $this->model->findOrFail($id);
		$obj->delete();
	    return Redirect::route($this->modelName.'.index')
	        ->with('myflash', 'Your record has been deleted!');
	}

}
