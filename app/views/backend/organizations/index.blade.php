@extends('layouts.layout')

@section('content')
	<div class="row">
		<div class="small-9 columns">
			<h1>Organizations</h1>
		</div>
		<div class="small-3 columns">
			{{ link_to_route('organizations.create', 'Create', null, ['class'=>'button expand']) }}
		</div>
	</div>

	<div class="row">
		<div class="columns">
			<div id="orgs"></div>
		</div>
	</div>
@stop

@section('js')
<script type="text/javascript">
var cs = cs || {};
cs.baseUrl = {{ esc_js(url()) }};

require(
	['bbgrid','../js/models/Organization','escaping-js'],
	function()
{
	cs.organizationCollection = new cs.OrganizationCollection();
	cs.organizationTable = new bbGrid.View({
		css: 'foundation',
		container: $('#orgs'),
		collection: cs.organizationCollection,
		autoFetch: true,
		colModel: [
			{
				property: 'uid',
				label: 'UID',
				render: function(model, view) {
					return '<a href="'+cs.baseUrl+'/organizations/'+esc_url(model.get('uid'))+'">'+esc_body(model.get('uid'))+'</a>';
				}
			},
			{
				property: 'name',
				label: 'Name',
				sortOrder: 'asc'
			}
		],
		events: {}
	});

});
</script>
@stop
