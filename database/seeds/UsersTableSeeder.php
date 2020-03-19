<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::where('name', Role::ADMIN)->first();

        $clientRole = Role::where('name', Role::CLIENT)->first();


        $password = Hash::make('password');

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@test.com',
            'password' => $password,
        ]);

        $admin->attachRole($adminRole);

        $password = Hash::make('password');

        $tester = User::create([
            'name' => 'Api_tester',
            'email' => 'apitester@test.com',
            'password' => $password,
        ]);

        $tester->attachRole($clientRole);

        $clients = factory(User::class, 5)->create();

        foreach ($clients as $client) {
            $client->attachRole($clientRole);
        }
    }
}
