<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SourceSeeder extends Seeder
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
                'source_id' => '1',
                'source_name' => 'Shelter',
            ],

            [
                'source_id' => '2',
                'source_name' => 'Pet Owner',
            ],

        ];

        DB::table('sources')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Source::create($value);
        // }
    }
}
