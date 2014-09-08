<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, minimum-scale=1, user-scalable=0" />

<title>PackageUsage</title>

<link rel="stylesheet" type="text/css" href="{{ asset('includes/shared/components/foundation/css/foundation.min.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('includes/shared/components/foundation_calendar_date_time_picker/foundation-icon-fonts-3/foundation-icons.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('includes/shared/components/foundation_calendar_date_time_picker/foundation_calendar.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ asset('includes/css/main.css') }}" />
@yield('css')

<script src="{{ asset('includes/shared/components/require.js') }}"></script>
<script>
	require.config({
		urlArgs: "bust="+(new Date()).getTime(),
		baseUrl: {{ esc_js(asset('includes/shared/components')) }}
	});
</script>
