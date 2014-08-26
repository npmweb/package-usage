<?php

$envFromJson = (array)json_decode(file_get_contents(dirname(__FILE__).'/../.env.json'));
if( empty($envFromJson) ) { die("syntax error in .env.json, or no config values specified"); }

foreach( $envFromJson as $key => $value ) {
    putenv($key.'='.$value);
}
