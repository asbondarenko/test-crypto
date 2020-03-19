<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = require(dirname(__FILE__) . '/../data/categories.php');

        foreach ($categories as $category) {
            $entity = factory(\App\Models\Cryptocurrency::class)->create([
                'name' => $category['name']
            ]);
        }
    }
}
