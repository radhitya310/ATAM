@extends('layouts.app')

@section('title')
    Add Pet - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Add Pet
                </h1>
                <br>
            </div>
            <br>
            <form method="post" action="/manage/pet/add/proses" enctype="multipart/form-data">
                @csrf

                {{-- masukkin user ID nya --}}
                {{-- <input type="number" name="user_id" id="user_id" value="{{Auth::user()->id}}" hidden> --}}
                <div class="form-group">
                    <label for="user_id">{{ __('Pet Owner *') }}</label>
                    <select name="user_id" id="user_id" class="form-control form-select @error('user_id') is-invalid @enderror" autofocus>
                        <option hidden value="">Choose...</option>
                        @foreach ($user as $users)
                            <option value="{{ $users->id }}" id="">{{ $users->id.' - ('.$users->name.')' }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                {{-- <div class="form-group">
                    <label for="user_id_adopter">{{ __('ID Adopter') }}</label>
                    <select name="user_id_adopter" id="user_id_adopter" class="form-control @error('user_id_adopter') is-invalid @enderror">
                        <option hidden value="">Choose..</option>
                            @foreach ($user as $users)
                                <option value="{{ $users->id }}" id="">{{ $users->id.' - ('.$users->name.')' }}</option>
                            @endforeach
                    </select>
                    @error('user_id_adopter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}

                <div class="form-group">
                    <label for="pet_name">{{ __('Name *') }}</label>
                    <input name="pet_name" type="text" class="form-control @error('pet_name') is-invalid @enderror" id="pet_name" placeholder="Pet Name" value="{{ old('pet_name') }}">
                    @error('pet_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row form-row">
                    <div class="form-group col-md-4">
                        <label for="species_id">{{ __('Species *') }}</label>
                        <select name="species_id" id="species_id" class="form-control form-select @error('species_id') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
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
                    <div class="form-group col-md-4">
                        <label for="breed_id">{{ __('Breed *') }}</label>
                        <select name="breed_id" id="breed_id" class="form-control form-select @error('breed_id') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
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
                    <div class="form-group col-md-4">
                        <label for="sex_id">{{ __('Sex *') }}</label>
                        <select name="sex_id" id="sex_id" class="form-control form-select @error('sex_id') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
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
                    <div class="form-group col-md-4">
                        <label for="age_id">{{ __('Age *') }}</label>
                        <select name="age_id" id="age_id" class="form-control form-select @error('age_id') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
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
                    <div class="form-group col-md-4">
                        <label for="source_id">{{ __('Source *') }}</label>
                        <select name="source_id" id="source_id" class="form-control form-select @error('source_id') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
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
                    <div class="form-group col-md-4">
                        <label for="vaccine_id">{{ __('Vaccine *') }}</label>
                        <select name="vaccine_id" id="vaccine_id" class="form-control form-select @error('vaccine_id') is-invalid @enderror">
                            <option hidden value="">Choose...</option>
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
                        <option hidden value="">Choose...</option>
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
                    <textarea name="pet_description" id="pet_description" class="form-control @error('pet_description') is-invalid @enderror" cols="30" rows="4" placeholder="Pet Description">{{ old('pet_description') }}</textarea>
                    @error('pet_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <input type="text" name="status" id="status" hidden value="Request for Adopt">

                <div class="form-group">
                    <label for="pet_image">{{ __('Image *') }}</label>
                    <input name="pet_image" type="file" class="form-control @error('pet_image') is-invalid @enderror" id="pet_image">
                    @error('pet_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
