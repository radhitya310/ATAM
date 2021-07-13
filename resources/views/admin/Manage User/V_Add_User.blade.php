@extends('layouts.app')

@section('title')
    Add User - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Add User
                </h1>
            </div>
            <form method="post" action="/manage/user/add/proses" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group input_style">
                        <label for="role_id">{{ __('User Role *') }}</label>
                        <select name="role_id" id="role_id" class="form-control form-select @error('role_id') is-invalid @enderror" autofocus>
                            <option hidden value="">Choose...</option>
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
                    {{-- <div class="form-group col-md-2">
                        <label for="inputZip">Zip</label>
                        <input type="text" class="form-control" id="inputZip">
                    </div> --}}
                </div>

                <div class="form-group">
                    <label for="name">{{ __('Name *') }}</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" autocomplete="name" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email *') }}</label>
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Example@gmail.com" autocomplete="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row form-row">
                    <div class="form-group col-md-5">
                        <label for="password">{{ __('Password *') }}</label>
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" autocomplete="new-password">
                        <span class="fas fa-eye field-icon css_iconEye" id="togglePassword1"></span>
                        <span style="font-size: 10px; color: grey">Password minimal 10 karakter</span>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-5">
                        <label for="password-confirm">{{ __('Confirm Password *') }}</label>
                        <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
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
                    <label for="phone_number">{{ __('Phone Number *') }}</label>
                    <input name="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Phone Number" autofocus value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="address">{{ __('Address *') }}</label>
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="30" rows="4" placeholder="Address">{{ old('address') }}</textarea>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="address">{{ __('Address *') }}</label>
                    {{-- <textarea name="address" id="address" class="shadow form-control @error('address') is-invalid @enderror" cols="30" rows="4" placeholder="Address">{{ old('address') }}</textarea> --}}
                    <input type="text" name="address" class="shadow form-control @error('address') is-invalid @enderror" id="autocomplete" placeholder="Address">
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group d-none" id="latitudeArea">
                    <label>Latitude</label>
                    <input type="text" name="latitude" id="latitude" readonly class="form-control">
                </div>

                <div class="form-group d-none" id="longitudeArea">
                    <label>Longitude</label>
                    <input type="text" name="longitude" id="longitude" readonly class="form-control">
                </div>

                <!-- Elemen yang akan menjadi map container atau gambar peta nya -->
                <div class="row">
                    <div id="googleMap" class="col-lg-12 wadah_peta"></div>
                </div>

                {{-- <div class="form-group">
                    <label for="kode_pos">{{ __('Postal Code *') }}</label>
                    <input name="kode_pos" type="number" class="form-control @error('kode_pos') is-invalid @enderror" id="kode_pos" placeholder="Postal Code" value="{{ old('kode_pos') }}">
                    @error('kode_pos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="user_photo">{{ __('Photo') }}</label>
                    <input name="user_photo" type="file" class="form-control  @error('user_photo') is-invalid @enderror" id="user_photo" placeholder="" value="">
                    <span style="font-size: 10px; color: grey">Kosongkan jika tidak ingin upload foto</span>
                    @error('user_photo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="">
                    <div class="">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Add') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- code java script here --}}
        <script type="text/javascript">
            function initialize() {
                var marker;

                // untuk input auto complete address
                var options = {
                    componentRestrictions: {country: "ID"}
                };
                var int = 0;
                var input = document.getElementById('autocomplete');
                var autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    var lat = place.geometry['location'].lat();
                    var long = place.geometry['location'].lng();
                    $('#latitude').val(lat);
                    $('#longitude').val(long);

                    if(marker){
                        // pindahkan marker
                        marker.setPosition(place.geometry.location);
                    }
                    else {
                        // buat marker baru
                        marker = new google.maps.Marker({
                            // position : new google.maps.LatLng(lat,long),
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
                    center:new google.maps.LatLng(-6.175110,106.865036), // jakarta
                    zoom: 10,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
            }

            // // event window di-load
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

        {{-- untuk simbol unhide password --}}
        <script src="/js/showHidePass.js" defer></script>

    </div>
@endsection
