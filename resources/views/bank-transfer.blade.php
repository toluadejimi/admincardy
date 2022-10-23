@extends('layouts.banktransfer')

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
                <h6>Bank Transfer Request</h6>
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
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>


                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($bank_transfers as $item)
                                <tr>
                                    <td>{{ $item->ref_id }}</td>
                                    <td>{{ $item->user->f_name  }}  {{  $item->user->l_name }}</td>
                                    <td>{{ $item->amount }}</td>
                                    <td>{{ $item->type }}</td>

                                    @if ($item->status == '0')
                                        <td><span class="badge rounded-pill bg-warning ">Pending</span></td>
                                    @else
                                        <td><span class="badge rounded-pill bg-success">Successful</span></td>
                                    @endif
                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}</td>
                                    <td>
                                        <div class="col-2 offset-2">
                                            <form action="/update-transfer/?id={{ $item->id }}&amount={{ $item->amount }}" method="post">
                                                @csrf
                                                @method('get')
                                                <button type="submit" class="btn btn-block btn-warning">Update</button>
                                            </form>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-0 offset-0">
                                            <form action="/delete-transfer/?id={{ $item->id }}&ref={{ $item->ref_id }}" method="post">
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


                        {!! $bank_transfers->appends(Request::all())->links() !!}




                    </table>
                </div>
            </div>
        </div>
    </div>






@endsection
