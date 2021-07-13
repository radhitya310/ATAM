<?php

namespace App\Http\Controllers;

use App\Models\Adopt_Submission;
use App\Models\Age;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Role;
use App\Models\Service;
use App\Models\Sex;
use App\Models\Source;
use App\Models\Species;
use App\Models\Sterilization;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // declare user model nya
    public function __construct()
    {
        $this->M_User = new User();
        $this->M_Role = new Role();
        $this->M_Pet = new Pet();
        $this->M_Age = new Age();
        $this->M_Breed = new Breed();
        $this->M_Sex = new Sex();
        $this->M_Source = new Source();
        $this->M_Species = new Species();
        $this->M_Sterilization = new Sterilization();
        $this->M_Vaccine = new Vaccine();
        $this->M_Adopt_Submission = new Adopt_Submission();
        $this->M_Transaction = new Transaction();
        $this->M_Service = new Service();

        // // untuk login terlebih dahulu ketika aplikasi dibuka
        // // menggunakan authentication scaffolding
        // // aktifkan Auth::routes() di web.php
        // $this->middleware('auth');
    }

    // // untuk view register
    public function viewRegister(Request $request){
        return view('auth.V_Register');
    }

    // // untuk proses submit register
    public function prosesRegister(Request $request){
        // // untuk default timezone nya
        date_default_timezone_set('Asia/Jakarta');
        // // menggunakan function date untuk ambil tanggal sekarang
        // $getDay = date('l'); // // l -> Monday, Tuesday, ...
        // $getTime = date('h:i:sa'); // // a -> PM AM
        $getTime = date('h:i:s'); // // h -> jam, i -> menit, s -> detik
        $getDate = date('Y-m-d');  // // Y -> tahun (2021), m -> bulan (04), d -> hari (03)

        // // code validation form
        // $this->validate($request, [
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:10', 'max:255','confirmed'],
            'password_confirmation' => ['required'],
            'phone_number' => 'required|numeric',
            'address' => 'required|max:255',
            // 'checkbox' => 'required',
        ],
        [
            // // untuk custom pesan error nya
            // 'checkbox.required' => 'Kamu harus ceklis untuk menyetujui aturan tersebut',
            // 'name.min' => 'Minimal 5 karakter',
            // 'email.max' => 'Maximal 50 karakter',
        ]);

        // menggunakan eloquent
        // User::create([
        //     // 'role_id' => $request['role_id'],
        //     'email' => $request['email'],
        //     'name' => $request['name'],
        //     'password' => Hash::make($request['password']),
        //     'phone_number' => $request['phone_number'],
        //     'address' => $request['address'],
        //     'longitude' => $request['longitude'],
        //     'latitude' => $request['latitude'],
        // ]);

        $data = [
            // 'role_id' => $request['role_id'],
            'email' => $request['email'],
            'name' => $request['name'],
            'password' => Hash::make($request['password']),
            'phone_number' => $request['phone_number'],
            'address' => $request['address'],
            'longitude' => $request['longitude'],
            'latitude' => $request['latitude'],

            // 'created_at' => \Carbon\Carbon::now(),
            'created_at' => $getDate.' '.$getTime,
        ];
        $this->M_User->tambahData($data);

        // // panggil function prosesLogin nya untuk langsung auto login
        // $this->prosesLogin($request);

        return redirect()->route('login')->with('message', 'Register Berhasil...');
    }

    // // untuk view login
    public function viewLogin(){
        // if (!session()->has('url.intended')) {
        //     session(['url.intended' => url()->previous()]);
        // }
        return view('auth.V_Login');
    }

    // // untuk proses login
    public function prosesLogin(Request $request){

        $credentials = $request->only('email','password');

        // jika berhasil login
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            $generateLink = $request->linkPreviousPage;
            // if ($generateLink == 'http://127.0.0.1:8000/' ||
            //     $generateLink == 'http://127.0.0.1:8000/login' ||
            //     $generateLink == 'http://127.0.0.1:8000/register' ||
            //     $generateLink == 'http://127.0.0.1:8000/adoption' ||
            //     $generateLink == 'http://127.0.0.1:8000/status/pet-adoption' ||
            //     $generateLink == 'http://127.0.0.1:8000/grooming' ||
            //     $generateLink == 'http://127.0.0.1:8000/konsultasi' ||
            //     $generateLink == 'http://nirmala.pet/' ||
            //     $generateLink == 'http://nirmala.pet/login' ||
            //     $generateLink == 'http://nirmala.pet/register' ||
            //     $generateLink == 'http://nirmala.pet/adoption' ||
            //     $generateLink == 'http://nirmala.pet/status/pet-adoption' ||
            //     $generateLink == 'http://nirmala.pet/grooming' ||
            //     $generateLink == 'http://nirmala.pet/konsultasi' ||
            //     $generateLink == 'http://nirmala.pet/' ||
            //     $generateLink == 'https://nirmala.pet/login' ||
            //     $generateLink == 'https://nirmala.pet/register' ||
            //     $generateLink == 'https://nirmala.pet/adoption' ||
            //     $generateLink == 'https://nirmala.pet/status/pet-adoption' ||
            //     $generateLink == 'https://nirmala.pet/grooming' ||
            //     $generateLink == 'https://nirmala.pet/konsultasi' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/login' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/register' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/adoption' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/status/pet-adoption' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/grooming' ||
            //     $generateLink == 'https://nirmala21.herokuapp.com/konsultasi' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/login' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/register' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/adoption' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/status/pet-adoption' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/grooming' ||
            //     $generateLink == 'http://nirmala21.herokuapp.com/konsultasi') {
            if (Auth::user()->role_id == 3) {
                return redirect('/');
            } else {
                if ($generateLink == 'http://nirmala.pet/' ||
                    $generateLink == 'http://nirmala.pet/login' ||
                    $generateLink == 'http://nirmala.pet/register' ||
                    $generateLink == 'http://nirmala.pet/adoption' ||
                    $generateLink == 'http://nirmala.pet/status/pet-adoption' ||
                    $generateLink == 'http://nirmala.pet/grooming' ||
                    $generateLink == 'http://nirmala.pet/konsultasi' ||
                    $generateLink == 'http://nirmala.pet/' ||
                    $generateLink == 'https://nirmala.pet/login' ||
                    $generateLink == 'https://nirmala.pet/register' ||
                    $generateLink == 'https://nirmala.pet/adoption' ||
                    $generateLink == 'https://nirmala.pet/status/pet-adoption' ||
                    $generateLink == 'https://nirmala.pet/grooming' ||
                    $generateLink == 'https://nirmala.pet/konsultasi') {

                    return redirect('/');
                }
                else {
                    return redirect($generateLink);
                }
            }


            // session(['url.intended' => url()->previous()]);
            // return redirect(session('url.intended'));
            // return redirect()->intended('/');
            // return redirect('/');
        }

        // jika gagal login akan return balik dengan error message nya
        return back()->withErrors([
            'email' => 'Email or Password does not match with our records',
        ]);

    }

    // // untuk proses logout
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    protected $type = 'search';
    // // untuk search input
    public function searchManage(Request $request){

        $typeData = $this->type;

        $request->validate([
            'search' => 'required',
        ]);

        $data = Request()->search;
        $typeSearch = Request()->type;

        if ($typeSearch == 'manageUser'){
            $user = $this->M_User->search($data, $typeSearch);
            return view('admin.Manage User.V_Manage_User', compact('user', 'data', 'typeData'));
        }
        elseif ($typeSearch == 'managePet') {
            $pet = $this->M_User->search($data, $typeSearch);
            return view('admin.Manage Pet.V_Manage_Pet', compact('pet', 'data', 'typeData'));
        }
        elseif ($typeSearch == 'manageServices') {
            $userID = Auth::user()->id;
            $petShop = $this->M_User->search($data, $typeSearch);
            $countUserIDPetShop =  $this->M_Service->countUserIDPetShop($userID);

            return view('petShop.Manage Services.V_Manage_Services', compact('countUserIDPetShop', 'petShop', 'data', 'typeData'));
        }
        elseif ($typeSearch == 'manageOrder') {
            $userID = Auth::user()->id;

            $data1 = Request()->search;
            $data = $this->M_User->search($data1, $typeSearch);
            // $data = $this->M_Transaction->manageOrder($userID);
            $dataUser = $this->M_User->getDataUser();
            $countUserIDPetShop =  $this->M_Transaction->countUserIDPetShop($userID);

            return view('petShop.Manage Order.V_Manage_Order', compact('countUserIDPetShop', 'data', 'dataUser', 'userID', 'data1', 'typeData'));
        }
        elseif ($typeSearch == 'transaction') {
            $userID = Auth::user()->id;
            $jumlah = $this->M_Transaction->countUserID();

            $data1 = Request()->search;
            $data = $this->M_User->search($data1, $typeSearch);
            $dataUser = $this->M_User->getDataUser();

            return view('V_Transaction', compact('data', 'dataUser', 'userID', 'data1', 'typeData', 'jumlah'));
        }
        elseif ($typeSearch == 'myPetStatus') {
            if (!Auth::guest()) {
                $userID = Auth::user()->id;
            }
            else {
                $userID = 0;
            }

            $age = $this->M_Age->getDataAge();
            $breed = $this->M_Breed->getDataBreed();
            $sex = $this->M_Sex->getDataSex();
            $source = $this->M_Source->getDataSource();
            $species = $this->M_Species->getDataSpecies();
            $sterilization = $this->M_Sterilization->getDataSterilization();
            $vaccine = $this->M_Vaccine->getDataVaccine();

            $adopter = $this->M_Pet->searchAdopter($data);
            $dataAccepted = $this->M_Pet->searchDataAccepted($data);
            $pet = $this->M_Pet->searchPet($data);

            $countPet = $this->M_Adopt_Submission->countPetID();

            $countUserID = $this->M_Pet->countUserID($userID);

            // $adopter = $this->M_Adopt_Submission->getAllDataWaiting();
            $user = $this->M_User->getDataUser();
            // $pet = $this->M_Pet->getAllDataStatusMyPet();
            // $idAdopter = $this->M_Adopt_Submission->getDataApproved();
            // $dataAccepted = $this->M_Adopt_Submission->getDataApprovedByUserID();
            $dataPetOwner = $this->M_Adopt_Submission->getDataPetOwner();
            return view('V_Status_Pet_Adopt',
                compact('countUserID',
                        'countPet',
                        'pet',
                        'adopter',
                        'user',
                        'userID',
                        'dataPetOwner',
                        'dataAccepted',
                        'data',
                        'typeData',
                        'age',
                        'breed',
                        'sex',
                        'source',
                        'species',
                        'sterilization',
                        'vaccine'));
        }
    }

    // // view home page
    public function viewHome(){
        // // untuk customizing URL
        // $pet->withPath('/');

        $pet = $this->M_Pet->getDataHome();

        // return view('V_Home', ['pet' => $pet]);
        return view('V_Home', compact('pet'));
    }

    // // // = ADMIN =
    // ===================================================
    // // function untuk ke view "V_Manage_User.blade.php"
    public function viewManageUser(){

        $typeData = 'manageUser';

        $data = null;

        // ambil method dari user model
        $user = $this->M_User->getAllData();

        // // menggunakan compact untuk passing variable ke view nya
        return view('admin.Manage User.V_Manage_User', compact('user', 'data', 'typeData'));
        // return view('admin.Manage User.V_Manage_User', ['user' =>  $user]);
        // return view('admin.Manage User.V_Manage_User', ['user' =>  $this->M_User->getAllData()]);
    }

    // function untuk view add user
    public function viewInsertData(){
        $role = $this->M_Role->getDataRole();

        return view('admin.Manage User.V_Add_User', compact('role'));
    }

    // function untuk proses submit di view add user
    public function prosesInsertData(Request $request){

        // // upload gambar dan pidahin file nya
        // // cara #1
        // $file_foto_user = $request->foto_user;
        // $fileName = $request->id . '_' . time() . '.' . $file_foto_user->extension();
        // $file_foto_user->move(public_path('/gambar/user'), $fileName);
        // // cara #2
        // $destination_file = public_path('/gambar/user');
        // $filename = time().'-'.$request->foto_user->getClientOriginalName();
        // $request->foto_user->move($destination_file, $filename);

        // // untuk default timezone nya
        date_default_timezone_set('Asia/Jakarta');
        // // menggunakan function date untuk ambil tanggal sekarang
        // $getDay = date('l'); // // l -> Monday, Tuesday, ...
        // $getTime = date('h:i:sa'); // // a -> PM AM
        $getTime = date('h:i:s'); // // h -> jam, i -> menit, s -> detik
        $getDate= date('Y-m-d');  // // Y -> tahun (2021), m -> bulan (04), d -> hari (03)

        $file_user_photo = Request()->user_photo;

        if ($file_user_photo == null) {
            // // code validation form
            // $this->validate($request, [
            $request->validate([
                'role_id' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:10', 'max:255', 'confirmed'],
                'password_confirmation' => ['required'],
                'phone_number' => 'required|numeric',
                'address' => 'required|max:255',
            ],
            [
                // untuk custom pesan error nya
                'role_id.required' => 'The user role field is required.',
            ]);
            $data = [
                // 'role_id' => $request->role_id,
                // 'name' => $request->name,
                // 'email' => $request()->email,
                // 'password' => Hash::make($request->password),
                // 'phone_number' => $request->phone_number,
                // 'address' => $request->address,

                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password), // pake Hash untuk enkripsi pass
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'created_at' => \Carbon\Carbon::now(),
                'created_at' => $getDate.' '.$getTime,
            ];
        } else {
            // // code validation form
            // $this->validate($request, [
            $request->validate([
                'role_id' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:10', 'max:255', 'confirmed'],
                'password_confirmation' => ['required'],
                'phone_number' => 'required|numeric',
                'address' => 'required|max:255',
                'user_photo' => 'mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
            ],
            [
                // untuk custom pesan error nya
                'role_id.required' => 'The user role field is required.',
            ]);

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                // 'role_id' => $request->role_id,
                // 'name' => $request->name,
                // 'email' => $request()->email,
                // 'password' => Hash::make($request->password),
                // 'phone_number' => $request->phone_number,
                // 'address' => $request->address,
                // 'user_photo' => $file_user_photo_name,

                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password), // pake Hash untuk enkripsi pass
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,
                'user_photo' => $file_user_photo_name,

                // 'created_at' => \Carbon\Carbon::now(),
                'created_at' => $getDate.' '.$getTime,
            ];
        }

        $this->M_User->tambahData($data);

        return redirect()->route('manageUser')->with('message', 'Add User Berhasil...');
    }

    // function untuk view edit data
    public function viewEditData($id){

        $user = $this->M_User->ubahData($id);
        $role = $this->M_Role->getDataRole();

        $edit = 'editUser';

        return view('admin.Manage User.V_Edit_User', compact('user', 'role', 'edit'));
    }

    // // function untuk submit button di view edit data
    // // untuk update data dari table users
    public function prosesUpdateData(Request $request, $id){
        // // untuk default timezone nya
        date_default_timezone_set('Asia/Jakarta');
        $getTime = date('h:i:s'); // // h -> jam, i -> menit, s -> detik
        $getDate= date('Y-m-d');  // // Y -> tahun (2021), m -> bulan (04), d -> hari (03)

        if (Request()->password == null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo == null) {
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message
            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number == null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email != null  && Request()->phone_number == null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number == null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }
        else if(Request()->password != null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                // 'role_id' => ['required'],
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // untuk custom pesan error nya
                // 'role_id.required' => 'The user role field is required.',
            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'role_id' => Request()->role_id,
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                // 'updated_at' => \Carbon\Carbon::now(),
                'updated_at' => $getDate.' '.$getTime,
            ];
        }

        $this->M_User->proses_ubahData($data, $id);

        $message = 'Edit User Berhasil...';

        // return redirect('/manage/user');
        return redirect()->route('manageUser')->with('message', $message);
    }

    // funcion untuk delete data
    public function deleteData($id){

        $this->M_User->hapusData($id);

        $message = 'Delete User Berhasil...';

        // return redirect('/manage/user');
        return redirect()->route('manageUser')->with('message', $message);
    }

    // // Edit Profile
    // untuk show edit profile form
    public function viewEditProfile(){

        $userID = Auth::user()->id;
        // $edit = 'editProfile';
        $user = $this->M_User->userDataByID($userID);

        // return view('V_Profile', compact('user', 'edit'));
        return view('V_Profile', compact('user'));
    }

    // // untuk edit pet shop
    public function viewEditPetShop(){
        $userID = Auth::user()->id;
        // $edit = 'editProfile';
        $user = $this->M_User->userDataByID($userID);

        // return view('V_Profile', compact('user', 'edit'));
        return view('V_Edit_Pet_Shop', compact('user'));
    }

    public function prosesUpdateDataStatusPetShop(Request $request, $id){
        $request->validate([
            'moreStatusPetShop' => ['max:255'],
            'openPetShop' => ['required', 'string', 'max:255']
        ]);
        $data = [
            // 'more_status_pet_shop' => $request->moreStatusPetShop
            'more_status_pet_shop' => Request()->moreStatusPetShop,
            'open_hour_pet_shop' => Request()->openPetShop
        ];

        $this->M_User->proses_ubahData($data, $id);
        return redirect()->route('editProfile')->with('message', 'Edit Status Pet Shop Berhasil...');
    }

    // untuk submit button pada view profile
    public function prosesUpdateDataProfile(Request $request, $id){


        // jika password dan email nya kosong atau tidak diisi
        if (Request()->password == null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo == null) {
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message
            ]);
            $data = [
                'name' => Request()->name,
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number == null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                // 'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                // 'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email != null  && Request()->phone_number == null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number == null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number == null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                // 'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                // 'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                // 'email' => Request()->email,
                // 'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo == null){
            // code validation here
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);
            $data = [
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email == null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                // 'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password == null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                // 'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                // 'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else if(Request()->password != null && Request()->email != null  && Request()->phone_number != null && Request()->user_photo != null){
            // code validation here
            $request->validate([
                'user_photo' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
                'name' => ['required', 'string', 'max:255'],
                'email' => ['string', 'email', 'max:255', 'unique:users'],
                'password' => ['string', 'min:10', 'max:255', 'confirmed'],
                'phone_number' => 'numeric|unique:users',
                'address' => 'required|max:255',
            ],
            [
                // custom message

            ]);

            $file_user_photo = Request()->user_photo;

            // // upload gambar dan  pidahin file nya
            $file_user_photo_name = 'userID=' . Request()->user_id . '_' . Request()->name. '.' . $file_user_photo->getClientOriginalExtension();
            $destination_file = public_path('/gambar/foto_user_login');
            $file_user_photo->move($destination_file, $file_user_photo_name);

            $data = [
                'user_photo' => $file_user_photo_name,
                'name' => Request()->name,
                'email' => Request()->email,
                'password' => Hash::make(Request()->password),
                'phone_number' => Request()->phone_number,
                'address' => Request()->address,
                'longitude' => Request()->longitude,
                'latitude' => Request()->latitude,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }

        $this->M_User->proses_ubahData($data, $id);
        // return redirect('/profile')->with('message', 'Edit Foto Berhasil...');
        return redirect()->route('editProfile')->with('message', 'Edit Profile Berhasil...');
    }

    // untuk send email
    // public function contactUs(Request $request){

    //     $request->validate([
    //         'user_name' => 'required|max:255',
    //         'user_email' => 'required|max:255|email',
    //         'user_message' => 'required|max:255',
    //     ]);

    //     $myemail = 'famserfarhad02@gmail.com';
    //     $name = $request->user_name;
    //     $email_address = $request->user_email;
    //     $message = $request->user_message;

    //     $to = $myemail;

    //     $email_subject = "Contact form submission: $name";

    //     $email_body = "You have received a new message. ".

    //     " Here are the details:\n Name: $name \n ".

    //     "Email: $email_address\n\n Message: \n $message";

    //     $headers = "From: $myemail\n";

    //     $headers .= "Reply-To: $email_address";

    //     mail($to,$email_subject,$email_body,$headers);

    //     $urlPrevious = url()->current();

    //     return redirect($urlPrevious);
    // }
}
