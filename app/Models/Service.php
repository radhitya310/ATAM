<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'service_id', // PK
        'user_id_pet_shop', // FK
        'service_type',
        'service_name',
        'service_price',
        'service_post_status',
        'doctor_name',
    ];

    // // ambil semua data services
    public function getDataService(){
        return DB::table('services')
                    ->orderByDesc('service_id')
                    ->simplePaginate(10);
    }

    public function countReservasiGroomKonsul($service_type){
        // $service_type = 'Grooming';
        // $service_type = 'Konsultasi';
        if ($service_type == 'Grooming') {
            return DB::select('select user_id_pet_shop, count(user_id_pet_shop) as countID
                                from services join users on services.user_id_pet_shop = users.id
                                where service_type = ?
                                group by user_id_pet_shop', [$service_type]);
        }
        else if ($service_type == 'Konsultasi'){
            return DB::select('select user_id_pet_shop, count(user_id_pet_shop) as countID
                                from services join users on services.user_id_pet_shop = users.id
                                where service_type = ?
                                group by user_id_pet_shop', [$service_type]);
        }

        // return DB::table('services')
        //             ->select('*', 'count(user_id_pet_shop) as countID')
        //             ->join('users', 'users.id', '=', 'services.user_id_pet_shop')
        //             ->where('service_type', $service_type)
        //             ->get();
    }

    // untuk di manage order
    public function countUserIDPetShop($userID){
        return DB::table('services')
                    ->join('users', 'users.id', '=', 'services.user_id_pet_shop')
                    ->where('services.user_id_pet_shop', $userID)
                    ->count();
    }

    // // untuk ambil count user_id_pet_shop untuk grooming
    public function countPetShopIDGroom($id){
        $service_type = 'Grooming';
        return DB::select('select count(user_id_pet_shop) AS id
                            from services
                            where user_id_pet_shop = ? and service_type = ?', [$id, $service_type]);
    }

    // // untuk ambil count user_id_pet_shop untuk konsultasi
    public function countPetShopIDKonsul($id){
        $service_type = 'Konsultasi';
        return DB::select('select count(user_id_pet_shop) as id
                            from services
                            where user_id_pet_shop = ? and service_type = ?', [$id, $service_type]);
    }

    // // ambil semua data tapi di group by pet shop id nya agar tidak duplikat
    // public function groupByTempPetShopsTable(){
    //     return DB::select('select user_id_pet_shop
    //                         from services
    //                         group by user_id_pet_shop');
    // }

    // // ambil min price
    public function minPriceServices($service_type){
        return DB::select('select user_id_pet_shop, min(service_price) AS service_price
                            from services
                            where service_type = ?
                            group by user_id_pet_shop', [$service_type]);
    }

    // // ambil max price
    public function maxPriceServices($service_type){
        return DB::select('select user_id_pet_shop, max(service_price) AS service_price
                            from services
                            where service_type = ?
                            group by user_id_pet_shop', [$service_type]);
    }

    // // ambil data berdasarkan siapa yang login
    public function getDataByID(){
        $userID = Auth::user()->id;

        return DB::table('services')
                    ->where('user_id_pet_shop', $userID)
                    ->orderByDesc('service_id')
                    ->simplePaginate(10);
    }

    // // untuk add data
    public function tambahData($data){
        $dataUser = DB::table('services')
                        ->insert($data);

        return $dataUser;
    }

    // // untuk ke view edit
    public function ubahData($id){
        return DB::table('services')
                    ->where('service_id', $id)
                    ->get();
    }

    // // untuk add data
    public function prosesUbahData($data, $id){
        $dataUser = DB::table('services')
                        ->where('service_id', $id)
                        ->update($data);

        return $dataUser;
    }

    // // untuk delete data
    public function hapusData($id){
        return DB::table('services')
                    ->where('service_id', $id)
                    ->delete();
    }

    // // untuk mengaktifkan post status
    public function activePost($id){
        return DB::table('services')
                    ->where('service_id', $id)
                    ->update([
                        'service_post_status' => 'enabled'
                    ]);
    }

    // // untuk non-aktifkan post status
    public function deactivePost($id){
        return DB::table('services')
                    ->where('service_id', $id)
                    ->update([
                        'service_post_status' => 'disabled'
                    ]);
    }

    // // untuk detail groom dan konsultasi service nya
    public function getDataDetailGroomKonsul($id, $service_type){
        $data = DB::table('services')
                    ->where('user_id_pet_shop', $id)
                    ->where('service_type', $service_type)
                    ->orderBy('service_price')
                    ->get();
                    // ->simplePaginate(4);

        return $data;
    }


    // // untuk detail konsul services
    public function paginateKonsulServices($id, $service_type){
        $data = DB::table('services')
                    ->where('user_id_pet_shop', $id)
                    ->where('service_type', $service_type)
                    ->orderBy('service_price')
                    ->simplePaginate(2);

        return $data;
    }
}
