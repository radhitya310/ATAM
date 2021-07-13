<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vaccine extends Model
{
    use HasFactory;

    protected $table = 'vaccines';

    protected $fillable = [
        'vaccine_id', // PK
        'vaccine_status',
    ];

    public function getDataVaccine(){
        return DB::table('vaccines')->get();
    }
}
