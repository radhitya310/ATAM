@extends('layouts.app')

@section('title')
    Manage Pet - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="title_body">
            <h1>
                Manage Pet
            </h1>
            <br>
        </div>

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
            <form action="/manage/pet/search" method="get">
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
                                <a href="/manage/pet">
                                    <button type="button" class="btn btn-danger" aria-hidden="true">
                                        &times;
                                    </button>
                                </a>
                            </div>
                        @endif

                        <input type="text" name="type" hidden value="managePet">
                    </div>
                </center>
            </form>
        </div>
        <br>

        {{-- <div class="button_add">
            <button type="submit" class="btn btn-primary">
                <a href="/manage/pet/add">
                    <i class="far fa-plus-square"></i>
                    Add
                </a>
            </button>
        </div> --}}

        @if ($typeData == 'search')
            <div class="table-responsive manageSearch">
        @else
            <div class="table-responsive">
        @endif
                <table class="table table-hover table-borderless">
                    <thead class="table-dark">
                        <th>No.</th>
                        <th>User ID</th>
                        <th>Pet ID</th>
                        <th>Pet Name</th>
                        <th>Breed</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th></th>
                    </thead>

                    @if ($pet->count() == 0)
                        <tbody>
                            <tr>
                                <td colspan="8">
                                    {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                    <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                </td>
                            </tr>
                        </tbody>
                    @endif

                    @foreach ($pet as $pets)
                        @if ($pets->status == 'Mark as Adopted')
                            <tbody class="bg-success">
                        @else
                            <tbody class="bg-light">
                        @endif
                                <tr>
                                    {{-- versi CodeIgniter --}}
                                    {{-- <td><?=$inc++?></td> --}}
                                    <td>{{$inc++}}</td>
                                    @if ($pets->user_id == null)
                                        <td></td>
                                    @else
                                        <td>{{$pets->user_id}}</td>
                                    @endif
                                    <td>{{$pets->pet_id}}</td>
                                    <td>{{$pets->pet_name}}</td>
                                    <td>{{$pets->breed_category}}</td>
                                    <td>
                                        <img src="{{ url('/gambar/pet/'. $pets->pet_image) }}" width="150px" height="150px" alt="gambar">
                                    </td>
                                    <td>{{$pets->status}}</td>
                                    <td>
                                        {{-- <form method="put" action="/manage/pet/edit/pet_ID={{$pets->pet_id}}">
                                            <button type="submit" id="" class="btn btn-warning">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </button>
                                        </form> --}}
                                        <button type="submit" title="Delete" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$pets->pet_id}}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                    @endforeach
                </table>
            </div>
        @if ($typeData == 'managePet')
            {{ $pet->links() }}
            <br>
            <br>
        @endif

        <!-- menggunakan Modal untuk button delete -->
        @foreach ($pet as $pets)
            <div class="modal fade" id="delete{{ $pets->pet_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
            {{-- <div class="modal fade" id="delete{{ $pets->pet_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true"> --}}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="deleteLabel">Delete Pet Adoption</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        </button>
                        </div>
                        <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Melakukan Delete Pet (Pet ID = '.$pets->pet_id.')?')}}
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            {{'No'}}
                        </button>
                        <form method="delete" action="/manage/pet/delete/{{$pets->pet_id}}">
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
