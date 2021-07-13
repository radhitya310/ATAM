<?php

namespace App\Http\Controllers;

use App\Models\M_Pet;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    // // function __construct() akan dijalankan terlebih dahulu
    // // panggil model
    // public function __construct(){
    //     $this->M_Pet = new M_Pet();

    //     // // untuk login terlebih dahulu ketika aplikasi dibuka
    //     // // menggunakan authentication scaffolding
    //     // // aktifkan Auth::routes() di web.php
    //     // $this->middleware('auth');
    // }

    // // // view home page
    // public function viewHome(){
    //     // // untuk customizing URL
    //     // $pet->withPath('/');

    //     $pet = $this->M_Pet->getDataHome();

    //     // return view('V_Home', ['pet' => $pet]);
    //     return view('V_Home', compact('pet'));
    // }

    // // view home
    // public function index(){
    //     // // untuk customizing URL
    //     // $pet->withPath('/');

    //     $pet = $this->M_Pet->getDataHome();

    //     // return view('V_Home', ['pet' => $pet]);
    //     return view('V_Home', compact('pet'));
    // }
}
