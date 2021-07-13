<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // untuk nama table nya sesuai dengan di db
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // kolom yg dapat di isi
    protected $fillable = [
        'id', //PK
        'role_id', // tambah kolom role_id => FK
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'longitude',
        'latitude',
        'user_photo',
        'more_status_pet_shop',
        'open_hour_pet_shop'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];

    // // relationship dari model M_Role ke User
    // // dari table roles ke users
    // public function M_Role(){
    //     return $this->belongsTo(M_Role::class, 'role_id');
    // }


    // // untuk ambil data berdasarkan search
    public function search($data, $typeSeach){
        $userID = Auth::user()->id;

        if ($typeSeach == 'manageUser') {
            return DB::table('users')
                        ->join('roles', 'roles.role_id', '=', 'users.role_id')
                        ->where('name', 'like', '%'.$data.'%')
                        ->orWhere('id', '=', $data)
                        ->orWhere('users.role_id', '=', $data)
                        ->orWhere('email', 'like', '%'.$data.'%')
                        ->orWhere('role_name', 'like', '%'.$data.'%')
                        ->orderByDesc('id')
                        ->get();
        }
        elseif ($typeSeach == 'managePet') {
            return DB::table('pets')
                        ->join('users', 'users.id', '=', 'pets.user_id')
                        ->join('breeds', 'breeds.breed_id', '=', 'pets.breed_id')
                        ->where('pet_name', 'like', '%'.$data.'%')
                        ->orWhere('pets.user_id', '=', $data)
                        ->orWhere('pets.pet_id', '=', $data)
                        ->orWhere('breed_category', 'like', '%'.$data.'%')
                        ->orWhere('status', 'like', '%'.$data.'%')
                        ->orderByDesc('pet_id')
                        ->get();
        }
        elseif ($typeSeach == 'manageServices') {
            if (Auth::user()->role_id == 1) {
                return DB::table('services')
                            ->where('user_id_pet_shop', '=', $data)
                            ->orWhere('services.service_id', '=', $data)
                            ->orWhere('service_price', 'like', '%'.$data.'%')
                            ->orWhere('service_name', 'like', '%'.$data.'%')
                            ->orWhere('doctor_name', 'like', '%'.$data.'%')
                            ->orWhere('service_type', 'like', '%'.$data.'%')
                            ->orWhere('service_post_status', 'like', '%'.$data.'%')
                            ->orderByDesc('service_id')
                            ->get();
            }
            else {
                return DB::table('services')
                            ->where('service_name', 'like', '%'.$data.'%')
                            ->orWhere('doctor_name', 'like', '%'.$data.'%')
                            ->orWhere('service_type', 'like', '%'.$data.'%')
                            ->orWhere('service_post_status', 'like', '%'.$data.'%')
                            ->orWhere('service_price', 'like', '%'.$data.'%')
                            ->orderByDesc('service_id')
                            ->get();
            }

        }
        elseif ($typeSeach == 'manageOrder') {
            if (Auth::user()->role_id == 1) {
                return DB::table('transactions')
                            ->join('services', 'services.service_id', '=', 'transactions.service_id')
                            ->join('users', 'users.id', '=', 'transactions.user_id')
                            ->where('transactions.service_id', 'like', '%'.$data.'%')
                            ->orWhere('transactions.user_id', 'like', '%'.$data.'%')
                            ->orWhere('users.name', 'like', '%'.$data.'%')
                            ->orWhere('transaction_id', 'like', '%'.$data.'%')
                            ->orWhere('transaction_date', 'like', '%'.$data.'%')
                            ->orWhere('transaction_name', 'like', '%'.$data.'%')
                            ->orWhere('service_name', 'like', '%'.$data.'%')
                            ->orWhere('transactions.time', 'like', '%'.$data.'%')
                            ->orWhere('total_price', 'like', '%'.$data.'%')
                            ->orWhere('transactions.status', 'like', '%'.$data.'%')
                            ->orderByDesc('transaction_id')
                            ->get();
            }
            // jika pet shop
            else {
                return DB::table('transactions')
                            ->select('*', 'services.user_id_pet_shop')
                            ->join('services', 'services.service_id', '=', 'transactions.service_id')
                            ->join('users', 'users.id', '=', 'transactions.user_id')
                            ->where('users.name', 'like', '%'.$data.'%')
                            ->orWhere('transaction_date', 'like', '%'.$data.'%')
                            ->orWhere('transaction_name', 'like', '%'.$data.'%')
                            ->orWhere('service_name', 'like', '%'.$data.'%')
                            ->orWhere('transactions.time', 'like', '%'.$data.'%')
                            ->orWhere('total_price', 'like', '%'.$data.'%')
                            ->orWhere('transactions.status', 'like', '%'.$data.'%')
                            ->orderByDesc('transaction_id')
                            ->get();
            }
        }
        elseif ($typeSeach == 'transaction') {
            return DB::table('transactions')
                        ->join('services', 'services.service_id', '=', 'transactions.service_id')
                        ->join('users', 'users.id', '=', 'transactions.user_id')
                        ->where('transaction_name', 'like', '%'.$data.'%')
                        ->orWhere('transaction_date', 'like', '%'.$data.'%')
                        ->orWhere('service_name', 'like', '%'.$data.'%')
                        ->orWhere('transactions.time', 'like', '%'.$data.'%')
                        ->orWhere('total_price', 'like', '%'.$data.'%')
                        ->orWhere('transactions.status', 'like', '%'.$data.'%')
                        ->orderByDesc('transaction_id')
                        ->get();
        }
    }

    // untuk ambil semua data dari table users
    public function getDataUser(){
        return DB::table('users')->get();
    }

    // untuk ambil data dari table users dengan role id = 3
    public function userPetShopDataTable(){
        return DB::table('users')
                    ->where('role_id', '=', 3)
                    ->get();
    }

    // untuk ambil data dari table usersd by ID
    public function userDataByID($id){
        return DB::table('users')
                    ->where('id', $id)
                    ->get();
    }


    // // // = ADMIN =
    // ==================================================
    // untuk ambil semua data
    public function getAllData(){

        // // menggunakan eloquent
        // // urutin descending berdasarkan user id
        // // method all() untuk ambil semua datanya
        // $user = User::all();
        // $user = User::simplePaginate(10);

        // // menggunakan query builder
        // // join 2 table yaitu users dan roles
        // // default join yaitu inner join
        // // method get() untuk ambil semua datanya
        // $user = DB::table('users')
        //             ->join('roles', 'roles.role_id', '=', 'users.role_id')
        //             ->orderByDesc('users.id')
        //             ->get();

        // // menggunakan left join
        $user = DB::table('users')
                    ->leftjoin('roles', 'roles.role_id', '=', 'users.role_id')
                    ->orderByDesc('users.id')
                    ->simplePaginate(10);

        // $user = DB::select('select * from users
        //                     left join roles on roles.role_id = users.role_id
        //                     order by id desc');

        return $user;
    }

    // untuk add data
    public function tambahData($tambah_data){

        // // menggunakan eloquent
        // // menggunakan method create, maka timestamp akan auto dimasukkan
        // $user = User::create($tambah_data);

        // // menggunakan query builder
        $user = DB::table('users')->insert($tambah_data);

        return $user;
    }

    // untuk view edit data
    public function ubahData($id){
        return DB::table('users')
                    ->leftJoin('roles', 'roles.role_id', '=', 'users.role_id')
                    ->where('id', $id)
                    ->get();
    }

    // update data
    public function proses_ubahData($data, $id){
        return DB::table('users')
                    ->where('id', $id)
                    ->update($data);
    }

    // delete data
    public function hapusData($id){
        // return DB::delete('delete from pets where pet_id = ?', [$id]);
        return DB::table('users')
                        ->where('id', $id)
                        ->delete();
    }




    // // // = Pet Shop =
    // ===================================================
    // untuk ambil semua data dari table users
    public function petShopUser(){
        return DB::table('users')
                    ->where('role_id' , '=', 3)
                    // ->paginate(4);
                    ->get();
    }

    // // untuk filter services
    // public function petShopUserSearch($lat, $long){
    public function petShopUserSearch($search_radius){
        if (!Auth::guest()) {
            $lat = Auth::user()->latitude;
            $long = Auth::user()->longitude;
        } else {
            $lat = 0;
            $long = 0;
        }

        if ($search_radius == 1) {
            $petShop = DB::table('users')
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
                            ->where('role_id' , '=', 3)
                            ->having(DB::raw('distance'), '<=', 5)
                            ->orderByDesc('id')
                            ->get();
        }
        elseif ($search_radius == 2) {
            $petShop = DB::table('users')
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
                            ->where('role_id' , '=', 3)
                            ->having(DB::raw('distance'), '>=', 6)
                            ->having(DB::raw('distance'), '<=', 10)
                            ->orderByDesc('id')
                            ->get();
        }
        elseif ($search_radius == 3) {
            $petShop = DB::table('users')
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
                            ->where('role_id' , '=', 3)
                            ->having(DB::raw('distance'), '>', 10)
                            ->orderByDesc('id')
                            ->get();
        }

        return $petShop;
    }
}
