@extends('layouts.app')

@section('title')
    Edit Services - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Edit Services
                </h1>
                <br>
            </div>
            <br>

            @foreach ($petShop as $petShops)
                <form method="post" action="/manage/services/update/{{ $petShops->service_id }}" enctype="multipart/form-data">
                    @csrf

                    @if ($petShops->service_type == 'Grooming')
                        {{-- <div class="form-group">
                            <label for="service_type">{{ __('Pet Shop ID *') }}</label>
                            <input name="user_id_pet_shop" type="number" class="form-control" id="user_id_pet_shop" readonly value="{{ $petShops->user_id_pet_shop }}">
                        </div> --}}

                        <div class="form-group">
                            <label for="service_type">{{ __('Service Type *') }}</label>
                            <input name="service_type" type="text" class="form-control text-secondary" id="service_type" readonly value="{{ $petShops->service_type }}">
                        </div>

                        <div class="form-group">
                            <label for="service_name">{{ __('Service Name *') }}</label>
                            <input name="service_name" type="text" class="form-control @error('service_name') is-invalid @enderror" id="service_name" placeholder="Service Name" autofocus value="{{ $petShops->service_name }}">
                            @error('service_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_price">{{ __('Price *') }}</label>
                            <input name="service_price" type="number" class="form-control @error('service_price') is-invalid @enderror" id="service_price" placeholder="Price" value="{{ $petShops->service_price }}">
                            @error('service_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    @else
                        {{-- <div class="classFoto">
                            <img src="{{ url('gambar/foto_dokter/'.$petShops->doctor_photo) }}" alt="foto dokter" class="rounded-circle" width="250px" height="250px">
                        </div>
                        <br> --}}

                        {{-- <div class="form-group">
                            <label for="service_type">{{ __('Pet Shop ID *') }}</label>
                            <input name="user_id_pet_shop" type="number" class="form-control" id="user_id_pet_shop" readonly value="{{ $petShops->user_id_pet_shop }}">
                        </div> --}}

                        <div class="form-group">
                            <label for="service_type">{{ __('Service Type *') }}</label>
                            <input name="service_type" type="text" class="form-control" id="service_type" readonly value="{{ $petShops->service_type }}">
                        </div>

                        <div class="form-group">
                            <label for="service_name">{{ __('Service Name *') }}</label>
                            <input name="service_name" type="text" class="form-control @error('service_name') is-invalid @enderror" id="service_name" placeholder="Service Name" value="{{ $petShops->service_name }}">
                            @error('service_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="service_price">{{ __('Price *') }}</label>
                            <input name="service_price" type="number" class="form-control @error('service_price') is-invalid @enderror" id="service_price" placeholder="Price" value="{{ $petShops->service_price }}">
                            @error('service_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="doctor_name">{{ __('Doctor Name*') }}</label>
                            <input name="doctor_name" type="text" class="form-control @error('doctor_name') is-invalid @enderror" id="doctor_name" placeholder="Doctor Name" value="{{ $petShops->doctor_name }}">
                            @error('doctor_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- <div class="form-group">
                            <label for="doctor_photo">{{ __('Doctor Photo') }}</label>
                            <input name="doctor_photo" type="file" class="form-control @error('doctor_photo') is-invalid @enderror" id="doctor_photo" value="{{ $petShops->doctor_photo }}">
                            @error('doctor_photo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                    @endif

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Update') }}
                        </button>
                    </div>
                    <br>
                </form>
            @endforeach
        </div>
    </div>
@endsection
