<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{

    // panggil model nya
    public function __construct()
    {
        $this->M_User = new User();
        $this->M_Service = new Service();
    }

    // // // = Grooming =
    // ============================================================
    public function viewGrooming(Request $request){
        // $service_types = Request()->service_type;
        // if ($service_types == 'Grooming') {
        //     $service_type = "Grooming";
        //     $dataUser = $this->M_User->petShopUser();
        //     // $dataPetShop = $this->M_Service->getDataService();
        //     $minPrice = $this->M_Service->minPriceServices($service_type);
        //     $maxPrice = $this->M_Service->maxPriceServices($service_type);
        //     // return view('V_Grooming',['test' => $dataUser]);
        //     return view('V_Services', compact('dataUser', 'minPrice', 'maxPrice', 'service_type'));
        // } else {
        //     # code...
        // }

        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        $user = $this->M_User->getDataUser();
        $search_radius = $request->radius;

        $service_type = "Grooming";

        if ($search_radius == null) {
            $valid = 0;
            $radius = '';
            $typePaginate = "services";
            $dataUser = $this->M_User->petShopUser();
        }
        else {
            // $lat = $request->lat;
            // $long = $request->long;
            $radius = $request->radius;
            $valid = 1;
            $typePaginate = "searchServices";
            // $dataUser = $this->M_User->petShopUserSearch($lat, $long);
            $dataUser = $this->M_User->petShopUserSearch($radius);
        }

        // $dataPetShop = $this->M_Service->getDataService();
        $countGrooming = $this->M_Service->countReservasiGroomKonsul($service_type);
        $minPrice = $this->M_Service->minPriceServices($service_type);
        $maxPrice = $this->M_Service->maxPriceServices($service_type);
        // return view('V_Grooming',['test' => $dataUser]);
        return view('V_Services', compact('countGrooming', 'user', 'userID', 'radius', 'typePaginate', 'valid', 'dataUser', 'minPrice', 'maxPrice', 'service_type'));
    }

    // // untuk detail grooming
    public function viewDetailGrooming($id){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        $service_type = "Grooming";
        $countPetShopID = $this->M_Service->countPetShopIDGroom($id);
        $dataUser = $this->M_User->userDataByID($id);
        $user = $this->M_User->userDataByID($userID);
        $petShopGroomKonsul = $this->M_Service->getDataDetailGroomKonsul($id, $service_type);
        return view('V_Detail_Services', compact('user', 'countPetShopID','petShopGroomKonsul','dataUser', 'userID', 'service_type'));
    }


    // // // = Konsultasi =
    // ============================================================
    public function viewKonsultasi(Request $request){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        $user = $this->M_User->getDataUser();
        $search_radius = $request->radius;

        if ($search_radius == null) {
            $valid = 0;
            $radius = '';
            $typePaginate = "services";
            $dataUser = $this->M_User->petShopUser();
        }
        else {
            // $lat = $request->lat;
            // $long = $request->long;
            $radius = $request->radius;
            $valid = 1;
            $typePaginate = "searchServices";
            // $dataUser = $this->M_User->petShopUserSearch($lat, $long);
            $dataUser = $this->M_User->petShopUserSearch($radius);
        }

        $service_type = "Konsultasi";

        // $dataPetShop = $this->M_Service->getDataService();
        $countGrooming = $this->M_Service->countReservasiGroomKonsul($service_type);
        $minPrice = $this->M_Service->minPriceServices($service_type);
        $maxPrice = $this->M_Service->maxPriceServices($service_type);
        return view('V_Services', compact('countGrooming', 'user', 'userID', 'radius', 'typePaginate', 'valid', 'dataUser', 'minPrice', 'maxPrice', 'service_type'));
    }

    // // untuk detail konsultasi
    public function viewDetailKonsultasi($id){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }
        $service_type = "Konsultasi";
        $countPetShopID = $this->M_Service->countPetShopIDKonsul($id);
        $dataUser = $this->M_User->userDataByID($id);
        $user = $this->M_User->userDataByID($userID);
        $petShopGroomKonsul = $this->M_Service->getDataDetailGroomKonsul($id, $service_type);
        $paginateKonsul = $this->M_Service->paginateKonsulServices($id, $service_type);
        return view('V_Detail_Services', compact('user','countPetShopID','petShopGroomKonsul', 'paginateKonsul', 'dataUser', 'userID', 'service_type'));
    }

    // // Manage Services
    // untuk ke view V_Menage_Services.blade.php
    public function viewManageServices(){
        $userID = Auth::user()->id;

        $typeData = 'manageServices';
        $data = null;
        // jika user nya pet shop
        if (Auth::user()->role_id == 3) {
            $petShop = $this->M_Service->getDataByID();
        }
        // jika user nya admin
        else {
            $petShop = $this->M_Service->getDataService();
        }

        $countUserIDPetShop =  $this->M_Service->countUserIDPetShop($userID);

        return view('petShop.Manage Services.V_Manage_Services', compact('countUserIDPetShop', 'petShop', 'data', 'typeData'));
    }

    // untuk add services grooming
    public function viewAddGroomingServices(){
        $service_type = "Grooming";

        $userID = Auth::user()->id;

        $dataPetShop = $this->M_User->userPetShopDataTable();

        return view('petShop.Manage Services.V_Add_Services', ['userID' => $userID, 'dataPetShop' => $dataPetShop, 'service_type' => $service_type]);
    }

    // untuk add services konsultasi
    public function viewAddKonsultasiServices(){
        $service_type = "Konsultasi";

        $userID = Auth::user()->id;

        $dataPetShop = $this->M_User->userPetShopDataTable();

        return view('petShop.Manage Services.V_Add_Services', ['userID' => $userID, 'dataPetShop' => $dataPetShop, 'service_type' => $service_type]);
    }

    // function untuk proses submit input add services di view V_Add_Services
    public function prosesInsertDataServices(Request $request){

        $service_type = Request()->service_type;

        // jika grooming
        if ($service_type == 'Grooming') {
            if (Auth::user()->role_id == 1) {
                // code validation here
                $request->validate([
                    'user_id_pet_shop' =>'required',
                    'service_name' =>'required|max:255',
                    'service_price' => 'required|numeric|min:0|max:99999999',
                ]);
            }
            else {
                // code validation here
                $request->validate([
                    'service_name' =>'required|max:255',
                    'service_price' => 'required|numeric|min:0|max:99999999',
                ]);
            }

            // // tampung datanya dalam satu array
            $data = [
                'user_id_pet_shop' => Request()->user_id_pet_shop,
                'service_type' => Request()->service_type,
                'service_name' => Request()->service_name,
                'service_price' => Request()->service_price,

                // 'user_id_pet_shop' => $request->user_id_pet_shop,
                // 'temp_pet_shop_type' => $request->temp_pet_shop_type,
                // 'service_name' => $request->service_name,
                // 'service_price' => $request->service_price,

                'created_at' => \Carbon\Carbon::now(),
            ];
        }
        // jika konsultasi
        else {
            if (Auth::user()->role_id == 1) {
                // code validation here
                $request->validate([
                    'user_id_pet_shop' => 'required',
                    'service_name' => 'required|max:255',
                    'service_price' => 'required|numeric|min:0|max:99999999',
                    'doctor_name' => 'required|max:255',
                    // 'doctor_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                ]);
            }
            else {
                // code validation here
                $request->validate([
                    'service_name' => 'required|max:255',
                    'service_price' => 'required|numeric|min:0|max:99999999',
                    'doctor_name' => 'required|max:255',
                    // 'doctor_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                ]);
            }

            // // tampung datanya dalam satu array
            $data = [
                'user_id_pet_shop' => Request()->user_id_pet_shop,
                'service_type' => Request()->service_type,
                'service_name' => Request()->service_name,
                'service_price' => Request()->service_price,
                'doctor_name' => Request()->doctor_name,
                // 'doctor_photo' => $file_name_foto_dokter,

                // 'user_id_pet_shop' => $request->user_id_pet_shop,
                // 'temp_pet_shop_type' => $request->temp_pet_shop_type,
                // 'service_name' => $request->service_name,
                // 'service_price' => $request->service_price,
                // 'doctor_name' => $request->doctor_name,
                // 'doctor_photo' => $file_name_foto_dokter,

                'created_at' => \Carbon\Carbon::now(),
            ];
        }

        // ambil dari model nya
        $this->M_Service->tambahData($data);

        // return redirect('/manage/services');
        return redirect('/manage/services')->with('message', 'Add Services Berhasil...');

    }

    // // untuk ke view edit services
    public function viewEditServices($id){

        // untuk ambil id yg login
        // $userID = Auth::user()->id;

        // ambil dari model nya
        $petShop = $this->M_Service->ubahData($id);

        return view('petShop.Manage Services.V_Edit_Services', compact('petShop'));
    }

    // // untuk proses submit edit services
    public function prosesUpdateServices(Request $request, $id){

        $service_type = Request()->service_type;

        if ($service_type == 'Grooming') {

            // code validation here
            $request->validate([
                'service_name' => 'required|max:255',
                'service_price' => 'required|numeric|min:1|max:99999999',
            ]);

            // // tampung datanya dalam satu array
            $data = [
                'service_name' => Request()->service_name,
                'service_price' => Request()->service_price,

                // 'service_name' => $request->service_name,
                // 'service_price' => $request->service_price,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else {
            // code validation here
            $request->validate([
                'service_name' => 'required|max:255',
                'service_price' => 'required|numeric|min:1|max:99999999',
                'doctor_name' => 'required|max:255',
                // 'doctor_photo' => 'mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
            ]);

            $file_foto_dokter = Request()->doctor_photo;

            $data = [
                // 'user_id_pet_shop' => Request()->user_id_pet_shop,
                'service_name' => Request()->service_name,
                'service_price' => Request()->service_price,
                'doctor_name' => Request()->doctor_name,

                // 'service_name' => $request->service_name,
                // 'service_price' => $request->service_price,
                // 'doctor_name' => $request->doctor_name,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }

        // ambil dari model nya
        $this->M_Service->prosesUbahData($data, $id);

        // return redirect('/manage/services');
        return redirect('/manage/services')->with('message', 'Edit Services Berhasil...');
    }

    // // untuk delete services
    public function deleteServices($id){
        // ambil dari model nya
        $this->M_Service->hapusData($id);
        // return redirect('/manage/services');
        return redirect('/manage/services')->with('message', 'Delete Services Berhasil...');
    }

    // // untuk enable post status
    public function activedPostStatus($id){
        // ambil dari model nya
        $this->M_Service->activePost($id);

        // return redirect('/manage/services');
        return redirect('/manage/services')->with('message', 'Enable Service Post Status Berhasil...');

    }

    // // untuk disable post status
    public function deactivedPostStatus($id){
        // ambil dari model nya
        $this->M_Service->deactivePost($id);

        // return redirect('/manage/services');
        return redirect('/manage/services')->with('message', 'Disable Service Post Status Berhasil...');
    }
}
