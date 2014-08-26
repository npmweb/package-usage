@extends('layouts.layout')

@section('content')
	<div class="row">
		<div class="columns">
			<h2>Organizations</h2>
			<ul>
				@foreach( $organizations as $org )
					<li>{{ esc_body($org->name) }}</li>
				@endforeach
			</ul>
		</div>
	</div>
@stop
