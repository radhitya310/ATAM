@extends('layouts.app')

@section('title')
    Manage Order - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="title_body">
            <h1>
                Manage Order
            </h1>
            <br>
        </div>

        @php
            $inc = 1;
            // $userID = Auth::user()->id;
            $karakter = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $random_angka = rand(10000, 99999);
            $random_huruf = substr(str_shuffle($karakter), 0, 5);
            // rand();
            // mt_rand();
            // random_int(valueMin, valueMax)
            // rand(valueMin, valueMax);
        @endphp

        {{-- untuk ambil pesan message dari controller nya --}}
        @if (session('message'))
            <div class="alert alert-success text-center">
                {{session('message')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                    {{-- &times; --}}
                </button>
            </div>
        @endif
        <div class="wadah_button_search_style">
            <form action="/manage/order/search" method="get">
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
                                    <input name="search" id="search" class="form-control @error('search') is-invalid @enderror" type="text" placeholder="Type to Search" aria-label="Search" value="{{$data1}}">
                                    @error('search')
                                        <span class="invalid-feedback text-center" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if ($data1 != null)
                            <div class="col-sm-1">
                                <a href="/manage/order">
                                    <button type="button" class="btn btn-danger ms-2" aria-hidden="true">
                                        &times;
                                    </button>
                                </a>
                            </div>
                        @endif

                        <input type="text" name="type" hidden value="manageOrder">
                    </div>
                </center>
            </form>
        </div>
        <br>

        @if (!Auth::guest() && Auth::user()->role_id == 1)
            @if ($typeData == 'search')
                <div class="table table-responsive manageSearch">
            @else
                <div class="table table-responsive">
            @endif
                    <div class="accordion" id="accordionExamples">
                        <table class="table table-hover table-borderless">
                            <thead class="table-dark">
                                <tr>
                                    <th>No.</th>
                                    <th>Service ID</th>
                                    <th>Reservation ID</th>
                                    <th>Reservation Name</th>
                                    <th>Transaction ID</th>
                                    <th>Transaction Date</th>
                                    {{-- <th>Transaction Name</th> --}}
                                    <th>Service Name</th>
                                    {{-- <th>Quantity</th> --}}
                                    <th>Service Time</th>
                                    {{-- <th>SubTotal (Rp.)</th> --}}
                                    <th>Total Price (Rp.)</th>
                                    <th>Status</th>
                                    {{-- <th>Reservation Code</th> --}}
                                    <th></th>
                                </tr>
                            </thead>

                            @if ($data->count() == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="11">
                                            <div class="text-center">
                                                <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                            </div>
                                            {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                        </td>
                                    </tr>
                                </tbody>
                            @endif

                            @foreach ($data as $datas)
                                @if ($datas->status == 'Accepted')
                                    <tbody class="bg-success">
                                @endif
                                @if ($datas->status == 'Waiting')
                                    <tbody class="bg-warning">
                                @endif
                                @if ($datas->status == 'Canceled' || $datas->status == 'Rejected')
                                    <tbody class="bg-danger">
                                @endif
                                        <tr>
                                            <td>{{$inc++}}</td>
                                            {{-- @if (Auth::user()->role_id == 1) --}}
                                                <td>{{$datas->service_id}}</td>
                                                <td>{{ $datas->user_id }}</td>
                                                @foreach ($dataUser as $dataUsers)
                                                    @if ($datas->user_id == $dataUsers->id)
                                                        <td>{{ $datas->name }}</td>
                                                    @endif
                                                @endforeach
                                                <td>{{ $datas->transaction_id }}</td>
                                            {{-- @else
                                                @foreach ($dataUser as $dataUsers)
                                                    @if ($datas->user_id == $dataUsers->id)
                                                        <td>{{ $datas->name }}</td>
                                                    @endif
                                                @endforeach
                                            @endif --}}
                                            <td>{{ $datas->transaction_date }}</td>
                                            {{-- <td>{{ $datas->transaction_name }}</td> --}}
                                            <td>{{ $datas->service_name }}</td>
                                            {{-- <td>{{ $datas->quantity }}</td> --}}
                                            <td>{{ $datas->time }}</td>
                                            {{-- <td>{{ number_format($datas->quantity*$datas->service_price, 0, ',', '.') }}</td> --}}
                                            <td>{{ number_format($datas->total_price, 0, ',', '.') }}</td>
                                            <td>{{ $datas->status }}</td>
                                            {{-- <td>{{ $datas->reservation_code }}</td> --}}
                                            <td>
                                                {{-- <form method="put" action="/transaction/detail/{{ $datas->transaction_id }}">
                                                    <button type="submit" id="" class="btn btn-info">Detail</button>
                                                </form> --}}
                                                <button type="submit" title="Detail" id="" class="btn btn-info dropdown-toggle" data-bs-toggle="collapse" href="#collapseExample{{ $datas->transaction_id }}" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                {{-- jika pet shop --}}
                                                {{-- @if (!Auth::guest() && Auth::user()->role_id == 3) --}}
                                                    {{-- @if ($datas->status == 'Waiting')
                                                        <button type="submit" id="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                        <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                    @endif --}}
                                                {{-- jika admin --}}
                                                {{-- @else --}}
                                                    {{-- @if ($datas->status != 'Waiting' && $datas->status != 'Canceled' && $datas->status != 'Accepted' && $datas->status != 'Rejected')
                                                        <form method="put" action="/transaction/confirm/{{ $datas->transaction_id }}" hidden>
                                                            @csrf
                                                            <input type="number" name="totalPrice" value="{{ $datas->quantity*$datas->service_price }}">
                                                            <button type="submit" id="clickButtonConfirm" class="btn btn-success">Confirm</button>
                                                        </form>
                                                    @endif --}}
                                                    {{-- @if ($datas->status == 'Rejected')
                                                        <button type="submit" id="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                    @endif
                                                    @if ($datas->status == 'Approved')
                                                        <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                    @endif --}}
                                                {{-- @endif --}}
                                            </td>
                                        </tr>
                                        <tr class="collapse detailTransaction bg-light" id="collapseExample{{ $datas->transaction_id }}" data-bs-parent="#accordionExamples">
                                            <td colspan="11">
                                                <div class="p-2">
                                                    {{-- untuk reservation code nya --}}
                                                    <div class="table table-responsive">
                                                        <table class="table table-hover table-borderless">
                                                            <tr class="text-danger">
                                                                <td class="w-50"><h2>Reservation Code</h2></td>
                                                                <td><h2>:</h2></td>
                                                                <td>
                                                                    <h2>
                                                                        {{ $datas->reservation_code }}
                                                                    </h2>
                                                                </td>
                                                            </tr>
                                                            @if ($datas->status != 'Waiting')
                                                                <tr>
                                                                    @if ($datas->status == 'Accepted' || $datas->status == 'Rejected')
                                                                        <td><h4>Message's From Pet Shop</h4></td>
                                                                    @else
                                                                        <td><h4>Message's From Customer</h4></td>
                                                                    @endif
                                                                    <td><h4>:</h4></td>
                                                                    <td>
                                                                        <h4>
                                                                            {{$datas->reason}}
                                                                        </h4>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                    {{-- <div class="reservation_code">
                                                        <h1 class="text-danger">Reservation Code : {{ $datas->reservation_code }}</h1>
                                                    </div> --}}
                                                    <div class="divider"></div>
                                                    <br>

                                                    <div class="table-responsive table_detail_trans">
                                                        <table class="table table-dark">
                                                            <tbody>
                                                                <tr>
                                                                    <td  class="w-50">Status</td>
                                                                    <td>:</td>
                                                                    @if ($datas->status == 'Accepted')
                                                                        <td class="bg-success">
                                                                    @endif
                                                                    @if ($datas->status == 'Waiting')
                                                                        <td class="bg-warning text-dark">
                                                                    @endif
                                                                    @if ($datas->status == 'Canceled' || $datas->status == 'Rejected')
                                                                        <td class="bg-danger">
                                                                    @endif
                                                                            {{ $datas->status }}
                                                                        </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td class="detail_column">Transaction ID</td>
                                                                    <td class="detail_column_2">:</td>
                                                                    <td>
                                                                        {{ $datas->transaction_id }}
                                                                    </td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td>Transaction Name</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ $datas->transaction_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transaction Date</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ $datas->transaction_date }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pet Shop Name</td>
                                                                    <td>:</td>
                                                                    @foreach ($dataUser as $dataUsers)
                                                                        @if ($datas->user_id_pet_shop == $dataUsers->id)
                                                                            <td>
                                                                                {{ $dataUsers->name }}
                                                                            </td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                                <tr>
                                                                    <td>Reservation Name</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ $datas->name }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    {{-- <div class="table-responsive table_detail_trans">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="detail_column">Reservation ID</td>
                                                                    <td class="detail_column_2">:</td>
                                                                    <td>
                                                                        {{ $datas->user_id }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="detail_column">Reservation Name</td>
                                                                    <td class="detail_column_2">:</td>
                                                                    <td>
                                                                        {{ $datas->name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pet Shop ID</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ $datas->user_id_pet_shop }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Pet Shop Name</td>
                                                                    <td>:</td>
                                                                    @foreach ($dataUser as $dataUsers)
                                                                        @if ($datas->user_id_pet_shop == $dataUsers->id)
                                                                            <td>
                                                                                {{ $dataUsers->name }}
                                                                            </td>
                                                                        @endif
                                                                    @endforeach
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> --}}

                                                    {{-- untuk random reservation_code --}}
                                                    @php
                                                        $random = rand(10000, 99999);
                                                        // rand();
                                                        // mt_rand();
                                                        // random_int(valueMin, valueMax)
                                                        // rand(valueMin, valueMax);
                                                    @endphp

                                                    <div class="table-responsive table_detail_trans_2">
                                                        <table class="table">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="detail_column w-50">Service Time</td>
                                                                    <td class="detail_column_2">:</td>
                                                                    <td>
                                                                        {{ $datas->time }}
                                                                    </td>
                                                                </tr>
                                                                {{-- <tr>
                                                                    <td class="detail_column">Service ID</td>
                                                                    <td class="detail_column_2">:</td>
                                                                    <td>
                                                                        {{ $datas->service_id }}
                                                                    </td>
                                                                </tr> --}}
                                                                <tr>
                                                                    <td>Service Name</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ $datas->service_name }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Quantity</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ $datas->quantity }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>SubTotal</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        {{ 'Rp. '.number_format($datas->service_price,0,',','.') }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    @if ($datas->status != null)
                                                                        <td>Total</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ 'Rp. '.number_format($datas->total_price,0,',','.') }}
                                                                        </td>
                                                                    @else
                                                                        <td>Total</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ 'Rp. '.number_format($datas->quantity*$datas->service_price,0,',','.') }}
                                                                        </td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="wadah_button_detail_trans">
                                                        @if (Auth::user()->role_id == 1)
                                                            @if ($datas->status == 'Waiting')
                                                                {{-- <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#cancel{{ $datas->transaction_id }}">Cancel</button> --}}
                                                                <button type="submit" id="" class="btn btn-success button_trans" data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                                <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                            @endif
                                                            @if ($datas->status == 'Accepted')
                                                                <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                            @endif
                                                            @if ($datas->status == 'Rejected')
                                                                <button type="submit" id="" class="btn btn-success button_trans"  data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                            @endif
                                                        @else
                                                            @if ($datas->status == 'Waiting' && $userID == $datas->user_id)
                                                                <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#cancel{{ $datas->transaction_id }}">Cancel</button>
                                                            @endif
                                                            @if ($datas->status == 'Waiting' && $userID == $datas->user_id_pet_shop)
                                                                {{-- <button type="submit" id="clickButton" class="btn btn-primary" hidden>Confirm</button> --}}
                                                                <button type="submit" id="" class="btn btn-success button_trans"  data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                                <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <br>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <br>
            @if ($typeData == 'manageOrder')
                {{ $data->links() }}
                <br>
                <br>
            @endif
        @else
            @if ($countUserIDPetShop == 0)
                <div class="table table-responsive">
                    <table class="table table-borderless table-hover">
                        <thead class="table-dark">
                            <th>No.</th>
                            <th>Reservation Name</th>
                            <th>Transaction Date</th>
                            <th>Service Name</th>
                            <th>Service Time</th>
                            <th>Total Price (Rp.)</th>
                            <th>Status</th>
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
                    <div class="table table-responsive manageSearch">
                @else
                    <div class="table table-responsive">
                @endif
                        <div class="accordion" id="accordionExamples">
                            <table class="table table-hover table-borderless">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No.</th>
                                        <th>Reservation Name</th>
                                        <th>Transaction Date</th>
                                        {{-- <th>Transaction Name</th> --}}
                                        <th>Service Name</th>
                                        {{-- <th>Quantity</th> --}}
                                        <th>Service Time</th>
                                        {{-- <th>SubTotal (Rp.)</th> --}}
                                        <th>Total Price (Rp.)</th>
                                        <th>Status</th>
                                        {{-- <th>Reservation Code</th> --}}
                                        <th></th>
                                    </tr>
                                </thead>

                                @if ($data->count() == 0)
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

                                @foreach ($data as $datas)
                                    @if ($datas->user_id_pet_shop == $userID)
                                        @if ($datas->status == 'Accepted')
                                            <tbody class="bg-success">
                                        @endif
                                        @if ($datas->status == 'Waiting')
                                            <tbody class="bg-warning">
                                        @endif
                                        @if ($datas->status == 'Canceled' || $datas->status == 'Rejected')
                                            <tbody class="bg-danger">
                                        @endif
                                            <tr>
                                                <td>{{$inc++}}</td>
                                                {{-- @if (Auth::user()->role_id == 1)
                                                    <td>{{$datas->service_id}}</td>
                                                    <td>{{ $datas->user_id }}</td>
                                                    @foreach ($dataUser as $dataUsers)
                                                        @if ($datas->user_id == $dataUsers->id)
                                                            <td>{{ $datas->name }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $datas->transaction_id }}</td>
                                                @else --}}
                                                    @foreach ($dataUser as $dataUsers)
                                                        @if ($datas->user_id == $dataUsers->id)
                                                            <td>{{ $datas->name }}</td>
                                                        @endif
                                                    @endforeach
                                                {{-- @endif --}}
                                                <td>{{ $datas->transaction_date }}</td>
                                                {{-- <td>{{ $datas->transaction_name }}</td> --}}
                                                <td>{{ $datas->service_name }}</td>
                                                {{-- <td>{{ $datas->quantity }}</td> --}}
                                                <td>{{ $datas->time }}</td>
                                                {{-- <td>{{ number_format($datas->quantity*$datas->service_price, 0, ',', '.') }}</td> --}}
                                                <td>{{ number_format($datas->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $datas->status }}</td>
                                                {{-- <td>{{ $datas->reservation_code }}</td> --}}
                                                <td>
                                                    {{-- <form method="put" action="/transaction/detail/{{ $datas->transaction_id }}">
                                                        <button type="submit" id="" class="btn btn-info">Detail</button>
                                                    </form> --}}

                                                    <button type="submit" title="Detail" id="" class="btn btn-info dropdown-toggle" data-bs-toggle="collapse" href="#collapseExample{{ $datas->transaction_id }}" aria-expanded="false" aria-controls="collapseExample">
                                                        <i class="fas fa-info-circle"></i>
                                                    </button>

                                                    {{-- jika pet shop --}}
                                                    {{-- @if (!Auth::guest() && Auth::user()->role_id == 3) --}}

                                                        {{-- @if ($datas->status == 'Waiting')
                                                            <button type="submit" id="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                            <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                        @endif --}}

                                                    {{-- jika admin --}}
                                                    {{-- @else --}}
                                                        {{-- @if ($datas->status != 'Waiting' && $datas->status != 'Canceled' && $datas->status != 'Accepted' && $datas->status != 'Rejected')
                                                            <form method="put" action="/transaction/confirm/{{ $datas->transaction_id }}" hidden>
                                                                @csrf
                                                                <input type="number" name="totalPrice" value="{{ $datas->quantity*$datas->service_price }}">
                                                                <button type="submit" id="clickButtonConfirm" class="btn btn-success">Confirm</button>
                                                            </form>
                                                        @endif --}}
                                                        {{-- @if ($datas->status != 'Accepted' && $datas->status != 'Canceled')
                                                            <button type="submit" id="" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                        @endif
                                                        @if ($datas->status != 'Rejected' && $datas->status != 'Canceled')
                                                            <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                        @endif --}}
                                                    {{-- @endif --}}
                                                </td>
                                            </tr>
                                            <tr class="collapse detailTransaction bg-light" id="collapseExample{{ $datas->transaction_id }}" data-bs-parent="#accordionExamples">
                                                <td colspan="9">
                                                    <div>
                                                        {{-- untuk reservation code nya --}}
                                                        <div class="table table-responsive">
                                                            <table class="table table-hover table-borderless">
                                                                <tr class="text-danger">
                                                                    <td class="w-50"><h2>Reservation Code</h2></td>
                                                                    <td><h2>:</h2></td>
                                                                    <td>
                                                                        <h2>
                                                                            {{ $datas->reservation_code }}
                                                                        </h2>
                                                                    </td>
                                                                </tr>
                                                                @if ($datas->status != 'Waiting')
                                                                    <tr>
                                                                        @if ($datas->status == 'Accepted' || $datas->status == 'Rejected')
                                                                            <td><h4>Message's From Pet Shop</h4></td>
                                                                        @else
                                                                            <td><h4>Message's From Customer</h4></td>
                                                                        @endif
                                                                        <td><h4>:</h4></td>
                                                                        <td>
                                                                            <h4>
                                                                                {{$datas->reason}}
                                                                            </h4>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </div>
                                                        {{-- <div class="reservation_code">
                                                            <h1 class="text-danger">Reservation Code : {{ $datas->reservation_code }}</h1>
                                                        </div> --}}
                                                        <div class="divider"></div>
                                                        <br>

                                                        <div class="table-responsive table_detail_trans">
                                                            <table class="table table-dark">
                                                                <tbody>
                                                                    <tr>
                                                                        <td  class="w-50">Status</td>
                                                                        <td>:</td>
                                                                        @if ($datas->status == 'Accepted')
                                                                            <td class="bg-success">
                                                                        @endif
                                                                        @if ($datas->status == 'Waiting')
                                                                            <td class="bg-warning text-dark">
                                                                        @endif
                                                                        @if ($datas->status == 'Canceled' || $datas->status == 'Rejected')
                                                                            <td class="bg-danger">
                                                                        @endif
                                                                                {{ $datas->status }}
                                                                            </td>
                                                                    </tr>
                                                                    {{-- <tr>
                                                                        <td class="detail_column">Transaction ID</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>
                                                                            {{ $datas->transaction_id }}
                                                                        </td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                        <td>Transaction Name</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $datas->transaction_name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Transaction Date</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $datas->transaction_date }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pet Shop Name</td>
                                                                        <td>:</td>
                                                                        @foreach ($dataUser as $dataUsers)
                                                                            @if ($datas->user_id_pet_shop == $dataUsers->id)
                                                                                <td>
                                                                                    {{ $dataUsers->name }}
                                                                                </td>
                                                                            @endif
                                                                        @endforeach
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Reservation Name</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $datas->name }}
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        {{-- <div class="table-responsive table_detail_trans">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="detail_column">Reservation ID</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>
                                                                            {{ $datas->user_id }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="detail_column">Reservation Name</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>
                                                                            {{ $datas->name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pet Shop ID</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $datas->user_id_pet_shop }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Pet Shop Name</td>
                                                                        <td>:</td>
                                                                        @foreach ($dataUser as $dataUsers)
                                                                            @if ($datas->user_id_pet_shop == $dataUsers->id)
                                                                                <td>
                                                                                    {{ $dataUsers->name }}
                                                                                </td>
                                                                            @endif
                                                                        @endforeach
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div> --}}

                                                        {{-- untuk random reservation_code --}}
                                                        @php
                                                            $random = rand(10000, 99999);
                                                            // rand();
                                                            // mt_rand();
                                                            // random_int(valueMin, valueMax)
                                                            // rand(valueMin, valueMax);
                                                        @endphp

                                                        <div class="table-responsive table_detail_trans_2">
                                                            <table class="table">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="detail_column w-50">Service Time</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>
                                                                            {{ $datas->time }}
                                                                        </td>
                                                                    </tr>
                                                                    {{-- <tr>
                                                                        <td class="detail_column">Service ID</td>
                                                                        <td class="detail_column_2">:</td>
                                                                        <td>
                                                                            {{ $datas->service_id }}
                                                                        </td>
                                                                    </tr> --}}
                                                                    <tr>
                                                                        <td>Service Name</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $datas->service_name }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Quantity</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ $datas->quantity }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>SubTotal</td>
                                                                        <td>:</td>
                                                                        <td>
                                                                            {{ 'Rp. '.number_format($datas->service_price,0,',','.') }}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        @if ($datas->status != null)
                                                                            <td>Total</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                                {{ 'Rp. '.number_format($datas->total_price,0,',','.') }}
                                                                            </td>
                                                                        @else
                                                                            <td>Total</td>
                                                                            <td>:</td>
                                                                            <td>
                                                                                {{ 'Rp. '.number_format($datas->quantity*$datas->service_price,0,',','.') }}
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="wadah_button_detail_trans">
                                                            @if (Auth::user()->role_id == 1)
                                                                @if ($datas->status == 'Waiting')
                                                                    {{-- <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#cancel{{ $datas->transaction_id }}">Cancel</button> --}}
                                                                    <button type="submit" id="" class="btn btn-success button_trans" data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                                    <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                                @endif
                                                                @if ($datas->status == 'Accepted')
                                                                    <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                                @endif
                                                                @if ($datas->status == 'Rejected')
                                                                    <button type="submit" id="" class="btn btn-success button_trans"  data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                                @endif
                                                            @else
                                                                @if ($datas->status == 'Waiting' && $userID == $datas->user_id)
                                                                    <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#cancel{{ $datas->transaction_id }}">Cancel</button>
                                                                @endif
                                                                @if ($datas->status == 'Waiting' && $userID == $datas->user_id_pet_shop)
                                                                    {{-- <button type="submit" id="clickButton" class="btn btn-primary" hidden>Confirm</button> --}}
                                                                    <button type="submit" id="" class="btn btn-success button_trans"  data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                                    <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                                @endif
                                                            @endif
                                                        </div>
                                                        <br>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <br>
                @if ($typeData == 'manageOrder')
                    {{ $data->links() }}
                    <br>
                    <br>
                @endif
            @endif
        @endif

        <!-- menggunakan Modal untuk confirm button reject dan accept  -->
        @foreach ($data as $datas)
            {{-- button accept --}}
            <div class="modal fade" id="accepted{{ $datas->transaction_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelLabel">Accept Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                        </div>
                        <form method="put" action="/transaction/approved/{{ $datas->transaction_id }}">
                            <div class="modal-body">
                                {{__('Apa Kamu Yakin Ingin Melakukan Accept Transaksi (Service Name = '.$datas->service_name.')?')}}
                                <br>
                                <br>
                                <div class="form-group p-2">
                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                    @csrf
                                    <input type="text" name="reservation_code" hidden value="{{ $datas->user_id.'-'.$random_angka.'-'.$random_huruf }}">
                                    <input name="message" type="text" class="form-control @error('message') is-invalid @enderror" id="reasonInput" placeholder="Message's to Customer.." value="{{ old('message') }}" autofocus required>
                                    <center>
                                        <span style="font-size: 10px; color: grey">Wajib diisi | Maksimal 255 karakter</span>
                                    </center>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- <span class="invalid-feedback" role="alert" id="reasonError">
                                        <strong></strong>
                                    </span> --}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    {{'Close'}}
                                </button>
                                {{-- <form action="/status/pet-adoption/approved/{{$adopters->pet_id}}/{{ $adopters->user_id_adopter }}" method="put" enctype="multipart/form-data"> --}}
                                <button type="submit" class="btn btn-primary">
                                    {{'Submit'}}
                                </button>
                            </div>
                        </form>
                        {{-- <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Melakukan Accept Transaksi (Service Name = '.$datas->service_name.')?')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                {{'No'}}
                            </button>
                            <form method="put" action="/transaction/approved/{{ $datas->transaction_id }}">
                                @csrf
                                <input type="text" name="reservation_code" hidden value="{{ $random.$datas->user_id }}">
                                <button type="submit" class="btn btn-primary">
                                    {{'Yes'}}
                                </button>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>

            {{-- button reject --}}
            <div class="modal fade" id="rejected{{ $datas->transaction_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
            {{-- <div class="modal fade" id="rejected{{ $datas->transaction_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelLabel">Reject Transaksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                {{-- <span aria-hidden="true">&times;</span> --}}
                            </button>
                        </div>
                        <form method="put" action="/transaction/rejected/{{ $datas->transaction_id }}">
                            <div class="modal-body">
                                {{__('Apa Kamu Yakin Ingin Melakukan Reject Transaksi (Service Name = '.$datas->service_name.')?')}}
                                <br>
                                <br>
                                <div class="form-group p-2">
                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                    @csrf
                                    <input name="message" type="text" class="form-control @error('message') is-invalid @enderror" id="reasonInput" placeholder="Message's to Customer.." value="{{ old('message') }}" autofocus required>
                                    <center>
                                        <span style="font-size: 10px; color: grey">Wajib diisi | Maksimal 255 karakter</span>
                                    </center>
                                    @error('message')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    {{-- <span class="invalid-feedback" role="alert" id="reasonError">
                                        <strong></strong>
                                    </span> --}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    {{'Close'}}
                                </button>
                                {{-- <form action="/status/pet-adoption/approved/{{$adopters->pet_id}}/{{ $adopters->user_id_adopter }}" method="put" enctype="multipart/form-data"> --}}
                                <button type="submit" class="btn btn-primary">
                                    {{'Submit'}}
                                </button>
                            </div>
                        </form>
                        {{-- <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Melakukan Reject Transaksi (Service Name = '.$datas->service_name.')?')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                {{'No'}}
                            </button>
                            <form method="put" action="/transaction/rejected/{{ $datas->transaction_id }}">
                                <button type="submit" class="btn btn-primary">
                                    {{'Yes'}}
                                </button>
                            </form>
                        </div> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
