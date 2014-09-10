@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="columns">
            <h2>Packages</h2>
                @foreach( $packageUsage as $package )
                    <div class="package">
                        <div class="row">
                            <div class="medium-10 columns">
                                <h3><a href="{{{ $package->homepage }}}">{{{ $package->name }}}</a></h3>
                                <p>{{{ $package->description }}}</p>
                            </div>
                            <div class="medium-2 columns">
                                <div><button class="usages button small">&#9733; {{{ count($package->usages) }}}</button></div>
                            </div>
                        </div>
                        <div class="usages" style="display:none">
                            <p>Used in {{{ pluralize($package->usages, 'app') }}}:</p>
                            <ul>
                                @foreach( $package->usages as $usage => $version )
                                    <li>{{{ $usage }}}: {{{ $version }}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
@stop
