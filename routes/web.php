<?php

// untuk akses file controller tambahkan method invokable dengan menggunakan namespace untuk kurangi penulisan
namespace App\Http\Controllers;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// cara menggunakan route
// Route::get('users/{id}', [App\Http\Controllers\nama_controller::class, 'nama_method_controller']);

// Auth::routes();

// // // = ADMIN =
// // Manage User
Route::get('/manage/user/search', [UserController::class, 'searchManage']);
// Route::get('/manage/user', [App\Http\Controllers\UserController::class, 'viewManageUser']);
Route::get('/manage/user', [UserController::class, 'viewManageUser'])->name('manageUser');
Route::get('/manage/user/add', [UserController::class, 'viewInsertData']);
Route::post('/manage/user/add/proses', [UserController::class, 'prosesInsertData']);
Route::get('/manage/user/edit/user_ID={id}', [UserController::class, 'viewEditData']);
Route::get('/manage/user/edit-foto/user_ID={id}', [UserController::class, 'viewManageEditFoto']);
Route::post('/manage/user/update/{id}', [UserController::class, 'prosesUpdateData']);
Route::get('/manage/user/delete/{id}', [UserController::class, 'deleteData']);
// ====================================================================================
// // Manage Pet
Route::get('/manage/pet/search', [UserController::class, 'searchManage']);
Route::get('/manage/pet', [PetController::class, 'viewManagePet'])->name('managePet');
Route::get('/manage/pet/add', [PetController::class, 'viewInsertData']);
Route::post('/manage/pet/add/proses', [PetController::class, 'prosesInsertData']);
Route::get('/manage/pet/edit/pet_ID={id}', [PetController::class, 'viewEditData']);
Route::post('/manage/pet/update/{id}', [PetController::class, 'prosesUpdateData']);
Route::get('/manage/pet/delete/{id}', [PetController::class, 'deleteData']);


// ====================================================================================


// // Profile
Route::get('/profile', [UserController::class, 'viewEditProfile'])->name('editProfile');
Route::get('/profile/edit-status-pet-shop', [UserController::class, 'viewEditPetShop'])->name('editPetShop');
Route::post('/profile/edit-status-pet-shop/update/{id}', [UserController::class, 'prosesUpdateDataStatusPetShop']);
Route::post('/profile/update/{id}', [UserController::class, 'prosesUpdateDataProfile']);

// ====================================================================================


// // Home
Route::get('/', [UserController::class, 'viewHome']);
Route::get('/adoption', [PetController::class, 'viewAdoption']);
Route::get('/register', [UserController::class, 'viewRegister']);
Route::post('/register/proses', [UserController::class, 'prosesRegister']);
Route::get('/login', [UserController::class, 'viewLogin'])->name('login');
Route::post('/login/proses', [UserController::class, 'prosesLogin']);
Route::post('/logout', [UserController::class, 'logout']);

// ====================================================================================


// // Adoption
Route::get('/adoption/search', [PetController::class, 'viewAdoption']);
// Route::view('/adoption/detail', 'V_Detail_Pet');
Route::get('/adoption/detail/{id}',[PetController::class, 'viewDetailPet']);
Route::get('/adoption/detail/submissions/{id}',[PetController::class, 'viewDetailAdoptSubmissions']);
// Route::get('/adoption/detail/waiting/{id}',[PetController::class, 'viewDetailPetWaiting']);
Route::get('/adoption/detail/proses/submissions', [PetController::class, 'requestProsesAdop']);
// Route::get('/adoption/cancel/{id1}/{id2}', [PetController::class, 'cancelProsesAdop']);
Route::get('/status/pet-adoption/search', [UserController::class, 'searchManage']);
Route::get('/status/pet-adoption', [PetController::class, 'statusPetAdop']);
Route::get('/status/pet-adoption/add', [PetController::class, 'viewAddData']);
Route::post('/status/pet-adoption/add/proses', [PetController::class, 'prosesInsertDataMyPet']);
Route::get('/status/pet-adoption/detail/{id}', [PetController::class, 'viewDetailPet']);
Route::get('/status/pet-adoption/detail/submissions/{id}', [PetController::class, 'viewDetailAdoptSubmissions']);
Route::get('/status/pet-adoption/approved/{id1}/{id2}', [PetController::class, 'statusApproved']);
Route::get('/status/pet-adoption/rejected/{id1}/{id2}', [PetController::class, 'statusRejected']);
Route::get('/status/pet-adoption/edit/{id}', [PetController::class, 'viewEditDataMyPet']);
Route::post('/status/pet-adoption/update/{id}', [PetController::class, 'prosesUpdateDataMyPet']);
Route::get('/status/pet-adoption/delete/{id}', [PetController::class, 'deleteDataMyPet']);
Route::post('/upload-records-pet/proses', [PetController::class, 'prosesUploadRecordsPet']);

// ====================================================================================


// // Grooming & Konsultasi
Route::get('/grooming/search', [ServiceController::class, 'viewGrooming']);
Route::get('/konsultasi/search', [ServiceController::class, 'viewKonsultasi']);
Route::get('/grooming', [ServiceController::class, 'viewGrooming']);
Route::get('/grooming/detail/{id}', [ServiceController::class, 'viewDetailGrooming']);
Route::get('/konsultasi', [ServiceController::class, 'viewKonsultasi']);
Route::get('/konsultasi/detail/{id}', [ServiceController::class, 'viewDetailKonsultasi']);
Route::post('/checkout/order', [TransactionController::class, 'orderGroomingKonsul']);

// ====================================================================================


// // // = Pet Shop =
// // Manage Services
Route::get('/manage/services/search', [UserController::class, 'searchManage']);
Route::get('/manage/services', [ServiceController::class, 'viewManageServices']);
Route::get('/manage/services/grooming/add', [ServiceController::class, 'viewAddGroomingServices']);
Route::get('/manage/services/konsultasi/add', [ServiceController::class, 'viewAddKonsultasiServices']);
Route::post('/manage/services/add/proses', [ServiceController::class, 'prosesInsertDataServices']);
Route::get('/manage/services/edit/{id}', [ServiceController::class, 'viewEditServices']);
Route::post('/manage/services/update/{id}', [ServiceController::class, 'prosesUpdateServices']);
Route::get('/manage/services/delete/{id}', [ServiceController::class, 'deleteServices']);
Route::get('/manage/services/actived/{id}', [ServiceController::class, 'activedPostStatus']);
Route::get('/manage/services/deactived/{id}', [ServiceController::class, 'deactivedPostStatus']);


// // Manage Order
Route::get('/manage/order/search', [UserController::class, 'searchManage']);
Route::get('/manage/order', [TransactionController::class, 'viewManageOrder']);
Route::get('/transaction/approved/{transaction_id}', [TransactionController::class, 'approvedTransaction']);
Route::get('/transaction/rejected/{transaction_id}', [TransactionController::class, 'rejectedTransaction']);


// // Transaction
Route::get('/transaction/search', [UserController::class, 'searchManage']);
Route::get('/transaction', [TransactionController::class, 'viewTransaction'])->name('transaction');
// Route::get('/transaction/confirm/transaction-ID={transaction_id}', [TransactionController::class, 'confirmTransaction']);
// Route::get('/transaction/cancel/transaction-ID={transaction_id}', [TransactionController::class, 'cancelTransaction']);
Route::get('/transaction/detail/{transaction_id}', [TransactionController::class, 'viewDetailTransaction']);


// // email form
Route::post('/send-email', [UserController::class, 'contactUs']);
