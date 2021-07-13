<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'transaction_id', // PK
        'user_id', // FK
        'service_id', // FK
        'transaction_date',
        'transaction_name',
        'quantity',
        'total_price',
        'time',
        'status',
        'reservation_code',
        'reason',
    ];

    // // ambil semua data
    // public function allTransactionsDataTable(){
    //     return DB::table('transactions')
    //                 ->orderByDesc('transaction_id')
    //                 ->get();
    // }


    // // untuk itung banyaknya order
    // public function countServiceID($id){
    //     return DB::table('transactions')
    //                 ->join('users', 'users.id', '=', 'transactions.user_id')
    //                 ->select(DB::raw("COUNT(service_id) as service_id"))
    //                 ->where('users.id', $id)
    //                 ->get();
    // }


    // untuk di manage order
    public function countUserIDPetShop($userID){
        return DB::table('transactions')
                    ->join('services', 'services.service_id', '=', 'transactions.service_id')
                    ->where('services.user_id_pet_shop', $userID)
                    ->count();
    }

    // // hitung jumlah id user yg melakukan transaksi
    public function countUserID(){
        $userID = Auth::user()->id;
        return DB::table('transactions')
                    ->select(DB::raw("COUNT(user_id) as id"))
                    ->where('user_id', $userID)
                    ->get();

        // return DB::select('select count(user_id) as id
        //                     from transactions
        //                     where user_id = ?', [$userID]);
    }

    // // ambil semua data
    public function getDataTransaction($userID){
        return DB::table('transactions')
                    ->join('services', 'services.service_id', '=', 'transactions.service_id')
                    ->join('users', 'users.id', '=', 'transactions.user_id')
                    ->where('user_id', $userID)
                    ->orderByDesc('transaction_id')
                    ->simplePaginate(10);
    }

    // // ambil data untuk view detail transaction
    public function detailTransaction($transID){
        return DB::table('transactions')
                    ->join('services', 'services.service_id', '=', 'transactions.service_id')
                    ->join('users', 'users.id', '=', 'transactions.user_id')
                    ->where('transaction_id', $transID)
                    ->get();
    }

    // // ambil semua data untuk view manage order - pet shop
    public function manageOrder($userID){
        // jika admin
        // if (Auth::user()->role_id == 1) {
        //     return DB::table('transactions')
        //                 ->join('services', 'services.service_id', '=', 'transactions.service_id')
        //                 ->join('users', 'users.id', '=', 'transactions.user_id')
        //                 ->orderByDesc('transaction_id')
        //                 ->simplePaginate(10);
        // }
        // else {
        // }
        // jika pet shop
        return DB::table('transactions')
                    ->join('services', 'services.service_id', '=', 'transactions.service_id')
                    ->join('users', 'users.id', '=', 'transactions.user_id')
                    ->where('services.user_id_pet_shop', $userID)
                    // ->where('transactions.status', '!=', 'Canceled')
                    ->orderByDesc('transaction_id')
                    ->simplePaginate(10);

    }

    // // untuk insert data ke table transactions
    public function insertData($data){
        return DB::table('transactions')
                    ->insert($data);
    }

    // // untuk update data ke table transactions
    public function updateData($id, $data){
        return DB::table('transactions')
                    ->where('transaction_id', $id)
                    ->update($data);
    }

}
