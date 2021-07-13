@extends('layouts.app')

@section('title')
    Manage Services - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="title_body">
            <h1>
                Manage Services
            </h1>
            <br>
        </div>

        @php
            $inc = 1;
        @endphp

        @if (session('message'))
            <div class="alert alert-success text-center">
                {{session('message')}}
                <button class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                    {{-- &times; --}}
                </button>
            </div>
        @endif
        <div class="wadah_button_search_style">
            <form action="/manage/services/search" method="get">
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
                                <a href="/manage/services">
                                    <button type="button" class="btn btn-danger" aria-hidden="true">
                                        &times;
                                    </button>
                                </a>
                            </div>
                        @endif

                        <input type="text" name="type" hidden value="manageServices">
                    </div>
                </center>
            </form>
        </div>
        <br>

        <!-- Split dropend button -->
        @if (!Auth::guest() && Auth::user()->role_id == 3)
            <div class="btn-group dropend button_add_reservation">
                <button type="button" title="Add" class="btn btn-primary">
                    <i class="far fa-plus-square"></i>
                </button>
                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropright</span>
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="/manage/services/grooming/add">Grooming</a>
                    <a class="dropdown-item" href="/manage/services/konsultasi/add">Konsultasi</a>
                </div>
            </div>
        @endif

        @if (!Auth::guest() && Auth::user()->role_id == 1)
            @if ($typeData == 'search')
                <div class="table-responsive manageSearch">
            @else
                <div class="table-responsive">
            @endif
                    <table class="table table-hover table-borderless">
                        <thead class="table-dark">
                            <th>No.</th>
                            <th>Pet Shop ID</th>
                            <th>Service ID</th>
                            <th>Service Name</th>
                            <th>Service Type</th>
                            <th>Price (Rp.)</th>
                            <th>Doctor Name</th>
                            {{-- <th>Doctor Photo</th> --}}
                            <th>Service Post Status</th>
                            <th></th>
                        </thead>

                        @if ($petShop->count() == 0)
                            <tbody>
                                <tr>
                                    <td colspan="9">
                                        <div class="text-center">
                                            <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                        </div>
                                        {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                    </td>
                                </tr>
                            </tbody>
                        @endif

                        @foreach ($petShop as $petShops)
                            <tbody class="bg-light">
                                <tr>
                                    @if ($petShops->service_post_status == "enabled")
                                        <td><?=$inc++?></td>
                                    @else
                                        <td class="bg-danger"><?=$inc++?></td>
                                    @endif
                                    @if (Auth::user()->role_id == 1)
                                        <td>{{$petShops->user_id_pet_shop}}</td>
                                        <td>{{$petShops->service_id}}</td>
                                    @endif
                                    <td>{{$petShops->service_name}}</td>
                                    <td>{{$petShops->service_type}}</td>
                                    <td>{{number_format($petShops->service_price, 0, ',', '.')}}</td>
                                    <td>{{$petShops->doctor_name}}</td>
                                    {{-- @if ($petShops->doctor_photo != null)
                                        <td>
                                            <img src="{{ url('gambar/foto_dokter/'.$petShops->doctor_photo) }}" alt="" width="150px" height="150px">
                                        </td>
                                    @else
                                        <td></td>
                                    @endif --}}
                                    <td>{{$petShops->service_post_status}}</td>
                                    @if (Auth::user()->role_id == 3)
                                        @if ($petShops->service_post_status == 'disabled')
                                            <td>
                                                <form method="put" action="/manage/services/actived/{{$petShops->service_id}}">
                                                    <button type="submit" id="" class="btn btn-success">Enable</button>
                                                </form>
                                            </td>
                                        @else
                                            <td>
                                                <form method="put" action="/manage/services/deactived/{{$petShops->service_id}}">
                                                    <button type="submit" id="" class="btn btn-danger">Disable</button>
                                                    {{-- <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nonActive{{$petShops->service_id}}">Disable</button> --}}
                                                </form>
                                            </td>
                                        @endif
                                    @endif
                                    <td>
                                        {{-- @if (Auth::user()->role_id == 3)
                                        @endif --}}
                                        {{-- <form method="put" action="/manage/services/edit/{{$petShops->service_id}}">
                                            <button type="submit" id="" class="btn btn-warning">
                                                <i class="far fa-edit"></i>
                                                Edit
                                            </button>
                                        </form> --}}
                                        <button type="submit" title="Delete" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$petShops->service_id}}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
                <br>
            @if ($typeData == 'manageServices')
                {{$petShop->links()}}
                <br>
                <br>
            @endif
        @else
            @if ($countUserIDPetShop == 0)
                <div class="table table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="table-dark">
                            <th>No.</th>
                            <th>Service Name</th>
                            <th>Service Type</th>
                            <th>Price (Rp.)</th>
                            <th>Doctor Name</th>
                            {{-- <th>Doctor Photo</th> --}}
                            <th>Service Post Status</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8">
                                    <div class="text-center">
                                        <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                    </div>
                                    {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                @if ($typeData == 'search')
                    <div class="table-responsive manageSearch">
                @else
                    <div class="table-responsive">
                @endif
                        <table class="table table-hover table-borderless">
                            <thead class="table-dark">
                                <th>No.</th>
                                <th>Service Name</th>
                                <th>Service Type</th>
                                <th>Price (Rp.)</th>
                                <th>Doctor Name</th>
                                {{-- <th>Doctor Photo</th> --}}
                                <th>Service Post Status</th>
                                <th></th>
                                <th></th>
                            </thead>

                            @if ($petShop->count() == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="8">
                                            <div class="text-center">
                                                <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                            </div>
                                            {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            @endif

                            @foreach ($petShop as $petShops)
                                <tbody class="bg-light">
                                    <tr>
                                        @if ($petShops->service_post_status == "enabled")
                                            <td><?=$inc++?></td>
                                        @else
                                            <td class="bg-danger"><?=$inc++?></td>
                                        @endif
                                        @if (Auth::user()->role_id == 1)
                                            <td>{{$petShops->user_id_pet_shop}}</td>
                                            <td>{{$petShops->service_id}}</td>
                                        @endif
                                        <td>{{$petShops->service_name}}</td>
                                        <td>{{$petShops->service_type}}</td>
                                        <td>{{number_format($petShops->service_price, 0, ',', '.')}}</td>
                                        <td>{{$petShops->doctor_name}}</td>
                                        {{-- @if ($petShops->doctor_photo != null)
                                            <td>
                                                <img src="{{ url('gambar/foto_dokter/'.$petShops->doctor_photo) }}" alt="" width="150px" height="150px">
                                            </td>
                                        @else
                                            <td></td>
                                        @endif --}}
                                        <td>{{$petShops->service_post_status}}</td>
                                        @if (Auth::user()->role_id == 3)
                                            @if ($petShops->service_post_status == 'disabled')
                                                <td>
                                                    <form method="put" action="/manage/services/actived/{{$petShops->service_id}}">
                                                        <button type="submit" id="" class="btn btn-success">Enable</button>
                                                    </form>
                                                </td>
                                            @else
                                                <td>
                                                    <form method="put" action="/manage/services/deactived/{{$petShops->service_id}}">
                                                        <button type="submit" id="" class="btn btn-danger">Disable</button>
                                                        {{-- <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#nonActive{{$petShops->service_id}}">Disable</button> --}}
                                                    </form>
                                                </td>
                                            @endif
                                        @endif
                                        <td>
                                            {{-- @if (Auth::user()->role_id == 3)
                                            @endif --}}
                                            <form method="put" action="/manage/services/edit/{{$petShops->service_id}}">
                                                <button type="submit" title="Edit" id="" class="btn btn-warning">
                                                    <i class="far fa-edit"></i>
                                                </button>
                                            </form>
                                            <button type="submit" title="Delete" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{$petShops->service_id}}">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <br>
                @if ($typeData == 'manageServices')
                    {{$petShop->links()}}
                    <br>
                    <br>
                @endif
            @endif
        @endif

        <!-- menggunakan Modal untuk button delete & non active -->
        @foreach ($petShop as $petShops)
            {{-- untuk delete services --}}
            <div class="modal fade" id="delete{{ $petShops->service_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
            {{-- <div class="modal fade" id="delete{{ $petShops->service_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="cancelLabel">Delete Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        </button>
                        </div>
                        <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Melakukan Delete Service (Service Name = '.$petShops->service_name.')?')}}
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            {{'No'}}
                        </button>
                        <form method="delete" action="/manage/services/delete/{{$petShops->service_id}}">
                            <button type="submit" class="btn btn-primary">
                                {{'Yes'}}
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- untuk non-active services --}}
            {{-- <div class="modal fade" id="nonActive{{ $petShops->service_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="cancelLabel">Disable Service</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Melakukan Disable Service (Service Name = '.$petShops->service_name.')?')}}
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            {{'No'}}
                        </button>
                        <form method="put" action="/manage/services/deactived/{{$petShops->service_id}}">
                            <button type="submit" class="btn btn-primary">
                                {{'Yes'}}
                            </button>
                        </form>
                        </div>
                    </div>
                </div>
            </div> --}}
        @endforeach
    </div>
@endsection
