@extends('layouts.app')

@section('title')
    Login - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="col1_1_login col-md-8 mx-auto text-center">
            <div class="title_body">
                <h1>
                    Login
                </h1>
                <br>
            </div>
            <br>

            @if (session('message'))
                <div class="alert alert-success">
                    {{session('message')}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                        {{-- &times; --}}
                    </button>
                </div>
            @endif

            {{-- panggil semua message error validation   --}}
            <div class="errorMessage">
                {{-- @if($errors)
                    <ul class="alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif --}}
                @if($errors)
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">
                            <li>
                                {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                                    {{-- &times; --}}
                                </button>
                            </li>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- <form method="post" action="{{ route('login') }}" enctype="multipart/form-data"> --}}
            <form method="post" action="/login/proses" enctype="multipart/form-data">
                @csrf

                @php
                    $linkPreviousPages = url()->previous();
                @endphp

                <input name="linkPreviousPage" type="text" hidden value="{{$linkPreviousPages}}">

                <div class="form-group">
                    <label for="exampleInputEmail1">Email address *</label>
                    <div class="row">
                        <div class="col-12">
                            <input name="email" type="email" id="email" class="shadow form-control @error('email') is-invalid @enderror" placeholder="Enter email" autofocus value="{{ old('email') }}">
                        </div>
                    </div>
                    {{-- @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror --}}
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password *</label>
                    <div class="row">
                        <div class="col-12">
                            <input name="password" type="password" id="password" class="shadow form-control @error('password') is-invalid @enderror" placeholder="Password">
                            <span class="fas fa-eye field-icon css_iconEye" id="togglePassword1"></span>
                        </div>
                        {{-- <div class="col-1">
                            <span class="fas fa-eye field-icon" id="togglePassword1"></span>
                        </div> --}}
                    </div>
                    {{-- @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror --}}
                </div>
                {{-- <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    @error('check_me')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}
                {{-- <div class="form-group">
                    <input type="checkbox" class="form-check-input shadow @error('checkbox') is-invalid @enderror"" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    @error('check_me')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        {{__('Sign In')}}
                    </button>
                    {{-- untuk forgot password --}}
                    {{-- @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif --}}
                </div>

                <div class="form-group pb-4">
                    {{-- untuk direct ke register form --}}
                    <a class="btn btn-link" href="/register">
                        {{ __('Belum punya akun?') }}
                    </a>
                </div>
            </form>
        </div>

        {{-- untuk show hide password --}}
        <script src="/js/showHidePass.js" defer></script>
    </div>

@endsection
