@extends('layouts.app')

@section('title')
    Transaction - Nirmala
@endsection

@section('content')
    <div class="wadah_2">
        <div class="title_body">
            <h1>
                My Transaction
            </h1>
            <br>
        </div>
        @php
            $inc = 1;
        @endphp
        {{-- @foreach ($data as $datas)
            @if ($datas->status == null)
                <div class="alert alert-danger wadahCloseButtonAlert" role="alert" id="wadahCloseButtonAlert">
                    Kamu harus klik button "Confirm" untuk melanjutkan transaksi...
                    <button type="button" class="btn-close" onclick="closeButtonAlertFunc()">
                        &times;
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">
                        &times;
                    </button>
                </div>
            @endif
        @endforeach --}}

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
            <form action="/transaction/search" method="get">
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
                                <a href="/transaction">
                                    <button type="button" class="btn btn-danger" aria-hidden="true">
                                        &times;
                                    </button>
                                </a>
                            </div>
                        @endif

                        <input type="text" name="type" hidden value="transaction">

                    </div>
                </center>
            </form>
        </div>
        <br>

        {{-- <button type="submit">Add User</button> --}}
        @if ($typeData == 'search')
            <div class="table-responsive manageSearch">
        @else
            <div class="table-responsive">
        @endif
                <div class="accordion" id="accordionExample">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                {{-- <th>Pet Shop ID</th>
                                <th>Pet Shop Name</th> --}}
                                {{-- <th>Transaction ID</th> --}}
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
                        @foreach ($jumlah as $item => $value)
                            @if ($value->id == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="7">
                                            {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                            <div class="text-center">
                                                <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
                            @if ($data->count() == 0)
                                <tbody>
                                    <tr>
                                        <td colspan="7">
                                            {{-- <h2 class="text-danger text-center">Data tidak ada</h2> --}}
                                            <div class="text-center">
                                                <img src="{{asset('gambar/DNF.png')}}" alt="foto" class="foto_size">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endif
                                @foreach ($data as $datas)
                                    @if ($datas->user_id == $userID)
                                        @if ($datas->status == 'Accepted')
                                            <tbody class="bg-success">
                                        @endif
                                        @if ($datas->status == 'Waiting' || $datas->status == null)
                                            <tbody class="bg-warning">
                                        @endif
                                        @if ($datas->status == 'Canceled' || $datas->status == 'Rejected')
                                            <tbody class="bg-danger">
                                        @endif
                                                <tr>
                                                    <td>{{$inc++}}</td>
                                                    {{-- <td>{{ $datas->user_id_pet_shop }}</td>
                                                    @foreach ($dataUser as $dataUsers)
                                                        @if ($dataUsers->id == $datas->user_id_pet_shop)
                                                            <td>{{ $dataUsers->name }}</td>
                                                        @endif
                                                    @endforeach --}}
                                                    {{-- <td>{{ $datas->transaction_id }}</td> --}}
                                                    <td>{{ $datas->transaction_date }}</td>
                                                    {{-- <td>{{ $datas->transaction_name }}</td> --}}
                                                    <td>{{ $datas->service_name }}</td>
                                                    {{-- <td>{{ $datas->quantity }}</td> --}}
                                                    <td>{{ $datas->time }}</td>
                                                    {{-- <td>{{ number_format($datas->service_price, 0, ',', '.') }}</td> --}}
                                                    <td>{{ number_format($datas->quantity*$datas->service_price, 0, ',', '.') }}</td>
                                                    @if ($datas->status == null)
                                                        <td>{{__('Waiting')}}</td>
                                                    @else
                                                        <td>{{ $datas->status }}</td>
                                                    @endif
                                                    {{-- <td>{{ $datas->reservation_code }}</td> --}}
                                                    <td>
                                                        {{-- <form method="put" action="/transaction/detail/transaction-ID={{ $datas->transaction_id }}">
                                                            <button type="submit" id="" class="btn btn-info">Detail</button>
                                                        </form> --}}
                                                        <button type="submit" title="Detail" id="" class="btn btn-info dropdown-toggle" data-bs-toggle="collapse" href="#collapseExample{{ $datas->transaction_id }}" aria-expanded="false" aria-controls="collapseExample">
                                                            <i class="fas fa-info-circle"></i>
                                                        </button>
                                                        {{-- @if ($datas->status != 'Waiting' && $datas->status != 'Cancel' && $datas->status != 'Approved' && $datas->status != 'Rejected')
                                                            <form method="put" action="/transaction/confirm/transaction-ID={{ $datas->transaction_id }}" hidden>
                                                                @csrf
                                                                <input type="number" name="total_price" value="{{ $datas->quantity*$datas->service_price }}">
                                                                <button type="submit" id="clickButtonConfirm" class="btn btn-success">Confirm</button>
                                                            </form>
                                                        @endif --}}
                                                        {{-- @if ($datas->status == 'Waiting')
                                                            <button type="submit" id="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancel{{ $datas->transaction_id }}">Cancel</button>
                                                        @endif --}}
                                                    </td>
                                                </tr>
                                                <tr class="collapse detailTransaction bg-light" id="collapseExample{{ $datas->transaction_id }}" data-bs-parent="#accordionExample">
                                                    <td colspan="8">
                                                        <div>
                                                            <div class="table-responsive">
                                                                <table class="table">
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
                                                                            <td class="w-50">Status</td>
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
                                                            <div class="form-group mt-3 mb-3 ms-2">
                                                                <span style="color: red; font-size: 16px">
                                                                    Metode pembayaran: Pay at Pet Shop
                                                                </span>
                                                            </div>
                                                            <div class="wadah_button_detail_trans mb-4">
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
                                                                    {{-- @if ($datas->status == 'Waiting' && $userID == $datas->user_id)
                                                                        <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#cancel{{ $datas->transaction_id }}">Cancel</button>
                                                                    @endif --}}
                                                                    @if ($datas->status == 'Waiting' && $userID == $datas->user_id_pet_shop)
                                                                        {{-- <button type="submit" id="clickButton" class="btn btn-primary" hidden>Confirm</button> --}}
                                                                        <button type="submit" id="" class="btn btn-success button_trans"  data-bs-toggle="modal" data-bs-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                                                                        <button type="submit" id="" class="btn btn-danger button_trans" data-bs-toggle="modal" data-bs-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    </table>
                </div>
            </div>
            <br>
        @if ($typeData == 'transaction')
            {{ $data->links() }}
            <br>
            <br>
        @endif

        <!-- menggunakan Modal untuk button cancel -->
        @foreach ($data as $datas)
            <div class="modal fade" id="cancel{{ $datas->transaction_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
            {{-- <div class="modal fade" id="cancel{{ $datas->transaction_id }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="cancelLabel">Cancel Transaksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            {{-- <span aria-hidden="true">&times;</span> --}}
                        </button>
                        </div>
                        <form method="put" action="/transaction/cancel/transaction-ID={{ $datas->transaction_id }}">
                            <div class="modal-body">
                                {{__('Apa Kamu Yakin Ingin Melakukan Cancel Transaksi (Service Name = '.$datas->service_name.')?')}}
                                <br>
                                <br>
                                <div class="form-group p-2">
                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                    @csrf
                                    <input name="message" type="text" class="form-control @error('message') is-invalid @enderror" id="reasonInput" placeholder="Berikan alasan anda disini.." value="{{ old('message') }}" autofocus>
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
                            {{__('Apa Kamu Yakin Ingin Melakukan Cancel Transaksi (Service Name = '.$datas->service_name.')?')}}
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            {{'No'}}
                        </button>
                        <form method="put" action="/transaction/cancel/transaction-ID={{ $datas->transaction_id }}">
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
