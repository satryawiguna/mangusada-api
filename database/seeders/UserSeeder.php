<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = (new Role())->where('title', '=', 'ADMIN')->first();

        $user = User::create([
            'role_id' => $role->id,
            'username' => 'admin',
            'email' => 'admin@mangusada.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_by' => 'system'
        ]);

        $user->profile()->create([
            'name' => 'Satrya Wiguna',
            'address' => 'Jl. Raya Bona Kelod, White House No 1',
            'phone_number' => '1234567890',
            'sim_number' => '10182913874983627632',
            'created_by' => 'system'
        ]);

        Profile::factory()->count(10)->create();
    }
}
