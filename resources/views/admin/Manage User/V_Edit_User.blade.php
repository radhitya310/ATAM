@extends('layouts.app')

@section('title')
    Edit User - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Edit User
                </h1>
            </div>

            {{-- untuk ambil pesan message dari controller nya --}}
            @if (session('message'))
                <div class="alert alert-success text-center">
                    {{session('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                </div>
            @endif

            @foreach ($user as $users)

                <form method="post" action="/manage/user/update/{{$users->id}}" enctype="multipart/form-data">
                    @csrf

                    {{-- @if ($edit == 'editUser') --}}
                        {{-- <input type="text" name="edit" id="" hidden value="{{$edit}}"> --}}

                        <div class="classFoto">
                            @if ($users->user_photo == null)
                                <img src="{{ asset('gambar/user_kosong.jpg') }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                            @else
                                <img src="{{ asset('gambar/foto_user_login/'.$users->user_photo) }}" alt="foto user" class="rounded-circle" width="250px" height="250px">
                            @endif
                        </div>
                        <br>

                        <input name="user_id" type="number" hidden value="{{ $users->id }}">

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
                            <label for="id">{{ __('User ID *') }}</label>
                            <input name="id" type="number" class="form-control text-center" id="id" placeholder="" readonly value="{{ $users->id }}">
                        </div>

                        <div class="form-group">
                            <label for="role_id">{{ __('User Role *') }}</label>
                            <select name="role_id" id="role_id" class="form-control form-select @error('role_id') is-invalid @enderror">
                                <option hidden value="{{ $users->role_id }}">{{ $users->role_name }}</option>
                                @foreach ($role as $roles)
                                    <option value="{{ $roles->role_id }}" id="">{{ $roles->role_name }}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="name">{{ __('Name *') }}</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="" autocomplete="name" value="{{ $users->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ $users->email }}" autocomplete="email" value="{{ old('email') }}">
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
                                <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" autocomplete="new-password" value="{{ old('password') }}">
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
                                <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password" autocomplete="new-password" value="{{ old('password_confirmation') }}">
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
                            <input name="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="{{$users->phone_number}}" value="{{ old('phone_number') }}">
                            <span style="font-size: 10px; color: grey">Kosongkan phone number jika tidak ingin diubah</span>
                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">{{ __('Address *') }}</label>
                            {{-- <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="4" placeholder="Address">{{ $users->address }}</textarea> --}}
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

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                    <br>
                </form>
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

            // // event window di-load
            google.maps.event.addDomListener(window, 'load', initialize);
            google.maps.event.addDomListener(window, 'load', markerAwal);
        </script>

        {{-- untuk show hide password --}}
        <script src="/js/showHidePass.js" defer></script>
    </div>
@endsection
