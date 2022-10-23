@extends('layouts.transactions')

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



    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <h6>Cards</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>

                                <th>Name</th>
                                <th>Trx ID</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Narration</th>
                                <th>Date</th>
                                <th>Action</th>


                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($transactions as $item)
                                <tr>
                                    <td>{{ $item->user->f_name }} {{ $item->user->l_name }}</td>
                                    <td>{{ $item->ref_trans_id}}</td>
                                    <td>{{ $item->transaction_type}}</td>
                                    <td>{{ $item->debit }}</td>
                                    <td>{{ $item->note }}</td>
                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}</td>

                                    <td>
                                        <div class="col-0 offset-0">
                                            <form action="/delete-transaction/?id={{ $item->id }}" method="post">
                                                @csrf
                                                @method('GET')
                                                <button type="submit" class="btn btn-block btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr colspan="20" class="text-center">No Record Found</tr>
                            @endforelse


                        </tbody>


                        {!! $transactions->appends(Request::all())->links() !!}




                    </table>
                </div>
            </div>
        </div>
    </div>






@endsection
