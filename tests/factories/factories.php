<?php

$factory('UpstatePHP\Website\Domain\Events\Event', [
    'remote_id' => $faker->randomNumber(7),
    'title' => $faker->sentence(3),
    'description' => $faker->paragraph(6),
    'registration_link' => $faker->url,
    'begins_at' => $faker->date,
    'ends_at' => $faker->date,
    'location_name' => 'OpenWorks',
    'street' => $faker->streetAddress,
    'city' => $faker->city,
    'state' => $faker->stateAbbr,
    'zipcode' => $faker->postcode,
    'latitude' => $faker->latitude,
    'longitude' => $faker->longitude
]);

$factory('UpstatePHP\Website\Domain\Sponsors\Sponsor', [
    'name' => $faker->company,
    'type' => $faker->randomElement(['sponsor', 'supporter']),
    'url' => $faker->url,
    'logo' => $faker->md5
]);
