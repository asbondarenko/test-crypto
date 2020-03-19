<?php

use Illuminate\Database\Seeder;
use App\Models\Cryptocurrency;
use App\Models\Asset;

class AssetCryptocurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cryptocurrencyAssets = require(dirname(__FILE__) . '/../data/cryptocurrency_assets.php');

        $cryptocurrencies = Cryptocurrency::all();

        foreach ($cryptocurrencies as $cryptocurrency) {
            if (array_key_exists($cryptocurrency->abbreviation, $cryptocurrencyAssets)) {
                $assets = Asset::whereIn('name', $cryptocurrencyAssets[$cryptocurrency->abbreviation])->pluck('id');

                $cryptocurrency->assets()->attach($assets);
            }
        }
    }
}
