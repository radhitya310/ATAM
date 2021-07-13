@extends('layouts.app')

@section('title')
    Status Pet Adoption - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="title_body">
            <h1>
                My Pet Status
            </h1>
            <br>
        </div>

        @php
            $inc = 1;
        @endphp

        <div class="d-grid text-center">
            <a class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="collapse" href="#collapse1" role="button" aria-expanded="false" aria-controls="collapseExample">
                History Adopt Submissions
            </a>
        </div>
        <br>

        <div class="collapse myPetStatusAdoptSubmissions mb-4" id="collapse1">
            <center>
                <div class="table table-responsive">
                    <table class="table table-hover table-borderless">
                        <thead class="table-dark">
                            <th>No.</th>
                            <th>Adopter Name</th>
                            <th>Adopter Email</th>
                            <th>Pet Name</th>
                            <th>Foto</th>
                            <th>Message</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            @if (!Auth::guest())
                                @foreach ($countPet as $countPets)
                                    @if ($countPets->id == 0)
                                        <tr>
                                            <td colspan="7">
                                                <div class="text-center">
                                                    <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                                </div>
                                                {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($dataPetOwner as $item => $value)
                                            @if ($value->status == 'Accepted')
                                                <tr class="bg-success">
                                            @else
                                                <tr class="bg-danger">
                                            @endif
                                                    <td>{{$inc++}}</td>
                                                    @foreach ($user as $users)
                                                        @if ($users->id == $value->user_id_adopter)
                                                            <td>{{$users->name}}</td>
                                                            <td>{{$users->email}}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>{{$value->pet_name}}</td>
                                                    <td>
                                                        <img src="{{ url('/gambar/pet/'. $value->pet_image) }}" width="150px" height="150px" alt="gambar">
                                                    </td>
                                                    <td>{{$value->reason}}</td>
                                                    <td>{{$value->status}}</td>
                                                </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                        <div class="text-center">
                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </center>
        </div>
        <div class="collapse divider" id="collapse1"></div>

        @if (session('message'))
            <div class="alert alert-success text-center">
                {{session('message')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                    {{-- &times; --}}
                </button>
            </div>
        @endif

        <div class="wadah_button_search_style">
            <br>
            <form action="/status/pet-adoption/search" method="get">
                <center>
                    <div class="row form-row">
                        <div class="col-sm-5 pb-2">
                            <div class="row">
                                <div class="col-2">
                                    <button class="btn btn-outline-success" type="submit">
                                        <i class="fas fa-search"></i>
                                        {{-- Search --}}
                                    </button>
                                </div>
                                <div class="col-10">
                                    <input name="search" id="search" class="form-control @error('search') is-invalid @enderror" type="text" placeholder="Type to Search" aria-label="Search" value="{{$data}}">
                                    @error('search')
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($data != null)
                            <div class="col-sm-1">
                                <a href="/status/pet-adoption">
                                    <button type="button" class="btn btn-danger ms-2" aria-hidden="true">
                                        &times;
                                    </button>
                                </a>
                            </div>
                        @endif

                        <input type="text" name="type" hidden value="myPetStatus">
                    </div>
                </center>
            </form>
        </div>

        @php
            $inc = 1;
        @endphp

        <div class="button_add">
            <button type="button" title="Add" class="btn btn-primary">
                <a href="/status/pet-adoption/add">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                    </svg> --}}
                    <i class="far fa-plus-square"></i>
                </a>
            </button>
        </div>

        <div class="button_track_records ms-3">
            <a data-bs-toggle="offcanvas" href="#offcanvasExampleRecords" aria-controls="offcanvasExampleRecords" class="">
                Track Records Pet&raquo;
            </a>
        </div>

        {{-- menggunakan offcanvas --}}
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExampleRecords" aria-labelledby="offcanvasExampleRecordsLabel">
            <div class="offcanvas-header bg-info">
                <h5 class="offcanvas-title" id="offcanvasExampleRecordsLabel">{{__('Track Records')}}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                @foreach ($trackRecord as $trackRecords)
                    @foreach ($collection as $item)

                    @endforeach
                    <div class="table table-responsive table-borderless wadah_table_record">
                        <table class="tbl_record">
                            <tr>
                                <td colspan="3">
                                    <center>
                                        <img src="{{asset('gambar/track_records_pet/' . $trackRecords->foto)}}" alt="gambar_pet" class="rounded-circle" width="200px" height="200px">
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Waktu Post
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $trackRecords->waktu_post }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Keterangan
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $trackRecords->keterangan }}
                                </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>

        @if (!Auth::guest())
            @if ($countUserID == 0)
                <div class="table table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="table-dark">
                            <th>No.</th>
                            <th>Adopter Name</th>
                            <th>Pet Name</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7">
                                    <div class="text-center">
                                        <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                    </div>
                                    {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="table-responsive table_my_pet_status manageSearch">
                    <table class="table table-hover table-borderless">
                        <thead class="table-dark">
                            <th>No.</th>
                            {{-- <th>ID Adopter</th> --}}
                            <th>Adopter Name</th>
                            {{-- <th>Pet ID</th> --}}
                            <th>Pet Name</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th></th>
                        </thead>

                        @if ($pet->count() == 0 && $adopter->count() == 0 && $dataAccepted->count() == 0)
                            <tbody>
                                <tr>
                                    <td colspan="6">
                                        <div class="text-center">
                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endif

                        {{-- untuk ambil data waiting di adopt submissions --}}
                        @foreach ($adopter as $adopters)
                            <tbody class="bg-warning">
                                <tr>
                                    {{-- versi CodeIgniter --}}
                                    {{-- <td><?=$inc++?></td> --}}
                                    <td>{{$inc++}}</td>
                                    {{-- <td>{{$adopters->user_id_adopter}}</td> --}}
                                    <td>{{$adopters->name}}</td>
                                    {{-- <td>{{$adopters->pet_id}}</td> --}}
                                    <td>{{$adopters->pet_name}}</td>
                                    <td>
                                        <img src="{{ url('/gambar/pet/'. $adopters->pet_image) }}" width="150px" height="150px" alt="gambar">
                                    </td>
                                    <td>{{$adopters->status}}</td>
                                    <td>
                                        {{-- <form method="get" action="/status/pet-adoption/detail/submissions/{{$adopters->adopt_submission_id}}">
                                            <button type="submit" id="" class="btn btn-info">Detail</button>
                                        </form> --}}
                                        <button type="submit" title="Detail" id="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailPetWaiting{{$adopters->adopt_submission_id}}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        {{-- <button type="submit" id="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#accepted{{$adopters->pet_id}}{{ $adopters->user_id_adopter }}">Accept</button>
                                        <br>
                                        <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejected{{$adopters->pet_id}}{{ $adopters->user_id_adopter }}">Reject</button> --}}
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach

                        {{-- untuk ambil data accepted nya --}}
                        @foreach ($dataAccepted as $dataAccepteds)
                            <tbody class="bg-success">
                                <tr>
                                    {{-- versi CodeIgniter --}}
                                    {{-- <td><?=$inc++?></td> --}}
                                    <td>{{$inc++}}</td>
                                    {{-- @foreach ($idAdopter as $idAdopters)
                                        @foreach ($user as $users)
                                            @if ($dataAccepteds->pet_id == $idAdopters->pet_id && $idAdopters->user_id_adopter == $users->id)
                                                <td>{{$users->name}}</td>
                                            @endif
                                        @endforeach
                                    @endforeach --}}
                                    @foreach ($user as $users)
                                        @if ($users->id == $dataAccepteds->user_id_adopter)
                                            <td>{{$users->name}}</td>
                                        @endif
                                    @endforeach
                                    <td>{{$dataAccepteds->pet_name}}</td>
                                    <td>
                                        <img src="{{ url('/gambar/pet/'. $dataAccepteds->pet_image) }}" width="150px" height="150px" alt="gambar">
                                    </td>
                                    <td>{{__('Mark as Adopted')}}</td>
                                    <td>
                                        {{-- <form method="get" action="/status/pet-adoption/detail/submissions/{{$dataAccepteds->adopt_submission_id}}">
                                            <button type="submit" id="" class="btn btn-info">Detail</button>
                                        </form> --}}
                                        <button type="submit" title="Detail" id="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailPetMarkasAdopted{{$dataAccepteds->adopt_submission_id}}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        {{-- @if ($dataAccepteds->status == 'Request for Adopt')
                                            <form method="put" action="/status/pet-adoption/edit/{{$dataAccepteds->pet_id}}">
                                                <button type="submit" id="" class="btn btn-warning">Edit</button>
                                            </form>
                                            <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$dataAccepteds->pet_id}}">Delete</button>
                                        @endif --}}
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach

                        {{-- untuk ambil data dari table pets  --}}
                        @foreach ($pet as $pets)
                            <tbody class="bg-light">
                                <tr>
                                    {{-- versi CodeIgniter --}}
                                    {{-- <td><?=$inc++?></td> --}}
                                    <td>{{$inc++}}</td>
                                    {{-- @if ($pets->status == 'Request for Adopt') --}}
                                        <td></td>
                                    {{-- @else
                                        @foreach ($idAdopter as $idAdopters)
                                            @foreach ($user as $users)
                                                @if ($pets->pet_id == $idAdopters->pet_id && $idAdopters->user_id_adopter == $users->id)
                                                    <td>{{$users->name}}</td>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @endif --}}
                                    <td>{{$pets->pet_name}}</td>
                                    <td>
                                        <img src="{{ url('/gambar/pet/'. $pets->pet_image) }}" width="150px" height="150px" alt="gambar">
                                    </td>
                                    <td>{{$pets->status}}</td>
                                    <td>
                                        {{-- <form method="get" action="/status/pet-adoption/detail/{{$pets->pet_id}}">
                                            <button type="submit" id="" class="btn btn-info">
                                                Detail
                                            </button>
                                        </form> --}}
                                        <button type="submit" title="Detail"  id="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detailPetRequest{{$pets->pet_id}}">
                                            <i class="fas fa-info-circle"></i>
                                        </button>
                                        @if ($pets->status == 'Request for Adopt')
                                            <form method="put" action="/status/pet-adoption/edit/{{$pets->pet_id}}">
                                                <button type="submit" title="Edit" id="" class="btn btn-warning">
                                                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                    </svg> --}}
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <button type="submit" title="Delete" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$pets->pet_id}}">
                                                {{-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg> --}}
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>

                            <!-- menggunakan Modal untuk button delete -->
                            {{-- @foreach ($pet as $pets)
                            @endforeach --}}
                            <div class="modal fade" id="delete{{ $pets->pet_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                            {{-- <div class="modal fade" id="delete{{ $pets->pet_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true"> --}}
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="deleteLabel">Delete Pet Adoption</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            {{-- <span aria-hidden="true">&times;</span> --}}
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            {{__('Apa Kamu Yakin Ingin Melakukan Delete Pet (Pet Name = '.$pets->pet_name.')?')}}
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                            {{'No'}}
                                        </button>
                                        <form method="delete" action="/status/pet-adoption/delete/{{$pets->pet_id}}">
                                            <button type="submit" class="btn btn-primary">
                                                {{'Yes'}}
                                            </button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </table>

                    {{-- modal untuk detail waiting adopt --}}
                    @foreach ($adopter as $adopters)
                        {{-- <div class="modal fade" id="detailWaiting" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                        <div class="modal fade" id="detailPetWaiting{{$adopters->adopt_submission_id}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
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
                                                    <td><h2>Status</h2></td>
                                                    <td><h2>:</h2></td>
                                                    <td>
                                                        @if ($adopters->status == 'Waiting for Adopt')
                                                            <h3 class="p-3 field_table_td bg-warning text-dark">
                                                        @endif
                                                            {{$adopters->status}}
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
                                        {{-- untuk data pet owner nya --}}
                                        {{-- @foreach ($pet as $pets) --}}
                                        @foreach ($user as $users)
                                            @if ($users->id == $adopters->user_id)
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
                                                            <tr>
                                                                <td>
                                                                    Phone Number
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $users->phone_number }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Email
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <a href="mailto:{{$users->email}}" target="_blank">
                                                                        {{ $users->email }}
                                                                    </a>
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
                                            @if ($users->id == $adopters->user_id_adopter)
                                                <div class="col_judul">
                                                    @if ($adopters->status == 'Accepted')
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
                                                            <tr>
                                                                <td>
                                                                    Phone Number
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $users->phone_number }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Email
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <a href="mailto:{{$users->email}}" target="_blank">
                                                                        {{ $users->email }}
                                                                    </a>
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
                                                            {{ $adopters->pet_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="field_table">
                                                            <img src="{{ asset('gambar/pet/' . $adopters->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
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
                                                            @if ($adopters->species_id == $speciess->species_id)
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
                                                            @if ($adopters->breed_id == $breeds->breed_id)
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
                                                            @if ($adopters->sex_id == $sexs->sex_id)
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
                                                            @if ($adopters->age_id == $ages->age_id)
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
                                                            @if ($adopters->source_id == $sources->source_id)
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
                                                            @if ($adopters->vaccine_id == $vaccines->vaccine_id)
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
                                                            @if ($adopters->sterilization_id == $sterilizations->sterilization_id)
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
                                                            {{ $adopters->pet_description }}
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
                                                            <label for="question2">{{ __('Apakah anda memiliki hewan pemeliharan? *') }}</label>
                                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$adopters->question_1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="question2">{{ __('Apakah anda pernah mengadopsi hewan peliharaan sebelumnya? *') }}</label>
                                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$adopters->question_2}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="question2">{{ __('Hewan peliharaan apa yang paling anda sukai? *') }}</label>
                                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$adopters->question_3}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="question2">{{ __('Berikan alasan anda ingin mengadopsi hewan peliharaan? *') }}</label>
                                                            <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $adopters->question_4 }}</textarea>
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
                                            <div class="statusApproveReject">
                                                <button type="submit" id="" class="button1_detail" data-bs-toggle="modal" data-bs-target="#accepted{{ $adopters->pet_id }}{{ $adopters->user_id_adopter }}">
                                                    {{__('Accept')}}
                                                </button>
                                            </div>
                                            <div class="statusApproveReject">
                                                <button type="submit" id="" class="button4_detail" data-bs-toggle="modal" data-bs-target="#rejected{{ $adopters->pet_id }}{{ $adopters->user_id_adopter }}">
                                                    {{__('Reject')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- untuk confirm button accept --}}
                        <div class="modal fade" id="accepted{{$adopters->pet_id}}{{ $adopters->user_id_adopter }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelLabel">Accept Pet Adoption</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            {{-- <span aria-hidden="true">&times;</span> --}}
                                        </button>
                                    </div>
                                        <form action="/status/pet-adoption/approved/{{$adopters->pet_id}}/{{ $adopters->user_id_adopter }}" method="put" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                {{__('Apa Kamu Yakin Ingin Melakukan Accept Pet Adoption (Pet Name = '.$adopters->pet_name.')?')}}
                                                <br>
                                                <br>
                                                <div class="form-group p-2">
                                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                                    <input name="reasonAccept" type="text" class="form-control @error('reasonAccept') is-invalid @enderror" id="reasonInput" placeholder="Berikan alasan anda disini.." value="{{ old('reasonAccept') }}" autofocus required>
                                                    <center>
                                                        <span style="font-size: 10px; color: grey">Wajib diisi | Maksimal 255 karakter</span>
                                                    </center>
                                                    @error('reasonAccept')
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

                        {{-- untuk confirm button rejected --}}
                        <div class="modal fade" id="rejected{{$adopters->pet_id}}{{$adopters->user_id_adopter}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                        {{-- <div class="modal fade" id="rejected{{$adopters->pet_id}}{{$adopters->user_id_adopter}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="cancelLabel">Reject Pet Adoption</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            {{-- <span aria-hidden="true">&times;</span> --}}
                                        </button>
                                    </div>
                                    <form method="put" action="/status/pet-adoption/rejected/{{$adopters->pet_id}}/{{ $adopters->user_id_adopter }}">
                                    {{-- <form method="put" id="statusReasonForm"> --}}
                                        <div class="modal-body">
                                            {{__('Apa Kamu Yakin Ingin Melakukan Reject Pet Adoption (Pet Name = '.$adopters->pet_name.')?')}}
                                            <br>
                                            <br>
                                            <div class="form-group p-2">
                                                {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                                <input name="reasonReject" type="text" class="form-control @error('reasonReject') is-invalid @enderror" id="reasonInput" placeholder="Berikan alasan anda disini.." value="{{ old('reasonReject') }}" autofocus required>
                                                <center>
                                                    <span style="font-size: 10px; color: grey">Wajib diisi | Maksimal 255 karakter</span>
                                                </center>
                                                @error('reasonReject')
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
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                {{'Close'}}
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                {{'Submit'}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- modal untuk detail pet request  --}}
                    @foreach ($pet as $pets)
                        <div class="modal fade" id="detailPetRequest{{$pets->pet_id}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                        {{-- <div class="modal fade" id="rejected{{ $pets->pet_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title" id="cancelLabel">Detail Pet Adoption</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            {{-- <span aria-hidden="true">&times;</span> --}}
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                        <div class="col_judul">
                                            Detail Pet
                                        </div>
                                        <div class="table-responsive table_detail">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="3" class="field_table">
                                                            {{ $pets->pet_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="field_table">
                                                            <img src="{{ asset('gambar/pet/' . $pets->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td class="detail_column_pet">ID</td>
                                                        <td>:</td>
                                                        <td>{{ $pets->pet_id }}</td>
                                                    </tr> --}}
                                                    <tr>
                                                        <td class="detail_column_pet">
                                                            Species
                                                        </td>
                                                        <td>:</td>
                                                        @foreach ($species as $speciess)
                                                            @if ($pets->species_id == $speciess->species_id)
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
                                                            @if ($pets->breed_id == $breeds->breed_id)
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
                                                            @if ($pets->sex_id == $sexs->sex_id)
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
                                                            @if ($pets->age_id == $ages->age_id)
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
                                                            @if ($pets->source_id == $sources->source_id)
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
                                                            @if ($pets->vaccine_id == $vaccines->vaccine_id)
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
                                                            @if ($pets->sterilization_id == $sterilizations->sterilization_id)
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
                                                            {{ $pets->pet_description }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- modal untuk detail pet mark as adopted --}}
                    @foreach ($dataAccepted as $dataAccepteds)
                        {{-- <div class="modal fade" id="detailAdoptAccepted" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                        <div class="modal fade" id="detailPetMarkasAdopted{{$dataAccepteds->adopt_submission_id}}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
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
                                                    <td><h2>Status</h2></td>
                                                    <td><h2>:</h2></td>
                                                    <td>
                                                        @if ($dataAccepteds->status == 'Accepted')
                                                            <h3 class="p-3 field_table_td bg-success text-light">
                                                        @endif
                                                            {{$dataAccepteds->status}}
                                                        </h3>
                                                    </td>
                                                </tr>
                                                @if ($dataAccepteds->status == 'Accepted')
                                                    <tr>
                                                        <td><h4>Message's From Pet Owner</h4></td>
                                                        <td><h4>:</h4></td>
                                                        <td>
                                                            <h4>
                                                                {{$dataAccepteds->reason}}
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
                                            @if ($users->id == $dataAccepteds->user_id)
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
                                                            <tr>
                                                                <td>
                                                                    Phone Number
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $users->phone_number }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Email
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <a href="mailto:{{$users->email}}" target="_blank">
                                                                        {{ $users->email }}
                                                                    </a>
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
                                                            </tr> --}}
                                                            {{-- <tr>
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
                                            @endif

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
                                        @endforeach
                                        {{-- @endforeach --}}

                                        {{-- untuk data adopter nya --}}
                                        @foreach ($user as $users)
                                            @if ($users->id == $dataAccepteds->user_id_adopter)
                                                <div class="col_judul">
                                                    @if ($dataAccepteds->status == 'Accepted')
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
                                                            <tr>
                                                                <td>
                                                                    Phone Number
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    {{ $users->phone_number }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    Email
                                                                </td>
                                                                <td>:</td>
                                                                <td>
                                                                    <a href="mailto:{{$users->email}}" target="_blank">
                                                                        {{ $users->email }}
                                                                    </a>
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
                                            @endif

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
                                                            {{ $dataAccepteds->pet_name }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" class="field_table">
                                                            <img src="{{ asset('gambar/pet/' . $dataAccepteds->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="300px" height="300px">
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
                                                            @if ($dataAccepteds->species_id == $speciess->species_id)
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
                                                            @if ($dataAccepteds->breed_id == $breeds->breed_id)
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
                                                            @if ($dataAccepteds->sex_id == $sexs->sex_id)
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
                                                            @if ($dataAccepteds->age_id == $ages->age_id)
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
                                                            @if ($dataAccepteds->source_id == $sources->source_id)
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
                                                            @if ($dataAccepteds->vaccine_id == $vaccines->vaccine_id)
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
                                                            @if ($dataAccepteds->sterilization_id == $sterilizations->sterilization_id)
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
                                                            {{ $dataAccepteds->pet_description }}
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
                                                            <label for="question2">{{ __('Hewan peliharaan apa yang anda miliki saat ini? *') }}</label>
                                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$dataAccepteds->question_1}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="question2">{{ __('Apa yang anda ketahui tentang kucing atau anjing? *') }}</label>
                                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$dataAccepteds->question_2}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="question2">{{ __('Apakah anda memiliki pekerjaan dan berapa gaji anda perbulan? *') }}</label>
                                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$dataAccepteds->question_3}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="question2">{{ __('Berikan alasan anda ingin mengadopsi hewan peliharaan? *') }}</label>
                                                            <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $dataAccepteds->question_4 }}</textarea>
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

                </div>
            @endif
        @else
            <div class="table table-responsive">
                <table class="table table-borderless table-hover">
                    <thead class="table-dark">
                        <th>No.</th>
                        <th>Adopter Name</th>
                        <th>Pet Name</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7">
                                {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                <div class="text-center">
                                    <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif

        <br>
        <br>
    </div>
@endsection
