<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'role_id', // PK
        'role_name',
    ];

    // // relationship dari table roles ke users
    // // one to many
    // // join model class nya menggunakan eloquent
    // //
    // public function User(){
    //     return $this->hasMany(User::class, 'role_id');
    // }

    // // ambil role table
    public function getDataRole(){
        return DB::table('roles')->get();
    }

}
