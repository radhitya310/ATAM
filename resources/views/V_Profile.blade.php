@extends('layouts.app')

@section('title')
    My Profile - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    My Profile
                </h1>
            </div>
            {{-- untuk panggil semua error nya --}}
            {{-- <div class="errorMessage">
                @if($errors)
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div> --}}

            {{-- untuk ambil pesan message dari controller nya --}}
            @if (session('message'))
                <div class="alert alert-success text-center">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                        {{-- &times; --}}
                    </button>
                </div>
            @endif

            @foreach ($user as $users)
                @if (Auth::user()->role_id == 3)
                    <div class="wadah_button_editPetShop">
                        <a href="{{ route('editPetShop') }}">
                            <button type="button" id="" class="btn btn-success">
                                {{__('Status Pet Shop')}}
                            </button>
                        </a>
                    </div>
                    <br>
                    <br>
                @endif

                <form method="post" action="/profile/update/{{$users->id}}" enctype="multipart/form-data">
                    @csrf

                    {{-- <input name="role_id" id="role_id" type="text" hidden value="{{$users->role_id}}"> --}}

                    <input name="user_id" type="number" id="" hidden value="{{$users->id}}">

                    <div class="classFoto">
                        @if ($users->user_photo == null)
                            <img src="{{ asset('gambar/user_kosong.jpg') }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                        @else
                            <img src="{{ asset('gambar/foto_user_login/'.$users->user_photo) }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                        @endif
                    </div>
                    <br>

                    {{-- @if ($edit == 'editFotoProfile')

                        <input name="edit" type="text" id="" hidden value="{{$edit}}">
                        <input name="name" type="text" id="" hidden value="{{$users->name}}">

                        <div class="form-group">
                            <label for="user_photo">{{ __('Image *') }}</label>
                            <input name="user_photo" type="file" class="form-control @error('user_photo') is-invalid @enderror" id="user_photo">
                            @error('user_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    @else --}}
                        {{-- <input name="edit" type="text" id="" hidden value="{{$edit}}"> --}}

                        <div class="form-group">
                            <label for="user_photo">{{ __('Change Photo') }}</label>
                            <input name="user_photo" type="file" class="form-control @error('user_photo') is-invalid @enderror" id="user_photo">
                            <span style="font-size: 10px; color: grey">Kosongkan change photo jika tidak ingin diubah</span>
                            @error('user_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Name *') }}</label>
                            <input name="name" type="text" class="shadow form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" autocomplete="name" value="{{ $users->name }}" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input name="email" type="email" class="shadow form-control @error('email') is-invalid @enderror" id="email" placeholder="{{$users->email}}" autocomplete="email" value="{{old('email')}}">
                            <span style="font-size: 10px; color: grey">Kosongkan email jika tidak ingin diubah</span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row form-row">
                            <div class="form-group col-md-5">
                                <label for="password">{{ __('Password') }}</label>
                                <input name="password" type="password" class="shadow form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" autocomplete="new-password">
                                <span class="fas fa-eye field-icon css_iconEye" id="togglePassword1"></span>
                                <span style="font-size: 10px; color: grey">Kosongkan password jika tidak ingin diubah</span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-5">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input name="password_confirmation" type="password" class="shadow form-control  @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
                                <span class="fas fa-eye field-icon css_iconEye" id="togglePassword2"></span>
                                <span style="font-size: 10px; color: grey">Harus sesuai dengan password</span>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone_number">{{ __('Phone Number') }}</label>
                            <input name="phone_number" type="number" class="shadow form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="{{$users->phone_number}}" value="{{ old('phone_number') }}">
                            <span style="font-size: 10px; color: grey">Kosongkan phone number jika tidak ingin diubah</span>
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">{{ __('Address *') }}</label>
                            {{-- <textarea name="address" id="address" class="shadow form-control @error('address') is-invalid @enderror" cols="30" rows="4" placeholder="Address">{{ $users->address }}</textarea> --}}
                            <input type="text" name="address" class="shadow form-control @error('address') is-invalid @enderror" id="autocomplete" placeholder="Address" value="{{ $users->address }}">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group d-none" id="latitudeArea">
                            <label>Latitude</label>
                            <input type="number" name="latitude" id="latitude" readonly class="form-control" value="{{$users->latitude}}">
                        </div>

                        <div class="form-group d-none" id="longitudeArea">
                            <label>Longitude</label>
                            <input type="number" name="longitude" id="longitude" readonly class="form-control" value="{{$users->longitude}}">
                        </div>

                        <!-- Elemen yang akan menjadi map container atau gambar peta nya -->
                        <div class="row">
                            <div id="googleMap" class="col-lg-12 wadah_peta"></div>
                        </div>

                    {{-- @endif --}}

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
                <br>
            @endforeach
        </div>

        {{-- code java script here --}}
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

            function initialize() {
                // untuk input auto complete address
                var options = {
                    componentRestrictions: {country: "ID"}
                };
                var int = 0;
                var input = document.getElementById('autocomplete');
                var autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    var newLat = place.geometry['location'].lat();
                    var newLong = place.geometry['location'].lng();
                    $('#latitude').val(newLat);
                    $('#longitude').val(newLong);

                    if(marker){
                        // pindahkan marker
                        marker.setPosition(place.geometry.location);
                    }
                    else {
                        // buat marker baru
                        marker = new google.maps.Marker({
                            // position : new google.maps.LatLng(place.geometry['location'].lat(),place.geometry['location'].lng()),
                            position : new google.maps.LatLng(place.geometry['location'].lat(),place.geometry['location'].lng()),
                            map: map,
                            animation: google.maps.Animation.BOUNCE
                        });
                    }

                    map.addListener("center_changed", () => {
                        // 30 seconds after the center of the map has changed, pan back to the
                        // marker.
                        window.setTimeout(() => {
                        map.panTo(marker.getPosition());
                        }, 30000); //ms
                    });

                    marker.addListener("click", () => {
                        map.setZoom(16);
                        map.setCenter(marker.getPosition());
                    });

                    // show latitude and longitude
                    // $("#latitudeArea").removeClass("d-none");
                    // $("#longitudeArea").removeClass("d-none");
                });

                var map = new google.maps.Map(document.getElementById('googleMap'), {
                    center:new google.maps.LatLng(lat,long), // jakarta
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
            }


            // // =======================================================


            // // //* Fungsi untuk mendapatkan nilai latitude longitude
            // function updateMarkerPosition(latLng) {
            //     document.getElementById('latitude').value = [latLng.lat()]
            //     document.getElementById('longitude').value = [latLng.lng()]
            // }

            // var long = document.getElementById('longitude').value;
            // var lat = document.getElementById('latitude').value;
            // var map = new google.maps.Map(document.getElementById('googleMap'), {
            //     center: new google.maps.LatLng(lat,long),
            //     zoom: 10,
            //     mapTypeId: google.maps.MapTypeId.ROADMAP
            // });

            // //posisi awal marker
            // var latLng = new google.maps.LatLng(lat,long);

            // /* buat marker yang bisa di drag lalu
            // panggil fungsi updateMarkerPosition(latLng)
            // dan letakan posisi terakhir di id=latitude dan id=longitude
            // */
            // var marker = new google.maps.Marker({
            //     position : latLng,
            //     map : map,
            //     draggable : true
            // });

            // map.addListener("center_changed", () => {
            //     // 30 seconds after the center of the map has changed, pan back to the
            //     // marker.
            //     window.setTimeout(() => {
            //     map.panTo(marker.getPosition());
            //     }, 30000); //ms
            // });

            // marker.addListener("click", () => {
            //     map.setZoom(16);
            //     map.setCenter(marker.getPosition());
            // });

            // updateMarkerPosition(latLng);
            // google.maps.event.addListener(marker, 'drag', function() {
            //     // ketika marker di drag, otomatis nilai latitude dan longitude
            //     //menyesuaikan dengan posisi marker
            //     updateMarkerPosition(marker.getPosition());
            // });

            // // ========================================================================

            // // untuk register
            // variabel global marker
            // var marker;
            // // // untuk marker location
            // function placeMarker(peta, posisiTitik){
            //     if(marker){
            //         // pindahkan marker
            //         marker.setPosition(posisiTitik);
            //     }
            //     else {
            //         // buat marker baru
            //         marker = new google.maps.Marker({
            //             position: posisiTitik,
            //             map: peta
            //         });
            //     }

            //     // isi nilai koordinat ke form
            //     document.getElementById("latitude").value = posisiTitik.lat();
            //     document.getElementById("longitude").value = posisiTitik.lng();

            //     // show latitude and longitude
            //     $("#latitudeArea").removeClass("d-none");
            //     $("#longitudeArea").removeClass("d-none");
            // }

            // function initialize() {
            //     // untuk input auto complete address
            //     var options = {
            //         componentRestrictions: {country: "IN"}
            //     };

            //     var input = document.getElementById('autocomplete');
            //     var autocomplete = new google.maps.places.Autocomplete(input, options);
            //     autocomplete.addListener('place_changed', function() {
            //         var place = autocomplete.getPlace();
            //         $('#latitude').val(place.geometry['location'].lat());
            //         $('#longitude').val(place.geometry['location'].lng());

            //         // show latitude and longitude
            //         $("#latitudeArea").removeClass("d-none");
            //         $("#longitudeArea").removeClass("d-none");
            //     });

            //     var long = document.getElementById('longitude').value;
            //     var lat = document.getElementById('latitude').value;

            //     var positioning = new google.maps.LatLng(lat, long);

            //     // // untuk gambar map nya
            //     var propertiPeta = {
            //         center:positioning,
            //         // center:new google.maps.LatLng(place.geometry['location'].lat(),place.geometry['location'].lng()),
            //         zoom:15,
            //         mapTypeId:google.maps.MapTypeId.ROADMAP
            //     };

            //     var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

            //     // even listner ketika peta diklik
            //     google.maps.event.addListener(peta, 'click', function(event) {
            //         placeMarker(this, event.latLng);
            //     });
            // }

            // ===================================================================================


            // function initialize() {
            //     // Create a map object and specify the DOM element for display.
            //     // var map = new google.maps.Map(document.getElementById('googleMap'), {
            //     //     center: {lat: -6.273300, lng: 106.823925},
            //     //     scrollwheel: false,
            //     //     zoom: 3
            //     // });

            //     var propertiPeta = {
            //             center:new google.maps.LatLng(-6.175110,106.865036),
            //             zoom:10,
            //             mapTypeId:google.maps.MapTypeId.ROADMAP
            //         };

            //     var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

            //     // even listner ketika peta diklik
            //     google.maps.event.addListener(peta, 'click', function(event) {
            //         taruhMarker(this, event.latLng);
            //     });
            // }




            // function initialize() {
            //     var propertiPeta = {
            //         center:new google.maps.LatLng(-6.175110,106.865036),
            //         zoom:10,
            //         mapTypeId:google.maps.MapTypeId.ROADMAP
            //     };

            //     var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

            //     // even listner ketika peta diklik
            //     google.maps.event.addListener(peta, 'click', function(event) {
            //         taruhMarker(this, event.latLng);
            //     });

            // }




            // function getAlamat() {
            //     var address = document.getElementById('address').value;
            //     geocoder.geocode( { 'address': address}, function(results, status) {
            //         if (status == google.maps.GeocoderStatus.OK) {
            //             map.setCenter(results[0].geometry.location);
            //             var marker = new google.maps.Marker({
            //                 map: map,
            //                 position: results[0].geometry.location
            //             });
            //             infowindow.setContent("Latitude: "
            //             +results[0].geometry.location.lat()+
            //             "<br>  Longitude: "+results[0].geometry.location.lng());
            //                 infowindow.open(map, marker);
            //         } else {
            //             alert('Geocode gagal karena : ' + status);
            //         }
            //     });
            // }




            // var marker;
            // function taruhMarker(peta, posisiTitik){
            //     if(marker){
            //         // pindahkan marker
            //         marker.setPosition(posisiTitik);
            //     } else {
            //         // buat marker baru
            //         marker = new google.maps.Marker({
            //         position: posisiTitik,
            //         map: peta
            //         });
            //     }
            // }

            // // fungsi initialize untuk mempersiapkan peta
            // function initialize() {
            //     var propertiPeta = {
            //     center:new google.maps.LatLng(-6.175110,106.865036),
            //     zoom:10,
            //     mapTypeId:google.maps.MapTypeId.ROADMAP
            //     };

            //     var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

            //     // even listner ketika peta diklik
            //     google.maps.event.addListener(peta, 'click', function(event) {
            //     taruhMarker(this, event.latLng);
            //     });
            // }

            // fungsi initialize untuk mempersiapkan peta
            // function initialize() {
            //     var propertiPeta = {
            //         // longitude and latitude jakarta
            //         center:new google.maps.LatLng(-6.175110,106.865036),
            //         zoom:10,
            //         mapTypeId:google.maps.MapTypeId.ROADMAP
            //     };

            //     var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);

            //     var marker = new google.maps.Marker({
            //         position: new google.maps.LatLng(-6.175110,106.865036),
            //         map: peta,
            //         animation: google.maps.Animation.BOUNCE
            //     });
            // }

            // // event window di-load
            google.maps.event.addDomListener(window, 'load', initialize);
            google.maps.event.addDomListener(window, 'load', markerAwal);
        </script>

        {{-- untuk show hide password --}}
        <script src="/js/showHidePass.js" defer></script>
    </div>
@endsection
