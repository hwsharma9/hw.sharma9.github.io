<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create([
            'designation' => 'User'
        ]);
        $users = User::where('designation', 'User')->get();
        foreach ($users as $key => $user) {
            $user->assignRole([5]);
        }
    }
}
