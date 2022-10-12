@extends('layouts.fundwalletnav')

@section('content')
    <div class="row mt-4">

        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="col-6 w-100">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
            </div>
            <div class="card">


                <h5 class="card-header">Fund Issuing Wallet</h5>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="" action="/fund-issuing-wallet-now" method="POST" onsubmit="return true">
                                @csrf
                                <div class="row">

                                    <div class="mb-3 col-md-6">
                                        <label for="amount" class="form-label">Amount to Fund (NGN)</label>
                                        <input class="form-control" type="number" name="amount" id="amount"
                                            value="" />
                                    </div>


                                    <div class="text-center col-md-4 mt-1 mb-3">
                                        <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Fund
                                            Wallet</button>
                                    </div>


                                </div>





                        </div>
                    </div>
                </div>


            </div>
        </div>









        <div class="col-lg-5 mb-5">
            <div class="card h-100 p-3">
                <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100"
                    style="background-image: url('../assets/img/ivancik.jpg');">
                    <span class="mask bg-gradient-dark"></span>
                    <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                        <p class="text-white">Total Funded</p>
                        <h4 class="text-white font-weight-bolder mb-4 pt-2">NGN {{ number_format($total_transactions), 2 }}
                        </h4>
                        <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:;">
                            <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Transactions</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>

                                <th>Trx ID</th>
                                <th>Amount(NGN)</th>
                                <th>To get (USD)</th>
                                <th>Status</th>
                                <th>Account Number</th>
                                <th>Reference</th>
                                <th>Bank Name</th>
                                <th>Account Name</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Time</th>


                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($transactions as $item)
                                <tr>
                                    <td>{{ $item->trx_id }}</td>
                                    <td>{{ number_format($item->amount, 2) }}</td>
                                    <td>{{ number_format($item->amount_usd, 2) }}</td>
                                    @if($item->status  == "0")
                                      <td><span class="badge rounded-pill bg-warning ">Pending</span></td>
                                      @else
                                      <td><span class="badge rounded-pill bg-success">Successful</span></td>
                                      @endif
                                    <td>{{ $item->account_number }}</td>
                                    <td>{{ $item->reference }}</td>
                                    <td>{{ $item->bank_name }}</td>
                                    <td>{{ $item->account_name }}</td>
                                    <td>{{ $item->message }}</td>
                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}</td>
                                    <td>{{ date('h:i:s A', strtotime($item->created_at)) }}</td>

                                </tr>
                            @empty
                                <tr colspan="20" class="text-center">No Record Found</tr>
                            @endforelse


                        </tbody>



                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
