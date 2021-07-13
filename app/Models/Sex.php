<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sex extends Model
{
    use HasFactory;

    protected $table = 'sexs';

    protected $fillable = [
        'sex_id', // PK
        'sex_name',
        'created_at',
        'updated_at',
    ];

    public function getDataSex(){
        return DB::table('sexs')->get();
    }
}
