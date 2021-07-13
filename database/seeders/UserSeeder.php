<?php

namespace Database\Seeders;

// model User digunakan
use App\Models\User;

// menggunakan Facades DB
use Illuminate\Support\Facades\DB;
// menggunakan Hash untuk hidden pass nya
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // menggunakan query builder
        // // untuk admin nya
        // DB::table('users')->insert([
            // 'role_id' => '1',
            // 'name' => 'Admin Name',
            // 'email' => 'admin@gmail.com',
            // 'password' => Hash::make('admin123'),
            // // bcrypt method like hash
            // // 'password' => bcrypt('admin123'),
            // 'phone_number' => '089123456789',
            // 'address' => 'Jl. Kemanggisan Pulo',
            // 'kode_pos' => '11480'
        //     'created_at' => \Carbon\Carbon::now(),
        //     'email_verified_at' => \Carbon\Carbon::now()
        // ]);
        // // untuk member nya
        // // DB::table('users')->insert([
        //         // 'role_id' => '2', // default nya 2 yaitu member
        //         'name' => 'Member Name',
        //         'email' => 'member@gmail.com',
        //         'password' => Hash::make('admin123'),
        //         // 'password' => bcrypt('member123'),
        //         'phone_number' => '000000000000',
        //         'address' => 'Jl. Kebon Jeruk',
        //         'kode_pos' => '22222'
        //     'created_at' => \Carbon\Carbon::now(),
        //     'email_verified_at' => \Carbon\Carbon::now()
        // ]);

        $data = [
            [
                'id' => '1',
                'role_id' => '1',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123456'),
                'phone_number' => '08987654321',
                'address' => 'Binus Alam Sutera, Jalan Jalur Sutera Barat, RT.001/RW.004, East Panunggangan, Tangerang City, Banten, Indonesia',
                'longitude' => 106.649330,
                'latitude' => -6.223606,
            ],
            [
                'id' => '2',
                'role_id' => '2',
                'name' => 'Member 1',
                'email' => 'member1@gmail.com',
                'password' => Hash::make('member123456'),
                'phone_number' => '084444444444',
                'address' => 'Rawa Belong, RT.1/RW.11, Palmerah, West Jakarta City, Jakarta, Indonesia',
                'longitude' => 106.786667,
                'latitude' => -6.202272,
            ],
            [
                'id' => '3',
                'role_id' => '2',
                'name' => 'Member 2',
                'email' => 'member2@gmail.com',
                'password' => Hash::make('member123456'),
                'phone_number' => '085555555555',
                'address' => 'Jalan Mandala Utara III, RT.5/RW.6, Tomang, West Jakarta City, Jakarta, Indonesia',
                'longitude' => 106.797157,
                'latitude' => -6.171972,
            ],
            [
                'id' => '4',
                'role_id' => '2',
                'name' => '[Sample Member 1]',
                'email' => 'samplemember1@yahoo.co.id',
                'password' => Hash::make('member123456'),
                'phone_number' => '999999999999',
                'address' => 'Jakarta, Indonesia',
                'longitude' => 106.845596,
                'latitude' => -6.208763,
            ],
            [
                'id' => '5',
                'role_id' => '2',
                'name' => '[Sample Member 2]',
                'email' => 'samplemember2@yahoo.com',
                'password' => Hash::make('member123456'),
                'phone_number' => '88888888888',
                'address' => 'Bandung, Bandung City, West Java, Indonesia',
                'longitude' => 107.619125,
                'latitude' => -6.917464,
            ],
                        // [
            //     'id' => '4',
            //     'role_id' => '3',
            //     'name' => 'PDX Pet Shop',
            //     'email' => 'PDXpetshop@gmail.com',
            //     'password' => Hash::make('petshop123456'),
            //     'phone_number' => '08118339032',
            //     'address' => 'Jalan Lapangan Bola No.34j, RT.4/RW.10, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia',
            //     'longitude' => 106.768173,
            //     'latitude' => -6.196859,
            // ],
            // [
            //     'id' => '5',
            //     'role_id' => '3',
            //     'name' => 'Love My Pet',
            //     'email' => 'lovemypet@gmail.com',
            //     'password' => Hash::make('petshop123456'),
            //     'phone_number' => '0215633315',
            //     'address' => 'Jalan Tanjung Duren Raya No.69a, RT.2/RW.5, South Tanjung Duren, West Jakarta City, Jakarta, Indonesia',
            //     'longitude' => 106.783707,
            //     'latitude' => -6.174767,
            // ],
            [
                'id' => '6',
                'role_id' => '3',
                'name' => '[Sample Pet Shop 1]',
                'email' => 'petshop1@gmail.com',
                'password' => Hash::make('petshop123456'),
                'phone_number' => '021111111',
                'address' => 'Jalan Lapangan Bola No.34j, RT.4/RW.10, Kebon Jeruk, West Jakarta City, Jakarta, Indonesia',
                'longitude' => 106.768173,
                'latitude' => -6.196859,
            ],
            [
                'id' => '7',
                'role_id' => '3',
                'name' => '[Sample Pet Shop 2]',
                'email' => 'petshop2@gmail.com',
                'password' => Hash::make('petshop123456'),
                'phone_number' => '021222222',
                'address' => 'Jalan Tanjung Duren Raya No.69a, RT.2/RW.5, South Tanjung Duren, West Jakarta City, Jakarta, Indonesia',
                'longitude' => 106.783707,
                'latitude' => -6.174767,
            ],
        ];

        // // jika menggunakan query builder
        // DB::table('users')->insert($data);

        // // jika use eloquent
        foreach ($data as $key => $value) {
            // menggunakan eloquent
            User::create($value);
        }
    }
}
