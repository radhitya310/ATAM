<?php

namespace App\Http\Controllers;

use App\Models\Adopt_Submission;
use App\Models\Age;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Sex;
use App\Models\Source;
use App\Models\Species;
use App\Models\Sterilization;
use App\Models\Track_Records;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    // untuk load model nya
    public function __construct(){
        $this->M_User = new User();
        $this->M_Pet = new Pet();
        $this->M_Age = new Age();
        $this->M_Breed = new Breed();
        $this->M_Sex = new Sex();
        $this->M_Source = new Source();
        $this->M_Species = new Species();
        $this->M_Sterilization = new Sterilization();
        $this->M_Vaccine = new Vaccine();
        $this->M_Adopt_Submission = new Adopt_Submission();
        $this->M_Track_Record = new Track_Records();
    }

    // tampilin view manage pet
    public function viewManagePet(){
        $typeData = 'managePet';
        $data = null;
        // ambil function getAllData dari model nya
        $pet = $this->M_Pet->getAllData();
        // return view('admin.Manage Pet.V_Manage_Pet', compact('pet'));
        return view('admin.Manage Pet.V_Manage_Pet', ['pet' => $pet, 'data' => $data, 'typeData' => $typeData]);
    }

    // function untuk view add pet
    public function viewInsertData(){
        $user = $this->M_User->getDataUser();
        $age = $this->M_Age->getDataAge();
        $breed = $this->M_Breed->getDataBreed();
        $sex = $this->M_Sex->getDataSex();
        $source = $this->M_Source->getDataSource();
        $species = $this->M_Species->getDataSpecies();
        $sterilization = $this->M_Sterilization->getDataSterilization();
        $vaccine = $this->M_Vaccine->getDataVaccine();

        return view('admin.Manage Pet.V_Add_Pet',
        compact('user',
                'age',
                'breed',
                'sex',
                'source',
                'species',
                'sterilization',
                'vaccine'
        ));
    }

    // function untuk proses submit di view add pet admin
    public function prosesInsertData(Request $request){

        // code validation here
        $request->validate([
            'user_id' =>'required',
            'pet_name' => 'required|max:255',
            'species_id' => 'required',
            'breed_id' => 'required',
            'sex_id' => 'required',
            'age_id' => 'required',
            'source_id' => 'required',
            'vaccine_id' => 'required',
            'sterilization_id' => 'required',
            'status' => 'required',
            'pet_description' => 'required|max:255',
            'pet_image' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte

        ]);

        $file_pet_image = Request()->pet_image;
        $file_adopt_application = Request()->adopt_application;

        // // upload gambar dan  pidahin file nya
        // $extension_file = $file_pet_image->getClientOriginalExtension();
        // $file_pet_image_name = $file_pet_image->getClientOriginalName();
        // $file_pet_image_name = time() . '_' . $file_pet_image->extension();
        $file_pet_image_name = 'userID=' . Request()->user_id . '_' . Request()->pet_name . '.' . $file_pet_image->getClientOriginalExtension();
        $destination_file = public_path('/gambar/pet');
        $file_pet_image->move($destination_file, $file_pet_image_name);

        // // tampung datanya dalam satu array
        $data = [
            'pet_name' => Request()->pet_name,
            'user_id' => Request()->user_id,
            'species_id' => Request()->species_id,
            'breed_id' => Request()->breed_id,
            'sex_id' => Request()->sex_id,
            'age_id' => Request()->age_id,
            'source_id' => Request()->source_id,
            'vaccine_id' => Request()->vaccine_id,
            'sterilization_id' => Request()->sterilization_id,
            'status' => Request()->status,
            'pet_description' => Request()->pet_description,
            'pet_image' => $file_pet_image_name,

            'created_at' => \Carbon\Carbon::now(),
        ];

        // menggunakan eloquent
        // Pet::create([
        //     'pet_name' => Request()->pet_name,
        //     'user_id' => Request()->user_id,
        //     'species_id' => Request()->species_id,
        //     'breed_id' => Request()->breed_id,
        //     'sex_id' => Request()->sex_id,
        //     'age_id' => Request()->age_id,
        //     'source_id' => Request()->source_id,
        //     'vaccine_id' => Request()->vaccine_id,
        //     'sterilization_id' => Request()->sterilization_id,
        //     'status' => Request()->status,
        //     'pet_description' => Request()->pet_description,
        //     'pet_image' => $file_pet_image_name,
        // ]);

        // ambil dari model nya
        $this->M_Pet->tambahData($data);

        $message = 'Add Pet Berhasil...';

        // return redirect('/manage/pet');
        return redirect()->route('managePet')->with('message', $message);
    }

    // untuk view edit data admin
    public function viewEditData($id){

        // ambil dari model
        $pet = $this->M_Pet->getAllDataDetail($id);
        $user = $this->M_User->getDataUser();
        $age = $this->M_Age->getDataAge();
        $breed = $this->M_Breed->getDataBreed();
        $sex = $this->M_Sex->getDataSex();
        $source = $this->M_Source->getDataSource();
        $species = $this->M_Species->getDataSpecies();
        $sterilization = $this->M_Sterilization->getDataSterilization();
        $vaccine = $this->M_Vaccine->getDataVaccine();

        return view('admin.Manage Pet.V_Edit_Pet',
        compact('pet',
                'user',
                'age',
                'breed',
                'sex',
                'source',
                'species',
                'sterilization',
                'vaccine'
        ));
    }

    // untuk submit pada edit data admin
    public function prosesUpdateData(Request $request, $id){

        $file_pet_image = Request()->pet_image;

        // // choose file nya tidak diinput
        // if (!$file_pet_image <> "") {
        if ($file_pet_image == null) {
            // code validation here
            $request->validate([
                'user_id' =>'required',
                'pet_name' => 'required|max:255',
                'species_id' => 'required',
                'breed_id' => 'required',
                'sex_id' => 'required',
                'age_id' => 'required',
                'source_id' => 'required',
                'vaccine_id' => 'required',
                'sterilization_id' => 'required',
                'status' => 'required',
                'pet_description' => 'required|max:255',
            ]);

            $data = [
                'user_id' => Request()->user_id,
                // 'user_id_adopter' => Request()->user_id_adopter,
                'pet_name' => Request()->pet_name,
                'species_id' => Request()->species_id,
                'breed_id' => Request()->breed_id,
                'sex_id' => Request()->sex_id,
                'age_id' => Request()->age_id,
                'source_id' => Request()->source_id,
                'vaccine_id' => Request()->vaccine_id,
                'sterilization_id' => Request()->sterilization_id,
                'status' => Request()->status,
                'pet_description' => Request()->pet_description,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        // jika choose file image
        else{
            $request->validate([
                'user_id' =>'required',
                'pet_name' => 'required|max:255',
                'species_id' => 'required',
                'breed_id' => 'required',
                'sex_id' => 'required',
                'age_id' => 'required',
                'source_id' => 'required',
                'vaccine_id' => 'required',
                'sterilization_id' => 'required',
                'status' => 'required',
                'pet_description' => 'required|max:255',
                'pet_image' => 'mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte

            ]);

            // // upload gambar dan  pidahin file nya
            // $extension_file = $file_pet_image->getClientOriginalExtension();
            // $file_name = $file_pet_image->getClientOriginalName();
            // $file_name = time() . '_' . $file_pet_image->extension();
            $file_pet_image = Request()->pet_image;
            $file_name = time().'_userID=' . Request()->user_id . '_' . Request()->pet_name . '.' . $file_pet_image->getClientOriginalExtension();
            $destination_file = public_path('/gambar/pet');
            $file_pet_image->move($destination_file, $file_name);

            $data = [
                'user_id' => Request()->user_id,
                // 'user_id_adopter' => Request()->user_id_adopter,
                'pet_name' => Request()->pet_name,
                'species_id' => Request()->species_id,
                'breed_id' => Request()->breed_id,
                'sex_id' => Request()->sex_id,
                'age_id' => Request()->age_id,
                'source_id' => Request()->source_id,
                'vaccine_id' => Request()->vaccine_id,
                'sterilization_id' => Request()->sterilization_id,
                'status' => Request()->status,
                'pet_description' => Request()->pet_description,
                'pet_image' => $file_name,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }

        $this->M_Pet->proses_ubahData($data, $id);

        $message = 'Edit Pet Berhasil...';

        // return redirect('/manage/pet');
        return redirect()->route('managePet')->with('message', $message);
    }

    // function untuk delete data (admin)
    public function deleteData($id){

        // ambil method hapus dari model M_Pet
        $this->M_Pet->hapusData($id);

        $message = 'Delete Pet Berhasil...';

        // return redirect('/manage/pet');
        return redirect()->route('managePet')->with('message', $message);
    }



    // // Adoption Controller
    // // =========================================================

    // // veiw adoption
    public function viewAdoption(Request $request){

        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        $countTablePets = $this->M_Pet->countPetID();

        $user = $this->M_User->getDataUser();
        $age = $this->M_Age->getDataAge();
        $breed = $this->M_Breed->getDataBreed();
        $sex = $this->M_Sex->getDataSex();
        $source = $this->M_Source->getDataSource();
        $species = $this->M_Species->getDataSpecies();
        $sterilization = $this->M_Sterilization->getDataSterilization();
        $vaccine = $this->M_Vaccine->getDataVaccine();

        $userLogin = $this->M_User->userDataByID($userID);

        $pet1 = $this->M_Adopt_Submission->getDataAdoptAccepted();

        $countStatus1 = $this->M_Adopt_Submission->countStatusWaiting($userID);
        $countStatus2 = $this->M_Adopt_Submission->countStatusAccepted($userID);
        $countStatus3 = $this->M_Adopt_Submission->countStatusCanceled($userID);
        $countStatus4 = $this->M_Adopt_Submission->countStatusRejected($userID);
        // $counUserID = $this->M_Adopt_Submission->countUserID();
        // $historiesAdopt2 = $this->M_Adopt_Submission->countPetID();

        $getAdoptSubmission = $this->M_Adopt_Submission->getAdoptSubmissions();

        $search_radius = $request->radius;
        $search_data1 = $request->species;
        $search_data2 = $request->breed;
        $search_data3 = $request->age;
        if (!Auth::guest()) {
            if ($search_radius == null && $search_data1 == null && $search_data2 == null && $search_data3 == null) {
                $pet2 = $this->M_Pet->getDataPaginateAdop();
                $search1 = "";
                $search2 = "";
                $search3 = "";
                $search3 = "";
                $radius = "";
                $typePaginate = "adopt";
                $valid = 0;
                $validLocation = 0;
            }
            else {
                if ($search_radius == null) {
                    $validLocation = 0;
                }
                else{
                    $validLocation = 1;
                }

                // $lat = $request->lat;
                // $long = $request->long;

                // $pet2 = $this->M_Pet->getDataSearchPaginateAdop($search_radius, $search_data1, $search_data2, $search_data3, $lat, $long);
                $pet2 = $this->M_Pet->getDataSearchPaginateAdop($search_radius, $search_data1, $search_data2, $search_data3);
                $search1 = $request->species;
                $search2 = $request->breed;
                $search3 = $request->age;
                $radius = $request->radius;
                $typePaginate = "searchAdopt";
                $valid = 1;
            }
        }
        else {
            // if ($search_radius == null && $search_data1 == null && $search_data2 == null && $search_data3 == null) {
            if ($search_data1 == null && $search_data2 == null && $search_data3 == null) {
                $pet2 = $this->M_Pet->getDataPaginateAdop();
                $search1 = "";
                $search2 = "";
                $search3 = "";
                $search3 = "";
                $radius = "";
                $typePaginate = "adopt";
                $valid = 0;
                $validLocation = 0;
            }
            else {
                // $pet2 = $this->M_Pet->getDataSearchPaginateAdop($search_radius, $search_data1,$search_data2,$search_data3);
                $pet2 = $this->M_Pet->getDataSearchPaginateAdopGuest($search_data1,$search_data2,$search_data3);
                $search1 = $request->species;
                $search2 = $request->breed;
                $search3 = $request->age;
                $radius = $request->radius;
                $typePaginate = "searchAdopt";
                $valid = 1;
                $validLocation = 0;
            }
        }


        $pet3 = $this->M_Adopt_Submission->getDataAdoptWaiting();

        return view('V_Adoption',
        compact('userLogin',
                'countTablePets',
                'userID',
                'user',
                'pet1',
                'pet2',
                'pet3',
                'age',
                'breed',
                'sex',
                'source',
                'species',
                'sterilization',
                'vaccine',
                'countStatus1',
                'countStatus2',
                'countStatus3',
                'countStatus4',
                'search1',
                'search2',
                'search3',
                'radius',
                'typePaginate',
                'valid',
                'validLocation',
                // 'counUserID',
                // 'historiesAdopt2',
                'getAdoptSubmission'
        ));
    }

    // // untuk tampilin detail pet nya
    public function viewDetailPet($id){

        $detailPet = 'requestAdopt';

        if(!Auth::guest()){
            // ambil user id yg login
            $userID = Auth::user()->id;
        }
        else{
            $userID = 0;
        }

        // $lat = $this->M_User->getLat($userID);
        // $long = $this->M_User->getLong($userID);
        $user = $this->M_User->userDataByID($userID);
        $pet = $this->M_Pet->getAllDataDetail($id);
        $adopter = $this->M_Adopt_Submission->getAllDataAdopter($id);
        return view('V_Detail_Pet', compact('user', 'pet', 'userID', 'adopter', 'detailPet'));
    }

    // untuk proes submit request for adopt
    public function requestProsesAdop(Request $request){

        // code validation here
        $request->validate([
            'question1' => 'required|max:255',
            'question2' => 'required|max:255',
            'question3' => 'required|max:255',
            'question4' => 'required|max:255',
        ]);

        $id1 = Request()->pet_id;
        $id2 = Request()->user_id_adopter;
        $data = [
            'pet_id' => $id1,
            'user_id_adopter' => $id2,
            'status' => Request()->status,
            'reason' => Request()->reason,
            'question_1' => Request()->question1,
            'question_2' => Request()->question2,
            'question_3' => Request()->question3,
            'question_4' => Request()->question4,
            'created_at' => \Carbon\Carbon::now(),
        ];

        $this->M_Adopt_Submission->submitProsesAdop($data, $id1, $id2);

        $message = 'Request Pet Adopt Berhasil....';

        // return redirect('/adoption');
        return redirect('/adoption')->with('message', $message);
    }

    // untuk proses cancel adop
    public function cancelProsesAdop(Request $request, $id1, $id2){
        $request->validate([
            'reasonCancel' => 'required|max:255',
        ]);

        $reason = Request()->reasonCancel;
        $type = 'Canceled';
        $this->M_Adopt_Submission->changeStatusProsesAdop($id1, $id2, $type, $reason);

        $message = 'Canceled Pet Adopt Berhasil....';

        // return redirect('/adoption');
        return redirect('/adoption')->with('message', $message);
    }

    // untuk nampilin status pet adoption
    public function statusPetAdop(){
        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        }
        else {
            $userID = 0;
        }

        $data = null;

        $age = $this->M_Age->getDataAge();
        $breed = $this->M_Breed->getDataBreed();
        $sex = $this->M_Sex->getDataSex();
        $source = $this->M_Source->getDataSource();
        $species = $this->M_Species->getDataSpecies();
        $sterilization = $this->M_Sterilization->getDataSterilization();
        $vaccine = $this->M_Vaccine->getDataVaccine();
        $trackRecord = $this->M_Track_Record->getDataAdopterRecords();

        $countPet = $this->M_Adopt_Submission->countPetID();
        $adopter = $this->M_Adopt_Submission->getAllDataWaiting();
        $user = $this->M_User->getDataUser();
        $pet = $this->M_Pet->getAllDataStatusMyPet();
        $countUserID = $this->M_Pet->countUserID($userID);
        // $idAdopter = $this->M_Adopt_Submission->getDataApproved();
        $dataAccepted = $this->M_Adopt_Submission->getDataApprovedByUserID();
        $dataPetOwner = $this->M_Adopt_Submission->getDataPetOwner();
        return view('V_Status_Pet_Adopt',
            compact('countUserID',
                    'countPet',
                    'pet',
                    'adopter',
                    'user',
                    'userID',
                    'dataAccepted',
                    'dataPetOwner',
                    'data',
                    'age',
                    'breed',
                    'sex',
                    'source',
                    'species',
                    'sterilization',
                    'vaccine',
                    'trackRecord'));
    }

    // untuk approve adop pet
    public function statusApproved(Request $request, $id1, $id2){

        $request->validate([
            'reasonAccept' => 'required|max:255',
        ]);

        $reason = Request()->reasonAccept;
        $type = 'Accepted';

        $this->M_Pet->approveProsesAdop($id1, $id2);
        $this->M_Adopt_Submission->changeStatusProsesAdop($id1, $id2, $type, $reason);

        $message = 'Accepted Pet Adopt Berhasil....';

        // return redirect('/status/pet-adoption');
        return redirect('/status/pet-adoption')->with('message', $message);
    }

    // untuk reject adop pet
    public function statusRejected(Request $request, $id1, $id2){

        $request->validate([
            'reasonReject' => 'required|max:255',
        ]);

        $reason = Request()->reasonReject;
        $type = 'Rejected';
        $this->M_Adopt_Submission->changeStatusProsesAdop($id1, $id2, $type, $reason);

        $message = 'Rejected Pet Adopt Berhasil....';

        // return redirect('/status/pet-adoption');
        return redirect('/status/pet-adoption')->with('message', $message);
    }

    // untuk ke view add data pet adoption
    public function viewAddData(){

        if (!Auth::guest()) {
            $userID = Auth::user()->id;
        } else {
            $userID = 0;
        }

        $age = $this->M_Age->getDataAge();
        $breed = $this->M_Breed->getDataBreed();
        $sex = $this->M_Sex->getDataSex();
        $source = $this->M_Source->getDataSource();
        $species = $this->M_Species->getDataSpecies();
        $sterilization = $this->M_Sterilization->getDataSterilization();
        $vaccine = $this->M_Vaccine->getDataVaccine();

        return view('V_Add_Status_Pet_Adopt',
            compact('userID',
                    'age',
                    'breed',
                    'sex',
                    'source',
                    'species',
                    'sterilization',
                    'vaccine'
            ));
    }

    // function untuk proses submit add pet di my pet status
    public function prosesInsertDataMyPet(Request $request){

        // // code validation here
        // $this->validate($request, [
        $request->validate([
            'pet_name' => 'required|max:255',
            // 'user_id' => 'required|unique:pets,user_id',
            'species_id' => 'required',
            'breed_id' => 'required',
            'sex_id' => 'required',
            'age_id' => 'required',
            'source_id' => 'required',
            'vaccine_id' => 'required',
            'sterilization_id' => 'required',
            'pet_description' => 'required|max:255',
            'pet_image' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte
        ]);

        $file_pet_image = Request()->pet_image;

        // // upload gambar dan  pidahin file nya
        // $extension_file = $file_pet_image->getClientOriginalExtension();
        // $file_pet_image_name = $file_pet_image->getClientOriginalName();
        // $file_pet_image_name = time(). '_' . $file_pet_image->extension();
        $file_pet_image_name = time().'_userID=' . Request()->user_id . '_' . Request()->pet_name . '.' . $file_pet_image->getClientOriginalExtension();
        $destination_file = public_path('/gambar/pet');
        $file_pet_image->move($destination_file, $file_pet_image_name);

        // // tampung datanya dalam satu array
        $data = [
            'pet_name' => Request()->pet_name,
            'user_id' => Request()->user_id,
            'species_id' => Request()->species_id,
            'breed_id' => Request()->breed_id,
            'sex_id' => Request()->sex_id,
            'age_id' => Request()->age_id,
            'source_id' => Request()->source_id,
            'vaccine_id' => Request()->vaccine_id,
            'sterilization_id' => Request()->sterilization_id,
            'pet_description' => Request()->pet_description,
            'pet_image' => $file_pet_image_name,

            // 'pet_name' => $request->pet_name,
            // 'user_id' => $request->user_id,
            // 'species_id' => $request->species_id,
            // 'breed_id' => $request()->breed_id,
            // 'sex_id' => $request->sex_id,
            // 'age_id' => $request->age_id,
            // 'source_id' => $request->source_id,
            // 'vaccine_id' => $request->vaccine_id,
            // 'sterilization_id' => $request->sterilization_id,
            // 'pet_description' => $request->pet_description,
            // 'pet_image' => $file_pet_image_name,

            'created_at' => \Carbon\Carbon::now(),
        ];

        // ambil dari model nya
        $this->M_Pet->tambahData($data);

        $message = 'Add Pet Berhasil...';

        // return redirect('/adoption');
        return redirect('/adoption')->with('message', $message);
    }

    // untuk view edit status pet adoption di my pet status
    public function viewEditDataMyPet($id){

        // if (!$this->M_Pet->getAllDataDetail($id)) {
        //     abort(404);
        // }
        // else {
        // }

        $age = $this->M_Age->getDataAge();
        $breed = $this->M_Breed->getDataBreed();
        $sex = $this->M_Sex->getDataSex();
        $source = $this->M_Source->getDataSource();
        $species = $this->M_Species->getDataSpecies();
        $sterilization = $this->M_Sterilization->getDataSterilization();
        $vaccine = $this->M_Vaccine->getDataVaccine();

        // $pet = DB::table('pets')
        //             ->where('pet_id', $id)
        //             ->get();

        // ambil dari model
        $pet = $this->M_Pet->getAllDataDetail($id);

        return view('V_Edit_Status_Pet_Adopt',
        compact('pet',
                'age',
                'breed',
                'sex',
                'source',
                'species',
                'sterilization',
                'vaccine'
        ));
    }

    // untuk submit button update pada view edit status pet adoption di my pet status
    public function prosesUpdateDataMyPet(REQuest $request, $id){

        $file_pet_image = Request()->pet_image;

        // // choose file nya tidak diinput
        // // jika file pet image dan file adopt application nya kosong
        if (!$file_pet_image <> "") {
            // // code validation here
            // $this->validate($request, [
            $request->validate([
                'pet_name' => 'required|max:255',
                // 'user_id' => 'required|unique:pets,user_id',
                'species_id' => 'required',
                'breed_id' => 'required',
                'sex_id' => 'required',
                'age_id' => 'required',
                'source_id' => 'required',
                'vaccine_id' => 'required',
                'sterilization_id' => 'required',
                'pet_description' => 'required|max:255',
            ]);

            $data = [
                'pet_name' => Request()->pet_name,
                'species_id' => Request()->species_id,
                'breed_id' => Request()->breed_id,
                'sex_id' => Request()->sex_id,
                'age_id' => Request()->age_id,
                'source_id' => Request()->source_id,
                'vaccine_id' => Request()->vaccine_id,
                'sterilization_id' => Request()->sterilization_id,
                'pet_description' => Request()->pet_description,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }
        else {
            // // code validation here
            // $this->validate($request, [
            $request->validate([
                'pet_name' => 'required|max:255',
                // 'user_id' => 'required|unique:pets,user_id',
                'species_id' => 'required',
                'breed_id' => 'required',
                'sex_id' => 'required',
                'age_id' => 'required',
                'source_id' => 'required',
                'vaccine_id' => 'required',
                'sterilization_id' => 'required',
                'pet_description' => 'required|max:255',
                'pet_image' => 'mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte

            ]);

            $file_pet_image_name = time().'_userID=' . Request()->user_id . '_' . Request()->pet_name . '.' . $file_pet_image->getClientOriginalExtension();
            $destination_file = public_path('/gambar/pet');
            $file_pet_image->move($destination_file, $file_pet_image_name);

            $data = [
                'pet_name' => Request()->pet_name,
                'user_id' => Request()->user_id,
                'species_id' => Request()->species_id,
                'breed_id' => Request()->breed_id,
                'sex_id' => Request()->sex_id,
                'age_id' => Request()->age_id,
                'source_id' => Request()->source_id,
                'vaccine_id' => Request()->vaccine_id,
                'sterilization_id' => Request()->sterilization_id,
                'pet_description' => Request()->pet_description,
                'pet_image' => $file_pet_image_name,

                'updated_at' => \Carbon\Carbon::now(),
            ];
        }

        $this->M_Pet->proses_ubahData($data, $id);

        $message = 'Edit Pet Berhasil...';

        // return redirect('/status/pet-adoption');
        return redirect('/status/pet-adoption')->with('message', $message);
    }

    // function untuk delete data di my pet status
    public function deleteDataMyPet($id){

        // $pet = $this->M_Pet->getAllDataDetail($id);

        // if ($pet->pet_image <> "") {
        //     // $namafile = public_path('/gambar/pet') . '/' . $pet->pet_image;
        //     $namafile = public_path('gambar/pet/'.$pet->pet_image);
        //     unlink($namafile);
        // }

        // ambil method hapus dari model M_Pet
        $this->M_Pet->hapusData($id);

        $message = 'Delete Pet Adopt Berhasil...';

        // return redirect('/status/pet-adoption');
        return redirect('/status/pet-adoption')->with('message', $message);
    }

    // // untuk upload records pet
    public function prosesUploadRecordsPet(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        // // menggunakan function date untuk ambil tanggal sekarang
        // $getTime = date('h:i:s (a)'); // // a -> am pm
        // $getTime = date('h:i:s'); // // h -> jam (format 12 jam), i -> menit, s -> detik
        // $getTime = date('H:i'); // // H -> jam (format 24 jam), i -> menit, s -> detik
        $getTime = date('H:i:s'); // // H -> jam (format 24 jam), i -> menit, s -> detik
        $getDay = date('l'); // // l -> Monday, Tuesday, ...
        $getDate= date('Y-m-d');  // // Y -> tahun (2021), m -> bulan (04), d -> hari (03)

        $request->validate([
            'keterangan' => 'required|max:255',
            'uploadFoto' => 'required|mimes:jpg,jpeg,png|max:1024', // satuan max size file kilobyte

        ]);

        $file_pet_image = Request()->uploadFoto;

        // // upload gambar dan  pidahin file nya
        $file_pet_image_name = time().'_adoptSubmissionsID=' . Request()->adoptSubmissionsID. '.' . $file_pet_image->getClientOriginalExtension();
        $destination_file = public_path('/gambar/track_records_pet');
        $file_pet_image->move($destination_file, $file_pet_image_name);

        // // tampung datanya dalam satu array
        $data = [
            'adopt_submission_id' => Request()->adoptSubmissionsID,
            'keterangan' => Request()->keterangan,
            'foto' => $file_pet_image_name,
            'waktu_post' => $getDate.', '.$getTime
        ];

        // ambil dari model nya
        $this->M_Track_Record->tambahData($data);

        $message = 'Upload Records Pet Berhasil...';

        return redirect('/adoption')->with('message', $message);
    }
}
