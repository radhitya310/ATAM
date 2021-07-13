@extends('layouts.app')

@section('title')
    Manage User - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="title_body">
            <h1>
                Manage User
            </h1>
            <br>
        </div>

        {{-- tag php versi 1--}}
        {{-- <?php
            // $inc = 1;
        ?> --}}

        {{-- tag php versi 2--}}
        @php
            $inc = 1;
        @endphp

        @if (session('message'))
            <div class="alert alert-success text-center">
                {{session('message')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                    {{-- &times; --}}
                </button>
            </div>
        @endif

        <div class="wadah_button_search_style">
            <form action="/manage/user/search" method="get">
                <center>
                    <div class="row form-row">
                        <div class="col-sm-5 pb-2">
                            <div class="row">
                                <div class="col-2">
                                    <button class="btn btn-outline-success" type="submit">
                                        <i class="fas fa-search"></i>
                                        {{-- Search --}}
                                    </button>
                                </div>
                                <div class="col-10">
                                    <input name="search" id="search" class="form-control @error('search') is-invalid @enderror" type="text" placeholder="Type to Search" aria-label="Search" value="{{$data}}">
                                    @error('search')
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($data != null)
                            <div class="col-sm-1">
                                <a href="/manage/user">
                                    <button type="button" class="btn btn-danger" aria-hidden="true">
                                        &times;
                                    </button>
                                </a>
                            </div>
                        @endif

                        <input type="text" name="type" hidden value="manageUser">
                    </div>
                </center>
            </form>
        </div>

        <div class="button_add">
            <button type="submit" title="Add" class="btn btn-primary">
                <a href="/manage/user/add">
                    <i class="far fa-plus-square"></i>
                </a>
            </button>
        </div>

        {{-- <button type="submit">Add User</button> --}}
        @if ($typeData == 'search')
            <div class="table-responsive manageSearch">
        @else
            <div class="table-responsive">
        @endif
                <table class="table table-hover table-borderless">
                    <thead class="table-dark">
                        <tr>
                            <th>No.</th>
                            <th>User ID</th>
                            <th>Role ID</th>
                            <th>Role Name</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Foto User</th>
                            <th></th>
                        </tr>
                    </thead>

                    @if ($user->count() == 0)
                        <tbody>
                            <tr>
                                <td colspan="8">
                                    {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                    <div class="text-center">
                                        <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @endif

                    @foreach ($user as $users)
                        <tbody class="bg-light">
                            <tr>
                                <td>{{$inc++}}</td>
                                @if ($users->role_id == NULL)
                                    <td>{{$users->id}}</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{$users->name}}</td>
                                    <td>{{$users->email}}</td>
                                    <td>
                                        <img src="{{url('gambar/foto_user_login/'.$users->user_photo)}}" alt="foto_user" width="150px" height="150px">
                                    </td>
                                    {{-- @if ($users->user_photo != null)
                                    @else
                                        <td></td>
                                    @endif --}}
                                @else
                                    <td>{{$users->id}}</td>
                                    <td>{{$users->role_id}}</td>
                                    <td>{{$users->role_name}}</td>
                                    <td>{{$users->name}}</td>
                                    <td>{{$users->email}}</td>
                                    <td>
                                        <img src="{{url('gambar/foto_user_login/'.$users->user_photo)}}" alt="foto_user" width="150px" height="150px">
                                    </td>
                                    {{-- @if ($users->user_photo != null)
                                    @else
                                        <td></td>
                                    @endif --}}
                                @endif
                                <td>
                                    <form method="put" action="/manage/user/edit/user_ID={{$users->id}}">
                                        <button type="submit" title="Edit" id="" class="btn btn-warning">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </form>
                                    <button type="submit" title="Delete" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $users->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        <br>
        <br>
        @if ($typeData == 'manageUser')
            {{ $user->links() }}
            <br>
            <br>
        @endif

        <!-- menggunakan static Modal untuk button cancel -->
        @foreach ($user as $users)
            <div class="modal fade" id="delete{{ $users->id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
            {{-- <div class="modal fade" id="delete{{ $users->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelLabel">Delete User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                            </div>
                        <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Melakukan Delete User (User ID = '.$users->id.')?')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                {{'No'}}
                            </button>
                            <form method="delete" action="/manage/user/delete/{{$users->id}}">
                                <button type="submit" class="btn btn-primary">
                                    {{'Yes'}}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection
