@extends('layouts.users')

@section('content')
    <div class="row mt-4">



        <div class="col-lg-6 mb-5">



            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-lg-0 mb-4">
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

    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <h6>Users</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>

                                <th>ID</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Action</th>


                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($users as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->f_name }}</td>
                                    <td>{{ $item->m_name }}</td>
                                    <td>{{ $item->l_name}}</td>
                                    <td>{{ $item->email}}</td>
                                    <td>{{ $item->phone }}</td>

                                    @if($item->is_kyc_verified  == "1")
                                      <td><span class="badge rounded-pill bg-warning ">Verified</span></td>
                                      @else
                                      <td><span class="badge rounded-pill bg-success">Not Verified</span></td>
                                      @endif
                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}</td>
                                    <td>
                                     <div class="col-2 offset-2">
                                        <form action="/card-info/?id={{$item->id}}" method="post">
                                         @csrf
                                         @method('get')
                                         <button type="submit" class="btn btn-block btn-success">Edit</button>
                                         </form>
                                        </div>
                                    </td>


                                    <td>
                                        <div class="col-0 offset-0">
                                           <form action="/delete-user/?id={{$item->id}}" method="post">
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



                    </table>
                    {!! $users->appends(Request::all())->links() !!}

                </div>
            </div>
        </div>
    </div>






@endsection
