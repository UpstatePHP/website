<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

    $this->call('SponsorTableSeeder');
    $this->command->info('Sponsor table Seeded!');
		// $this->call('UserTableSeeder');
	}

}

use App\Sponsor as Sponsor;

class SponsorTableSeeder extends Seeder {
  public function run()
  {
    // Clear the table.
    Sponsor::truncate();

    // Add the test data.
    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'cargo.jpg',
      'name' => 'Cargo'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'commerceguys.jpg',
      'name' => 'Commerce Guys'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'digitalocean.jpg',
      'name' => 'Digital Ocean'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'supporter',
      'url' => 'http://www.google.com',
      'logo' => 'eig.jpg',
      'name' => 'EiG'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'fgp.jpg',
      'name' => 'FGP Technology'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'fuel.jpg',
      'name' => 'FUEL'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'globalvendorlink.jpg',
      'name' => 'Global Vendor Link'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'ironyard.jpg',
      'name' => 'The Iron Yard'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'jetbrains.jpg',
      'name' => 'JetBrains'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'supporter',
      'url' => 'http://www.google.com',
      'logo' => 'laracasts.jpg',
      'name' => 'LaraCasts'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'modis.jpg',
      'name' => 'Modis'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'moonclerk.jpg',
      'name' => 'MoonClerk'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'openworks.jpg',
      'name' => 'OpenWorks'
    ));


    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'robojuice.jpg',
      'name' => 'Robojuice'
    ));

    Sponsor::create(array(
      'created_at' => time(),
      'updated_at' => time(),
      'type' => 'not_supporter',
      'url' => 'http://www.google.com',
      'logo' => 'tower2.jpg',
      'name' => 'Tower2'
    ));
  }
}
