@extends('layouts.app')

@section('title')
    Add Services - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    @if ($service_type == 'Grooming')
                        Add Grooming Services
                    @else
                        Add Konsultasi Services
                    @endif
                </h1>
                <br>
            </div>
            <br>

            <form method="post" action="/manage/services/add/proses" enctype="multipart/form-data">
                @csrf

                {{-- jika admin --}}
                @if (Auth::user()->role_id == 1)
                    <div class="form-group">
                        <label for="user_id_pet_shop">{{ __('Pet Shop ID*') }}</label>
                        <select name="user_id_pet_shop" id="user_id_pet_shop" class="form-control form-select @error('user_id_pet_shop') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
                            @foreach ($dataPetShop as $dataPetShops)
                                <option value="{{ $dataPetShops->id }}" id="">{{ $dataPetShops->id.' - ('.$dataPetShops->name.')' }}</option>
                            @endforeach
                        </select>
                        @error('user_id_pet_shop')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                {{-- jika pet shop--}}
                @else
                    <input name="user_id_pet_shop" type="number" id="user_id_pet_shop" hidden value="{{ $userID }}">
                @endif

                <div class="form-group">
                    <label for="service_name">{{ __('Service Name *') }}</label>
                    <input name="service_name" type="text" class="form-control @error('service_name') is-invalid @enderror" id="service_name" placeholder="Name" value="{{ old('service_name') }}">
                    @error('service_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="service_price">{{ __('Price *') }}</label>
                    <input name="service_price" type="number" class="form-control @error('service_price') is-invalid @enderror" id="service_price" placeholder="Price" value="{{ old('service_price') }}">
                    @error('service_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- jika grooming --}}
                @if ($service_type == 'Grooming')
                    <input name="service_type" type="text" id="service_type" hidden value="Grooming">
                {{-- jika konsultasi --}}
                @else
                    <input name="service_type" type="text" id="service_type" hidden value="Konsultasi">

                    <div class="form-group">
                        <label for="doctor_name">{{ __('Doctor Name *') }}</label>
                        <input name="doctor_name" type="text" class="form-control @error('doctor_name') is-invalid @enderror" id="doctor_name" placeholder="Nama Dokter" value="{{ old('doctor_name') }}">
                        @error('doctor_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label for="doctor_photo">{{ __('Doctor Photo *') }}</label>
                        <input name="doctor_photo" type="file" class="form-control @error('doctor_photo') is-invalid @enderror" id="doctor_photo" value="{{ old('doctor_photo') }}">
                        @error('doctor_photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                @endif


                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Add') }}
                    </button>
                </div>
                <br>
            </form>
        </div>
    </div>
@endsection
