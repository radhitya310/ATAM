@extends('layouts.app')

@section('title')
    Detail Pet - Nirmala
@endsection

@section('content')
    <div class="col1_3">
        @if ($detailPet == 'requestAdopt')
            {{-- untuk data pet owner nya --}}
            @foreach ($pet as $pets)
                {{-- untuk radius nya --}}
                {{-- <div class="table table-responsive pt-4">
                    <table class="table table-hover text-danger">
                        <tr>
                            <td class="w-50"><h2>Radius</h2></td>
                            <td><h2>:</h2></td>
                            <td>
                                <h2>
                                    @if (!Auth::guest())
                                        {{ number_format($pets->distance, 2, ',', '.').' (KM)' }}
                                        {{Auth::user()->latitude}}
                                        {{Auth::user()->longitude}}
                                    @endif
                                </h2>
                            </td>
                        </tr>
                    </table>
                </div> --}}
                <br>
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
                                    {{ $pets->user_id }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td class="detail_column">
                                    Name
                                </td>
                                <td class="detail_column_2">:</td>
                                <td>
                                    {{ $pets->name }}
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    Phone Number
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->phone_number }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td>
                                    Email
                                </td>
                                <td>:</td>
                                <td>
                                    <a href="mailto:{{$pets->email}}" target="_blank">
                                        {{ $pets->email }}
                                    </a>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    Kode POS
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->kode_pos }}
                                </td>
                            </tr> --}}

                            {{-- <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>
                                    {{ $pets->address }} --}}
                                    {{-- @if (!Auth::guest() && $userID != $pets->id)
                                        <a href="#directionMap" data-bs-toggle="modal" aria-expanded="false" aria-controls="directionMap">
                                            [View Direction Map]
                                        </a>
                                    @endif --}}
                                {{-- </td>
                            </tr> --}}

                            {{-- <tr>
                                <td colspan="3">
                                    <div class="form-group d-none" id="latitudeArea">
                                        <label>Latitude</label>
                                        <input type="number" name="latitude" id="latitude" readonly class="form-control" value="{{$pets->latitude}}">
                                    </div>

                                    <div class="form-group d-none">
                                        <label>Longitude</label>
                                        <input type="number" name="longitude" id="longitude" readonly class="form-control" value="{{$pets->longitude}}">
                                    </div>

                                    <div class="row">
                                        <div id="googleMap" class="col-lg-12 wadah_peta"></div>
                                    </div>
                                </td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            @endforeach

            {{-- code java script untuk pet owner --}}
            <script type="text/javascript">

                var marker;
                // //posisi awal marker
                var long = document.getElementById('longitude').value;
                var lat = document.getElementById('latitude').value;
                // var latLng = new google.maps.LatLng(lat,long);

                function markerAwal(){
                    var map = new google.maps.Map(document.getElementById('googleMap'), {
                        center:new google.maps.LatLng(lat,long), // jakarta
                        zoom: 10,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    });

                    marker = new google.maps.Marker({
                        position : new google.maps.LatLng(lat,long),
                        map : map,
                        animation: google.maps.Animation.BOUNCE
                    });

                    map.addListener("center_changed", () => {
                        // 30 seconds after the center of the map has changed, pan back to the
                        // marker.
                        window.setTimeout(() => {
                        map.panTo(marker.getPosition());
                        }, 30000); //ms
                    });

                    marker.addListener("click", () => {
                        map.setZoom(17);
                        map.setCenter(marker.getPosition());
                    });
                }

                // // event window di-load
                google.maps.event.addDomListener(window, 'load', markerAwal);
            </script>

            {{-- untuk data detail pet nya --}}
            @foreach ($pet as $pets)
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
                                <td>
                                    {{ $pets->species_name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Breed
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->breed_category }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sex
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->sex_name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Age
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->age_category }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Source
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->source_name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Vaccine
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->vaccine_status }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sterilization
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $pets->sterilization_status }}
                                </td>
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

                {{-- jika statusnya request --}}
                @if ($pets->status == "Request for Adopt")
                    <div class="text-center d-grid">
                        <a class="btn btn-outline-info btn-block dropdown-toggle" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Adopt Here
                        </a>
                    </div>

                    <div class="collapse show mt-4 teamsCollapse" id="collapseExample">
                        <div class="text-center p-2">
                            <h3>Answer the Questions!!</h3>
                        </div>
                        @if (!Auth::guest())
                            <form action="/adoption/detail/proses/submissions" method="get" enctype="multipart/form-data">
                                <input type="number" name="pet_id" id="" hidden value="{{ $pets->pet_id }}">
                                <input type="number" name="user_id_adopter" id="" hidden value="{{ $userID }}">
                        @else
                            <form action="" method="">
                        @endif
                                <input name="status" type="text" hidden value="Waiting for Adopt">
                                <input name="reason" type="text" hidden value="[NULL]">

                                <div class="form-group">
                                    <label for="question1">{{ __('Apakah Anda memiliki hewan peliharaan? Jika iya, mohon sebutkan jumlah & jenis hewan yang Anda miliki. *') }}</label>
                                    <input type="text" name="question1" class="form-control @error('question1') is-invalid @enderror" id="question1" placeholder="write here..." autofocus value="{{old('question1')}}">
                                    {{-- <select name="question1" id="question1" class="form-control form-select @error('question1') is-invalid @enderror" autofocus>
                                        <option hidden value="" id="">Choose..</option>
                                        <option value="Yes" id="">Yes</option>
                                        <option value="No" id="">No</option>
                                    </select> --}}
                                    @error('question1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="question2">{{ __('Apa saja hal yang Anda ketahui tentang jenis hewan yang akan diadopsi? *') }}</label>
                                    <input type="text" name="question2" class="form-control @error('question1') is-invalid @enderror" id="question2" placeholder="write here..." value="{{old('question2')}}">
                                    {{-- <select name="question2" id="question2" class="form-control form-select @error('question2') is-invalid @enderror" autofocus>
                                        <option hidden value="" id="">Choose..</option>
                                        <option value="Yes" id="">Yes</option>
                                        <option value="No" id="">No</option>
                                    </select> --}}
                                    @error('question2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="question3">{{ __('Apakah Anda sanggup mendukung kebutuhan hewan seperti vaksin, biaya pengobatan, steril, dll? *') }}</label>
                                    <input type="text" name="question3" class="form-control @error('question3') is-invalid @enderror" id="question3" placeholder="write here..." value="{{old('question3')}}">
                                    @error('question3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="question4">{{ __('Jelaskan alasan Anda tertarik pada hewan yang dipilih! *') }}</label>
                                    <textarea name="question4" id="question4" class="form-control @error('question4') is-invalid @enderror" cols="30" rows="4" placeholder="write here...">{{ old('question4') }}</textarea>
                                    @error('question4')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <br>
                                <div class="form-group wadah_button_detail">
                                    {{-- untuk validasi bukan guest --}}
                                    @if (!Auth::guest())

                                        {{-- ambil id adopter nya --}}
                                        @php
                                            $userID = Auth::user()->id;
                                        @endphp

                                        @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                            <button type="button" class="button2_detail" disabled>
                                                {{ $pets->status }}
                                            </button>
                                        @else
                                            @if ($userID != $pets->user_id)
                                                <button type="submit" id="" class="button1_detail">
                                                    {{ $pets->status }}
                                                </button>
                                            @endif

                                            @if ($userID == $pets->user_id)
                                                <button type="submit" id="" class="button2_detail" disabled>
                                                    {{ $pets->status }}
                                                </button>
                                            @endif
                                        @endif
                                    @endif
                                    @if (Auth::guest())
                                        {{-- jika guest --}}
                                        <a href="/login">
                                            <button type="button" class="button1_detail">
                                                {{ $pets->status }}
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </form>
                    </div>
                {{-- jika status nya mark as adopted --}}
                @else
                    @foreach ($adopter as $adopters)
                        <div class="container">
                            <div class="text-center p-2">
                                <h3>Answer from the Questions</h3>
                            </div>
                            <div class="table-responsive mt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="question2">{{ __('Apakah Anda memiliki hewan peliharaan? Jika iya, mohon sebutkan jumlah & jenis hewan yang Anda miliki. *') }}</label>
                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$adopters->question_1}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="question2">{{ __('Apa saja hal yang Anda ketahui tentang jenis hewan yang akan diadopsi? *') }}</label>
                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$adopters->question_2}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="question2">{{ __('Apakah Anda sanggup mendukung kebutuhan hewan seperti vaksin, biaya pengobatan, steril, dll? *') }}</label>
                                            <input type="text" name="" class="form-control" id="" placeholder="" readonly value="{{$adopters->question_3}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="question2">{{ __('Jelaskan alasan Anda tertarik pada hewan yang dipilih! *') }}</label>
                                            <textarea name="" id="" class="form-control" cols="30" rows="4" readonly>{{ $adopters->question_4 }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <br>

                    <div class="wadah_button_detail">
                        {{-- untuk validasi bukan guest --}}
                        @if (!Auth::guest() && Auth::user()->role_id != 3)

                            {{-- ambil id adopter nya --}}
                            @php
                                $userID = Auth::user()->id;
                            @endphp

                            @if($pets->status == 'Mark as Adopted')
                                <button type="submit" id="" class="button3_detail" disabled>
                                    {{ $pets->status }}
                                </button>
                            @endif
                        @endif
                    </div>
                @endif
            @endforeach

            <!-- menggunakan Modal untuk direction map -->
            @foreach ($user as $users)
                <div class="modal fade" id="directionMap" data-bs-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                <h5 class="modal-title" id="deleteLabel">View Direction Map</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    {{-- {{-- <span aria-hidden="true">&times;</span> --}} --}}
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="text" id="start" hidden value="{{ $users->address }}">
                                <input type="text" id="end" hidden value="{{ $pets->address }}">

                                {{-- <input type="number" id="latOrigin" value="{{ $users->latitude }}">
                                <input type="number" id="longOrigin" value="{{ $users->longitude }}">
                                <input type="number" id="latDestination" value="{{ $pets->latitude }}">
                                <input type="number" id="longDestination" value="{{ $pets->longitude }}"> --}}
                                <div class="text-center">
                                    <strong>Mode of Travel: </strong>
                                    <select id="mode" onchange="calcRoute();">
                                        <option value="DRIVING">Driving</option>
                                        <option value="WALKING">Walking</option>
                                        {{-- <option value="BICYCLING">Bicycling</option> --}}
                                        <option value="TRANSIT">Transit</option>
                                    </select>
                                </div>
                                <br>
                                <div id="mapDirection" class="col-lg-12 wadah_peta"></div>
                            </div>
                            <div class="modal-footer">
                                {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    {{'No'}}
                                </button>
                                <form method="delete" action="/manage/pet/delete/{{$pets->pet_id}}">
                                    <button type="submit" class="btn btn-primary">
                                        {{'Yes'}}
                                    </button>
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- untuk javascript direction map nya --}}
            <script type="text/javascript">
                function initMap() {
                    var directionsService = new google.maps.DirectionsService();
                    var directionsRenderer = new google.maps.DirectionsRenderer();
                    var jakarta = new google.maps.LatLng(-6.175110,106.865036);
                    var mapOptions = {
                        center: jakarta,
                        zoom:10,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }

                    var map = new google.maps.Map(document.getElementById('mapDirection'), mapOptions);
                    directionsRenderer.setMap(map);

                    // var latOri = document.getElementById("latOrigin").value;
                    // var longOri =document.getElementById("longOrigin").value;

                    // var latDes = document.getElementById("latDestination").value;
                    // var longDes =document.getElementById("longDestination").value;

                    // var start = new google.maps.LatLng(latOri,longOri);
                    // var end = new google.maps.LatLng(latDes,longDes);

                    var start = document.getElementById('start').value;
                    var end = document.getElementById('end').value;
                    var request = {
                        origin: start,
                        destination: end,
                        travelMode: 'DRIVING'
                        // travelMode: google.maps.TravelMode[selectedMode]
                        // travelMode: [selectedMode]
                    };
                    directionsService.route(request, function(result, status) {
                        if (status == 'OK') {
                            directionsRenderer.setDirections(result);
                        }
                    });

                }

                function calcRoute(){
                    var directionsService = new google.maps.DirectionsService();
                    var directionsRenderer = new google.maps.DirectionsRenderer();
                    var jakarta = new google.maps.LatLng(-6.175110,106.865036);
                    var mapOptions = {
                        center: jakarta,
                        zoom:10,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    }

                    var map = new google.maps.Map(document.getElementById('mapDirection'), mapOptions);
                    directionsRenderer.setMap(map);

                    var selectedMode = document.getElementById('mode').value;
                    // var latOri = document.getElementById("latOrigin").value;
                    // var longOri =document.getElementById("longOrigin").value;

                    // var latDes = document.getElementById("latDestination").value;
                    // var longDes =document.getElementById("longDestination").value;

                    // var start = new google.maps.LatLng(latOri,longOri);
                    // var end = new google.maps.LatLng(latDes,longDes);

                    var start = document.getElementById('start').value;
                    var end = document.getElementById('end').value;
                    var request = {
                        origin: start,
                        destination: end,
                        // travelMode: 'DRIVING'
                        travelMode: google.maps.TravelMode[selectedMode]
                    };
                    directionsService.route(request, function(response, status) {
                        if (status == 'OK') {
                            directionsRenderer.setDirections(response);
                        }
                    });
                }

                google.maps.event.addDomListener(window, 'load', initMap);
            </script>

        @endif
    </div>
@endsection
