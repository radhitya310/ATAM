<?php

namespace Database\Seeders;

use App\Models\Breed;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'breed_id' => '1',
                'breed_category' => 'Local',
            ],

            [
                'breed_id' => '2',
                'breed_category' => 'Mix Breed',
            ],

            [
                'breed_id' => '3',
                'breed_category' => 'Pure',
            ],

        ];

        DB::table('breeds')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Breed::create($value);
        // }
    }
}
