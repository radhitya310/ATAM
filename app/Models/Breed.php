<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Breed extends Model
{
    use HasFactory;

    protected $table = 'breeds';

    protected $fillable = [
        'breed_id',
        'breed_category',
    ];

    public function getDataBreed(){
        return DB::table('breeds')->get();
    }
}
