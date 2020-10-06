<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('users')->truncate();

        foreach(range(1, 10) as $index)
        {
            $user = User::create(array(
                'password' => $faker->word,
                'name' => $faker->userName,
                'email' => $faker->email
            ));
        }    }
}
