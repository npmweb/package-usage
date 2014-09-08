<!DOCTYPE html5>
<html>
    <head>
        @include('layouts._headtag')
    </head>
    <body>
        @include('layouts._header')
        <div class="row">
            <div class="columns">
                @yield('content')
            </div>
        </div>
        @include('layouts._footer')
    </body>
</html>
