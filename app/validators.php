<?php

Validator::resolver(function($translator, $data, $rules, $messages)
{
    return new \NpmWeb\LaravelValidatorCustomRules\Validator($translator, $data, $rules, $messages);
});
