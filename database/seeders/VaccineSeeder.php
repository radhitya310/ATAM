<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VaccineSeeder extends Seeder
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
                'vaccine_id' => '1',
                'vaccine_status' => 'Yes',
            ],

            [
                'vaccine_id' => '2',
                'vaccine_status' => 'No',
            ],
        ];

        DB::table('vaccines')->insert($data);

        // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Vaccine::create($value);
        // }
    }
}
