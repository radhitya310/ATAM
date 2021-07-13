@extends('layouts.app')

@section('title')
    Edit My Pet Status - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Edit Pet
                </h1>
            </div>
            @foreach ($pet as $pets)
                <form method="post" action="/status/pet-adoption/update/{{ $pets->pet_id }}" enctype="multipart/form-data">
                    @csrf

                    <div class="classFoto">
                        <img src="{{ asset('gambar/pet/'.$pets->pet_image) }}" alt="gambar_pet" class="rounded-circle" width="250px" height="250px">
                    </div>

                    <div class="form-group">
                        <input name="user_id" type="text" class="form-control" id="user_id" hidden value="{{ $pets->user_id }}">
                    </div>

                    <div class="form-group mt-4">
                        <label for="pet_name">{{ __('Name *') }}</label>
                        <input name="pet_name" type="text" class="form-control @error('pet_name') is-invalid @enderror" id="pet_name" placeholder="Pet Name" value="{{ $pets->pet_name }}">
                        {{-- <span style="color: grey; font-size: 10px">Hindari penggunaan nama yang sama karena foto akan ter-replace</span> --}}
                        @error('pet_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row form-row">
                        <div class="form-group col-sm-4">
                            <label for="species_id">{{ __('Species *') }}</label>
                            <select name="species_id" id="species_id" class="form-control form-select @error('species_id') is-invalid @enderror">
                                <option hidden value="{{ $pets->species_id }}">{{ $pets->species_name }}</option>
                                @foreach ($species as $specieses)
                                    <option value="{{ $specieses->species_id }}" id="">{{ $specieses->species_name }}</option>
                                @endforeach
                            </select>
                            @error('species_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="breed_id">{{ __('Breed *') }}</label>
                            <select name="breed_id" id="breed_id" class="form-control form-select @error('breed_id') is-invalid @enderror">
                                <option hidden value="{{ $pets->breed_id }}">{{ $pets->breed_category }}</option>
                                @foreach ($breed as $breeds)
                                    <option value="{{ $breeds->breed_id }}" id="">{{ $breeds->breed_category }}</option>
                                @endforeach
                            </select>
                            @error('breed_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="sex_id">{{ __('Sex *') }}</label>
                            <select name="sex_id" id="sex_id" class="form-control form-select @error('sex_id') is-invalid @enderror">
                                <option hidden value="{{ $pets->sex_id }}">{{ $pets->sex_name }}</option>
                                @foreach ($sex as $sexs)
                                    <option value="{{ $sexs->sex_id }}" id="">{{ $sexs->sex_name }}</option>
                                @endforeach
                            </select>
                            @error('sex_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-row">
                        <div class="form-group col-sm-4">
                            <label for="age_id">{{ __('Age *') }}</label>
                            <select name="age_id" id="age_id" class="form-control form-select @error('age_id') is-invalid @enderror">
                                <option hidden value="{{ $pets->age_id }}">{{ $pets->age_category }}</option>
                                @foreach ($age as $ages)
                                    <option value="{{ $ages->age_id }}" id="">{{ $ages->age_category }}</option>
                                @endforeach
                            </select>
                            @error('age_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="source_id">{{ __('Source *') }}</label>
                            <select name="source_id" id="source_id" class="form-control form-select @error('source_id') is-invalid @enderror">
                                <option hidden value="{{ $pets->source_id }}">{{ $pets->source_name }}</option>
                                @foreach ($source as $sources)
                                    <option value="{{ $sources->source_id }}" id="">{{ $sources->source_name }}</option>
                                @endforeach
                            </select>
                            @error('source_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group col-sm-4">
                            <label for="vaccine_id">{{ __('Vaccine *') }}</label>
                            <select name="vaccine_id" id="vaccine_id" class="form-control form-select @error('vaccine_id') is-invalid @enderror">
                                <option hidden value="{{ $pets->vaccine_id }}">{{ $pets->vaccine_status }}</option>
                                @foreach ($vaccine as $vaccines)
                                    <option value="{{ $vaccines->vaccine_id }}" id="">{{ $vaccines->vaccine_status }}</option>
                                @endforeach
                            </select>
                            @error('vaccine_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group input_style">
                        <label for="sterilization_id">{{ __('Sterilization *') }}</label>
                        <select name="sterilization_id" id="sterilization_id" class="form-control form-select @error('sterilization_id') is-invalid @enderror">
                            <option hidden value="{{ $pets->sterilization_id }}">{{ $pets->sterilization_status }}</option>
                            @foreach ($sterilization as $sterilizations)
                                <option value="{{ $sterilizations->sterilization_id }}" id="">{{ $sterilizations->sterilization_status }}</option>
                            @endforeach
                        </select>
                        @error('sterilization_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pet_description">{{ __('Description *') }}</label>
                        <textarea name="pet_description" id="pet_description" class="form-control @error('pet_description') is-invalid @enderror" cols="30" rows="4" placeholder="Pet Description">{{ $pets->pet_description }}</textarea>
                        @error('pet_description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div hidden>
                        {{-- untuk status --}}
                        <input name="status" type="number" id="status" value="{{ $pets->status }}">
                    </div>

                    <div class="form-group">
                        <label for="pet_image">{{ __('Change Photo') }}</label>
                        <input name="pet_image" type="file" class="form-control @error('pet_image') is-invalid @enderror" id="pet_image">
                        <span style="font-size: 10px; color: grey">Kosongkan foto jika tidak ingin diubah</span>
                        @error('pet_image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
    </div>
@endsection

