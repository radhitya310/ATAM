<?php

namespace Database\Seeders;

use App\Models\Pet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetSeeder extends Seeder
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
                'pet_id' => 1,
                'user_id' => 2,
                'species_id' => 1,
                'breed_id' => 1,
                'sex_id' => 1,
                'age_id' => 3,
                'source_id' => 2,
                'vaccine_id' => 2,
                'sterilization_id' => 1,
                'status' => 'Request for Adopt',
                'pet_name' => '[Sample Pet Name 1]',
                'pet_description' => 'Lucu lucu lucu lucu lucu lucu',
                'pet_image' => '',
            ],
            [
                'pet_id' => 2,
                'user_id' => 2,
                'species_id' => 2,
                'breed_id' => 3,
                'sex_id' => 2,
                'age_id' => 1,
                'source_id' => 2,
                'vaccine_id' => 2,
                'sterilization_id' => 2,
                'status' => 'Request for Adopt', //// default Request for Adopt
                'pet_name' => '[Sample Pet Name 2]',
                'pet_description' => 'nice nice nice nice',
                'pet_image' => '',
            ],
            [
                'pet_id' => 3,
                'user_id' => 2,
                'species_id' => 1,
                'breed_id' => 1,
                'sex_id' => 1,
                'age_id' => 4,
                'source_id' => 2,
                'vaccine_id' => 2,
                'sterilization_id' => 1,
                'status' => 'Request for Adopt',
                'pet_name' => '[Sample Pet Name 3]',
                'pet_description' => 'good good good good',
                'pet_image' => '',
            ],
            [
                'pet_id' => 4,
                'user_id' => 2,
                'species_id' => 1,
                'breed_id' => 1,
                'sex_id' => 1,
                'age_id' => 1,
                'source_id' => 1,
                'vaccine_id' => 2,
                'sterilization_id' => 2,
                'status' => 'Request for Adopt',
                'pet_name' => '[Sample Pet Name 4]',
                'pet_description' => 'cute cute cute cute',
                'pet_image' => '',
            ],
            [
                'pet_id' => 5,
                'user_id' => 3,
                'species_id' => 2,
                'breed_id' => 2,
                'sex_id' => 1,
                'age_id' => 4,
                'source_id' => 2,
                'vaccine_id' => 2,
                'sterilization_id' => 1,
                'status' => 'Request for Adopt',
                'pet_name' => '[Sample Pet Name 5]',
                'pet_description' => 'lucu good nice cute',
                'pet_image' => '',
            ],
            [
                'pet_id' => 6,
                'user_id' => 4,
                'species_id' => 2,
                'breed_id' => 2,
                'sex_id' => 1,
                'age_id' => 4,
                'source_id' => 2,
                'vaccine_id' => 2,
                'sterilization_id' => 1,
                'status' => 'Request for Adopt',
                'pet_name' => '[Sample Pet Name 6]',
                'pet_description' => 'lucu good nice cute',
                'pet_image' => '',
            ],
            [
                'pet_id' => 7,
                'user_id' => 5,
                'species_id' => 1,
                'breed_id' => 2,
                'sex_id' => 1,
                'age_id' => 4,
                'source_id' => 2,
                'vaccine_id' => 2,
                'sterilization_id' => 1,
                'status' => 'Request for Adopt',
                'pet_name' => '[Sample Pet Name 7]',
                'pet_description' => 'lucu good nice cute',
                'pet_image' => '',
            ],

        ];

        DB::table('pets')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Pet::create($value);
        // }
    }
}
