@extends('layouts.app')

@section('title')
    Transaction Detail - Nirmala
@endsection

@section('content')
    <div class="col1_3">
        {{-- untuk reservation code nya --}}
        @foreach ($data as $datas)
            <div class="table table-responsive">
                <table>
                    <tr class="text-danger">
                        <td><h2>Reservation Code</h2></td>
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
        @endforeach
        <div class="divider"></div>
        <br>
        @foreach ($data as $datas)
            <div class="table-responsive table_detail_trans">
                <table class="table table-dark">
                    <tbody>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            @if ($datas->status == 'Accepted')
                                <td class="field_table_td bg-success">
                            @endif
                            @if ($datas->status == 'Waiting')
                                <td class="field_table_td bg-warning text-dark">
                            @endif
                            @if ($datas->status == 'Canceled' || $datas->status == 'Rejected')
                                <td class="field_table_td bg-danger">
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
        @endforeach

        {{-- untuk random reservation_code --}}
        @php
            $random = rand(10000, 99999);
            // rand();
            // mt_rand();
            // random_int(valueMin, valueMax)
            // rand(valueMin, valueMax);
        @endphp

        @foreach ($data as $datas)
            <div class="table-responsive table_detail_trans_2">
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="detail_column">Service Time</td>
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
                        {{-- <button type="submit" id="" class="btn btn-danger button_trans" data-toggle="modal" data-target="#cancel{{ $datas->transaction_id }}">Cancel</button> --}}
                        <button type="submit" id="" class="btn btn-success button_trans" data-toggle="modal" data-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                        <button type="submit" id="" class="btn btn-danger button_trans" data-toggle="modal" data-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                    @endif
                    @if ($datas->status == 'Accepted')
                        <button type="submit" id="" class="btn btn-danger button_trans" data-toggle="modal" data-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                    @endif
                    @if ($datas->status == 'Rejected')
                        <button type="submit" id="" class="btn btn-success button_trans"  data-toggle="modal" data-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                    @endif
                @else
                    @if ($datas->status == 'Waiting' && $userID == $datas->user_id)
                        <button type="submit" id="" class="btn btn-danger button_trans" data-toggle="modal" data-target="#cancel{{ $datas->transaction_id }}">Cancel</button>
                    @endif
                    @if ($datas->status == 'Waiting' && $userID == $datas->user_id_pet_shop)
                        {{-- <button type="submit" id="clickButton" class="btn btn-primary" hidden>Confirm</button> --}}
                        <button type="submit" id="" class="btn btn-success button_trans"  data-toggle="modal" data-target="#accepted{{ $datas->transaction_id }}">Accept</button>
                        <button type="submit" id="" class="btn btn-danger button_trans" data-toggle="modal" data-target="#rejected{{ $datas->transaction_id }}">Reject</button>
                    @endif
                @endif
            </div>
        @endforeach

        <!-- menggunakan Modal untuk button cancel & rejected -->
        @foreach ($data as $datas)
            {{-- untuk button cancel --}}
            {{-- <div class="modal fade" id="cancel{{ $datas->transaction_id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
            <div class="modal fade" id="cancel{{ $datas->transaction_id }}" data-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelLabel">Cancel Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    {{'Close'}}
                                </button>
                                {{-- <form action="/status/pet-adoption/approved/{{$adopters->pet_id}}/{{ $adopters->user_id_adopter }}" method="put" enctype="multipart/form-data"> --}}
                                <button type="submit" class="btn btn-primary">
                                    {{'Submit'}}
                                </button>
                            </div>
                        </form>
                        {{-- <div class="modal-body">
                            {{__('Apa Kamu Yakin Ingin Cancel Transaksi (Service Name = '.$datas->service_name.')?')}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
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

            {{-- untuk confirm button accept --}}
            <div class="modal fade" id="accepted{{ $datas->transaction_id }}" data-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelLabel">Accept Transaksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="put" action="/transaction/approved/transaction-ID={{ $datas->transaction_id }}">
                            <div class="modal-body">
                                {{__('Apa Kamu Yakin Ingin Melakukan Reject Transaksi (Service Name = '.$datas->service_name.')?')}}
                                <br>
                                <br>
                                <div class="form-group p-2">
                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                    @csrf
                                    <input type="text" name="reservation_code" hidden value="{{ $random.$datas->user_id }}">
                                    <input name="message" type="text" class="form-control @error('message') is-invalid @enderror" id="reasonInput" placeholder="Message's to Customer.." value="{{ old('message') }}" autofocus>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
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
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                {{'No'}}
                            </button>
                            <form method="put" action="/transaction/approved/transaction-ID={{ $datas->transaction_id }}">
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

            <!-- menggunakan Modal untuk button rejected -->
            {{-- <div class="modal fade" id="rejected{{ $datas->transaction_id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true"> --}}
            <div class="modal fade" id="rejected{{ $datas->transaction_id }}" data-keyboard="false" tabindex="-1" aria-labelledby="cancelLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="cancelLabel">Reject Transaksi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form method="put" action="/transaction/rejected/transaction-ID={{ $datas->transaction_id }}">
                            <div class="modal-body">
                                {{__('Apa Kamu Yakin Ingin Melakukan Reject Transaksi (Service Name = '.$datas->service_name.')?')}}
                                <br>
                                <br>
                                <div class="form-group p-2">
                                    {{-- <label for="reason">{{ __('Reason *') }}</label> --}}
                                    @csrf
                                    <input name="message" type="text" class="form-control @error('message') is-invalid @enderror" id="reasonInput" placeholder="Message's to Customer.." value="{{ old('message') }}" autofocus>
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
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            {{'No'}}
                        </button>
                        <form method="put" action="/transaction/rejected/transaction-ID={{ $datas->transaction_id }}">
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
