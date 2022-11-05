@extends('layouts.vas')

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

        </div>

    </div>

    <div class="row mb-3">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">

                <div class="card-body p-3">
                    <div class="row">

                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Vas Out</p>
                                <h5 class="font-weight-bolder mb-0">
                                    NGN {{ number_format($total_vas), 2 }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-bold-up text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>







    <div class="col-12 mt-6">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <h6>Value Added Purchase</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>

                                <th>REF ID</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Date</th>


                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($vas as $item)
                                <tr>
                                    <td>{{ $item->ref_id }}</td>
                                    <td>{{ $item->user->f_name  }}  {{  $item->user->l_name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}</td>

                                </tr>
                            @empty
                                <tr colspan="20" class="text-center">No Record Found</tr>
                            @endforelse


                        </tbody>


                        {!! $vas->appends(Request::all())->links() !!}




                    </table>
                </div>
            </div>
        </div>
    </div>






@endsection
