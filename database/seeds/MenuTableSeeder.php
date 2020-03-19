<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = require(dirname(__FILE__) . '/../data/menu.php');

        $adminRole = Role::where('name', Role::ADMIN)->first();

        foreach ($menu as $entity => $data) {
            $menuModel = factory(\App\Models\Menu::class)->create($data);

            $menuModel->roles()->attach($adminRole);
        }
    }
}
