<?php

use NpmWeb\PackageUsage\Models\Organization;

class OrganizationTableSeeder extends Seeder {

    public function run()
    {
        DB::table('organizations')->delete();

        Organization::create([
        	'id' => 1,
        	'permalink' => 'abc',
			'name' => 'Parent Organization',
			'logo' => 'someorg.jif',
			'url' => 'http://some.org',
			'address' => '123 Main Street',
			'city' => 'Atlanta',
			'state' => 'GA',
			'postal_code' => '30328',
			'country' => 'US',
			'email' => 'one@some.org',
		]);

        Organization::create([
        	'id' => 2,
        	'permalink' => 'bcd',
			'name' => 'Child Organization',
			'logo' => 'someorg.jif',
			'url' => 'http://some.org',
			'address' => '123 Main Street',
			'city' => 'Atlanta',
			'state' => 'GA',
			'postal_code' => '30328',
			'country' => 'US',
			'email' => 'one@some.org',
		]);
    }

}
