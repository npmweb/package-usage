<!-- scripts -->
<script type="text/javascript" src="{{ asset('includes/shared/components/jquery/jquery-built.js') }}"></script>
<script type="text/javascript" src="{{ asset('includes/shared/components/foundation/js/foundation/foundation.js') }}"></script>
<script type="text/javascript" src="{{ asset('includes/shared/components/foundation/js/foundation/foundation.topbar.js') }}"></script>
<script type="text/javascript" src="{{ asset('includes/shared/components/foundation_calendar_date_time_picker/js/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('includes/shared/components/foundation_calendar_date_time_picker/foundation_calendar.js') }}"></script>
<script type="text/javascript" src="{{ asset('includes/shared/components/foundation_calendar_date_time_picker/helpers/date-helpers.js') }}"></script>
<script type="text/javascript" src="{{ asset('includes/shared/components/foundation_calendar_date_time_picker/helpers/string-helpers.js') }}"></script>
<script>
	$(document).foundation();
</script>
@yield('js')
