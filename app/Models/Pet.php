<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Pet extends Model
{
    use HasFactory;

    // nama table nya
    protected $table = 'pets';

    // nama kolom nya
    protected $fillable = [
        'pet_id', // PK
        'user_id', // FK
        'species_id', // FK
        'breed_id', // FK
        'sex_id', // FK
        'age_id', // FK
        'source_id', // FK
        'vaccine_id', // FK
        'sterilization_id', // FK
        'status',
        'pet_name',
        'pet_description',
        'pet_image',
    ];


    // ambil data dari table pets untuk manage pet
    public function getAllData(){
        // join 3 table
        $int = 10;
        $pet = DB::table('pets')
                    ->join('users', 'users.id', '=', 'pets.user_id')
                    ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                    ->orderByDesc('pet_id')
                    ->simplePaginate($int);

        // $pet = M_Pet::simplePaginate(10);
        // $pet = DB::table('pets')->simplePaginate(10);

        // $pet = DB::table('pets')
        //             ->join('users', 'users.id', '=', 'pets.user_id')
        //             ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
        //             ->orderByDesc('pet_id')
        //             ->get();

        return $pet;
    }

    // add data ke table pets
    public function tambahData($pet_data){
        return DB::table('pets')
                    ->insert($pet_data);
    }

    // untuk view edit data
    public function ubahData($id){
        return DB::table('pets')
                    ->join('users', 'users.id', '=', 'pets.user_id')
                    ->where('pet_id', $id)
                    ->get();
    }

    // update data
    public function proses_ubahData($data, $id){
        return DB::table('pets')
                    ->where('pet_id', $id)
                    ->update($data);
    }

    // delete data
    public function hapusData($id){

        // return DB::delete('delete from pets where pet_id = ?', [$id]);

        return DB::table('pets')
                     ->where('pet_id', $id)
                     ->delete();
    }

    // // untuk view pet adoption di Home Page
    public function getDataHome(){
        // // menggunakan query builder
        // // join 2 table pets dan breeds
        // // diurutkan dari yang terbesar pet_id nya
        // // inputan terakhir akan muncul di pling kiri
        // $pet = DB::table('pets')
        //         ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
        //         ->orderByDesc('pet_id')
        //         ->limit(4)
        //         ->get();
        $status = 'Request for Adopt';
        $pet = DB::table('pets')
                ->join('users', 'users.id', '=', 'pets.user_id')
                ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                ->where('pets.status', '=', $status)
                ->orderByDesc('pet_id')
                ->paginate(3);
                // ->simplePaginate(3);

        // $pet = DB::select('select * from pets
        //                     left join breeds
        //                     on breeds.breed_id = pets.breed_id
        //                     ORDER BY pet_id DESC
        //                     LIMIT 4');

        return $pet;
    }

    // // Pagination Adoption - data all
    public function getDataPaginateAdop(){
        // // menggunakan query builder
        // // diurutkan dari yang terbesar pet_id nya
        $pet = DB::table('pets')
                    ->join('species', 'species.species_id', '=', 'pets.species_id')
                    ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                    ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                    ->where('pets.status', '=', 'Request for Adopt')
                    ->whereNotIn('pet_id', function($query){
                        if (!Auth::guest()) {
                            $userID = Auth::user()->id;
                        } else {
                            $userID = 0;
                        }
                        $query->select('pet_id')
                              ->from('adopt_submissions')
                              ->where('status', '=', 'Waiting for Adopt')
                              ->where('user_id_adopter', '=', $userID);
                    })
                    // ->where('pets.status', '!=', 'Mark as Adopted')
                    ->orderByDesc('pet_id')
                    ->paginate(6);
                    // ->simplePaginate(6);

        // // menggunakan eloquent
        // $pet = M_Pet::paginate(9);
        // $pet = M_Pet::paginate(9);
        return $pet;
    }

    // // Seearch filter Pagination Adoption - data all
    // public function getDataSearchPaginateAdop($search_radius,$data1,$data2,$data3,$lat,$long){
    public function getDataSearchPaginateAdop($search_radius,$data1,$data2,$data3){
        // // menggunakan query builder
        // // join dua table
        // // diurutkan dari yang terbesar pet_id nya
        // $pet = DB::table('pets')
        //         ->join('users', 'users.id', '=', 'pets.user_id')
        //         ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
        //         ->where('pets.status', '=', 'Request for Adopt')
        //         ->where('users.kode_pos','like',''.$data.'%')
        //         // ->where('users.kode_pos','like','%'.$data)
        //         // ->where('users.kode_pos','like','%'.$data.'%')
        //         ->orderByDesc('pet_id')
        //         ->simplePaginate(9);

        if (!Auth::guest()) {
            $lat = Auth::user()->latitude;
            $long = Auth::user()->longitude;
        } else {
            $lat = 0;
            $long = 0;
        }


        if ($search_radius != "" && $data1 == "" && $data2 == "" && $data3 == "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            // ->select('*', DB::raw("
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
                            // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                            //                 * cos(radians(users.latitude))
                            //                 * cos(radians(users.longitude) - radians(" . $long . "))
                            //                 + sin(radians(" .$lat. "))
                            //                 * sin(radians(users.latitude))) AS distance"))
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->having(DB::raw('distance'), '<=', 5)
                            // ->where('pets.species_id', $data1)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            // ->where('pets.species_id', $data1)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->having(DB::raw('distance'), '>', 10)
                            // ->where('pets.species_id', $data1)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius == "" && $data1 != "" && $data2 == "" && $data3 == "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius == "" && $data1 == "" && $data2 != "" && $data3 == "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.breed_id', $data2)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius == "" && $data1 == "" && $data2 == "" && $data3 != "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius != "" && $data1 != "" && $data2 == "" && $data3 == "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->having(DB::raw('distance'), '>', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius != "" && $data1 == "" && $data2 != "" && $data3 == "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.breed_id', $data2)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.breed_id', $data2)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.breed_id', $data2)
                            ->having(DB::raw('distance'), '>', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius != "" && $data1 == "" && $data2 == "" && $data3 != "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius == "" && $data1 != "" && $data2 != "" && $data3 == "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.breed_id', $data2)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius == "" && $data1 != "" && $data2 == "" && $data3 != "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius == "" && $data1 == "" && $data2 != "" && $data3 != "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.breed_id', $data2)
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius != "" && $data1 != "" && $data2 != "" && $data3 == "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.breed_id', $data2)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.breed_id', $data2)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.breed_id', $data2)
                            ->having(DB::raw('distance'), '>', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius != "" && $data1 == "" && $data2 != "" && $data3 != "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.breed_id', $data2)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.breed_id', $data2)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.breed_id', $data2)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius != "" && $data1 != "" && $data2 == "" && $data3 != "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('species', 'species.species_id', '=', 'pets.species_id')
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
        }
        elseif ($search_radius == "" && $data1 != "" && $data2 != "" && $data3 != "") {
            $pet = DB::table('pets')
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.breed_id', $data2)
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($search_radius != "" && $data1 != "" && $data2 != "" && $data3 != "") {
            if ($search_radius == 1) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.breed_id', $data2)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 2) {
                $pet = DB::table('pets')
                            ->select('*', DB::raw("
                                            2 * 6371 * (
                                                asin(
                                                    sqrt(
                                                        ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                        cos((0.01745 * ".$lat.")) *
                                                        cos((0.01745 * users.latitude)) *
                                                        ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                    )
                                                )
                                            )
                                            AS distance"))
                            ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                            ->join('users', 'users.id', '=', 'pets.user_id')
                            ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                            ->where('pets.status', '=', 'Request for Adopt')
                            ->where('pets.species_id', $data1)
                            ->where('pets.breed_id', $data2)
                            ->where('pets.age_id', $data3)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->whereNotIn('pet_id', function($query){
                                if (!Auth::guest()) {
                                    $userID = Auth::user()->id;
                                } else {
                                    $userID = 0;
                                }
                                $query->select('pet_id')
                                        ->from('adopt_submissions')
                                        ->where('status', '=', 'Waiting for Adopt')
                                        ->where('user_id_adopter', '=', $userID);
                            })
                            ->orderByDesc('pet_id')
                            ->get();
            }
            elseif ($search_radius == 3) {
                $pet = DB::table('pets')
                        ->select('*', DB::raw("
                                        2 * 6371 * (
                                            asin(
                                                sqrt(
                                                    ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                    cos((0.01745 * ".$lat.")) *
                                                    cos((0.01745 * users.latitude)) *
                                                    ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                )
                                            )
                                        )
                                        AS distance"))
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.breed_id', $data2)
                        ->where('pets.age_id', $data3)
                        ->having(DB::raw('distance'), '>', 10)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
            }
        }

        return $pet;
    }

    // // untuk search guest nya
    public function getDataSearchPaginateAdopGuest($data1,$data2,$data3){
        // // menggunakan query builder
        // // join dua table
        // // diurutkan dari yang terbesar pet_id nya
        // $pet = DB::table('pets')
        //         ->join('users', 'users.id', '=', 'pets.user_id')
        //         ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
        //         ->where('pets.status', '=', 'Request for Adopt')
        //         ->where('users.kode_pos','like',''.$data.'%')
        //         // ->where('users.kode_pos','like','%'.$data)
        //         // ->where('users.kode_pos','like','%'.$data.'%')
        //         ->orderByDesc('pet_id')
        //         ->simplePaginate(9);

        // if ($search_radius == "") {
        //     $pet = 0;
        // } else {
        // }
        if ($data1 != "" && $data2 == "" && $data3 == "") {
            $pet = DB::table('pets')
                        ->select('*')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif($data1 == "" && $data2 != "" && $data3 == "") {
            $pet = DB::table('pets')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        // ->where('pets.species_id', $data1)
                        ->where('pets.breed_id', $data2)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif($data1 == "" && $data2 == "" && $data3 != ""){
            $pet = DB::table('pets')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.age_id', $data3)
                        // ->where('pets.breed_id', $data2)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif($data1 != "" && $data2 != "" && $data3 == ""){
            $pet = DB::table('pets')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.breed_id', $data2)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif($data1 != "" && $data2 == "" && $data3 != ""){
            $pet = DB::table('pets')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif($data1 == "" && $data2 != "" && $data3 != ""){
            $pet = DB::table('pets')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.breed_id', $data2)
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif($data1 != "" && $data2 != "" && $data3 != ""){
            $pet = DB::table('pets')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->where('pets.status', '=', 'Request for Adopt')
                        ->where('pets.species_id', $data1)
                        ->where('pets.breed_id', $data2)
                        ->where('pets.age_id', $data3)
                        ->whereNotIn('pet_id', function($query){
                            if (!Auth::guest()) {
                                $userID = Auth::user()->id;
                            } else {
                                $userID = 0;
                            }
                            $query->select('pet_id')
                                    ->from('adopt_submissions')
                                    ->where('status', '=', 'Waiting for Adopt')
                                    ->where('user_id_adopter', '=', $userID);
                        })
                        ->orderByDesc('pet_id')
                        ->get();
        }

        return $pet;
    }

    // untuk detail complete data pet
    public function getAllDataDetail($id){
        if (!Auth::guest()) {
            // $lat = DB::select('select latitude from users where id = ?', [$userID]);
            // $long = DB::select('select longitude from users where id = ?', [$userID]);
            // $lat = DB::table('users')->select('users.latitude')->where('id', $userID)->get();
            // $long = DB::table('users')->select('users.longitude')->where('id', $userID)->get();
            $lat = Auth::user()->latitude;
            $long = Auth::user()->longitude;
        } else {
            $lat = 0;
            $long = 0;
        }

        $pet = DB::table('pets')
                        // ->select('*', DB::raw("
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
                        // ->select('*', DB::raw("6371 * acos(cos(radians(" . $lat . "))
                        //                 * cos(radians(users.latitude))
                        //                 * cos(radians(users.longitude) - radians(" . $long . "))
                        //                 + sin(radians(" .$lat. "))
                        //                 * sin(radians(users.latitude))) AS distance"))
                        ->select('*', DB::raw("
                                        2 * 6371 * (
                                            asin(
                                                sqrt(
                                                    ( (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) * (sin(((0.01745 * ".$lat.") - (0.01745 * users.latitude))/2)) ) +
                                                    cos((0.01745 * ".$lat.")) *
                                                    cos((0.01745 * users.latitude)) *
                                                    ( (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) * (sin(((0.01745 * ".$long.") - (0.01745 * users.longitude))/2)) )
                                                )
                                            )
                                        )
                                        AS distance"))
                    ->join('users', 'users.id', '=', 'pets.user_id')
                    ->join('species', 'species.species_id', '=', 'pets.species_id')
                    ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                    ->join('sexs', 'sexs.sex_id', '=', 'pets.sex_id')
                    ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                    ->join('sources', 'sources.source_id', '=', 'pets.source_id')
                    ->join('vaccines', 'vaccines.vaccine_id', '=', 'pets.vaccine_id')
                    ->join('sterilizations', 'sterilizations.sterilization_id', '=', 'pets.sterilization_id')
                    ->where('pet_id', $id)
                    ->get();

        return $pet;
    }

    // ambil data dari table pets untuk status my pet
    public function getAllDataStatusMyPet(){
        // ambil id nya
        if (!Auth::guest()) {
            $userID = Auth::user()->id;

            // join 3 table
            // $pet = DB::table('pets')
            //             ->join('users', 'users.id', '=', 'pets.user_id')
            //             ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
            //             ->where('pets.user_id', $userID)
            //             ->orderByDesc('pets.pet_id')
            //             ->simplePaginate(10);

            $pet = DB::table('pets')
                        ->select('*', 'pets.pet_id', 'pets.status')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('species', 'species.species_id', '=', 'pets.species_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->join('sexs', 'sexs.sex_id', '=', 'pets.sex_id')
                        ->join('ages', 'ages.age_id', '=', 'pets.age_id')
                        ->join('sources', 'sources.source_id', '=', 'pets.source_id')
                        ->join('vaccines', 'vaccines.vaccine_id', '=', 'pets.vaccine_id')
                        ->join('sterilizations', 'sterilizations.sterilization_id', '=', 'pets.sterilization_id')
                        ->where('pets.user_id', $userID)
                        ->where('pets.status', 'Request for Adopt')
                        ->whereNotIn('pets.pet_id', function($query){
                            $query->select('pet_id')
                                  ->from('adopt_submissions')
                                  ->where('status', '=', 'Waiting for Adopt');
                        })
                        ->orderByDesc('pets.pet_id')
                        ->get();

            // $pet = DB::select('select *
            //                     from pets
            //                     left join users on users.id = pets.user_id
            //                     left join breeds on breeds.breed_id = pets.breed_id
            //                     where user_id = ? and pet_id not in (select pet_id from adopt_submissions)
            //                     order by pet_id desc', [$userID]);


            // $lim = 5;
            // $off = 1;
            // $pet = DB::select('select * from pets
            //                     left join users on pets.user_id = users.id
            //                     left join breeds on breeds.breed_id = pets.breed_id
            //                     where pets.user_id = ?
            //                     Limit ? Offset ?', [$userID, $lim, $off]);

            // $pet = DB::select('select * from pets
            //                     left join users on pets.user_id = users.id
            //                     left join breeds on breeds.breed_id = pets.breed_id
            //                     where pets.user_id = ?
            //                     order by pet_id desc', [$userID]);
        }
        else {
            $pet = null;
        }
        return $pet;
    }

    // untuk proses approve pet adop
    public function approveProsesAdop($id1, $id2){
        // ubah status nya jadi mark as adopted
        $pet = DB::table('pets')
                    ->join('adopt_submissions', 'adopt_submissions.pet_id', '=', 'pets.pet_id')
                    ->where('pets.pet_id', $id1)
                    ->update([
                            'pets.status' => 'Mark as Adopted',
                            // 'pets.user_id_adopter' => $id2,
                        ]);

        return $pet;
    }

    // itung banyaknya user yg add pet
    public function countUserID($userID){
        return DB::table('pets')
                    ->where('user_id', $userID)
                    ->count();
    }

    // itung banyaknya pet yg status request untuk di page adoption
    public function countPetID(){
        $status = 'Request for Adopt';
        return DB::table('pets')
                    ->where('status', $status)
                    ->count();
    }

    public function searchAdopter($data){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
            $status = 'Waiting for Adopt';
            $adopter = DB::table('adopt_submissions')
                        ->select('*', 'adopt_submissions.status', 'adopt_submissions.user_id_adopter')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->join('users', 'users.id', '=', 'adopt_submissions.user_id_adopter')
                        // ->where('pets.user_id', $userID)
                        // ->where('adopt_submissions.status', $status)
                        ->where(function($query) use($userID, $status){
                            // $userID = Auth::user()->id;
                            return $query->where('pets.user_id', $userID)
                                         ->where('adopt_submissions.status', $status);
                        })
                        ->where(function($query) use($data){
                            return $query->where('users.name', 'like', '%'.$data.'%')
                                         ->orWhere('pet_name', 'like', '%'.$data.'%')
                                         ->orWhere('adopt_submissions.status', 'like', '%'.$data.'%');
                        })
                        ->orderByDesc('adopt_submissions.pet_id')
                        ->get();

            // $adopter = DB::select("select *, adopt_submissions.status, adopt_submissions.user_id_adopter
            //                         from adopt_submissions
            //                         join pets on pets.pet_id = adopt_submissions.pet_id
            //                         join users on users.id = adopt_submissions.user_id_adopter
            //                         where (pets.user_id = ? and adopt_submissions.status = ?) or adopt_submissions.status like '%?%'", [$userID, $status, $data]);
        }
        else {
            $adopter = null;
        }

        return $adopter;
    }

    public function searchDataAccepted($data){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
            $status = 'Accepted';
            $pet = DB::table('adopt_submissions')
                        ->select('*', 'adopt_submissions.status')
                        ->join('pets', 'pets.pet_id', '=', 'adopt_submissions.pet_id')
                        ->join('users', 'users.id', '=', 'adopt_submissions.user_id_adopter')
                        // ->where('adopt_submissions.status', '=', 'Accepted')
                        // ->where('pets.user_id', $userID)
                        ->where(function($query) use($userID, $status){
                            // $userID = Auth::user()->id;
                            return $query->where('pets.user_id', $userID)
                                         ->where('adopt_submissions.status', $status);
                        })
                        ->where(function($query) use($data){
                            return $query->where('users.name', 'like', '%'.$data.'%')
                                         ->orWhere('pet_name', 'like', '%'.$data.'%')
                                         ->orWhere('adopt_submissions.status', 'like', '%'.$data.'%');
                        })
                        ->orderByDesc('adopt_submissions.pet_id')
                        ->get();
        } else {
            $pet = 0;
        }

        return $pet;
    }

    public function searchPet($data){
        // ambil id nya
        if (!Auth::guest()) {
            $userID = Auth::user()->id;

            // join 3 table
            // $pet = DB::table('pets')
            //             ->join('users', 'users.id', '=', 'pets.user_id')
            //             ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
            //             ->where('pets.user_id', $userID)
            //             ->orderByDesc('pets.pet_id')
            //             ->simplePaginate(10);

            $pet = DB::table('pets')
                        ->select('*', 'pets.pet_id', 'pets.status')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->where(function($query) use($userID){
                            return $query->where('pets.user_id', $userID)
                                         ->where('pets.status', 'Request for Adopt')
                                         ->whereNotIn('pets.pet_id', function($query){
                                            $query->select('pet_id')
                                                  ->from('adopt_submissions')
                                                  ->where('status', '=', 'Waiting for Adopt');
                                         });
                        })
                        ->where(function($query) use($data){
                            return $query->where('pet_name', 'like', '%'.$data.'%')
                                         ->orWhere('pets.status', 'like', '%'.$data.'%');
                        })
                        ->orderByDesc('pets.pet_id')
                        ->get();


            // $pet = DB::select('select *
            //                     from pets
            //                     left join users on users.id = pets.user_id
            //                     left join breeds on breeds.breed_id = pets.breed_id
            //                     where user_id = ? and pet_id not in (select pet_id from adopt_submissions)
            //                     order by pet_id desc', [$userID]);


            // $lim = 5;
            // $off = 1;
            // $pet = DB::select('select * from pets
            //                     left join users on pets.user_id = users.id
            //                     left join breeds on breeds.breed_id = pets.breed_id
            //                     where pets.user_id = ?
            //                     Limit ? Offset ?', [$userID, $lim, $off]);

            // $pet = DB::select('select * from pets
            //                     left join users on pets.user_id = users.id
            //                     left join breeds on breeds.breed_id = pets.breed_id
            //                     where pets.user_id = ?
            //                     order by pet_id desc', [$userID]);
        }
        else {
            $pet = null;
        }
        return $pet;
    }
}
