<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    // panggil model nya
    public function __construct()
    {
        $this->M_User = new User();
        $this->M_Service = new Service();
        $this->M_Transaction = new Transaction();
    }


    // // Manage Order
    public function viewManageOrder(){
        $typeData = 'manageOrder';
        $data1 = null;
        $userID = Auth::user()->id;

        $data = $this->M_Transaction->manageOrder($userID);
        $dataUser = $this->M_User->getDataUser();

        // $countService =  $this->M_Transaction->countServiceID($userID);
        $countUserIDPetShop =  $this->M_Transaction->countUserIDPetShop($userID);

        return view('petShop.Manage Order.V_Manage_Order', compact('countUserIDPetShop', 'data', 'dataUser', 'userID', 'data1', 'typeData'));
    }


    // // = Transaction =
    // // =========================================================
    // // untuk tampilin view transaction nya
    public function viewTransaction(){
        $typeData = 'transaction';
        $data1 = null;
        $userID = Auth::user()->id;

        $data = $this->M_Transaction->getDataTransaction($userID);
        $dataUser = $this->M_User->getDataUser();

        $jumlah = $this->M_Transaction->countUserID();

        return view('V_Transaction', compact('data', 'dataUser', 'userID', 'data1', 'typeData', 'jumlah'));
    }

    // // untuk view detail transaction
    public function viewDetailTransaction($transID){
        $userID = Auth::user()->id;

        $data = $this->M_Transaction->detailTransaction($transID);
        $dataUser = $this->M_User->getDataUser();

        return view('V_Detail_Transaction', compact('data', 'dataUser', 'userID'));
    }


    // // = Grooming =
    // // =========================================================
    // // untuk submit checkout book grooming
    public function orderGroomingKonsul(Request $request){

        // // untuk default timezone nya
        date_default_timezone_set('Asia/Jakarta');
        // // menggunakan function date untuk ambil tanggal sekarang
        // $getTime = date('h:i:s (a)'); // // a -> am pm
        // $getTime = date('h:i:s'); // // h -> jam (format 12 jam), i -> menit, s -> detik
        // $getTime = date('H:i:s'); // // H -> jam (format 24 jam), i -> menit, s -> detik
        $getTime = date('H:i'); // // H -> jam (format 24 jam), i -> menit, s -> detik
        $getDay = date('l'); // // l -> Monday, Tuesday, ...
        $getDate= date('Y-m-d');  // // Y -> tahun (2021), m -> bulan (04), d -> hari (03)

        $date = Request()->date;
        $time = Request()->time;

        if (Request()->service_type == 'Grooming') {
            // // code validation here
            $request->validate([
                'service_id' => 'required',
                'quantity' => 'required|numeric|min:1|max:99999',
                'date' => 'required',
                'time' => 'required',
            ],
            [
                // // untuk custom pesan error nya
                'service_id.required' => 'The reservation services field is required.',
                // 'quantity.required' => 'The quantity must be at least 1.',
            ]);

            $data = [
                'service_id' => Request()->service_id,
                'user_id' => Request()->user_id,
                'quantity' => Request()->quantity,
                'time' => $date.' / '.$time,
                'transaction_name' => 'Book Grooming',
                // 'transaction_date' => Str::upper($getDate.' '.$getTime),
                'transaction_date' => $getDay.', '.$getDate.' / '.$getTime,
                'status' => 'Waiting',
                // 'total_price' => $qty * $service_price,
                'total_price' => Request()->total_price,
            ];
        }
        elseif (Request()->service_type == 'Konsultasi'){
            // code validation here
            $request->validate([
                'service_id' => 'required',
                'date' => 'required',
                'time' => 'required',
            ],
            [
                // untuk custom pesan error nya
                'service_id.required' => 'The reservation services field is required.',
            ]);

            $data = [
                'service_id' => Request()->service_id,
                'user_id' => Request()->user_id,
                'quantity' => Request()->quantity,
                'time' => $date.' / '.$time,
                'transaction_name' => 'Book Konsultasi',
                // 'transaction_date' => Str::upper($getDate.' '.$getTime),
                'transaction_date' => $getDay.', '.$getDate.' / '.$getTime,
                'status' => 'Waiting',
                // 'total_price' => $qty * $service_price,
                'total_price' => Request()->total_price,
            ];
        }

        $this->M_Transaction->insertData($data);

        // return redirect('/transaction');
        return redirect()->route('transaction')->with('message', 'Transaction Berhasil...');
    }


    // // untuk confirm button transactions
    // public function confirmTransaction($id){

    //     $data = [
    //         'status' => 'Waiting',
    //         'total_price' => Request()->total_price,
    //     ];

    //     $this->M_Transaction->updateData($id, $data);

    //     return redirect('/transaction');
    // }


    // // untuk cancel button transactions
    public function cancelTransaction(Request $request, $id){

        $request->validate([
            'message' => 'required|max:100',
        ]);

        $reason = Request()->message;

        $data = [
            'status' => 'Canceled',
            'reason' => $reason,
        ];

        $this->M_Transaction->updateData($id, $data);

        $message = 'Canceled Transaksi Berhasil...';

        // return redirect('/transaction');
        return redirect('/transaction')->with('message', $message);
    }

    // // untuk accept button transactions
    public function approvedTransaction(Request $request, $id){

        $request->validate([
            'message' => 'required|max:100',
        ]);

        $reason = Request()->message;

        $data = [
            'status' => 'Accepted',
            'reason' => $reason,
            'reservation_code' => Request()->reservation_code
        ];

        $this->M_Transaction->updateData($id, $data);

        $message = 'Accepted Transaksi Berhasil...';

        // return redirect('/manage/order');
        return redirect('/manage/order')->with('message', $message);
    }

    // // untuk reject button transactions
    public function rejectedTransaction(Request $request, $id){
        $request->validate([
            'message' => 'required|max:100',
        ]);

        $reason = Request()->message;

        $data = [
            'status' => 'Rejected',
            'reason' => $reason,
        ];

        $this->M_Transaction->updateData($id, $data);

        $message = 'Rejected Transaksi Berhasil...';

        // return redirect('/manage/order');
        return redirect('/manage/order')->with('message', $message);
    }

}
