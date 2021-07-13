<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Track_Records extends Model
{
    use HasFactory;

    protected $table = 'Track_Records';

    protected $fillable = [
        'track_record_id',
        'adopt_submission_id',
        'foto',
        'keterangan',
        'waktu_post'
    ];

    public function getDataAdopterRecords(){
        return DB::table('track_records')
                    ->join('adopt_Submissions', 'adopt_submissions.adopt_submission_id', '=', 'track_records.adopt_submission_id')
                    ->orderByDesc('track_record_id')
                    ->get();
    }

    public function tambahData($data){
        return DB::table('track_records')
                    ->insert($data);
    }
}
