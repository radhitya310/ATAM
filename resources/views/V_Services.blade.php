@extends('layouts.app')

@section('title')
    @if ($service_type == 'Grooming')
        Pet Grooming - Nirmala
    @else
        Pet Konsultasi - Nirmala
    @endif
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_services">
            <div class="title_body">
                <h1>
                    @if ($service_type == 'Grooming')
                        Pet Grooming
                    @else
                        Pet Konsultasi
                    @endif
                </h1>
            </div>
            {{-- <br>
            <br>
            <form action="/adoption/search" method="get" enctype="multipart/form-data" class="form-inline justify-content-center">
                <input name="kodePos" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" required>
                <button class="btn btn-info my-2 my-sm-0" type="submit" onclick="">Search</button>
            </form> --}}
        </div>
        @php
            $inc = 1;
        @endphp

        {{-- untuk filter nya --}}
        <center>
            <div class="wadah_filter pb-3 filter">
                @if ($service_type == 'Grooming')
                    <form action="/grooming/search" name="postName" method="get">
                @else
                    <form action="/konsultasi/search" name="postName" method="get">
                @endif
                        @if (!Auth::guest())
                            {{-- @foreach ($user as $users)
                                @if ($userID == $users->id)
                                    <input type="number" name="lat" hidden value="{{$users->latitude}}">
                                    <input type="number" name="long" hidden value="{{$users->longitude}}">
                                @endif
                            @endforeach --}}

                            <div class="form-group">
                                {{-- <label for="species">{{ __('Filter By Species') }}</label> --}}
                                <select name="radius" id="radius" class="form-control form-select cursorClass" onchange="postName.submit()" autofocus>
                                    @if ($radius == "")
                                        <option hidden value="">Filter By Location</option>
                                        <option value="1">radius ( 0 - 5 km ) </option>
                                        <option value="2">radius ( 6 - 10 km ) </option>
                                        <option value="3">radius ( > 10 km ) </option>
                                    @else
                                        @if ($radius == 1)
                                            <option hidden value="1">radius ( 0 - 5 km ) </option>
                                            <option value="2">radius ( 6 - 10 km ) </option>
                                            <option value="3">radius ( > 10 km ) </option>
                                        @endif
                                        @if ($radius == 2)
                                            <option hidden value="2">radius ( 6 - 10 km ) </option>
                                            <option value="1">radius ( 0 - 5 km ) </option>
                                            <option value="3">radius ( > 10 km ) </option>
                                        @endif
                                        @if ($radius == 3)
                                            <option hidden value="3">radius ( > 10 km ) </option>
                                            <option value="1">radius ( 0 - 5 km ) </option>
                                            <option value="2">radius ( 6 - 10 km ) </option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                {{-- <label for="species">{{ __('Filter By Species') }}</label> --}}
                                <select title="you must login first" disabled name="radius" id="radius" class="form-control form-select cursorNot" onchange="postName.submit()">
                                    @if ($radius == "")
                                        <option hidden value="">Filter By Location</option>
                                        <option value="1">radius ( 0 - 5 km ) </option>
                                        <option value="2">radius ( 6 - 10 km ) </option>
                                        <option value="3">radius ( > 10 km ) </option>
                                    @else
                                        @if ($radius == 1)
                                            <option hidden value="1">radius ( 0 - 5 km ) </option>
                                            <option value="2">radius ( 6 - 10 km ) </option>
                                            <option value="3">radius ( > 10 km ) </option>
                                        @endif
                                        @if ($radius == 2)
                                            <option hidden value="2">radius ( 6 - 10 km ) </option>
                                            <option value="1">radius ( 0 - 5 km ) </option>
                                            <option value="3">radius ( > 10 km ) </option>
                                        @endif
                                        @if ($radius == 3)
                                            <option hidden value="3">radius ( > 10 km ) </option>
                                            <option value="1">radius ( 0 - 5 km ) </option>
                                            <option value="2">radius ( 6 - 10 km ) </option>
                                        @endif
                                    @endif
                                </select>
                            </div>
                        @endif

                        @if ($valid == 0)
                            <div class="wadah_buttonReset d-none" id="wadah_buttonReset">
                        @else
                            <div class="wadah_buttonReset" id="wadah_buttonReset">
                        @endif
                            @if ($service_type == 'Grooming')
                                <a href="/grooming">
                            @else
                                <a href="/konsultasi">
                            @endif
                                    <button class="btn btn-danger" type="button" id="resetButtonFilter">
                                        &times;
                                    </button>
                                </a>
                            </div>
                    </form>

            </div>
        </center>

        {{-- @if ($typePaginate == 'searchServices')
            <div class="filterServices p-2 mb-5">
        @else --}}
        {{-- @endif --}}
                <div class="col2_services">
                    <div class="filterServices">
                        @if($dataUser->count() == 0)
                            <div class="text-center">
                                <label>
                                    <br>
                                    {{-- <h2 class="text-danger">Data tidak ada</h2> --}}
                                    <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                    <br>
                                </label>
                            </div>
                        @endif
                        @foreach ($countGrooming as $countGroomings)
                            @if ($countGroomings->countID != 0)
                                @foreach ($dataUser as $dataUsers)
                                    @if ($valid == 0)
                                        @if ($countGroomings->user_id_pet_shop == $dataUsers->id)
                                            <div class="table-responsive tbl_services">
                                                <table class="table table-hover border_none">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="3">
                                                                <center>
                                                                    <div class="classFoto">
                                                                        @if ($dataUsers->user_photo == null)
                                                                            <img src="{{ asset('gambar/petshop.png') }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                                                                        @else
                                                                            <img src="{{url('gambar/foto_user_login/'.$dataUsers->user_photo)}}" alt="foto pet shop" class="rounded-circle" width="250px" height="250px">
                                                                        @endif
                                                                    </div>
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Pet Shop Name</td>
                                                            <td class="detail_column_2">:</td>
                                                            <td>{{ $dataUsers->name }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone Number</td>
                                                            <td>:</td>
                                                            <td>{{ $dataUsers->phone_number }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Email</td>
                                                            <td>:</td>
                                                            <td>
                                                                <a href="mailto:{{$dataUsers->email}}" target="_blank">
                                                                    {{ $dataUsers->email }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Opening Hours
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                {{$dataUsers->open_hour_pet_shop}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address</td>
                                                            <td>:</td>
                                                            <td>{{ $dataUsers->address }}</td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td>Postal Code</td>
                                                            <td>:</td>
                                                            <td>{{ $dataUsers->kode_pos }}</td>
                                                        </tr> --}}
                                                        <tr>
                                                            <td>Price</td>
                                                            <td>:</td>
                                                            <td class="bg-success text-white">
                                                                @foreach ($minPrice as $minPrices)
                                                                    @foreach ($maxPrice as $maxPrices)
                                                                        @if ($minPrices->user_id_pet_shop == $dataUsers->id && $maxPrices->user_id_pet_shop == $dataUsers->id)
                                                                            {{ 'Rp. ('.number_format($minPrices->service_price, 0, ',', '.').' - '.number_format($maxPrices->service_price,0,',','.').')' }}
                                                                        @endif
                                                                    @endforeach
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                {{-- @if (Auth::user())
                                                    <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                @else
                                                    <form action="{{ route('login') }}" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                    <form action="/login" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                @endif --}}
                                                @if ($service_type == 'Grooming')
                                                    <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                @else
                                                    <form action="/konsultasi/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                @endif
                                                        <button type="submit" class="btn btn-danger" id="">Book Now</button>
                                                    </form>
                                            </div>
                                        @endif
                                    @else
                                        @if ($radius == 1)
                                            @if ($countGroomings->user_id_pet_shop == $dataUsers->id && $countGroomings->countID != 0)
                                                @if ($dataUsers->distance <= 5)
                                                    <div class="table-responsive tbl_services">
                                                        @if ($service_type == 'Grooming')
                                                            <table class="table border_none">
                                                        @else
                                                            <table class="table border_none">
                                                        @endif
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <center>
                                                                                <div class="classFoto">
                                                                                    @if ($dataUsers->user_photo == null)
                                                                                        <img src="{{ asset('gambar/petshop.png') }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                                                                                    @else
                                                                                        <img src="{{url('gambar/foto_user_login/'.$dataUsers->user_photo)}}" alt="foto pet shop" class="rounded-circle" width="250px" height="250px">
                                                                                    @endif
                                                                                </div>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Radius
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td class="text-danger">
                                                                            {{-- {{$pets2->distance.' (KM)' }} --}}
                                                                            {{ number_format($dataUsers->distance, 2, ',', '.').' (KM)' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pet Shop Name</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>{{ $dataUsers->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone Number</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->phone_number }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            <a href="mailto:{{$dataUsers->email}}" target="_blank">
                                                                                {{ $dataUsers->email }}
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Opening Hours
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{$dataUsers->open_hour_pet_shop}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->address }}</td>
                                                                    </tr>
                                                                    {{-- <tr>
                                                                        <td>Postal Code</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->kode_pos }}</td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                        <td>Price</td>
                                                                        <td>:</td>
                                                                        <td class="bg-success text-white">
                                                                        @foreach ($minPrice as $minPrices)
                                                                            @foreach ($maxPrice as $maxPrices)
                                                                                @if ($minPrices->user_id_pet_shop == $dataUsers->id && $maxPrices->user_id_pet_shop == $dataUsers->id)
                                                                                    {{ 'Rp. ('.number_format($minPrices->service_price, 0, ',', '.').' - '.number_format($maxPrices->service_price,0,',','.').')' }}
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            {{-- @if (Auth::user())
                                                                <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                            @else
                                                                <form action="{{ route('login') }}" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                <form action="/login" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                            @endif --}}
                                                                @if ($service_type == 'Grooming')
                                                                    <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                @else
                                                                    <form action="/konsultasi/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                @endif
                                                                        <button type="submit" class="btn btn-danger" id="">Book Now</button>
                                                                    </form>
                                                    </div>
                                                @else
                                                    <div class="classNotFoundService">
                                                        {{-- <h2 class="text-danger">
                                                            Data tidak ada
                                                        </h2> --}}
                                                        <div class="text-center">
                                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                        @if ($radius == 2)
                                            @if ($countGroomings->user_id_pet_shop == $dataUsers->id && $countGroomings->countID != 0)
                                                @if ($dataUsers->distance >= 6 && $dataUsers->distance <= 10)
                                                    <div class="table-responsive tbl_services">
                                                        @if ($service_type == 'Grooming')
                                                            <table class="table border_none">
                                                        @else
                                                            <table class="table border_none">
                                                        @endif
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <center>
                                                                                <div class="classFoto">
                                                                                    @if ($dataUsers->user_photo == null)
                                                                                        <img src="{{ asset('gambar/petshop.png') }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                                                                                    @else
                                                                                        <img src="{{url('gambar/foto_user_login/'.$dataUsers->user_photo)}}" alt="foto pet shop" class="rounded-circle" width="250px" height="250px">
                                                                                    @endif
                                                                                </div>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Radius
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td class="text-danger">
                                                                            {{-- {{$pets2->distance.' (KM)' }} --}}
                                                                            {{ number_format($dataUsers->distance, 2, ',', '.').' (KM)' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pet Shop Name</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>{{ $dataUsers->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone Number</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->phone_number }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            <a href="mailto:{{$dataUsers->email}}" target="_blank">
                                                                                {{ $dataUsers->email }}
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Opening Hours
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{$dataUsers->open_hour_pet_shop}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->address }}</td>
                                                                    </tr>
                                                                    {{-- <tr>
                                                                        <td>Postal Code</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->kode_pos }}</td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                        <td>Price</td>
                                                                        <td>:</td>
                                                                        <td class="bg-success text-white">
                                                                        @foreach ($minPrice as $minPrices)
                                                                            @foreach ($maxPrice as $maxPrices)
                                                                                @if ($minPrices->user_id_pet_shop == $dataUsers->id && $maxPrices->user_id_pet_shop == $dataUsers->id)
                                                                                    {{ 'Rp. ('.number_format($minPrices->service_price, 0, ',', '.').' - '.number_format($maxPrices->service_price,0,',','.').')' }}
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            {{-- @if (Auth::user())
                                                                <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                            @else
                                                                <form action="{{ route('login') }}" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                <form action="/login" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                            @endif --}}
                                                                @if ($service_type == 'Grooming')
                                                                    <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                @else
                                                                    <form action="/konsultasi/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                @endif
                                                                        <button type="submit" class="btn btn-danger" id="">Book Now</button>
                                                                    </form>
                                                    </div>
                                                @else
                                                    <div class="classNotFoundService">
                                                        {{-- <h2 class="text-danger">
                                                            Data tidak ada
                                                        </h2> --}}
                                                        <div class="text-center">
                                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                        @if ($radius == 3)
                                            @if ($countGroomings->user_id_pet_shop == $dataUsers->id && $countGroomings->countID != 0)
                                                @if ($dataUsers->distance > 10)
                                                    <div class="table-responsive tbl_services">
                                                        @if ($service_type == 'Grooming')
                                                            <table class="table border_none">
                                                        @else
                                                            <table class="table border_none">
                                                        @endif
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="3">
                                                                            <center>
                                                                                <div class="classFoto">
                                                                                    @if ($dataUsers->user_photo == null)
                                                                                        <img src="{{ asset('gambar/petshop.png') }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                                                                                    @else
                                                                                        <img src="{{url('gambar/foto_user_login/'.$dataUsers->user_photo)}}" alt="foto pet shop" class="rounded-circle" width="250px" height="250px">
                                                                                    @endif
                                                                                </div>
                                                                            </center>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Radius
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td class="text-danger">
                                                                            {{-- {{$pets2->distance.' (KM)' }} --}}
                                                                            {{ number_format($dataUsers->distance, 2, ',', '.').' (KM)' }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pet Shop Name</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>{{ $dataUsers->name }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Phone Number</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->phone_number }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Email</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            <a href="mailto:{{$dataUsers->email}}" target="_blank">
                                                                                {{ $dataUsers->email }}
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            Opening Hours
                                                                        </td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{$dataUsers->open_hour_pet_shop}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->address }}</td>
                                                                    </tr>
                                                                    {{-- <tr>
                                                                        <td>Postal Code</td>
                                                                        <td>:</td>
                                                                        <td>{{ $dataUsers->kode_pos }}</td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                        <td>Price</td>
                                                                        <td>:</td>
                                                                        <td class="bg-success text-white">
                                                                        @foreach ($minPrice as $minPrices)
                                                                            @foreach ($maxPrice as $maxPrices)
                                                                                @if ($minPrices->user_id_pet_shop == $dataUsers->id && $maxPrices->user_id_pet_shop == $dataUsers->id)
                                                                                    {{ 'Rp. ('.number_format($minPrices->service_price, 0, ',', '.').' - '.number_format($maxPrices->service_price,0,',','.').')' }}
                                                                                @endif
                                                                            @endforeach
                                                                        @endforeach
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            {{-- @if (Auth::user())
                                                                <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                            @else
                                                                <form action="{{ route('login') }}" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                <form action="/login" method="" enctype="multipart/form-data" class="form_btn_bookNow">
                                                            @endif --}}
                                                                @if ($service_type == 'Grooming')
                                                                    <form action="/grooming/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                @else
                                                                    <form action="/konsultasi/detail/{{ $dataUsers->id }}" method="get" enctype="multipart/form-data" class="form_btn_bookNow">
                                                                @endif
                                                                        <button type="submit" class="btn btn-danger" id="">Book Now</button>
                                                                    </form>
                                                    </div>
                                                @else
                                                    <div class="classNotFoundService">
                                                        {{-- <h2 class="text-danger">
                                                            Data tidak ada
                                                        </h2> --}}
                                                        <div class="text-center">
                                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
        {{-- pagination --}}
        {{-- @if ($typePaginate == 'services')
            <div class="col3_services">
                <ul class="pagination">
                    <li class="page-item {{ ($dataUser->currentPage() == 1) ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $dataUser->url($dataUser->currentPage()-1) }}" tabindex="-1" aria-disabled="true">&laquo;</a>
                    </li>

                    @for ($i = 1; $i <= $dataUser->lastPage(); $i++)
                        <li class="page-item {{ ($dataUser->currentPage() == $i) ? ' active' : '' }}" aria-current="page">
                            <a class="page-link" href="{{ $dataUser->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <li class="page-item {{ ($dataUser->currentPage() == $dataUser->lastPage()) ? ' disabled' : '' }}">
                        <a class="page-link" href="{{ $dataUser->url($dataUser->currentPage()+1) }}">&raquo;</a>
                    </li>
                </ul>
            </div>
        @endif --}}
        <br>
    </div>
@endsection
