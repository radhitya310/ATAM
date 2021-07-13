@extends('layouts.app')

@section('title')
    Adoption - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        {{-- @php
            $userID = Auth::user()->id;
        @endphp

        <?=
            $userID = Auth::user()->id;
        ?> --}}

        {{-- untuk judul --}}
        <div class="col1_2">
            <div class="title_body">
                <h1>
                    Pet Adoption
                </h1>
                <br>
            </div>
        </div>

        {{-- tampilin request pet + pagination + filter + button my pet status --}}
        <div class="col2_2">
            @if (session('message'))
                <div class="alert alert-success text-center m-4">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                        {{-- &times; --}}
                    </button>
                </div>
            @endif

            {{-- untuk ke status pet adoption --}}
            <div class="wadah_button_MyPet">
                @if (!Auth::guest() && Auth::user()->role_id == 1)
                    <button type="button" id="" class="btn btn-primary" disabled>
                        {{__('My Pet Status')}}
                    </button>
                @else
                    <a href="/status/pet-adoption">
                        <button type="button" id="" class="btn btn-primary">
                            {{__('My Pet Status')}}
                        </button>
                    </a>
                @endif
                {{-- @if (!Auth::guest())
                    <a href="/status/pet-adoption">
                @else
                    <a href="/login">
                @endif
                    <button type="button" id="" class="btn btn-success">
                        {{__('My Pet Status')}}
                    </button>
                </a> --}}
            </div>

            {{-- untuk filter nya --}}
            <div class="wadah_filter p-3 filter">
                <form action="/adoption/search" name="postName" method="get">
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

                    <div class="form-group">
                        {{-- <label for="species">{{ __('Filter By Species') }}</label> --}}
                        <select name="species" id="species" class="form-control form-select cursorClass" onchange="postName.submit()" autofocus>
                            @if ($search1 == "")
                                <option hidden value="">Filter By Species</option>
                            @else
                                @foreach ($species as $specieses)
                                    @if ($specieses->species_id == $search1)
                                        <option hidden value="{{$search1}}">{{ $specieses->species_name }}</option>
                                    @endif
                                @endforeach
                            @endif
                            @foreach ($species as $specieses)
                                @if ($specieses->species_id != $search1)
                                    <option value="{{ $specieses->species_id }}" id="">{{ $specieses->species_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        {{-- <label for="breed">{{ __('Filter By Breed') }}</label> --}}
                        <select name="breed" id="breed" class="form-control form-select cursorClass" onchange="postName.submit()">
                            @if ($search2 == "")
                                <option hidden value="">Filter By Breed</option>
                            @else
                                @foreach ($breed as $breeds)
                                    @if ($breeds->breed_id == $search2)
                                        <option hidden value="{{$search2}}">{{ $breeds->breed_category }}</option>
                                    @endif
                                @endforeach
                            @endif
                            @foreach ($breed as $breeds)
                                @if ($breeds->breed_id != $search2)
                                    <option value="{{ $breeds->breed_id }}" id="">{{ $breeds->breed_category }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        {{-- <label for="age">{{ __('Filter By Species') }}</label> --}}
                        <select name="age" id="age" class="form-control form-select cursorClass" onchange="postName.submit()" autofocus>
                            @if ($search3 == "")
                                <option hidden value="">Filter By Ages</option>
                            @else
                                @foreach ($age as $ages)
                                    @if ($ages->age_id == $search3)
                                        <option hidden value="{{$search3}}">{{ $ages->age_category }}</option>
                                    @endif
                                @endforeach
                            @endif
                            @foreach ($age as $ages)
                                @if ($ages->age_id != $search3)
                                    <option value="{{ $ages->age_id }}" id="">{{ $ages->age_category }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    @if ($valid == 0)
                        <div class="wadah_buttonReset d-none" id="wadah_buttonReset">
                    @else
                        <div class="wadah_buttonReset" id="wadah_buttonReset">
                    @endif
                        <a href="/adoption">
                            <button class="btn btn-danger" type="button" id="resetButtonFilter">
                                &times;
                            </button>
                        </a>
                    </div>
                </form>

            </div>

            {{-- untuk request pet --}}
            @if ($typePaginate == 'searchAdopt')
                <div class="col2_2_isi searchAdopt">
            @else
                <div class="col2_2_isi">
            @endif
                    {{-- <div class="wadah_button_search_style">
                        <form action="/adoption/search" method="get" enctype="multipart/form-data" class="form-inline">
                            <input name="search" class="form-control mr-sm-2 @error('search') is-invalid @enderror" type="search" placeholder="Type to Search" aria-label="Search" value="">
                            <button class="btn btn-info my-2 my-sm-0" type="submit" onclick="searchkodePos()">Search</button>
                            @error('search')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </form>
                    </div>
                    <br> --}}

                    @if ($countTablePets == 0)
                        <label>
                            <h2 class="text-danger">Data tidak ada</h2>
                        </label>
                    @else
                        @if($pet2->count() == 0)
                            <label>
                                <br>
                                <h2 class="text-danger">Data tidak ada</h2>
                            </label>
                        @endif
                        @foreach ($pet2 as $pets2)
                            @if (!Auth::guest())
                                @foreach ($userLogin as $item => $value)
                                    <form action="/adoption/detail/{{ $pets2->pet_id }}" method="get" enctype="multipart/form-data">
                                        @if ($validLocation == 0)
                                            @if ($userID == $pets2->user_id)
                                                <table class="isi_tbl tbl_active1">
                                            @else
                                                <table class="isi_tbl">
                                            @endif
                                                    <tr>
                                                        <td colspan="3">
                                                            <img src="{{asset('gambar/pet/' . $pets2->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="200px" height="200px">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Name
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $pets2->pet_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Breed
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $pets2->breed_category }}
                                                        </td>
                                                    {{-- <tr class="d-none" id="rowAge"> --}}
                                                    {{-- @if ($valid == 0)
                                                        <tr class="d-none">
                                                    @else
                                                        <tr>
                                                    @endif --}}
                                                    <tr>
                                                        <td>
                                                            Age
                                                        </td>
                                                        <td>:</td>
                                                        <td>
                                                            {{ $pets2->age_category }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="detail_more text-center">
                                                            {{-- @foreach ($user as $users)
                                                                @if ($userID == $users->id)
                                                                    <input type="number" name="lat" hidden value="{{$users->latitude}}">
                                                                    <input type="number" name="long" hidden value="{{$users->longitude}}">
                                                                @endif
                                                            @endforeach
                                                            <button type="submit" class="btn btn-outline-info text-dark">
                                                                Adopt here...
                                                            </button> --}}
                                                            <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                            {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}/{{$value->latitude}}/{{$value->longitude}}"> --}}
                                                                <button type="button" class="btn btn-outline-info text-dark">
                                                                    Adopt here...
                                                                </button>
                                                            </a>
                                                            {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                                Adopt here...
                                                            </a> --}}
                                                        </td>
                                                    </tr>
                                                </table>
                                        @else
                                            @if ($userID == $pets2->user_id)
                                                <table class="isi_tbl tbl_active1">
                                            @else
                                                <table class="isi_tbl">
                                            @endif
                                                    @if ($radius == 1)
                                                        @if ($pets2->distance <= 5)
                                                            <tr>
                                                                <td colspan="3">
                                                                    <img src="{{asset('gambar/pet/' . $pets2->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="200px" height="200px">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Radius
                                                                </td>
                                                                <td>:</td>
                                                                <td class="text-danger">
                                                                    {{-- {{$pets2->distance.' (KM)' }} --}}
                                                                    {{ number_format($pets2->distance, 2, ',', '.').' (KM)' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Name
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->pet_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Breed
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->breed_category }}
                                                                </td>
                                                            {{-- <tr class="d-none" id="rowAge"> --}}
                                                            {{-- @if ($valid == 0)
                                                                <tr class="d-none">
                                                            @else
                                                                <tr>
                                                            @endif --}}
                                                            <tr>
                                                                <td>
                                                                    Age
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->age_category }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="detail_more text-center">
                                                                    <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                                    {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}/{{$value->latitude}}/{{$value->longitude}}"> --}}
                                                                        <button type="button" class="btn btn-outline-info text-dark">
                                                                            Adopt here...
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <div class="classNotFound">
                                                                <h2 class="text-danger text-center">
                                                                    Data tidak ada
                                                                </h2>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if ($radius == 2)
                                                        @if ($pets2->distance >= 6 && $pets2->distance <= 10)
                                                            <tr>
                                                                <td colspan="3">
                                                                    <img src="{{asset('gambar/pet/' . $pets2->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="200px" height="200px">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Radius
                                                                </td>
                                                                <td>:</td>
                                                                <td class="text-danger">
                                                                    {{-- {{$pets2->distance.' (KM)' }} --}}
                                                                    {{ number_format($pets2->distance, 2, ',', '.').' (KM)' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Name
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->pet_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Breed
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->breed_category }}
                                                                </td>
                                                            {{-- <tr class="d-none" id="rowAge"> --}}
                                                            {{-- @if ($valid == 0)
                                                                <tr class="d-none">
                                                            @else
                                                                <tr>
                                                            @endif --}}
                                                            <tr>
                                                                <td>
                                                                    Age
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->age_category }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="detail_more text-center">
                                                                    <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                                    {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}/{{$value->latitude}}/{{$value->longitude}}"> --}}
                                                                        <button type="button" class="btn btn-outline-info text-dark">
                                                                            Adopt here...
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <div class="classNotFound">
                                                                <h2 class="text-danger text-center">
                                                                    Data tidak ada
                                                                </h2>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @if ($radius == 3)
                                                        @if ($pets2->distance > 10)
                                                            <tr>
                                                                <td colspan="3">
                                                                    <img src="{{asset('gambar/pet/' . $pets2->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="200px" height="200px">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Radius
                                                                </td>
                                                                <td>:</td>
                                                                <td class="text-danger">
                                                                    {{-- {{$pets2->distance.' (KM)' }} --}}
                                                                    {{ number_format($pets2->distance, 2, ',', '.').' (KM)' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Name
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->pet_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Breed
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->breed_category }}
                                                                </td>
                                                            {{-- <tr class="d-none" id="rowAge"> --}}
                                                            {{-- @if ($valid == 0)
                                                                <tr class="d-none">
                                                            @else
                                                                <tr>
                                                            @endif --}}
                                                            <tr>
                                                                <td>
                                                                    Age
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets2->age_category }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="detail_more text-center">
                                                                    <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                                    {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}/{{$value->latitude}}/{{$value->longitude}}"> --}}
                                                                        <button type="button" class="btn btn-outline-info text-dark">
                                                                            Adopt here...
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            <div class="classNotFound">
                                                                <h2 class="text-danger text-center">
                                                                    Data tidak ada
                                                                </h2>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </table>
                                        @endif
                                    </form>
                                @endforeach
                            @else
                                <form action="/adoption/detail/{{ $pets2->pet_id }}" method="get" enctype="multipart/form-data">
                                    @if ($userID == $pets2->user_id)
                                        <table class="isi_tbl tbl_active1">
                                    @else
                                        <table class="isi_tbl">
                                    @endif
                                            <tr>
                                                <td colspan="3">
                                                    <img src="{{asset('gambar/pet/' . $pets2->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="200px" height="200px">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Name
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    {{ $pets2->pet_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Breed
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    {{ $pets2->breed_category }}
                                                </td>
                                            {{-- <tr class="d-none" id="rowAge"> --}}
                                            {{-- @if ($valid == 0)
                                                <tr class="d-none">
                                            @else
                                                <tr>
                                            @endif --}}
                                            <tr>
                                                <td>
                                                    Age
                                                </td>
                                                <td>:</td>
                                                <td>
                                                    {{ $pets2->age_category }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="detail_more text-center">
                                                    {{-- @foreach ($user as $users)
                                                        @if ($userID == $users->id)
                                                            <input type="number" name="lat" hidden value="{{$users->latitude}}">
                                                            <input type="number" name="long" hidden value="{{$users->longitude}}">
                                                        @endif
                                                    @endforeach
                                                    <button type="submit" class="btn btn-outline-info text-dark">
                                                        Adopt here...
                                                    </button> --}}
                                                    <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                    {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}/{{0}}/{{0}}"> --}}
                                                        <button type="button" class="btn btn-outline-info text-dark">
                                                            Adopt here...
                                                        </button>
                                                    </a>
                                                    {{-- <a href="/adoption/detail/{{ $pets2->pet_id }}">
                                                        Adopt here...
                                                    </a> --}}
                                                </td>
                                            </tr>
                                        </table>
                                </form>
                            @endif
                        @endforeach
                    @endif

                    <br>
                    <br>
                    @if ($typePaginate == 'adopt')
                        {{-- pagination --}}
                        {{-- link per page tidak ditampilkan semua --}}
                        <?php
                            // batas link nya
                            $batas_link = 4;
                        ?>
                        <ul class="pagination">
                            <li class="page-item {{ ($pet2->currentPage() == 1) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $pet2->url(1) }}" tabindex="-1" aria-disabled="true">First</a>
                            </li>

                            <li class="page-item {{ ($pet2->currentPage() == 1) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $pet2->url($pet2->currentPage()-1) }}" tabindex="-1" aria-disabled="true"><</a>
                            </li>

                            @for ($i = 1; $i <= $pet2->lastPage(); $i++)
                                <?php
                                    $half_total_links = floor($batas_link / 2);
                                    $from = $pet2->currentPage() - $half_total_links;
                                    $to = $pet2->currentPage() + $half_total_links;
                                    if ($pet2->currentPage() < $half_total_links) {
                                        $to += $half_total_links - $pet2->currentPage();
                                    }
                                    if ($pet2->lastPage() - $pet2->currentPage() < $half_total_links){
                                        $from -= $half_total_links - ($pet2->lastPage() - $pet2->currentPage()) - 1;
                                    }
                                ?>

                                @if ($from < $i && $i < $to)
                                    <li class=" page-item {{ ($pet2->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $pet2->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            <li class="page-item {{ ($pet2->currentPage() == $pet2->lastPage()) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $pet2->url($pet2->currentPage()+1) }}">></a>
                            </li>

                            <li class="page-item {{ ($pet2->currentPage() == $pet2->lastPage()) ? ' disabled' : '' }}">
                                <a class="page-link" href="{{ $pet2->url($pet2->lastPage()) }}">Last</a>
                            </li>
                        </ul>
                        {{-- {{$pet2->links()}} --}}
                    @endif
                </div>
        </div>

        {{-- tampilin waiting + canceled + rejected + accepted --}}
        <div class="col3_2">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button btn btn-outline-warning" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Waiting for Adopt
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if (!Auth::guest())
                                <div class="wadah_waitingMark">
                                    {{-- @foreach ($countStatus1 as $item => $value) --}}
                                    {{-- @foreach ($countStatus1 as $countStatuss1)
                                    @endforeach --}}
                                    @if($countStatus1 == 0)
                                        <label>
                                            <br>
                                            <h2 class="text-danger">Data tidak ada</h2>
                                        </label>
                                    @else
                                        @foreach ($pet3 as $pets3)
                                            <form action="/adoption/detail/submissions/{{ $pets3->adopt_submission_id }}" method="put" enctype="multipart/form-data">
                                                {{-- <a href="/adoption/detail/waiting/{{ $pets3->adopt_submission_id }}"> --}}
                                                    <table class="isi_tbl tbl_active_waiting">
                                                        <tr>
                                                            <td colspan="3">
                                                                <center>
                                                                    <img src="{{asset('gambar/pet/' . $pets3->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="100px" height="100px">
                                                                </center>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Name
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                {{ $pets3->pet_name }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Breed
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                @foreach ($breed as $breeds)
                                                                    @if ($breeds->breed_id == $pets3->breed_id)
                                                                        {{ $breeds->breed_category }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Age
                                                            </td>
                                                            <td>:</td>
                                                            <td>
                                                                @foreach ($age as $ages)
                                                                    @if ($ages->age_id == $pets3->age_id)
                                                                        {{ $ages->age_category }}
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td>
                                                                Status
                                                            </td>
                                                            <td>:</td>
                                                            <td class="text-warning">
                                                                {{$pets3->status}}
                                                            </td>
                                                        </tr> --}}
                                                        <tr>
                                                            <td>
                                                                Status
                                                            </td>
                                                            <td>:</td>
                                                            <td class="text-dark bg-warning">
                                                                {{$pets3->status}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="detail_more text-center">
                                                                <a href="/adoption/detail/submissions/{{ $pets3->adopt_submission_id }}" data-bs-toggle="modal" data-bs-target="#detailWaiting{{ $pets3->adopt_submission_id }}">
                                                                {{-- <a href="/adoption/detail/submissions/{{ $pets3->adopt_submission_id }}"> --}}
                                                                    Detail more...
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                {{-- </a> --}}
                                            </form>

                                            {{-- modal untuk detail waiting --}}
                                            {{-- <div class="modal fade" id="detailWaiting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                                            <div class="modal fade" id="detailWaiting{{ $pets3->adopt_submission_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-info">
                                                            <h5 class="modal-title text-center" id="cancelLabel">Detail Pet Adoption</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                {{-- <span aria-hidden="true">&times;</span> --}}
                                                            </button>
                                                        </div>
                                                        <div class="modal-body text-left">
                                                            <div class="table table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <td class="w-50"><h2>Status</h2></td>
                                                                        <td><h2>:</h2></td>
                                                                        <td>
                                                                            @if ($pets3->status == 'Rejected' || $pets3->status == 'Canceled' )
                                                                                <h3 class="p-3 field_table_td bg-danger text-light">
                                                                            @endif
                                                                            @if ($pets3->status == 'Accepted')
                                                                                <h3 class="p-3 field_table_td bg-success text-light">
                                                                            @endif
                                                                            @if ($pets3->status == 'Waiting for Adopt')
                                                                                <h3 class="p-3 field_table_td bg-warning text-dark">
                                                                            @endif
                                                                                {{$pets3->status}}
                                                                            </h3>
                                                                        </td>
                                                                    </tr>
                                                                    {{-- @if ($pets3->status == 'Accepted' || $pets3->status == 'Rejected')
                                                                        <tr>
                                                                            <td><h4>Message's Pet Owner</h4></td>
                                                                            <td><h4>:</h4></td>
                                                                            <td>
                                                                                <h4>
                                                                                    {{$pets3->reason}}
                                                                                </h4>
                                                                            </td>
                                                                        </tr>
                                                                    @endif --}}
                                                                </table>
                                                            </div>

                                                            <div class="divider mb-3"></div>
                                                            {{-- <div class="table table-responsive pt-4">
                                                                <table class="table table-hover text-danger">
                                                                    <tr>
                                                                        <td class="w-50"><h2>Radius</h2></td>
                                                                        <td><h2>:</h2></td>
                                                                        <td>
                                                                            <h2>
                                                                                {{ number_format($pets3->distance, 2, ',', '.').' (KM)' }}
                                                                            </h2>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div> --}}

                                                            {{-- untuk data pet owner nya --}}
                                                            {{-- @foreach ($pet as $pets) --}}
                                                            @foreach ($user as $users)
                                                                @if ($users->id == $pets3->user_id)
                                                                    <div class="col_judul">
                                                                        Pet Owner
                                                                    </div>
                                                                    <div class="table-responsive table_detail">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                {{-- <tr>
                                                                                    <td>
                                                                                        ID
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $adopters->user_id }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td class="detail_column">
                                                                                        Name
                                                                                    </td>
                                                                                    <td class="detail_column_2">:</td>
                                                                                    <td>
                                                                                        {{ $users->name }}
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td>
                                                                                        Phone Number
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->phone_number }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td>
                                                                                        Email
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->email }}
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td>
                                                                                        Kode POS
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->kode_pos }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                                {{-- <tr>
                                                                                    <td>Address</td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->address }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3">
                                                                                        <div class="form-group d-none" id="latitudeArea">
                                                                                            <label>Latitude</label>
                                                                                            <input type="number" name="latitude" id="latitude5" readonly class="form-control" value="{{$users->latitude}}">
                                                                                        </div>

                                                                                        <div class="form-group d-none">
                                                                                            <label>Longitude</label>
                                                                                            <input type="number" name="longitude" id="longitude5" readonly class="form-control" value="{{$users->longitude}}">
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div id="googleMap5" class="col-lg-12 wadah_peta"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr> --}}
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    {{-- code java script untuk pet owner--}}
                                                                    <script type="text/javascript">

                                                                        var marker5;
                                                                        // //posisi awal marker
                                                                        var long5 = document.getElementById('longitude5').value;
                                                                        var lat5 = document.getElementById('latitude5').value;
                                                                        // var latLng = new google.maps.LatLng(lat,long);

                                                                        function markerAwal5(){
                                                                            var map5 = new google.maps.Map(document.getElementById('googleMap5'), {
                                                                                center:new google.maps.LatLng(lat5,long5), // jakarta
                                                                                zoom: 10,
                                                                                mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                            });

                                                                            marker5 = new google.maps.Marker({
                                                                                position : new google.maps.LatLng(lat5,long5),
                                                                                map : map5,
                                                                                animation: google.maps.Animation.BOUNCE
                                                                            });

                                                                            map5.addListener("center_changed", () => {
                                                                                // 30 seconds after the center of the map has changed, pan back to the
                                                                                // marker.
                                                                                window.setTimeout(() => {
                                                                                map5.panTo(marker5.getPosition());
                                                                                }, 30000); //ms
                                                                            });

                                                                            marker5.addListener("click", () => {
                                                                                map5.setZoom(17);
                                                                                map5.setCenter(marker5.getPosition());
                                                                            });
                                                                        }

                                                                        // // event window di-load
                                                                        google.maps.event.addDomListener(window, 'load', markerAwal5);
                                                                    </script>
                                                                @endif
                                                            @endforeach
                                                            {{-- @endforeach --}}

                                                            {{-- untuk data adopter nya --}}
                                                            @foreach ($user as $users)
                                                                @if ($users->id == $pets3->user_id_adopter)
                                                                    <div class="col_judul">
                                                                        @if ($pets3->status == 'Accepted')
                                                                            Pet Adopter
                                                                        @else
                                                                            Calon Adopter
                                                                        @endif
                                                                    </div>
                                                                    <div class="table-responsive table_detail">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                {{-- <tr>
                                                                                    <td>
                                                                                        ID
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $adopters->user_id_adopter }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td class="detail_column">
                                                                                        Name
                                                                                    </td>
                                                                                    <td class="detail_column_2">:</td>
                                                                                    <td>
                                                                                        {{ $users->name }}
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td>
                                                                                        Phone Number
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->phone_number }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td>
                                                                                        Email
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->email }}
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td>
                                                                                        Kode POS
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $adopters->kode_pos }}
                                                                                    </td>
                                                                                </tr> --}}
                                                                                {{-- <tr>
                                                                                    <td>Address</td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $users->address }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3">
                                                                                        <div class="form-group d-none" id="latitudeArea">
                                                                                            <label>Latitude</label>
                                                                                            <input type="number" name="latitude" id="latitude6" readonly class="form-control" value="{{$users->latitude}}">
                                                                                        </div>

                                                                                        <div class="form-group d-none">
                                                                                            <label>Longitude</label>
                                                                                            <input type="number" name="longitude" id="longitude6" readonly class="form-control" value="{{$users->longitude}}">
                                                                                        </div>

                                                                                        <div class="row">
                                                                                            <div id="googleMap6" class="col-lg-12 wadah_peta"></div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr> --}}
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    {{-- code java script untuk pet owner--}}
                                                                    <script type="text/javascript">

                                                                        var marker6;
                                                                        // //posisi awal marker
                                                                        var long6 = document.getElementById('longitude6').value;
                                                                        var lat6 = document.getElementById('latitude6').value;
                                                                        // var latLng = new google.maps.LatLng(lat,long);

                                                                        function markerAwal6(){
                                                                            var map6 = new google.maps.Map(document.getElementById('googleMap6'), {
                                                                                center:new google.maps.LatLng(lat6,long6), // jakarta
                                                                                zoom: 10,
                                                                                mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                            });

                                                                            marker6 = new google.maps.Marker({
                                                                                position : new google.maps.LatLng(lat6,long6),
                                                                                map : map6,
                                                                                animation: google.maps.Animation.BOUNCE
                                                                            });

                                                                            map6.addListener("center_changed", () => {
                                                                                // 30 seconds after the center of the map has changed, pan back to the
                                                                                // marker.
                                                                                window.setTimeout(() => {
                                                                                map6.panTo(marker6.getPosition());
                                                                                }, 30000); //ms
                                                                            });

                                                                            marker6.addListener("click", () => {
                                                                                map6.setZoom(17);
                                                                                map6.setCenter(marker6.getPosition());
                                                                            });
                                                                        }

                                                                        // // event window di-load
                                                                        google.maps.event.addDomListener(window, 'load', markerAwal6);
                                                                    </script>
                                                                @endif
                                                            @endforeach

                                                            {{-- untuk data detail pet nya --}}
                                                            {{-- @foreach ($pet as $pets) --}}
                                                            <div class="col_judul">
                                                                Detail Pet
                                                            </div>
                                                            <div class="table-responsive table_detail">
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="3" class="field_table">
                                                                                {{ $pets3->pet_name }}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="3" class="field_table">
                                                                                <img src="{{ asset('gambar/pet/' . $pets3->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
                                                                            </td>
                                                                        </tr>
                                                                        {{-- <tr>
                                                                            <td>ID</td>
                                                                            <td>:</td>
                                                                            <td>{{ $adopters->pet_id }}</td>
                                                                        </tr> --}}
                                                                        <tr>
                                                                            <td class="detail_column_pet">
                                                                                Species
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($species as $speciess)
                                                                                @if ($pets3->species_id == $speciess->species_id)
                                                                                    <td>
                                                                                        {{ $speciess->species_name }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Breed
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($breed as $breeds)
                                                                                @if ($pets3->breed_id == $breeds->breed_id)
                                                                                    <td>
                                                                                        {{ $breeds->breed_category }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Sex
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($sex as $sexs)
                                                                                @if ($pets3->sex_id == $sexs->sex_id)
                                                                                    <td>
                                                                                        {{ $sexs->sex_name }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Age
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($age as $ages)
                                                                                @if ($pets3->age_id == $ages->age_id)
                                                                                    <td>
                                                                                        {{ $ages->age_category }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Source
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($source as $sources)
                                                                                @if ($pets3->source_id == $sources->source_id)
                                                                                    <td>
                                                                                        {{ $sources->source_name }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Vaccine
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($vaccine as $vaccines)
                                                                                @if ($pets3->vaccine_id == $vaccines->vaccine_id)
                                                                                    <td>
                                                                                        {{ $vaccines->vaccine_status }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Sterilization
                                                                            </td>
                                                                            <td>:</td>
                                                                            @foreach ($sterilization as $sterilizations)
                                                                                @if ($pets3->sterilization_id == $sterilizations->sterilization_id)
                                                                                    <td>
                                                                                        {{ $sterilizations->sterilization_status }}
                                                                                    </td>
                                                                                @endif
                                                                            @endforeach
                                                                        </tr>
                                                                        <tr>
                                                                            <td>
                                                                                Description
                                                                            </td>
                                                                            <td>:</td>
                                                                            <td>
                                                                                {{ $pets3->pet_description }}
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <div class="container">
                                                                <div class="text-center p-2">
                                                                    <h3>Answer from the Questions</h3>
                                                                </div>
                                                                <div class="table-responsive mt-4">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="question2">{{ __('Apakah Anda memiliki hewan peliharaan? Jika iya, mohon sebutkan jumlah & jenis hewan yang Anda miliki. *') }}</label>
                                                                                <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$pets3->question_1}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="question2">{{ __('Apa saja hal yang Anda ketahui tentang jenis hewan yang akan diadopsi? *') }}</label>
                                                                                <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$pets3->question_2}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="question2">{{ __('Apakah Anda sanggup mendukung kebutuhan hewan seperti vaksin, biaya pengobatan, steril, dll? *') }}</label>
                                                                                <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$pets3->question_3}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="form-group">
                                                                                <label for="question2">{{ __('Jelaskan alasan Anda tertarik pada hewan yang dipilih! *') }}</label>
                                                                                <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $pets3->question_4 }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="wadah_button_detail">
                                                                {{-- <button type="submit" id="" class="button3_detail" disabled>
                                                                    @if ($adopters->status == "Accepted")
                                                                        {{__('Mark as Adopted')}}
                                                                    @else
                                                                        {{$adopters->status}}
                                                                    @endif
                                                                </button> --}}
                                                                {{-- <div class="cancelButton_detail">
                                                                    <button type="submit" id="" class="button4_detail" data-bs-toggle="modal" data-bs-target="#cancel{{ $pets3->pet_id }}{{ $pets3->user_id_adopter }}">
                                                                        {{__('Cancel')}}
                                                                    </button>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                                {{'No'}}
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                {{'Yes'}}
                                                            </button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- menggunakan Modal untuk confirm button cancel-->
                                            {{-- untuk confirm button cancel  --}}
                                            <div class="modal fade" id="cancel{{$pets3->pet_id}}{{$pets3->user_id_adopter}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                                            {{-- <div class="modal fade" id="cancel{{$pets3->pet_id}}{{$pets3->user_id_adopter}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="cancelLabel">Cancel Pet Adoption</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                {{-- <span aria-hidden="true">&times;</span> --}}
                                                            </button>
                                                        </div>
                                                        <form method="put" action="/adoption/cancel/{{$pets3->pet_id}}/{{ $pets3->user_id_adopter }}">
                                                            <div class="modal-body">
                                                                {{__('Apa Kamu Yakin Ingin Melakukan Cancel Pet Adoption (Pet Name = '.$pets3->pet_name.')?')}}
                                                                <br>
                                                                <br>
                                                                <div class="form-group p-2">
                                                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                                                    <input name="reasonCancel" type="text" class="form-control @error('reasonCancel') is-invalid @enderror" id="reasonInput" placeholder="Berikan alasan anda disini.." value="{{ old('reasonCancel') }}" autofocus>
                                                                    <center>
                                                                        <span style="font-size: 10px; color: grey">wajib diisi</span>
                                                                    </center>
                                                                    @error('reasonCancel')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                    {{-- <span class="invalid-feedback" role="alert" id="reasonError">
                                                                        <strong></strong>
                                                                    </span> --}}
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                                    {{'No'}}
                                                                </button>
                                                                <form method="put" action="/adoption/cancel/{{$pets3->pet_id}}/{{ $pets3->user_id_adopter }}">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        {{'Yes'}}
                                                                    </button>
                                                                </form> --}}
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                                    {{'Close'}}
                                                                </button>
                                                                {{-- <form action="/status/pet-adoption/approved/{{$adopters->pet_id}}/{{ $adopters->user_id_adopter }}" method="put" enctype="multipart/form-data"> --}}
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{'Submit'}}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <div class="wadah_waitingMark">
                                    <label>
                                        <br>
                                        <h2 class="text-danger">Data tidak ada</h2>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button btn btn-outline-danger collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Canceled
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if (!Auth::guest())
                                <div class="wadah_waitingMark">
                                    {{-- @foreach ($countStatus3 as $countStatuss3)
                                    @endforeach --}}
                                    @if ($countStatus3 == 0)
                                        <label>
                                            <br>
                                            <h2 class="text-danger">Data tidak ada</h2>
                                        </label>
                                    @else
                                        @foreach ($getAdoptSubmission as $item => $value)
                                            @if ($value->status == 'Canceled')
                                                @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                    <form action="/adoption/detail/submissions/{{$value->adopt_submission_id}}" method="get" enctype="multipart/form-data">
                                                        {{-- <a href="/adoption/detail/{{ $pets1->pet_id }}"> --}}
                                                @else
                                                    @if (!Auth::guest() && $value->user_id == $userID || $value->user_id_adopter == $userID)
                                                        <form action="/adoption/detail/submissions/{{$value->adopt_submission_id}}" method="get" enctype="multipart/form-data">
                                                            {{-- <a href="/adoption/detail/{{ $pets1->pet_id }}"> --}}
                                                    @else
                                                        <form action="" enctype="multipart/form-data" class="MarkAsAdopted_not">
                                                    @endif
                                                @endif
                                                        <table class="isi_tbl tbl_active text-left">
                                                            <tr>
                                                                <td colspan="3">
                                                                    <center>
                                                                        <img src="{{asset('gambar/pet/' . $value->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="100px" height="100px">
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Name
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $value->pet_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Breed
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    @foreach ($breed as $breeds)
                                                                        @if ($breeds->breed_id == $value->breed_id)
                                                                            {{ $breeds->breed_category }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Age
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    @foreach ($age as $ages)
                                                                        @if ($ages->age_id == $value->age_id)
                                                                            {{ $ages->age_category }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Status
                                                                </td>
                                                                <td>:</td>
                                                                <td class="text-light bg-danger">
                                                                    {{$value->status}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="detail_more text-center">
                                                                    @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                                        <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}" data-bs-toggle="modal" data-bs-target="#detalAdoptSubmissions{{$value->adopt_submission_id}}">
                                                                        {{-- <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}"> --}}
                                                                    @else
                                                                        @if (!Auth::guest() && $value->user_id == $userID || $value->user_id_adopter == $userID)
                                                                            <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}" data-bs-toggle="modal" data-bs-target="#detalAdoptSubmissions{{$value->adopt_submission_id}}">
                                                                            {{-- <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}"> --}}
                                                                        @else
                                                                            <a>
                                                                        @endif
                                                                    @endif
                                                                        Detail more...
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    {{-- </a> --}}
                                                    </form>

                                                    {{-- modal untuk detail adopt submissions --}}
                                                    {{-- <div class="modal fade" id="detalAdoptSubmissions" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                                                    <div class="modal fade" id="detalAdoptSubmissions{{$value->adopt_submission_id}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info">
                                                                    <h5 class="modal-title text-center" id="cancelLabel">Detail Pet Adoption</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                        {{-- <span aria-hidden="true">&times;</span> --}}
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-left">
                                                                    <div class="table table-responsive">
                                                                        <table class="table">
                                                                            <tr>
                                                                                <td class="w-50"><h2>Status</h2></td>
                                                                                <td><h2>:</h2></td>
                                                                                <td>
                                                                                    @if ($value->status == 'Rejected' || $value->status == 'Canceled' )
                                                                                        <h3 class="p-3 field_table_td bg-danger text-light">
                                                                                    @endif
                                                                                    @if ($value->status == 'Accepted')
                                                                                        <h3 class="p-3 field_table_td bg-success text-light">
                                                                                    @endif
                                                                                    @if ($value->status == 'Waiting for Adopt')
                                                                                        <h3 class="p-3 field_table_td bg-warning text-dark">
                                                                                    @endif
                                                                                        {{$value->status}}
                                                                                    </h3>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                @if ($value->status == 'Accepted' || $value->status == 'Rejected')
                                                                                    <td><h4>Message's From Pet Owner</h4></td>
                                                                                @endif
                                                                                @if ($value->status == 'Canceled')
                                                                                    <td><h4>Message's From Calon Adopter</h4></td>
                                                                                @endif
                                                                                    <td><h4>:</h4></td>
                                                                                    <td>
                                                                                        <h4>
                                                                                            {{$value->reason}}
                                                                                        </h4>
                                                                                    </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="divider mb-3"></div>

                                                                    {{-- <div class="table table-responsive pt-4">
                                                                        <table class="table table-hover text-danger">
                                                                            <tr>
                                                                                <td class="w-50"><h2>Radius</h2></td>
                                                                                <td><h2>:</h2></td>
                                                                                <td>
                                                                                    <h2>
                                                                                        Blom kelar
                                                                                        @if (!Auth::guest())
                                                                                            {{ number_format($pets->distance, 2, ',', '.').' (KM)' }}
                                                                                        @endif
                                                                                    </h2>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div> --}}

                                                                    {{-- untuk data pet owner nya --}}
                                                                    {{-- @foreach ($pet as $pets) --}}
                                                                    @foreach ($user as $users)
                                                                        @if ($users->id == $value->user_id)
                                                                            <div class="col_judul">
                                                                                Pet Owner
                                                                            </div>
                                                                            <div class="table-responsive table_detail">
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                ID
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $adopters->user_id }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td class="detail_column">
                                                                                                Name
                                                                                            </td>
                                                                                            <td class="detail_column_2">:</td>
                                                                                            <td>
                                                                                                {{ $users->name }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Phone Number
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->phone_number }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td>
                                                                                                Email
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->email }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Kode POS
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->kode_pos }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        {{-- <tr>
                                                                                            <td>Address</td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->address }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3">
                                                                                                <div class="form-group d-none" id="latitudeArea">
                                                                                                    <label>Latitude</label>
                                                                                                    <input type="number" name="latitude" id="latitude1" readonly class="form-control" value="{{$users->latitude}}">
                                                                                                </div>

                                                                                                <div class="form-group d-none">
                                                                                                    <label>Longitude</label>
                                                                                                    <input type="number" name="longitude" id="longitude1" readonly class="form-control" value="{{$users->longitude}}">
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div id="googleMap1" class="col-lg-12 wadah_peta"></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            {{-- code java script untuk pet owner --}}
                                                                            <script type="text/javascript">

                                                                                var marker1;
                                                                                // //posisi awal marker
                                                                                var long1 = document.getElementById('longitude1').value;
                                                                                var lat1 = document.getElementById('latitude1').value;
                                                                                // var latLng = new google.maps.LatLng(lat,long);

                                                                                function markerAwal1(){
                                                                                    var map1 = new google.maps.Map(document.getElementById('googleMap1'), {
                                                                                        center:new google.maps.LatLng(lat1,long1), // jakarta
                                                                                        zoom: 10,
                                                                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                                    });

                                                                                    marker1 = new google.maps.Marker({
                                                                                        position : new google.maps.LatLng(lat1,long1),
                                                                                        map : map1,
                                                                                        animation: google.maps.Animation.BOUNCE
                                                                                    });

                                                                                    map1.addListener("center_changed", () => {
                                                                                        // 30 seconds after the center of the map has changed, pan back to the
                                                                                        // marker.
                                                                                        window.setTimeout(() => {
                                                                                        map1.panTo(marker1.getPosition());
                                                                                        }, 30000); //ms
                                                                                    });

                                                                                    marker1.addListener("click", () => {
                                                                                        map1.setZoom(17);
                                                                                        map1.setCenter(marker1.getPosition());
                                                                                    });
                                                                                }

                                                                                // // event window di-load
                                                                                google.maps.event.addDomListener(window, 'load', markerAwal1);
                                                                            </script>
                                                                        @endif
                                                                    @endforeach
                                                                    {{-- @endforeach --}}


                                                                    {{-- untuk data adopter nya --}}
                                                                    @foreach ($user as $users)
                                                                        @if ($users->id == $value->user_id_adopter)
                                                                            <div class="col_judul">
                                                                                @if ($value->status == 'Accepted')
                                                                                    Pet Adopter
                                                                                @else
                                                                                    Calon Adopter
                                                                                @endif
                                                                            </div>
                                                                            <div class="table-responsive table_detail">
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                ID
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $adopters->user_id_adopter }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td class="detail_column">
                                                                                                Name
                                                                                            </td>
                                                                                            <td class="detail_column_2">:</td>
                                                                                            <td>
                                                                                                {{ $users->name }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Phone Number
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->phone_number }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td>
                                                                                                Email
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->email }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Kode POS
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $adopters->kode_pos }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        {{-- <tr>
                                                                                            <td>Address</td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->address }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3">
                                                                                                <div class="form-group d-none" id="latitudeArea">
                                                                                                    <label>Latitude</label>
                                                                                                    <input type="number" name="latitude" id="latitude2" readonly class="form-control" value="{{$users->latitude}}">
                                                                                                </div>

                                                                                                <div class="form-group d-none">
                                                                                                    <label>Longitude</label>
                                                                                                    <input type="number" name="longitude" id="longitude2" readonly class="form-control" value="{{$users->longitude}}">
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div id="googleMap2" class="col-lg-12 wadah_peta"></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                            {{-- code java script untuk pet adopter --}}
                                                                            <script type="text/javascript">

                                                                                var marker2;
                                                                                // //posisi awal marker
                                                                                var long2 = document.getElementById('longitude2').value;
                                                                                var lat2 = document.getElementById('latitude2').value;
                                                                                // var latLng = new google.maps.LatLng(lat,long);

                                                                                function markerAwal2(){
                                                                                    var map2 = new google.maps.Map(document.getElementById('googleMap2'), {
                                                                                        center:new google.maps.LatLng(lat2,long2), // jakarta
                                                                                        zoom: 10,
                                                                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                                    });

                                                                                    marker2 = new google.maps.Marker({
                                                                                        position : new google.maps.LatLng(lat2,long2),
                                                                                        map : map2,
                                                                                        animation: google.maps.Animation.BOUNCE
                                                                                    });

                                                                                    map2.addListener("center_changed", () => {
                                                                                        // 30 seconds after the center of the map has changed, pan back to the
                                                                                        // marker.
                                                                                        window.setTimeout(() => {
                                                                                        map2.panTo(marker2.getPosition());
                                                                                        }, 30000); //ms
                                                                                    });

                                                                                    marker2.addListener("click", () => {
                                                                                        map2.setZoom(17);
                                                                                        map2.setCenter(marker2.getPosition());
                                                                                    });
                                                                                }

                                                                                // // event window di-load
                                                                                google.maps.event.addDomListener(window, 'load', markerAwal2);
                                                                            </script>
                                                                        @endif
                                                                    @endforeach

                                                                    {{-- untuk data detail pet nya --}}
                                                                    {{-- @foreach ($pet as $pets) --}}
                                                                    <div class="col_judul">
                                                                        Detail Pet
                                                                    </div>
                                                                    <div class="table-responsive table_detail">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="3" class="field_table">
                                                                                        {{ $value->pet_name }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3" class="field_table">
                                                                                        <img src="{{ asset('gambar/pet/' . $value->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td>ID</td>
                                                                                    <td>:</td>
                                                                                    <td>{{ $adopters->pet_id }}</td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td class="detail_column_pet">
                                                                                        Species
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($species as $speciess)
                                                                                        @if ($value->species_id == $speciess->species_id)
                                                                                            <td>
                                                                                                {{ $speciess->species_name }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Breed
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($breed as $breeds)
                                                                                        @if ($value->breed_id == $breeds->breed_id)
                                                                                            <td>
                                                                                                {{ $breeds->breed_category }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Sex
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($sex as $sexs)
                                                                                        @if ($value->sex_id == $sexs->sex_id)
                                                                                            <td>
                                                                                                {{ $sexs->sex_name }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Age
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($age as $ages)
                                                                                        @if ($value->age_id == $ages->age_id)
                                                                                            <td>
                                                                                                {{ $ages->age_category }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Source
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($source as $sources)
                                                                                        @if ($value->source_id == $sources->source_id)
                                                                                            <td>
                                                                                                {{ $sources->source_name }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Vaccine
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($vaccine as $vaccines)
                                                                                        @if ($value->vaccine_id == $vaccines->vaccine_id)
                                                                                            <td>
                                                                                                {{ $vaccines->vaccine_status }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Sterilization
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($sterilization as $sterilizations)
                                                                                        @if ($value->sterilization_id == $sterilizations->sterilization_id)
                                                                                            <td>
                                                                                                {{ $sterilizations->sterilization_status }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Description
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $value->pet_description }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <div class="container">
                                                                        <div class="text-center p-2">
                                                                            <h3>Answer from the Questions</h3>
                                                                        </div>
                                                                        <div class="table-responsive mt-4">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Apakah Anda memiliki hewan peliharaan? Jika iya, mohon sebutkan jumlah & jenis hewan yang Anda miliki. *') }}</label>
                                                                                        <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$value->question_1}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Apa saja hal yang Anda ketahui tentang jenis hewan yang akan diadopsi? *') }}</label>
                                                                                        <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$value->question_2}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Apakah Anda sanggup mendukung kebutuhan hewan seperti vaksin, biaya pengobatan, steril, dll? *') }}</label>
                                                                                        <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$value->question_3}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Jelaskan alasan Anda tertarik pada hewan yang dipilih! *') }}</label>
                                                                                        <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $value->question_4 }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="wadah_button_detail">
                                                                        {{-- <button type="submit" id="" class="button3_detail" disabled>
                                                                            @if ($adopters->status == "Accepted")
                                                                                {{__('Mark as Adopted')}}
                                                                            @else
                                                                                {{$adopters->status}}
                                                                            @endif
                                                                        </button> --}}
                                                                        @if ($value->status == 'Waiting for Adopt')
                                                                            <div class="cancelButton_detail">
                                                                                <button type="submit" id="" class="button4_detail" data-bs-toggle="modal" data-bs-target="#cancel1{{ $value->pet_id }}{{ $value->user_id_adopter }}">
                                                                                    {{__('Cancel')}}
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                                        {{'No'}}
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        {{'Yes'}}
                                                                    </button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <div class="wadah_waitingMark">
                                    <label>
                                        <br>
                                        <h2 class="text-danger">Data tidak ada</h2>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button btn btn-outline-danger collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Rejected
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if (!Auth::guest())
                                <div class="wadah_waitingMark">
                                    {{-- @foreach ($countStatus4 as $countStatuss4)
                                    @endforeach --}}
                                    @if ($countStatus4 == 0)
                                        <label>
                                            <br>
                                            <h2 class="text-danger">Data tidak ada</h2>
                                        </label>
                                    @else
                                        @foreach ($getAdoptSubmission as $item => $value)
                                            @if ($value->status == 'Rejected')
                                                @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                    <form action="/adoption/detail/submissions/{{$value->adopt_submission_id}}" method="get" enctype="multipart/form-data">
                                                        {{-- <a href="/adoption/detail/{{ $pets1->pet_id }}"> --}}
                                                @else
                                                    @if (!Auth::guest() && $value->user_id == $userID || $value->user_id_adopter == $userID)
                                                        <form action="/adoption/detail/submissions/{{$value->adopt_submission_id}}" method="get" enctype="multipart/form-data">
                                                            {{-- <a href="/adoption/detail/{{ $pets1->pet_id }}"> --}}
                                                    @else
                                                        <form action="" enctype="multipart/form-data" class="MarkAsAdopted_not">
                                                    @endif
                                                @endif
                                                        <table class="isi_tbl tbl_active text-left">
                                                            <tr>
                                                                <td colspan="3">
                                                                    <center>
                                                                        <img src="{{asset('gambar/pet/' . $value->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="100px" height="100px">
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Name
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $value->pet_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Breed
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    @foreach ($breed as $breeds)
                                                                        @if ($breeds->breed_id == $value->breed_id)
                                                                            {{ $breeds->breed_category }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Age
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    @foreach ($age as $ages)
                                                                        @if ($ages->age_id == $value->age_id)
                                                                            {{ $ages->age_category }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Status
                                                                </td>
                                                                <td>:</td>
                                                                <td class="text-light bg-danger">
                                                                    {{$value->status}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="detail_more text-center">
                                                                    @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                                        <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}" data-bs-toggle="modal" data-bs-target="#detalAdoptSubmissions{{$value->adopt_submission_id}}">
                                                                        {{-- <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}"> --}}
                                                                    @else
                                                                        @if (!Auth::guest() && $value->user_id == $userID || $value->user_id_adopter == $userID)
                                                                            <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}" data-bs-toggle="modal" data-bs-target="#detalAdoptSubmissions{{$value->adopt_submission_id}}">
                                                                            {{-- <a href="/adoption/detail/submissions/{{$value->adopt_submission_id}}"> --}}
                                                                        @else
                                                                            <a>
                                                                        @endif
                                                                    @endif
                                                                        Detail more...
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    {{-- </a> --}}
                                                    </form>

                                                    {{-- modal untuk detail adopt submissions --}}
                                                    {{-- <div class="modal fade" id="detalAdoptSubmissions" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                                                    <div class="modal fade" id="detalAdoptSubmissions{{$value->adopt_submission_id}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info">
                                                                    <h5 class="modal-title text-center" id="cancelLabel">Detail Pet Adoption</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                        {{-- <span aria-hidden="true">&times;</span> --}}
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body text-left">
                                                                    <div class="table table-responsive">
                                                                        <table class="table">
                                                                            <tr>
                                                                                <td class="w-50"><h2>Status</h2></td>
                                                                                <td><h2>:</h2></td>
                                                                                <td>
                                                                                    @if ($value->status == 'Rejected' || $value->status == 'Canceled' )
                                                                                        <h3 class="p-3 field_table_td bg-danger text-light">
                                                                                    @endif
                                                                                    @if ($value->status == 'Accepted')
                                                                                        <h3 class="p-3 field_table_td bg-success text-light">
                                                                                    @endif
                                                                                    @if ($value->status == 'Waiting for Adopt')
                                                                                        <h3 class="p-3 field_table_td bg-warning text-dark">
                                                                                    @endif
                                                                                        {{$value->status}}
                                                                                    </h3>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                @if ($value->status == 'Accepted' || $value->status == 'Rejected')
                                                                                    <td><h4>Message's From Pet Owner</h4></td>
                                                                                @endif
                                                                                @if ($value->status == 'Canceled')
                                                                                    <td><h4>Message's From Calon Adopter</h4></td>
                                                                                @endif
                                                                                    <td><h4>:</h4></td>
                                                                                    <td>
                                                                                        <h4>
                                                                                            {{$value->reason}}
                                                                                        </h4>
                                                                                    </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>

                                                                    <div class="divider mb-3"></div>
                                                                    {{-- untuk data pet owner nya --}}
                                                                    {{-- @foreach ($pet as $pets) --}}
                                                                    @foreach ($user as $users)
                                                                        @if ($users->id == $value->user_id)
                                                                            <div class="col_judul">
                                                                                Pet Owner
                                                                            </div>
                                                                            <div class="table-responsive table_detail">
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                ID
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $adopters->user_id }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td class="detail_column">
                                                                                                Name
                                                                                            </td>
                                                                                            <td class="detail_column_2">:</td>
                                                                                            <td>
                                                                                                {{ $users->name }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Phone Number
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->phone_number }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td>
                                                                                                Email
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->email }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Kode POS
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->kode_pos }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        {{-- <tr>
                                                                                            <td>Address</td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->address }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3">
                                                                                                <div class="form-group d-none" id="latitudeArea">
                                                                                                    <label>Latitude</label>
                                                                                                    <input type="number" name="latitude" id="latitude1" readonly class="form-control" value="{{$users->latitude}}">
                                                                                                </div>

                                                                                                <div class="form-group d-none">
                                                                                                    <label>Longitude</label>
                                                                                                    <input type="number" name="longitude" id="longitude1" readonly class="form-control" value="{{$users->longitude}}">
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div id="googleMap1" class="col-lg-12 wadah_peta"></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            {{-- code java script untuk pet owner --}}
                                                                            <script type="text/javascript">

                                                                                var marker1;
                                                                                // //posisi awal marker
                                                                                var long1 = document.getElementById('longitude1').value;
                                                                                var lat1 = document.getElementById('latitude1').value;
                                                                                // var latLng = new google.maps.LatLng(lat,long);

                                                                                function markerAwal1(){
                                                                                    var map1 = new google.maps.Map(document.getElementById('googleMap1'), {
                                                                                        center:new google.maps.LatLng(lat1,long1), // jakarta
                                                                                        zoom: 10,
                                                                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                                    });

                                                                                    marker1 = new google.maps.Marker({
                                                                                        position : new google.maps.LatLng(lat1,long1),
                                                                                        map : map1,
                                                                                        animation: google.maps.Animation.BOUNCE
                                                                                    });

                                                                                    map1.addListener("center_changed", () => {
                                                                                        // 30 seconds after the center of the map has changed, pan back to the
                                                                                        // marker.
                                                                                        window.setTimeout(() => {
                                                                                        map1.panTo(marker1.getPosition());
                                                                                        }, 30000); //ms
                                                                                    });

                                                                                    marker1.addListener("click", () => {
                                                                                        map1.setZoom(17);
                                                                                        map1.setCenter(marker1.getPosition());
                                                                                    });
                                                                                }

                                                                                // // event window di-load
                                                                                google.maps.event.addDomListener(window, 'load', markerAwal1);
                                                                            </script>
                                                                        @endif
                                                                    @endforeach
                                                                    {{-- @endforeach --}}


                                                                    {{-- untuk data adopter nya --}}
                                                                    @foreach ($user as $users)
                                                                        @if ($users->id == $value->user_id_adopter)
                                                                            <div class="col_judul">
                                                                                @if ($value->status == 'Accepted')
                                                                                    Pet Adopter
                                                                                @else
                                                                                    Calon Adopter
                                                                                @endif
                                                                            </div>
                                                                            <div class="table-responsive table_detail">
                                                                                <table class="table">
                                                                                    <tbody>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                ID
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $adopters->user_id_adopter }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td class="detail_column">
                                                                                                Name
                                                                                            </td>
                                                                                            <td class="detail_column_2">:</td>
                                                                                            <td>
                                                                                                {{ $users->name }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Phone Number
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->phone_number }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        <tr>
                                                                                            <td>
                                                                                                Email
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->email }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        {{-- <tr>
                                                                                            <td>
                                                                                                Kode POS
                                                                                            </td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $adopters->kode_pos }}
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                        {{-- <tr>
                                                                                            <td>Address</td>
                                                                                            <td>:</td>
                                                                                            <td>
                                                                                                {{ $users->address }}
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan="3">
                                                                                                <div class="form-group d-none" id="latitudeArea">
                                                                                                    <label>Latitude</label>
                                                                                                    <input type="number" name="latitude" id="latitude2" readonly class="form-control" value="{{$users->latitude}}">
                                                                                                </div>

                                                                                                <div class="form-group d-none">
                                                                                                    <label>Longitude</label>
                                                                                                    <input type="number" name="longitude" id="longitude2" readonly class="form-control" value="{{$users->longitude}}">
                                                                                                </div>

                                                                                                <div class="row">
                                                                                                    <div id="googleMap2" class="col-lg-12 wadah_peta"></div>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr> --}}
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>

                                                                            {{-- code java script untuk pet adopter --}}
                                                                            <script type="text/javascript">

                                                                                var marker2;
                                                                                // //posisi awal marker
                                                                                var long2 = document.getElementById('longitude2').value;
                                                                                var lat2 = document.getElementById('latitude2').value;
                                                                                // var latLng = new google.maps.LatLng(lat,long);

                                                                                function markerAwal2(){
                                                                                    var map2 = new google.maps.Map(document.getElementById('googleMap2'), {
                                                                                        center:new google.maps.LatLng(lat2,long2), // jakarta
                                                                                        zoom: 10,
                                                                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                                    });

                                                                                    marker2 = new google.maps.Marker({
                                                                                        position : new google.maps.LatLng(lat2,long2),
                                                                                        map : map2,
                                                                                        animation: google.maps.Animation.BOUNCE
                                                                                    });

                                                                                    map2.addListener("center_changed", () => {
                                                                                        // 30 seconds after the center of the map has changed, pan back to the
                                                                                        // marker.
                                                                                        window.setTimeout(() => {
                                                                                        map2.panTo(marker2.getPosition());
                                                                                        }, 30000); //ms
                                                                                    });

                                                                                    marker2.addListener("click", () => {
                                                                                        map2.setZoom(17);
                                                                                        map2.setCenter(marker2.getPosition());
                                                                                    });
                                                                                }

                                                                                // // event window di-load
                                                                                google.maps.event.addDomListener(window, 'load', markerAwal2);
                                                                            </script>
                                                                        @endif
                                                                    @endforeach

                                                                    {{-- untuk data detail pet nya --}}
                                                                    {{-- @foreach ($pet as $pets) --}}
                                                                    <div class="col_judul">
                                                                        Detail Pet
                                                                    </div>
                                                                    <div class="table-responsive table_detail">
                                                                        <table class="table">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td colspan="3" class="field_table">
                                                                                        {{ $value->pet_name }}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td colspan="3" class="field_table">
                                                                                        <img src="{{ asset('gambar/pet/' . $value->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
                                                                                    </td>
                                                                                </tr>
                                                                                {{-- <tr>
                                                                                    <td>ID</td>
                                                                                    <td>:</td>
                                                                                    <td>{{ $adopters->pet_id }}</td>
                                                                                </tr> --}}
                                                                                <tr>
                                                                                    <td class="detail_column_pet">
                                                                                        Species
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($species as $speciess)
                                                                                        @if ($value->species_id == $speciess->species_id)
                                                                                            <td>
                                                                                                {{ $speciess->species_name }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Breed
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($breed as $breeds)
                                                                                        @if ($value->breed_id == $breeds->breed_id)
                                                                                            <td>
                                                                                                {{ $breeds->breed_category }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Sex
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($sex as $sexs)
                                                                                        @if ($value->sex_id == $sexs->sex_id)
                                                                                            <td>
                                                                                                {{ $sexs->sex_name }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Age
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($age as $ages)
                                                                                        @if ($value->age_id == $ages->age_id)
                                                                                            <td>
                                                                                                {{ $ages->age_category }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Source
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($source as $sources)
                                                                                        @if ($value->source_id == $sources->source_id)
                                                                                            <td>
                                                                                                {{ $sources->source_name }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Vaccine
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($vaccine as $vaccines)
                                                                                        @if ($value->vaccine_id == $vaccines->vaccine_id)
                                                                                            <td>
                                                                                                {{ $vaccines->vaccine_status }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Sterilization
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    @foreach ($sterilization as $sterilizations)
                                                                                        @if ($value->sterilization_id == $sterilizations->sterilization_id)
                                                                                            <td>
                                                                                                {{ $sterilizations->sterilization_status }}
                                                                                            </td>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        Description
                                                                                    </td>
                                                                                    <td>:</td>
                                                                                    <td>
                                                                                        {{ $value->pet_description }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <div class="container">
                                                                        <div class="text-center p-2">
                                                                            <h3>Answer from the Questions</h3>
                                                                        </div>
                                                                        <div class="table-responsive mt-4">

                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Apakah Anda memiliki hewan peliharaan? Jika iya, mohon sebutkan jumlah & jenis hewan yang Anda miliki. *') }}</label>
                                                                                        <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$value->question_1}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Apa saja hal yang Anda ketahui tentang jenis hewan yang akan diadopsi? *') }}</label>
                                                                                        <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$value->question_2}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Apakah Anda sanggup mendukung kebutuhan hewan seperti vaksin, biaya pengobatan, steril, dll? *') }}</label>
                                                                                        <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$value->question_3}}">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="form-group">
                                                                                        <label for="question2">{{ __('Jelaskan alasan Anda tertarik pada hewan yang dipilih! *') }}</label>
                                                                                        <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $value->question_4 }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="wadah_button_detail">
                                                                        {{-- <button type="submit" id="" class="button3_detail" disabled>
                                                                            @if ($adopters->status == "Accepted")
                                                                                {{__('Mark as Adopted')}}
                                                                            @else
                                                                                {{$adopters->status}}
                                                                            @endif
                                                                        </button> --}}
                                                                        @if ($value->status == 'Waiting for Adopt')
                                                                            <div class="cancelButton_detail">
                                                                                <button type="submit" id="" class="button4_detail" data-bs-toggle="modal" data-bs-target="#cancel1{{ $value->pet_id }}{{ $value->user_id_adopter }}">
                                                                                    {{__('Cancel')}}
                                                                                </button>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                                        {{'No'}}
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">
                                                                        {{'Yes'}}
                                                                    </button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <div class="wadah_waitingMark">
                                    <label>
                                        <br>
                                        <h2 class="text-danger">Data tidak ada</h2>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button btn btn-outline-success collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Accepted
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if (!Auth::guest())
                                <div class="wadah_waitingMark">
                                    @foreach ($countStatus2 as $countStatuss2)
                                        @if ($countStatuss2->id == 0)
                                            <label>
                                                <br>
                                                <h2 class="text-danger">Data tidak ada</h2>
                                            </label>
                                        @else
                                            @foreach ($pet1 as $pets1)
                                                @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                    <form action="/adoption/detail/submissions/{{ $pets1->adopt_submission_id }}" method="get" enctype="multipart/form-data">
                                                        {{-- <a href="/adoption/detail/{{ $pets1->pet_id }}"> --}}
                                                @else
                                                    @if (!Auth::guest() && $pets1->user_id == $userID || $pets1->user_id_adopter == $userID)
                                                        <form action="/adoption/detail/submissions/{{ $pets1->adopt_submission_id }}" method="get" enctype="multipart/form-data">
                                                            {{-- <a href="/adoption/detail/{{ $pets1->pet_id }}"> --}}
                                                    @else
                                                        <form action="" enctype="multipart/form-data" class="MarkAsAdopted_not">
                                                    @endif
                                                @endif
                                                        <table class="isi_tbl tbl_active_markAsAdopted text-left">
                                                            <tr>
                                                                <td colspan="3">
                                                                    <center>
                                                                        <img src="{{asset('gambar/pet/' . $pets1->pet_image)}}" alt="gambar_pet" class="rounded-circle" width="100px" height="100px">
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Name
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $pets1->pet_name }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Breed
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    @foreach ($breed as $breeds)
                                                                        @if ($breeds->breed_id == $pets1->breed_id)
                                                                            {{ $breeds->breed_category }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Age
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    @foreach ($age as $ages)
                                                                        @if ($ages->age_id == $pets1->age_id)
                                                                            {{ $ages->age_category }}
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Status
                                                                </td>
                                                                <td>:</td>
                                                                <td class="text-light bg-success">
                                                                    {{$pets1->status}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="detail_more text-center">
                                                                    @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                                        <a href="/adoption/detail/submissions/{{ $pets1->adopt_submission_id }}" data-bs-toggle="modal" data-bs-target="#detailAdoptAccepted{{ $pets1->adopt_submission_id }}">
                                                                        {{-- <a href="/adoption/detail/submissions/{{ $pets1->adopt_submission_id }}"> --}}
                                                                    @else
                                                                        @if (!Auth::guest() && $pets1->user_id == $userID || $pets1->user_id_adopter == $userID)
                                                                            <a href="/adoption/detail/submissions/{{ $pets1->adopt_submission_id }}" data-bs-toggle="modal" data-bs-target="#detailAdoptAccepted{{ $pets1->adopt_submission_id }}">
                                                                            {{-- <a href="/adoption/detail/submissions/{{ $pets1->adopt_submission_id }}"> --}}
                                                                        @else
                                                                            <a>
                                                                        @endif
                                                                    @endif
                                                                        Detail more...
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    {{-- </a> --}}
                                                </form>

                                                {{-- <div class="modal fade" id="detailAdoptAccepted" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                                                <div class="modal fade" id="detailAdoptAccepted{{ $pets1->adopt_submission_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info">
                                                                <h5 class="modal-title text-center" id="cancelLabel">Detail Pet Adoption</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                                    {{-- <span aria-hidden="true">&times;</span> --}}
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-left">
                                                                <div class="table table-responsive">
                                                                    <table class="table">
                                                                        <tr>
                                                                            <td class="w-50"><h2>Status</h2></td>
                                                                            <td><h2>:</h2></td>
                                                                            <td>
                                                                                @if ($pets1->status == 'Rejected' || $pets1->status == 'Canceled' )
                                                                                    <h3 class="p-3 field_table_td bg-danger text-light">
                                                                                @endif
                                                                                @if ($pets1->status == 'Accepted')
                                                                                    <h3 class="p-3 field_table_td bg-success text-light">
                                                                                @endif
                                                                                @if ($pets1->status == 'Waiting for Adopt')
                                                                                    <h3 class="p-3 field_table_td bg-warning text-dark">
                                                                                @endif
                                                                                    {{$pets1->status}}
                                                                                </h3>
                                                                            </td>
                                                                        </tr>
                                                                        @if ($pets1->status == 'Accepted' || $pets1->status == 'Rejected')
                                                                            <tr>
                                                                                <td><h4>Message's From Pet Owner</h4></td>
                                                                                <td><h4>:</h4></td>
                                                                                <td>
                                                                                    <h4>
                                                                                        {{$pets1->reason}}
                                                                                    </h4>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    </table>
                                                                </div>

                                                                <div class="divider mb-3"></div>
                                                                {{-- untuk data pet owner nya --}}
                                                                {{-- @foreach ($pet as $pets) --}}
                                                                @foreach ($user as $users)
                                                                    @if ($users->id == $pets1->user_id)
                                                                        <div class="col_judul">
                                                                            Pet Owner
                                                                        </div>
                                                                        <div class="table-responsive table_detail">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    {{-- <tr>
                                                                                        <td>
                                                                                            ID
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $adopters->user_id }}
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                    <tr>
                                                                                        <td class="detail_column">
                                                                                            Name
                                                                                        </td>
                                                                                        <td class="detail_column_2">:</td>
                                                                                        <td>
                                                                                            {{ $users->name }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    {{-- <tr>
                                                                                        <td>
                                                                                            Phone Number
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->phone_number }}
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                    <tr>
                                                                                        <td>
                                                                                            Email
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->email }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    {{-- <tr>
                                                                                        <td>
                                                                                            Kode POS
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->kode_pos }}
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                    {{-- <tr>
                                                                                        <td>Address</td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->address }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="3">
                                                                                            <div class="form-group d-none" id="latitudeArea">
                                                                                                <label>Latitude</label>
                                                                                                <input type="number" name="latitude" id="latitude3" readonly class="form-control" value="{{$users->latitude}}">
                                                                                            </div>

                                                                                            <div class="form-group d-none">
                                                                                                <label>Longitude</label>
                                                                                                <input type="number" name="longitude" id="longitude3" readonly class="form-control" value="{{$users->longitude}}">
                                                                                            </div>

                                                                                            <div class="row">
                                                                                                <div id="googleMap3" class="col-lg-12 wadah_peta"></div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        {{-- code java script untuk pet owner --}}
                                                                        <script type="text/javascript">

                                                                            var marker3;
                                                                            // //posisi awal marker
                                                                            var long3 = document.getElementById('longitude3').value;
                                                                            var lat3 = document.getElementById('latitude3').value;
                                                                            // var latLng = new google.maps.LatLng(lat,long);

                                                                            function markerAwal3(){
                                                                                var map3 = new google.maps.Map(document.getElementById('googleMap3'), {
                                                                                    center:new google.maps.LatLng(lat3,long3), // jakarta
                                                                                    zoom: 10,
                                                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                                });

                                                                                marker3 = new google.maps.Marker({
                                                                                    position : new google.maps.LatLng(lat3,long3),
                                                                                    map : map3,
                                                                                    animation: google.maps.Animation.BOUNCE
                                                                                });

                                                                                map3.addListener("center_changed", () => {
                                                                                    // 30 seconds after the center of the map has changed, pan back to the
                                                                                    // marker.
                                                                                    window.setTimeout(() => {
                                                                                    map3.panTo(marker3.getPosition());
                                                                                    }, 30000); //ms
                                                                                });

                                                                                marker3.addListener("click", () => {
                                                                                    map3.setZoom(17);
                                                                                    map3.setCenter(marker3.getPosition());
                                                                                });
                                                                            }

                                                                            // // event window di-load
                                                                            google.maps.event.addDomListener(window, 'load', markerAwal3);
                                                                        </script>
                                                                    @endif
                                                                @endforeach
                                                                {{-- @endforeach --}}

                                                                {{-- untuk data adopter nya --}}
                                                                @foreach ($user as $users)
                                                                    @if ($users->id == $pets1->user_id_adopter)
                                                                        <div class="col_judul">
                                                                            @if ($pets1->status == 'Accepted')
                                                                                Pet Adopter
                                                                            @else
                                                                                Calon Adopter
                                                                            @endif
                                                                        </div>
                                                                        <div class="table-responsive table_detail">
                                                                            <table class="table">
                                                                                <tbody>
                                                                                    {{-- <tr>
                                                                                        <td>
                                                                                            ID
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $adopters->user_id_adopter }}
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                    <tr>
                                                                                        <td class="detail_column">
                                                                                            Name
                                                                                        </td>
                                                                                        <td class="detail_column_2">:</td>
                                                                                        <td>
                                                                                            {{ $users->name }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    {{-- <tr>
                                                                                        <td>
                                                                                            Phone Number
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->phone_number }}
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                    <tr>
                                                                                        <td>
                                                                                            Email
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->email }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    {{-- <tr>
                                                                                        <td>
                                                                                            Kode POS
                                                                                        </td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $adopters->kode_pos }}
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                    {{-- <tr>
                                                                                        <td>Address</td>
                                                                                        <td>:</td>
                                                                                        <td>
                                                                                            {{ $users->address }}
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="3">
                                                                                            <div class="form-group d-none" id="latitudeArea">
                                                                                                <label>Latitude</label>
                                                                                                <input type="number" name="latitude" id="latitude4" readonly class="form-control" value="{{$users->latitude}}">
                                                                                            </div>

                                                                                            <div class="form-group d-none">
                                                                                                <label>Longitude</label>
                                                                                                <input type="number" name="longitude" id="longitude4" readonly class="form-control" value="{{$users->longitude}}">
                                                                                            </div>

                                                                                            <div class="row">
                                                                                                <div id="googleMap4" class="col-lg-12 wadah_peta"></div>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr> --}}
                                                                                </tbody>
                                                                            </table>
                                                                        </div>

                                                                        {{-- code java script untuk pet adopter--}}
                                                                        <script type="text/javascript">

                                                                            var marker4;
                                                                            // //posisi awal marker
                                                                            var long4 = document.getElementById('longitude4').value;
                                                                            var lat4 = document.getElementById('latitude4').value;
                                                                            // var latLng = new google.maps.LatLng(lat,long);

                                                                            function markerAwal4(){
                                                                                var map4 = new google.maps.Map(document.getElementById('googleMap4'), {
                                                                                    center:new google.maps.LatLng(lat4,long4), // jakarta
                                                                                    zoom: 10,
                                                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                                                });

                                                                                marker4 = new google.maps.Marker({
                                                                                    position : new google.maps.LatLng(lat4,long4),
                                                                                    map : map4,
                                                                                    animation: google.maps.Animation.BOUNCE
                                                                                });

                                                                                map4.addListener("center_changed", () => {
                                                                                    // 30 seconds after the center of the map has changed, pan back to the
                                                                                    // marker.
                                                                                    window.setTimeout(() => {
                                                                                    map4.panTo(marker4.getPosition());
                                                                                    }, 30000); //ms
                                                                                });

                                                                                marker4.addListener("click", () => {
                                                                                    map4.setZoom(17);
                                                                                    map4.setCenter(marker4.getPosition());
                                                                                });
                                                                            }

                                                                            // // event window di-load
                                                                            google.maps.event.addDomListener(window, 'load', markerAwal4);
                                                                        </script>
                                                                    @endif
                                                                @endforeach

                                                                {{-- untuk data detail pet nya --}}
                                                                {{-- @foreach ($pet as $pets) --}}
                                                                <div class="col_judul">
                                                                    Detail Pet
                                                                </div>
                                                                <div class="table-responsive table_detail">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td colspan="3" class="field_table">
                                                                                    {{ $pets1->pet_name }}
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="3" class="field_table">
                                                                                    <img src="{{ asset('gambar/pet/' . $pets1->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
                                                                                </td>
                                                                            </tr>
                                                                            {{-- <tr>
                                                                                <td>ID</td>
                                                                                <td>:</td>
                                                                                <td>{{ $adopters->pet_id }}</td>
                                                                            </tr> --}}
                                                                            <tr>
                                                                                <td class="detail_column_pet">
                                                                                    Species
                                                                                </td>
                                                                                <td>:</td>
                                                                                @foreach ($species as $speciess)
                                                                                    @if ($pets1->species_id == $speciess->species_id)
                                                                                        <td>
                                                                                            {{ $speciess->species_name }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Breed
                                                                                </td>
                                                                                <td>:</td>
                                                                                @foreach ($breed as $breeds)
                                                                                    @if ($pets1->breed_id == $breeds->breed_id)
                                                                                        <td>
                                                                                            {{ $breeds->breed_category }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Sex
                                                                                </td>
                                                                                <td>:</td>
                                                                                @foreach ($sex as $sexs)
                                                                                    @if ($pets1->sex_id == $sexs->sex_id)
                                                                                        <td>
                                                                                            {{ $sexs->sex_name }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Age
                                                                                </td>

                                                                                <td>:</td>
                                                                                @foreach ($age as $ages)
                                                                                    @if ($pets1->age_id == $ages->age_id)
                                                                                        <td>
                                                                                            {{ $ages->age_category }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Source
                                                                                </td>
                                                                                <td>:</td>
                                                                                @foreach ($source as $sources)
                                                                                    @if ($pets1->source_id == $sources->source_id)
                                                                                        <td>
                                                                                            {{ $sources->source_name }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Vaccine
                                                                                </td>
                                                                                <td>:</td>
                                                                                @foreach ($vaccine as $vaccines)
                                                                                    @if ($pets1->vaccine_id == $vaccines->vaccine_id)
                                                                                        <td>
                                                                                            {{ $vaccines->vaccine_status }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Sterilization
                                                                                </td>
                                                                                <td>:</td>
                                                                                @foreach ($sterilization as $sterilizations)
                                                                                    @if ($pets1->sterilization_id == $sterilizations->sterilization_id)
                                                                                        <td>
                                                                                            {{ $sterilizations->sterilization_status }}
                                                                                        </td>
                                                                                    @endif
                                                                                @endforeach
                                                                            </tr>
                                                                            <tr>
                                                                                <td>
                                                                                    Description
                                                                                </td>
                                                                                <td>:</td>
                                                                                <td>
                                                                                    {{ $pets1->pet_description }}
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                                <div class="container">
                                                                    <div class="text-center p-2">
                                                                        <h3>Answer from the Questions</h3>
                                                                    </div>
                                                                    <div class="table-responsive mt-4">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="question2">{{ __('Apakah Anda memiliki hewan peliharaan? Jika iya, mohon sebutkan jumlah & jenis hewan yang Anda miliki. *') }}</label>
                                                                                    <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$pets1->question_1}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="question2">{{ __('Apa yang anda ketahui tentang kucing atau anjing? *') }}</label>
                                                                                    <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$pets1->question_2}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="question2">{{ __('Apakah Anda sanggup mendukung kebutuhan hewan seperti vaksin, biaya pengobatan, steril, dll? *') }}</label>
                                                                                    <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$pets1->question_3}}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <label for="question2">{{ __('Jelaskan alasan Anda tertarik pada hewan yang dipilih! *') }}</label>
                                                                                    <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $pets1->question_4 }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                                    {{'No'}}
                                                                </button>
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{'Yes'}}
                                                                </button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="wadah_waitingMark">
                                    <label>
                                        <br>
                                        <h2 class="text-danger">Data tidak ada</h2>
                                    </label>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="end">
        </div>
    </div>

@endsection
