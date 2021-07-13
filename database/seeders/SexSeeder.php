<?php

namespace Database\Seeders;

use App\Models\Sex;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SexSeeder extends Seeder
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
                'sex_id' => '1',
                'sex_name' => 'Male',
            ],

            [
                'sex_id' => '2',
                'sex_name' => 'Female',
            ],
        ];

        DB::table('sexs')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Sex::create($value);
        // }
    }
}
