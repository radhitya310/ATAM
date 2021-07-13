@extends('layouts.app')

@section('title')
    Register - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Register
                </h1>
                <br>
            </div>
            <br>

            {{-- paggil semua message error validation --}}
            {{-- <div class="errorMessage">
                @if($errors)
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div> --}}

            {{-- <form method="post" action="{{ route('register') }}" enctype="multipart/form-data"> --}}
            <form method="post" action="/register/proses" enctype="multipart/form-data">
                @csrf

                {{-- <input name="role_id" id="role_id" type="number" value="2" hidden> --}}
                {{-- <input name="registerSuccess" type="number" hidden value="1"> --}}

                <div class="form-group">
                    <label for="name">{{ __('Name *') }}</label>
                    <input name="name" type="text" class="shadow form-control @error('name') is-invalid @enderror" id="name" placeholder="Name" autocomplete="name" autofocus value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email *') }}</label>
                    <input name="email" type="email" class="shadow form-control @error('email') is-invalid @enderror" id="email" placeholder="Example@gmail.com" autocomplete="email" value="{{ old('email') }}">
                    <span style="font-size: 10px; color: grey">Gunakan email yang valid</span>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row form-row">
                    <div class="form-group col-md-5">
                        <label for="password">{{ __('Password *') }}</label>
                        <input name="password" type="password" class="shadow form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" autocomplete="new-password">
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
                        <input name="password_confirmation" type="password" class="shadow form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Confirm Password" autocomplete="new-password">
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
                    <input name="phone_number" type="number" class="shadow form-control @error('phone_number') is-invalid @enderror" id="phone_number" placeholder="Phone Number" value="{{ old('phone_number') }}">
                    <span style="font-size: 10px; color: grey">Gunakan phone number yang valid</span>
                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
                    <input type="checkbox" name="checkbox" class="shadow @error('checkbox') is-invalid @enderror" id="checkbox">
                    <label for="checkboxLabel">"I Agree with the rules" User Agreement. <u><a data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">Read Here..</a></u></label>
                    @error('checkbox')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group pt-3 pb-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Sign Up') }}
                    </button>
                </div>
                <br>
            </form>

            {{-- menggunakan offcanvas --}}
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <div class="offcanvas-header bg-info">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">User Agreement</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="text-left rata-kiri">
                        <p>
                            The Rules:
                        </p>
                        <ul>
                            <li>Semua hasil upload harus berkaitan dengan hewan kucing atau anjing.</li>
                            <li>Menggunakan username atau pet name atau pet shop name yang tidak mengandung unsur negatif.</li>
                            <li>Foto hewan yang di-upload tidak mengandung harga.</li>
                            <li>Jika ada user yang berbeda meng-upload hewan dengan foto sama, maka pihak kami akan mengambil first upload dan men-takedown yang non first upload.</li>
                        </ul>
                    </div>
                    <div class="">
                        <p class="text-danger">
                            Pihak kami akan bertindak tegas terhadap user yang melakukan pelanggaran diatas.
                        </p>
                    </div>
                </div>
                <div class="p-3 bg-secondary text-light">
                    <h5>
                        INGAT!!! Pihak kami tidak memungut biaya apapun.
                    </h5>
                </div>
            </div>

            {{-- <div class="modal fade" id="UserAgreement" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h5 class="modal-title" id="staticBackdropLabel">User Agreement</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        <div class="modal-body">
                            <div class="text-left rata-kiri">
                                <p>
                                    The Rules:
                                </p>
                                <ul>
                                    <li>Semua hasil upload harus berkaitan dengan hewan kucing atau anjing.</li>
                                    <li>Menggunakan username atau pet name atau pet shop name yang tidak mengandung unsur negatif.</li>
                                    <li>Foto hewan yang di-upload tidak mengandung harga.</li>
                                    <li>Jika ada user yang berbeda meng-upload hewan dengan foto sama, maka pihak kami akan mengambil first upload dan men-takedown yang non first upload.</li>
                                </ul>
                            </div>
                            <div class="">
                                <p class="text-danger">
                                    Pihak kami akan bertindak tegas terhadap user yang melakukan pelanggaran diatas.
                                </p>
                            </div>

                        </div>
                        <div class="modal-footer bg-secondary text-light">
                            <div class="">
                                <h5>
                                    INGAT!!! Pihak kami tidak memungut biaya apapun.
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

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
    </div>
@endsection
