<?php

namespace Database\Seeders;

use App\Models\Age;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgeSeeder extends Seeder
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
                'age_id' => '1',
                'age_category' => 'Baby',
            ],

            [
                'age_id' => '2',
                'age_category' => 'Young',
            ],

            [
                'age_id' => '3',
                'age_category' => 'Adult',
            ],

            [
                'age_id' => '4',
                'age_category' => 'Senior',
            ],
        ];

        DB::table('ages')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Age::create($value);
        // }
    }
}
