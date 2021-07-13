@extends('layouts.app')

@section('title')
    Home - Nirmala
@endsection

{{-- @if (Auth::guest())
    code here
@endif --}}
{{-- guest => user blom sama sekali login --}}
{{-- @guest
@endguest --}}

{{-- jika user nya bukan pet shop --}}
{{-- @if (!Auth::guest())
@endif --}}
@section('content')
    {{-- @if (!Auth::guest())
        @php
            $userID = Auth::user()->id;
        @endphp
    @endif --}}
    <div class="wadah_home">
        {{-- <div class="col1_home">
            <div class="col1_home_isi">

                @include('include.date&time')
            </div>
        </div> --}}
        <div class="col2_home mt-5">
            {{-- <h1>
                <img src="{{ asset('gambar/PageHome.jpg') }}" alt="Gambar1" class="w-100">
            </h1>
            <br>
            <br>
            <br> --}}
            <div class="row">
                <div class="col-lg-4">
                    <div class="carousel carousel-dark slide image_slider w-100" id="carouselExampleCaptions" data-bs-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="5"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="6"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <center>
                                    <img src="{{ asset('gambar/PageHome.jpg') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Calvin Ananda</h1> --}}
                                    {{-- <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ducimus dolorem commodi sed, architecto itaque quisquam. Est ullam id earum quam minus enim nulla nostrum optio. Nesciunt possimus provident a distinctio?
                                    </p> --}}
                                </div>
                            </div>
                            <div class="carousel-item">
                                <center>
                                    <img src="{{ asset('gambar/fotoGroom2.jpg') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Farhad Famser</h1>
                                    <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Beatae voluptatibus deserunt nihil, assumenda enim, dolor at esse consequuntur soluta eveniet voluptatem quam porro voluptas animi amet, iste odio rerum ratione?
                                    </p> --}}
                                </div>
                            </div>
                            <div class="carousel-item">
                                <center>
                                    <img src="{{ asset('gambar/fotoGroom1.jpg') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Farhad Famser</h1>
                                    <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis nam nihil tempora. Sunt, consequatur voluptas. Minus laudantium voluptates incidunt suscipit eligendi cupiditate blanditiis magni in! Unde iusto aliquid minima ad.
                                    </p> --}}
                                </div>
                            </div>
                            <div class="carousel-item">
                                <center>
                                    <img src="{{ asset('gambar/3.png') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Rayhan</h1>
                                    <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex qui aperiam nobis sapiente ipsam cum, adipisci expedita possimus cupiditate, quaerat, optio corrupti perspiciatis minus. Qui praesentium recusandae perspiciatis omnis quibusdam!
                                    </p> --}}
                                </div>
                            </div>
                            <div class="carousel-item">
                                <center>
                                    <img src="{{ asset('gambar/fotoGroom3.jpg') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Rayhan</h1>
                                    <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio reiciendis nam est possimus nobis saepe quos? Praesentium quae hic minus ut illo iure aliquam, exercitationem, animi, adipisci voluptatibus similique nulla!
                                    </p> --}}
                                </div>
                            </div>
                            <div class="carousel-item">
                                <center>
                                    <img src="{{ asset('gambar/4.png') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Rayhan</h1>
                                    <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio reiciendis nam est possimus nobis saepe quos? Praesentium quae hic minus ut illo iure aliquam, exercitationem, animi, adipisci voluptatibus similique nulla!
                                    </p> --}}
                                </div>
                            </div>
                            <div class="carousel-item">
                                <center>
                                    <img src="{{ asset('gambar/6.png') }}" alt="Gambar1" class="fotoTeams" width="100%" height="300px">
                                </center>
                                <div class="carousel-caption text-dark">
                                    {{-- <h1 class="display-4">Rayhan</h1>
                                    <hr class="bg-dark"> --}}
                                    {{-- <p>
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Distinctio reiciendis nam est possimus nobis saepe quos? Praesentium quae hic minus ut illo iure aliquam, exercitationem, animi, adipisci voluptatibus similique nulla!
                                    </p> --}}
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-8 ps-4 pe-4">
                    <div class="row penjelasanWebIn">
                        <div class="text-center col-md-12 nirmala1">
                            <strong>
                                Apa itu Nirmala?
                            </strong>
                            <hr>
                        </div>
                        {{-- <div class="pt-5 col-sm-4">
                            <img src="{{ asset('gambar/logo/Logo Nirmala Kuning (No BG).png') }}" alt="logoUs" class="w-100">
                        </div> --}}
                        <div class="pt-2 text-start col-md-12 detailPetShop">
                            <h2>
                                <strong>
                                    Nirmala
                                </strong>
                            </h2>
                            <div>
                                <p>
                                    Merupakan sebuah aplikasi berbasis web yang berguna
                                    untuk mempertemukan pengguna yang ingin melakukan
                                    adopsi hewan khususnya kucing & anjing (adopter) dengan
                                    pemilik hewan (pet owner). Selain fitur adopsi, terdapat juga fitur yang
                                    dapat mempertemukan antara user dengan pet shop
                                    serta melakukan reservasi layanan yang tersedia.
                                </p>
                                <p>
                                    Kata Nirmala itu sendiri diambil dari
                                    KBBI (Kamus Besar Bahasa Indonesia) yang artinya
                                    "tanpa cacat cela; bersih; suci; tidak bernoda".
                                    <i>retrieved from <u><a href="https://kbbi.web.id/nirmala" target="_blank">https://kbbi.web.id/nirmala</a></u></i>
                                </p>

                                <p>
                                    Beberapa Fitur yang ada didalam aplikasi ini yaitu:
                                        <ul>
                                            <li>View Direction Map.</li>
                                            <li>Filter by location.</li>
                                            <li>Booking reservasi layanan grooming dan konsultasi.</li>
                                            <li>Adopsi hewan peliharaan.</li>
                                        </ul>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container text-start">
                <div class="our_services pt-4">
                    <h1 class="text-center">
                        <strong>
                            Services
                        </strong>
                    </h1>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card kotakSize">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <img src="{{asset('gambar/adopsi.png')}}" alt="foto" width="100%" height="100%" class="">
                                <div class="card-body">
                                    <h5 class="card-title">Pet Adoption</h5>
                                    <p class="card-text">Mengadopsi atau adopsikan hewan peliharaan.</p>
                                </div>
                                <div class="card-footer">
                                    {{-- @if (Auth::guest() || Auth::user()->role_id != 3)
                                        <a href="/adoption" class="btn btn-success">Click Here</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card kotakSize">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <img src="{{asset('gambar/grooming.png')}}" alt="foto" width="100%" height="100%" class="">
                                <div class="card-body">
                                    <h5 class="card-title">Pet Grooming</h5>
                                    <p class="card-text">Rawatlah hewan peliharaan anda untuk selalu menjaga kesehatannya.</p>
                                </div>
                                <div class="card-footer">
                                    {{-- <small class="text-muted">Last updated 3 mins ago</small> --}}
                                    {{-- @if (Auth::guest() || Auth::user()->role_id != 3)
                                        <a href="/grooming" class="btn btn-success">Click Here</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card kotakSize">
                                {{-- <img src="..." class="card-img-top" alt="..."> --}}
                                <img src="{{asset('gambar/konsul.png')}}" alt="foto" width="100%" height="100%" class="">
                                <div class="card-body">
                                    <h5 class="card-title">Pet Konsultasi</h5>
                                    <p class="card-text">Berkonsultasi dengan dokter hewan.</p>
                                </div>
                                <div class="card-footer">
                                    {{-- <small class="text-muted">Last updated 3 mins ago</small> --}}
                                    {{-- @if (Auth::guest() || Auth::user()->role_id != 3)
                                        <a href="/konsultasi" class="btn btn-success">Click Here</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- <br>
            <div class="wadah_kategori">
                <a href="/adoption">
                    <button class="btn btn-primary">
                        Adoption
                    </button>
                </a>
            </div>
            <br>
            <div class="wadah_kategori_isi">
                @foreach ($pet as $pets)
                    <a href="/adoption" class="">
                        <table class="isi_tbl">
                            <tr>
                                <td colspan="3">
                                    <img src="{{asset('gambar/pet/'. $pets->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="100px" height="100px">
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>{{$pets->pet_name}}</td>
                            </tr>
                            <tr>
                                <td>Breed</td>
                                <td>:</td>
                                <td>{{$pets->breed_category}}</td>
                            </tr>
                            <tr>
                                <td>Age</td>
                                <td>:</td>
                                <td>{{$pets->age_category}}</td>
                            </tr>
                        </table>
                    </a>
                @endforeach
            </div> --}}
            <br>

            {{-- pagination --}}
            {{-- link per page tidak ditampilkan semua --}}
            {{-- <?php
                // batas link nya
                $batas_link = 4;
            ?>
            <ul class="pagination">
                <li class="page-item {{ ($pet->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $pet->url(1) }}" tabindex="-1" aria-disabled="true">First</a>
                </li>

                <li class="page-item {{ ($pet->currentPage() == 1) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $pet->url($pet->currentPage()-1) }}" tabindex="-1" aria-disabled="true"><</a>
                </li>

                @for ($i = 1; $i <= $pet->lastPage(); $i++)
                    <?php
                        $half_total_links = floor($batas_link / 2);
                        $from = $pet->currentPage() - $half_total_links;
                        $to = $pet->currentPage() + $half_total_links;
                        if ($pet->currentPage() < $half_total_links) {
                            $to += $half_total_links - $pet->currentPage();
                        }
                        if ($pet->lastPage() - $pet->currentPage() < $half_total_links){
                            $from -= $half_total_links - ($pet->lastPage() - $pet->currentPage()) - 1;
                        }
                    ?>

                    @if ($from < $i && $i < $to)
                        <li class=" page-item {{ ($pet->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $pet->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

                <li class="page-item {{ ($pet->currentPage() == $pet->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $pet->url($pet->currentPage()+1) }}">></a>
                </li>

                <li class="page-item {{ ($pet->currentPage() == $pet->lastPage()) ? ' disabled' : '' }}">
                    <a class="page-link" href="{{ $pet->url($pet->lastPage()) }}">Last</a>
                </li>
            </ul> --}}

            {{-- {{$pet->links()}} --}}
        </div>
        <div class="col3_home">
            <br>

            @include('include.aboutUs')

            <br>
            <br>
        </div>
    </div>
@endsection
