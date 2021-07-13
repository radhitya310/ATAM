<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
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
                'role_id' => '1',
                'role_name' => 'Admin',
            ],

            [
                'role_id' => '2',
                'role_name' => 'Member',
            ],

            [
                'role_id' => '3',
                'role_name' => 'Pet Shop',
            ],
        ];

        DB::table('roles')->insert($data);

        // // jika use eloquent
        // foreach ($data as $key => $value) {
        //     // menggunakan eloquent
        //     Role::create($value);
        // }
    }
}
