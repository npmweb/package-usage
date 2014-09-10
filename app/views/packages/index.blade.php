@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="columns">
            <h2>Packages</h2>
            <ul>
                @foreach( $packageUsage as $package )
                    <li>
                        <h3><a href="{{{ $package->homepage }}}">{{{ $package->name }}}</a><h3>
                        <p>{{{ $package->description }}}</p>
                        <p>Used in {{{ count($package->usages) }}} apps:</p>
                        <ul>
                            @foreach( $package->usages as $usage )
                                <li>{{{ $usage }}}</li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@stop
