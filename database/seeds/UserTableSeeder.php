<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info("Truncating users table");
        \App\User::truncate();
        for ($i=0; $i < 20000 ; $i++) { 
            $this->command->info("Creating '{$i}' user");
            \App\User::create([
                'name' => ucwords(str_replace('_', ' ', $i)),
                'email' => $i.'@test.com',
                'password' => bcrypt('123456'),
                'status' => '1'
            ]);
        }
    }
}
