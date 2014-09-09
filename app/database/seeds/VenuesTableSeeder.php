<?php

use Faker\Factory as Faker;
use UpstatePHP\Website\Models\Venue;

class VenuesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        foreach(range(1, 3) as $index)
        {
            Venue::create([
                'name' => $faker->company,
                'url' => $faker->url,
                'street' => $faker->streetAddress,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'zipcode' => $faker->postcode,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude
            ]);
        }
    }

}