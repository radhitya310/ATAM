<?php

namespace Database\Seeders;

use App\Models\Species;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpeciesSeeder extends Seeder
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
                'species_id' => '1',
                'species_name' => 'Cat',
            ],

            [
                'species_id' => '2',
                'species_name' => 'Dog',
            ],
        ];

        DB::table('species')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Species::create($value);
        // }
    }
}
