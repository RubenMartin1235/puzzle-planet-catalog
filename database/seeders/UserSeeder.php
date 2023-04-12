<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_admin = Role::where('name','admin')->first();
        $role_loader = Role::where('name','loader')->first();
        $role_user = Role::where('name','user')->first();

        $user = User::factory()->create([
            'name'=>'admin',
            'email'=>'admin@puzzplan.com',
            'password'=>Hash::make('1234567890'),
            'remember_token'=>Str::random(10),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $user->roles()->attach($role_admin);

        $user = User::factory()->create([
            'name'=>'loader',
            'email'=>'loader@puzzplan.com',
            'password'=>Hash::make('1234567890'),
            'remember_token'=>Str::random(10),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $user->roles()->attach($role_loader);

        $user = User::factory()->create([
            'name'=>'Flor1450',
            'email'=>'flor1450@puzzplan.com',
            'password'=>Hash::make('flwor1450'),
            'remember_token'=>Str::random(10),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $user->roles()->attach($role_user);

        $user = User::factory()->create([
            'name'=>'Lastarman123',
            'email'=>'lastarman123@puzzplan.com',
            'password'=>Hash::make('praisethelight123'),
            'remember_token'=>Str::random(10),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
        $user->roles()->attach($role_user);
    }
}
