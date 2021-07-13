<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Age extends Model
{
    use HasFactory;

    // private $age;

    // // getter (accessors)
    // public function getAge(){
    //     return $this->age;
    // }

    // // setter (mutators)
    // public function setAge($i){
    //     $this->age = $i;
    // }


    protected $table = 'ages';

    protected $fillable = [
        'age_id',
        'age_category',
    ];

    public function getDataAge(){
        return DB::table('ages')->get();
    }
}
