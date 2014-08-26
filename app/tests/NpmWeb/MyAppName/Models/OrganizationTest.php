<?php

namespace NpmWeb\MyAppName\Models;

use NpmWeb\LaravelTest\BackendTestCase;

class OrganizationTest extends BackendTestCase {

    protected $model;

    public function setUp() {
        parent::setUp();
        $this->model = new Organization();
    }

    public function testValidationErrorRequired() {
        // arrange
        $input = [];

        // act
        $this->model->fill($input);

        // assert
        $this->assertNotValid($this->model->validate());
        foreach(
            ['name','permalink','email']
            as $field
        ) {
            $this->assertRequiredError($this->model,$field);
        }
    }

    public function testValidationErrorMax() {
        // arrange
        $lengths = [
            'name' => 150,
            'logo' => 45,
            'url' => 150,
            'address' => 150,
            'city' => 45,
            'state' => 45,
            'postal_code' => 45,
            'country' => 45,
            'permalink' => 45,
            'email' => 150,
        ];
        $input = [];
        foreach( $lengths as $field => $length ) {
            $input[$field] = $this->string_of_length($length+1);
        }

        // act
        $this->model->fill($input);

        // assert
        $this->assertNotValid($this->model->validate());
        foreach( $lengths as $field => $length ) {
            $this->assertMaxLengthError($this->model,$field,$length);
        }
    }

    public function testValidationErrorFormat() {
        // arrange
        $input = [
            'name' => 'Some Organization',
            'logo' => 'someorg.jif',
            'url' => 'not/a/url',
            'address' => '123 Main Street',
            'city' => 'Atlanta',
            'state' => 'GA',
            'postal_code' => '30328',
            'country' => 'US',
            'permalink' => 'some',
            'email' => 'bad@bad',
        ];

        // act
        $this->model->fill($input);

        // assert
        $this->assertNotValid($this->model->validate());
        // var_dump($this->model->errors());
        $this->assertValidationError($this->model,'url','The url format is invalid.');
        $this->assertValidationError($this->model,'email','The email format is invalid.');
    }

    public function testValidationSuccess() {
        // arrange
        $input = [
            'name' => 'Some Organization',
            'logo' => 'someorg.jif',
            'url' => 'http://some.org',
            'address' => '123 Main Street',
            'city' => 'Atlanta',
            'state' => 'GA',
            'postal_code' => '30328',
            'country' => 'US',
            'permalink' => 'some',
            'email' => 'one@some.org',
        ];

        // act
        $this->model->fill($input);

        // assert
        $this->assertValid($this->model->validate());
        foreach( $input as $field => $value ) {
            $this->assertEquals($value,$this->model->$field);
        }
    }

}
