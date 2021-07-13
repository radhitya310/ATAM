<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sterilization extends Model
{
    use HasFactory;

    protected $table = 'sterilizations';

    protected $fillable = [
        'sterilization_id', // PK
        'sterilization_status',
    ];

    public function getDataSterilization(){
        return DB::table('sterilizations')->get();
    }
}
