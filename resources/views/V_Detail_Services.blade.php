@extends('layouts.app')

@section('title')
    @if ($service_type == 'Grooming')
        Book Grooming Services - Nirmala
    @else
        Book Konsultasi Services - Nirmala
    @endif
@endsection

@section('content')
    <div class="wadah">
        <div class="col1_detail">
            {{-- untuk detail pet shop nya --}}
            @foreach ($dataUser as $dataUsers)
                <div class="col_judul">
                    Detail Pet Shop
                </div>
                <div class="table table-responsive table_detail">
                    <table class="table table-hover border_none">
                        <tbody>
                            <tr>
                                <td colspan="3">
                                    <center>
                                        <div class="row">
                                            <div>
                                                @if ($dataUsers->user_photo == null)
                                                    <img src="{{ asset('gambar/petshop.png') }}" alt="foto user" class="" width="60%" height="100%">
                                                @else
                                                    <img src="{{url('gambar/foto_user_login/'.$dataUsers->user_photo)}}" alt="foto pet shop" class="" width="60%" height="100%">
                                                @endif
                                            </div>
                                            <a data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample" class="text-decoration-none mt-2 mb-2">More Info...</a>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                            {{-- <tr class="text-danger">
                                <td><h4>Radius</h4></td>
                                <td><h4>:</h4></td>
                                <td>
                                    <h4>
                                        Blom kelar
                                        @if (!Auth::guest())
                                            {{ number_format($pets->distance, 2, ',', '.').' (KM)' }}
                                        @endif
                                    </h4>
                                </td>
                            </tr> --}}
                            <tr>
                                <td class="detail_column">Name</td>
                                <td class="detail_column_2">:</td>
                                <td>
                                    {{ $dataUsers->name }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Phone Number
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $dataUsers->phone_number }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email
                                </td>
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
                                <td colspan="3">
                                    <div class="accordion" id="accordionExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Detail Reservation Services
                                                </button>
                                            </h2>
                                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                <div class="accordion-body">
                                                    @foreach ($countPetShopID as $item => $value)
                                                        @if ($value->id == 0)
                                                            {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                                        @else
                                                            @foreach ($petShopGroomKonsul as $petShopGroomKonsuls)
                                                                    {{-- @if ($petShopGroomKonsuls->service_post_status == 'disabled')
                                                                        <tbody class="bg-danger">
                                                                    @else
                                                                        <tbody>
                                                                    @endif --}}
                                                                    {{-- <tr>
                                                                    </tr> --}}
                                                                    {{-- @if (!Auth::guest() && Auth::user()->role_id == 1)
                                                                        <td>{{ $petShopGroomKonsuls->service_id }}</td>
                                                                    @endif --}}
                                                                    @if ($petShopGroomKonsuls->service_post_status == 'disabled')
                                                                        <div class="row pb-2 pt-2 bg-danger text-light">
                                                                    @else
                                                                        <div class="row pb-2 pt-2">
                                                                    @endif
                                                                        <div class="col-6">
                                                                            {{ $petShopGroomKonsuls->service_name }}
                                                                        </div>
                                                                        <div class="col-3">
                                                                            {{number_format($petShopGroomKonsuls->service_price, 0, ',', '.')}}
                                                                        </div>
                                                                        <div class="col-3">
                                                                            @if ($petShopGroomKonsuls->service_post_status == 'enabled')
                                                                                {{__('(Tersedia)')}}
                                                                            @else
                                                                                {{__('(Tidak Tersedia)')}}
                                                                            @endif
                                                                            {{-- {{ '('.$petShopGroomKonsuls->service_post_status.')' }} --}}
                                                                        </div>
                                                                    </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Address
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $dataUsers->address }}
                                    @if (!Auth::guest())
                                        <a href="#directionMap" data-bs-toggle="modal" aria-expanded="false" aria-controls="directionMap">
                                    @else
                                        <a class="cursorNot" title="you must login first">
                                    @endif
                                        [View Direction Map]
                                    </a>
                                </td>
                            </tr>
                            {{-- <tr>
                                <td>
                                    Postal Code
                                </td>
                                <td>:</td>
                                <td>
                                    {{ $dataUsers->kode_pos }}
                                </td>
                            </tr> --}}
                            <tr>
                                <td colspan="3">
                                    <div class="form-group d-none" id="latitudeArea">
                                        <label>Latitude</label>
                                        <input type="number" name="latitude" id="latitude" readonly class="form-control" value="{{$dataUsers->latitude}}">
                                    </div>

                                    <div class="form-group d-none">
                                        <label>Longitude</label>
                                        <input type="number" name="longitude" id="longitude" readonly class="form-control" value="{{$dataUsers->longitude}}">
                                    </div>

                                    <!-- Elemen yang akan menjadi map container atau gambar peta nya -->
                                    <div class="row">
                                        <div id="googleMap" class="col-lg-12 wadah_peta"></div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- menggunakan offcanvas --}}
                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header bg-info">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{$dataUsers->name}}</h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="text-left">
                            {{-- <div class="row">
                                <div class="col-3">
                                    <p>
                                        {{__('Open')}}
                                    </p>
                                </div>
                                <div class="col-2">
                                    {{__(':')}}
                                </div>
                                <div class="col-7">
                                    <p>
                                        {{__('Buka jam 07:00 AM')}}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <p>
                                        {{__('Closed')}}
                                    </p>
                                </div>
                                <div class="col-2">
                                    {{__(':')}}
                                </div>
                                <div class="col-7">
                                    <p>
                                        {{__('Tutup jam 15:00')}}
                                    </p>
                                </div>
                            </div> --}}

                            <div class="row">
                                <div class="col_judul text-center">
                                    {{__('About Pet Shop')}}
                                </div>
                                <div class="col-12">
                                    <p>
                                        {{-- {{__('Kami jual berbagai produk yang seperti: makanan kucing, makanan anjing, vitamin, dan masih banyak lagi..')}} --}}
                                        {{$dataUsers->more_status_pet_shop}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 bg-secondary text-light">
                        <h5>

                        </h5>
                    </div>
                </div>
            @endforeach

            {{-- code java script--}}
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

                <!-- menggunakan Modal untuk direction map -->
                @foreach ($user as $users)
                    <div class="modal fade" id="directionMap" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h5 class="modal-title" id="deleteLabel">View Direction Map</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        {{-- <span aria-hidden="true">&times;</span> --}}
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input type="text" id="start" hidden value="{{ $users->address }}">
                                    <input type="text" id="end" hidden value="{{ $dataUsers->address }}">
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

            {{-- <div class="col_judul">
                Detail Reservation Services
            </div>
            @if ($service_type == 'Grooming')
                <div class="table table-responsive table_detail detailService">
                    <table class="table table-hover ">
                        <thead class="table-dark">
                            <th>Service Name</th>
                            <th>Price (Rp.)</th>
                            <th>Status</th>
                        </thead>
                        @foreach ($countPetShopID as $item => $value)
                            @if ($value->id == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h2 class="text-danger text-center">Data tidak ada</h2>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
                                @foreach ($petShopGroomKonsul as $petShopGroomKonsuls)
                                        @if ($petShopGroomKonsuls->service_post_status == 'disabled')
                                            <tbody class="bg-danger">
                                        @else
                                            <tbody>
                                        @endif
                                                <tr>
                                                    <td>{{ $petShopGroomKonsuls->service_name }}</td>
                                                    <td>{{number_format($petShopGroomKonsuls->service_price, 0, ',', '.')}}</td>
                                                    <td>{{ '('.$petShopGroomKonsuls->service_post_status.')' }}</td>
                                                </tr>
                                            </tbody>
                                @endforeach
                            @endif
                        @endforeach
                    </table>
                </div> --}}
            {{-- @else
                <div class="table table-responsive table_detail">
                    <table class="table table-hover ">
                        <thead class="table-dark">
                            <th>Service Name</th>
                            <th>Price (Rp.)</th>
                            <th>Doctor Name</th>
                            <th>Status</th>
                        </thead>
                        @foreach ($countPetShopID as $item => $value)
                            @if ($value->id == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h2 class="text-danger text-center">Data tidak ada</h2>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
                                @foreach ($petShopGroomKonsul as $petShopGroomKonsuls)
                                        @if ($petShopGroomKonsuls->service_post_status == 'disabled')
                                            <tbody class="bg-danger">
                                        @else
                                            <tbody>
                                        @endif
                                                <tr>
                                                    <td>{{ $petShopGroomKonsuls->service_name }}</td>
                                                    <td>{{number_format($petShopGroomKonsuls->service_price, 0, ',', '.')}}</td>
                                                    <td>{{ $petShopGroomKonsuls->doctor_name }}</td>
                                                    <td>{{ '('.$petShopGroomKonsuls->service_post_status.')' }}</td>
                                                </tr>
                                            </tbody>
                                @endforeach
                            @endif
                        @endforeach
                    </table>
                </div>

            @endif --}}
            {{-- <br> --}}
        </div>

        {{-- untuk book nya --}}
        <div class="col2_detail">
            <div class="col_judul">
                Book Here
            </div>
            <br>
            <div>
                <form method="post" action="/checkout/order" enctype="multipart/form-data">
                    @csrf

                    {{-- User ID --}}
                    <input name="user_id" type="number" id="user_id" hidden value="{{ $userID }}">
                    @if ($service_type == 'Grooming')
                        <input name="service_type" type="text" id="service_type" hidden value="{{ $service_type }}">
                    @else
                        <input name="service_type" type="text" id="service_type" hidden value="{{ $service_type }}">
                    @endif

                    <div class="form-group border-bottom pb-4">
                        <label for="service_id">{{ __('Reservation Services*') }}</label>
                        <select name="service_id" id="service_id" class="form-control form-select @error('service_id') is-invalid @enderror" autofocus>
                            <option hidden value="">Choose...</option>
                            @foreach ($petShopGroomKonsul as $petShopGroomKonsuls)
                                @if ($petShopGroomKonsuls->service_post_status == "enabled")
                                    {{-- @if (!Auth::guest() && Auth::user()->role_id == 1)
                                        <option value="{{ $petShopGroomKonsuls->service_id }}" id="" data-price="{{ $petShopGroomKonsuls->service_price }}">{{$petShopGroomKonsuls->service_id.' - ('.$petShopGroomKonsuls->service_name.')' }}</option>
                                    @else --}}
                                        <option value="{{ $petShopGroomKonsuls->service_id }}" id="" data-price="{{ $petShopGroomKonsuls->service_price }}">{{$petShopGroomKonsuls->service_name}}</option>
                                    {{-- @endif --}}
                                @endif
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group border-bottom pb-4 wadah_subTotalPrice" id="wadah_subTotalPrice">
                        <label for="service_price">{{ __('Service Price') }}</label>
                        <div class="row form-inline">
                            <div class="col-1">
                                Rp.
                            </div>
                            <div class="col-10">
                                <input name="service_price" type="number" class="form-control ms-2 cursor_none" id="service_price" readonly value="" onchange="calculateTotal()">
                            </div>
                        </div>
                    </div>

                    <div class="form-group border-bottom pb-4">
                        <label for="time">{{ __('Date *') }}</label>
                        <input name="date" type="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date') }}">
                        <span style="color: grey; font-size: 10px"> format = bulan(mm)/tanggal(dd)/tahun(yyyy) </span>
                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group border-bottom pb-4">
                        <label for="time">{{ __('Time *') }}</label>
                        <input name="time" type="time" class="form-control @error('time') is-invalid @enderror" id="time" value="{{ old('time') }}">
                        <span style="color: grey; font-size: 10px"> format = jam:menit</span>
                        @error('time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if ($service_type == 'Grooming')
                        <div class="form-group border-bottom pb-4">
                            <label for="quantity">{{ __('Qty *') }}</label>
                            <div class="row">
                                <div class="col-2">
                                    {{-- <button class="btn btn-primary ms-2" type="button" value="{{$qty++}}"> --}}
                                    <button class="btn btn-danger me-2" type="button" id="minusClickButton" onclick="minusClick()">
                                        &minus;
                                    </button>
                                </div>
                                <div class="col-8">
                                    <input name="quantity" type="number" class="text-center form-control @error('quantity') is-invalid @enderror cursor_none" id="quantity" readonly value="{{1}}">
                                </div>
                                <div class="col-2">
                                    {{-- <button class="btn btn-primary ms-2" type="button" value="{{$qty++}}"> --}}
                                    <button class="btn btn-success ms-2" type="button" id="plusClickButton" onclick="plusClick()">
                                        &plus;
                                    </button>
                                </div>
                                @error('quantity')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @else
                        <div class="form-group border-bottom pb-4" hidden>
                            <label for="quantity">{{ __('Qty *') }}</label>
                            <input name="quantity" type="number" class="form-control cursor_none" id="quantity" readonly value="{{1}}">
                        </div>
                    @endif

                    <div class="form-group border-bottom pb-4 wadah_totalPrice" id="wadah_totalPrice">
                        <label for="total_price">{{ __('Total Price') }}</label>
                        <div class="row form-inline">
                            <div class="col-1">
                                Rp.
                            </div>
                            <div class="col-10">
                                <input name="total_price" type="number" class="form-control ms-2 cursor_none" id="totalPrice" readonly value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3" id="">
                        <span style="color: red; font-size: 16px">
                            Metode pembayaran: Pay at Pet Shop
                        </span>
                    </div>

                    <br>
                    <div class="form-group">
                        @if (!Auth::guest())
                            @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 3)
                                <button type="submit" class="btn btn-primary" disabled>
                                    {{ __('Checkout') }}
                                </button>
                            @else
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Checkout') }}
                                </button>
                            @endif
                        @endif
                        @if (Auth::guest())
                            <a href="/login">
                                <button type="button" class="btn btn-primary">
                                    {{ __('Checkout') }}
                                </button>
                            </a>
                        @endif
                    </div>
                    <br>
                    <br>
                </form>
            </div>
        </div>
    </div>
@endsection
