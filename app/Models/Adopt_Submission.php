<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Adopt_Submission extends Model
{
    use HasFactory;

    protected $table = 'adopt_submissions';

    // // kolom yang diizinkan untuk diisi
    protected $fillable = [
        'adopt_submission_id', // PK
        'pet_id', // FK
        'user_id_adopter', // FK
        'status',
        'question_1',
        'question_2',
        'question_3',
        'question_4',
    ];

    // // kebalikan dari fillable
    // // guarded = yang tidak diizinkan
    // protected $guarded = [];

    // public function getDataAdopt_submissions(){
    //     return DB::table('adopt_submissions')->get();
    // }

    // // untuk adopt submissions di my pet status
    public function getDataPetOwner(){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        return DB::table('adopt_submissions')
                    ->select('*', 'adopt_submissions.status', 'adopt_submissions.user_id_adopter')
                    ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                    ->where('pets.user_id', $userID)
                    ->where('adopt_submissions.status', '!=', 'Waiting for Adopt')
                    ->orderByDesc('adopt_submission_id')
                    ->get();
    }

    // // untuk itung banyaknya user_id_adopter
    // public function countUserID(){
    //     if (!Auth::guest() && Auth::user()->role_id == 1) {

    //         return DB::table('adopt_submissions')
    //                     ->select(DB::raw("COUNT(user_id_adopter) as id"))
    //                     ->get();

    //         // return DB::select('select count(user_id_adopter) as id
    //         //                     from adopt_submissions');
    //     }
    //     else {
    //         if (!Auth::guest()) {
    //             $userID = Auth::user()->id;
    //         } else {
    //             $userID = 0;
    //         }

    //         return DB::table('adopt_submissions')
    //                     ->select(DB::raw("COUNT(user_id_adopter) as id"))
    //                     ->where('user_id_adopter', $userID)
    //                     ->get();

    //         // return DB::select('select count(user_id_adopter) as id
    //         //                     from adopt_submissions
    //         //                     where user_id_adopter = ?', [$userID]);
    //     }
    // }

    // // untuk itung banyaknya pet id
    public function countPetID(){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
            $status = 'Waiting for Adopt';

            $petID = DB::table('adopt_submissions')
                        ->select(DB::raw("COUNT(adopt_submissions.pet_id) as id"))
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->where('pets.user_id', $userID)
                        ->where('adopt_submissions.status', '!=', $status)
                        ->get();

            // $petID =  DB::select('select count(adopt_submissions.pet_id) as id
            //                         from adopt_submissions
            //                         join pets on pets.pet_id = adopt_submissions.pet_id
            //                         where pets.user_id = ? and adopt_submissions.status != ?', [$userID, $status]);
        } else {
            $petID = 0;
        }

        return $petID;
    }

    // untuk ambil data accepted by userID
    public function getDataApprovedByUserID(){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        return DB::table('adopt_submissions')
                    ->select('*', 'adopt_submissions.status')
                    ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                    ->where('adopt_submissions.status', '=', 'Accepted')
                    ->where('pets.user_id', $userID)
                    ->get();
    }

    // ambil semua data di table adopt submissions
    public function getAdoptSubmissions(){
        if (!Auth::guest() && Auth::user()->role_id == 1) {
            return DB::table('adopt_submissions')
                        ->select('*','adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->orderByDesc('adopt_submission_id')
                        ->get();
        }
        else{
            if (!Auth::guest()) {
                $userID = Auth::user()->id;
            }
            else {
                $userID = 0;
            }
            return DB::table('adopt_submissions')
                        ->select('*','adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->where('adopt_submissions.user_id_adopter', $userID)
                        // ->orWhere('pets.user_id', $userID)
                        ->orderByDesc('adopt_submission_id')
                        ->get();
        }
    }


    // accepted pet adopt
    public function getDataAdoptAccepted(){
        if (!Auth::guest() && Auth::user()->role_id == 1) {
            return DB::table('adopt_submissions')
                        ->select('*','adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->where('adopt_submissions.status', 'Accepted')
                        ->orderByDesc('adopt_submission_id')
                        ->get();
        }
        else{
            if (!Auth::guest()) {
                $userID = Auth::user()->id;
            }
            else {
                $userID = 0;
            }
            return DB::table('adopt_submissions')
                        ->select('*','adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->where('adopt_submissions.user_id_adopter', $userID)
                        ->where('adopt_submissions.status', 'Accepted')
                        // ->orWhere('pets.user_id', $userID)
                        ->orderByDesc('adopt_submission_id')
                        ->get();
        }
    }

    // // waiting pet adopt
    public function getDataAdoptWaiting(){

        if (!Auth::guest() && Auth::user()->role_id == 1) {
            return DB::table('adopt_submissions')
                        ->select('*','adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->where('adopt_submissions.status', 'Waiting for Adopt')
                        ->orderByDesc('adopt_submission_id')
                        ->get();
        }
        else{
            if (!Auth::guest()) {
                $userID = Auth::user()->id;
                $lat = Auth::user()->latitude;
                $long = Auth::user()->longitude;
            }
            else {
                $userID = 0;
                $lat = 0;
                $long = 0;
            }

            return DB::table('adopt_submissions')
                        // ->select('*','adopt_submissions.status',
                        //             DB::raw("
                        //                 6371 * (
                        //                     2 * asin(
                        //                         sqrt(
                        //                             ( (sin((radians(".$lat.") - radians(users.latitude))/2)) * (sin((radians(".$lat.") - radians(users.latitude))/2)) ) +
                        //                             cos(radians(".$lat.")) *
                        //                             cos(radians(users.latitude)) *
                        //                             ( (sin((radians(".$long.") - radians(users.longitude))/2)) * (sin((radians(".$long.") - radians(users.longitude))/2)) )
                        //                         )
                        //                     )
                        //                 )
                        //                 AS distance"))
                        ->select('*','adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->where('adopt_submissions.user_id_adopter', $userID)
                        ->where('adopt_submissions.status', 'Waiting for Adopt')
                        // ->orWhere('pets.user_id', $userID)
                        ->orderByDesc('adopt_submission_id')
                        ->get();
        }

        // jika dia bukan guest
        // if(!Auth::guest()){
        //     // ambil id user sedang login
        //     $userID = Auth::user()->id;

        //     // // menggunakan query builder
        //     // // join 2 table
        //     // // ada dua kondisi
        //     // $pet = DB::table('pets')
        //     //         ->join('users', 'users.id', '=', 'pets.user_id')
        //     //         ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
        //     //         ->where('user_id_adopter', $userID)
        //     //         ->orderByDesc('pet_id')
        //     //         ->get();

        //     $pet = DB::table('adopt_submissions')
        //                 ->select('*','adopt_submissions.status')
        //                 ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
        //                 ->where('adopt_submissions.user_id_adopter', $userID)
        //                 ->where('adopt_submissions.status', 'Waiting for Adopt')
        //                 ->orderByDesc('adopt_submissions.adopt_submission_id')
        //                 ->get();
        // }
        // else{
        //     $pet = 0;
        // }

        // return $pet;
    }

    // untuk status my pet waiting adopt
    public function getAllDataWaiting(){

        if (!Auth::guest()) {
            $userID = Auth::user()->id;

            $adopter = DB::table('adopt_submissions')
                        ->select('*', 'adopt_submissions.status', 'adopt_submissions.user_id_adopter')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->join('users', 'users.id', '=', 'adopt_submissions.user_id_adopter')
                        ->where('pets.user_id', $userID)
                        ->where('adopt_submissions.status', '=', 'Waiting for Adopt')
                        ->orderByDesc('adopt_submissions.pet_id')
                        ->get();
        }
        else {
            $adopter = null;
        }

        return $adopter;
    }

    // untuk detail data waiting pet adopt
    // public function getAllDataAdopterWaiting($id){
    //     $adopter = DB::table('adopt_submissions')
    //                 ->select('*','adopt_submissions.status','adopt_submissions.user_id_adopter')
    //                 ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
    //                 ->join('users', 'users.id', '=', 'adopt_submissions.user_id_adopter')
    //                 ->where('adopt_submission_id', $id)
    //                 ->get();

    //     return $adopter;
    // }

    // untuk proses submit pet adop
    public function submitProsesAdop($data, $id1, $id2){

        // untuk validasi biar ga duplikat
        // $idAdopter = DB::select('select user_id_adopter
        //                             from adopt_submissions
        //                             where pet_id = ? and user_id_adopter = ?', [$id1, $id2]);

        // if ($idAdopter == null) {
        //     $pet = DB::table('adopt_submissions')
        //                 ->insert($data);
        // }
        // else {
        //     $pet = DB::table('adopt_submissions')
        //                 ->where('pet_id', $id1)
        //                 ->where('user_id_adopter', $id2)
        //                 ->update($data);
        // }


        $pet = DB::table('adopt_submissions')
                    ->insert($data);

        return $pet;
    }

    // untuk proses ubah status di adopt_submissions
    public function changeStatusProsesAdop($id1, $id2, $type, $reason){
        // $pet = DB::table('pets')
        //             ->where('pet_id', $id)
        //             ->update([
        //                     'status_id' => 1,
        //                     'user_id_adopter' => NULL,
        //                 ]);

        if ($type == 'Canceled') {
            $pet = DB::table('adopt_submissions')
                        ->where('status', 'Waiting for Adopt')
                        ->where('pet_id', $id1)
                        ->where('user_id_adopter', $id2)
                        ->update([
                            'status' => $type,
                            'reason' => $reason,
                        ]);
        }
        elseif($type == 'Rejected') {
            $pet = DB::table('adopt_submissions')
                        ->where('status', 'Waiting for Adopt')
                        ->where('pet_id', $id1)
                        ->where('user_id_adopter', $id2)
                        ->update([
                            'status' => $type,
                            'reason' => $reason,
                        ]);
        }
        elseif($type == 'Accepted') {
            $pet = DB::table('adopt_submissions')
                        ->where('status', 'Waiting for Adopt')
                        ->where('pet_id', $id1)
                        ->where('user_id_adopter', $id2)
                        ->update([
                            'status' => $type,
                            'reason' => $reason,
                        ]);

            $pet2 = DB::table('adopt_submissions')
                        ->where('status', 'Waiting for Adopt')
                        ->where('pet_id', $id1)
                        ->where('user_id_adopter', '!=', $id2)
                        ->update([
                            'status' => 'Rejected',
                            'reason' => '[Report by System] Maaf, Hewan Sudah diadopsi..',
                        ]);

            return $pet2;
        }

        return $pet;
    }

    // untuk detail data adopter
    public function getAllDataAdopter($id){
        // $adopter = DB::table('pets')
        //             ->join('users', 'users.id', '=', 'pets.user_id_adopter')
        //             ->where('pet_id', $id)
        //             ->get();

        $adopter = DB::table('adopt_submissions')
                        ->select('*','adopt_submissions.status','adopt_submissions.user_id_adopter')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->join('users', 'users.id', '=', 'adopt_submissions.user_id_adopter')
                        ->where('adopt_submissions.status', 'Accepted')
                        ->where('adopt_submissions.pet_id', $id)
                        ->get();

        return $adopter;
    }

    // // untuk count status = waiting by user id adopter
    public function countStatusWaiting($userID){

        $status = 'Waiting for Adopt';
        if (!Auth::guest() && Auth::user()->role_id == 1) {
            $pet = DB::table('adopt_submissions')
                        // ->select(DB::raw("COUNT(status) as statusPet"))
                        ->where('status', $status)
                        // ->get();
                        ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where status = ?', [$status]);
        }
        else{
            // $pet = DB::table('adopt_submissions')
            //             // ->select(DB::raw("COUNT(status) as statusPet"))
            //             ->select(DB::raw("COUNT(*) AS statusPet"))
            //             ->where('status', $status)
            //             ->where('user_id_adopter', $userID)
            //             ->get();
            $pet = DB::table('adopt_submissions')
                        ->where('status', $status)
                        ->where('user_id_adopter', $userID)
                        ->count();

            // $pet = DB::select("select count(status) as statusPet
            //                     from adopt_submissions
            //                     where status = ? and user_id_adopter = ?", [$status, $userID]);
        }
        // $pet = DB::select('select count(user_id_adopter) as ID
        //                     from adopt_submissions
        //                     where user_id_adopter = ?', [$userID]);

        return $pet;
    }

    // untuk count status = approved by user id adopter
    public function countStatusAccepted($userID){
        // $status = 'Mark as Adopted';
        // $pet = DB::select('select count(status) as petStatusMark
        //                     from pets
        //                     where status = ?', [$status]);

        $status = 'Accepted';
        if (!Auth::guest() && Auth::user()->role_id == 1) {
            $pet = DB::table('adopt_submissions')
                        ->select(DB::raw("COUNT(user_id_adopter) as id"))
                        ->where('status', $status)
                        ->get();
                        // ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where status = ?', [$status]);
        }
        else{
            $pet = DB::table('adopt_submissions')
                        // ->select(DB::raw("COUNT(status) as statusPet"))
                        ->select(DB::raw("COUNT(user_id_adopter) AS id"))
                        ->where('status', $status)
                        ->where('user_id_adopter', $userID)
                        ->get();
                        // ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where user_id_adopter = ? and status = ?', [$userID, $status]);
        }

        return $pet;
    }

    // // untuk itung banyaknya cancel
    public function countStatusCanceled($userID){
        $status = 'Canceled';
        if (!Auth::guest() && Auth::user()->role_id == 1) {

            $pet = DB::table('adopt_submissions')
                        // ->select(DB::raw("COUNT(status) as statusPet"))
                        ->where('status', $status)
                        // ->get();
                        ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where status = ?', [$status]);
        }
        else {
            // if (!Auth::guest()) {
            //     $userID = Auth::user()->id;
            // } else {
            //     $userID = 0;
            // }

            $pet = DB::table('adopt_submissions')
                        // ->select(DB::raw("COUNT(status) as statusPet"))
                        // ->select(DB::raw("COUNT(*) AS statusPet"))
                        ->where('status', $status)
                        ->where('user_id_adopter', $userID)
                        // ->get();
                        ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where user_id_adopter = ? and status = ?', [$userID, $status]);
        }

        return $pet;
    }

    // // untuk itung banyaknya reject
    public function countStatusRejected($userID){
        $status = 'Rejected';
        if (!Auth::guest() && Auth::user()->role_id == 1) {

            $pet = DB::table('adopt_submissions')
                        // ->select(DB::raw("COUNT(status) as statusPet"))
                        ->where('status', $status)
                        // ->get();
                        ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where status = ?', [$status]);
        }
        else {
            // if (!Auth::guest()) {
            //     $userID = Auth::user()->id;
            // } else {
            //     $userID = 0;
            // }

            $pet = DB::table('adopt_submissions')
                        // ->select(DB::raw("COUNT(status) as statusPet"))
                        // ->select(DB::raw("COUNT(*) AS statusPet"))
                        ->where('status', $status)
                        ->where('user_id_adopter', $userID)
                        // ->get();
                        ->count();

            // $pet = DB::select('select count(status) as statusPet
            //                     from adopt_submissions
            //                     where user_id_adopter = ? and status = ?', [$userID, $status]);
        }

        return $pet;
    }

    // // untuk upload records pet
    public function uploadPerkembanganPet(){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
            $status = 'Accepted';
        } else {
            $userID = 0;
            $status = 'Accepted';
        }

        $pet = DB::table('adopt_submissions')
            ->select('*', 'adopt_submissions.status', 'adopt_submissions.user_id_adopter')
            ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
            ->where('status', $status)
            ->where('user_id_adopter', $userID)
            ->get();

        return $pet;

    }
}
