<?php

use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assets = require(dirname(__FILE__) . '/../data/assets.php');

        foreach ($assets as $asset) {
            $entity = factory(\App\Models\Asset::class)->create([
                'name' => $asset['name'],
                'value' => $asset['value']
            ]);
        }
    }
}
