<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Species extends Model
{
    use HasFactory;

    protected $table = 'species';

    protected $fillable = [
        'species_id', // PK
        'species_name',
    ];

    public function getDataSpecies(){
        return DB::table('species')->get();
    }
}
