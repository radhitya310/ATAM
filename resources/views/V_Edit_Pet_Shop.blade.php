@extends('layouts.app')

@section('title')
    Edit Status Pet Shop - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1 col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Edit Status Pet Shop
                </h1>
            </div>
            <br>

            @foreach ($user as $users)
                <form method="post" action="/profile/edit-status-pet-shop/update/{{$users->id}}" enctype="multipart/form-data">
                    @csrf

                    {{-- <input name="role_id" id="role_id" type="text" hidden value="{{$users->role_id}}"> --}}

                    <input name="user_id" type="number" id="" hidden value="{{$users->id}}">

                    <div class="form-group">
                        <label for="openPetShop">{{ __('Open Hours *') }}</label>
                        {{-- <textarea name="openPetShop" id="" cols="30" rows="6" class="shadow form-control @error('openPetShop') is-invalid @enderror" placeholder="Status Pet Shop" autocomplete="name" autofocus>{{ $users->open_hour_pet_shop }}</textarea> --}}
                        <input name="openPetShop" type="text" class="shadow form-control @error('openPetShop') is-invalid @enderror" id="name" placeholder="Open Pet Shop" autocomplete="openPetShop" value="{{ $users->open_hour_pet_shop }}" autofocus>
                        @error('openPetShop')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="moreStatusPetShop">{{ __('More Status') }}</label>
                        <textarea name="moreStatusPetShop" id="" cols="30" rows="6" class="shadow form-control @error('moreStatusPetShop') is-invalid @enderror" placeholder="More Status Pet Shop" autocomplete="name" autofocus>{{ $users->more_status_pet_shop }}</textarea>
                        {{-- <input name="moreStatusPetShop" type="text" class="shadow form-control @error('moreStatusPetShop') is-invalid @enderror" id="name" placeholder="Status Pet Shop" autocomplete="name" value="{{ $users->more_status_pet_shop }}" autofocus> --}}
                        @error('moreStatusPetShop')
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
                </form>
                <br>
            @endforeach
        </div>
    </div>
@endsection
