@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="columns">
            <h2>Packages</h2>
                @foreach( $packageUsage as $package )
                    <div class="package">
                        <div>
                            <button class="usages button small right">&#9733; {{{ count((array)$package->usages) }}}</button>
                            <h3><a href="{{{ $package->homepage }}}" target="_blank">{{{ $package->name }}}</a></h3>
                            <p>{{{ $package->description }}}</p>
                        </div>
                        <div class="usages" style="display:none">
                            <ul>
                                @foreach( $package->usages as $usage => $version )
                                    <li><a href="https://bitbucket.org/npmweb/{{{ $usage }}}" target="_blank">{{{ $usage }}}</a>: {{{ $version }}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
@stop

@section('js')
<script type="text/javascript">

require(['jquery'], function($) {
    $(function(){
        $('button.usages').click(function(evt){
            $(this).closest('.package').find('div.usages').toggle();
        });
    });
});

</script>
@stop