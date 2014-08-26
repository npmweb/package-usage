@extends('layouts.layout')

@section('content')
	<div class="row">
		<div class="columns">
			<h1>Organization</h1>
		</div>
	</div>
	<div class="row">
		<div class="columns">
			@if ($model->id)
				{{ Form::model( $model, ['route' => ['organizations.update', $model->uid], 'method' => 'put', 'validate'=>true, 'data-abide'=>''])}}
			@else
				{{ Form::model( $model, ['route' => 'organizations.store', 'validate'=>true, 'data-abide'=>''])}}
			@endif

				{{ Form::hidden('parent_organization_id') }}
				@if ($model->id)
					{{ Form::readonly('permalink') }}
				@else
					{{ Form::text('permalink',null,['errors'=>$errors]) }}
				@endif
				{{ Form::text('name',null,['errors'=>$errors]) }}
				{{ Form::text('logo',null,['errors'=>$errors]) }}
				{{ Form::text('url',null,['errors'=>$errors]) }}
				{{ Form::text('address',null,['errors'=>$errors]) }}
				{{ Form::text('city',null,['errors'=>$errors]) }}
				{{ Form::select('state',Reference::get('states'),'GA',['errors'=>$errors]) }}
				{{ Form::text('postal_code',null,['errors'=>$errors]) }}
				{{ Form::text('country',null,['errors'=>$errors]) }}
				{{ Form::text('email',null,['errors'=>$errors]) }}

				<div class="medium-6 medium-offset-3">
					{{ Form::submit('Submit', ['class'=>'button']) }}
					@if ($model->id)
						{{ link_to_route('organizations.show','Cancel',$model->uid, ['class'=>'button secondary'])}}
					@elseif ($model->parentOrganization)
						{{ link_to_route('organizations.show','Cancel',$model->parentOrganization->uid, ['class'=>'button secondary']) }}
					@else
						{{ link_to_route('organizations.index','Cancel', null, ['class'=>'button secondary']) }}
					@endif
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop
