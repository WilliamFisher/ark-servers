<?php

use Illuminate\Database\Seeder;

class ServersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servers')->insert([
          'name' => str_random(8),
          'user_id' => 1,
          'description' => str_random(10),
          'map' => 'The Island',
          'platform' => 'Xbox',
          'is_pvp' => true,
          'is_pve' => false,
          'xp_rate' => 2,
          'gather_rate' => 5,
          'tame_rate' => 10,
          'breeding_rate' => 15,
          'last_wipe' => '2017-4-17',
        ]);
    }
}
