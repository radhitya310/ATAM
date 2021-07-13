<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
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
                'service_id' => 1,
                'user_id_pet_shop' => 6,
                'service_type' => 'Grooming',
                'service_name' => 'Cukur bulu',
                'service_price' => 55000,
                'service_post_status' => 'enabled',
                'doctor_name' => NULL,
            ],
            [
                'service_id' => 2,
                'user_id_pet_shop' => 6,
                'service_type' => 'Grooming',
                'service_name' => 'Cukur kuku',
                'service_price' => 25000,
                'service_post_status' => 'enabled',
                'doctor_name' => NULL,
            ],
            [
                'service_id' => 3,
                'user_id_pet_shop' => 6,
                'service_type' => 'Grooming',
                'service_name' => 'Memandikan Hewan',
                'service_price' => 90000,
                'service_post_status' => 'enabled',
                'doctor_name' => NULL,
            ],
            [
                'service_id' => 4,
                'user_id_pet_shop' => 6,
                'service_type' => 'Grooming',
                'service_name' => 'Memandikan Hewan + cukur bulu',
                'service_price' => 120000,
                'service_post_status' => 'enabled',
                'doctor_name' => NULL,
            ],
            [
                'service_id' => 5,
                'user_id_pet_shop' => 7,
                'service_type' => 'Grooming',
                'service_name' => 'Memandikan Hewan + cukur bulu',
                'service_price' => 100000,
                'service_post_status' => 'enabled',
                'doctor_name' => NULL,
            ],
            [
                'service_id' => 6,
                'user_id_pet_shop' => 7,
                'service_type' => 'Konsultasi',
                'service_name' => 'Konsultasi Penyakit Kucing',
                'service_price' => 20000,
                'service_post_status' => 'enabled',
                'doctor_name' => 'Drh. ABC',
            ],
            [
                'service_id' => 7,
                'user_id_pet_shop' => 7,
                'service_type' => 'Konsultasi',
                'service_name' => 'Konsultasi penyakit anjing',
                'service_price' => 20000,
                'service_post_status' => 'enabled',
                'doctor_name' => 'Drh. EFG',
            ],
        ];

        // // jika use query builder
        // DB::table('services')->insert($data);

        // // jika use eloquent
        foreach ($data as $key => $value) {
            // menggunakan eloquent
            Service::create($value);
        }
    }
}
