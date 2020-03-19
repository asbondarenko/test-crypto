<?php

use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class CryptocurrenciesTableSeeder extends Seeder
{

    protected $uploadService;

    function __construct(\App\Services\UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cryptocurrencies = require(dirname(__FILE__) . '/../data/cryptocurrencies.php');

        foreach ($cryptocurrencies as $cryptocurrency) {
            $entity = factory(\App\Models\Cryptocurrency::class)->create([
                'name' => $cryptocurrency['name'],
                'color' => $cryptocurrency['color'],
                'abbreviation' => $cryptocurrency['abbreviation'],
            ]);

            $uploadedFile = new UploadedFile(base_path('database/data/cryptocurrencies/' . $cryptocurrency['image']), $cryptocurrency['image'], 'image/png');

            $this->uploadService->store($uploadedFile, $entity, null, \App\Models\Cryptocurrency::IMAGE_FIELD_NAME);

            $uploadedFile = new UploadedFile(base_path('database/data/cryptocurrencies/' . $cryptocurrency['image_transparent']), $cryptocurrency['image_transparent'], 'image/png');

            $this->uploadService->store($uploadedFile, $entity, null, \App\Models\Cryptocurrency::IMAGE_TRANSPARENT_FIELD_NAME);
        }
    }
}
