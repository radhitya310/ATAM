<?php

namespace Database\Seeders;

use App\Models\Sterilization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SterilizationSeeder extends Seeder
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
                'sterilization_id' => '1',
                'sterilization_status' => 'Yes',
            ],

            [
                'sterilization_id' => '2',
                'sterilization_status' => 'No',
            ],
        ];

        DB::table('sterilizations')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Sterilization::create($value);
        // }
    }
}
