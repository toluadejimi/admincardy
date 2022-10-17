@extends('layouts.usdcard')

@section('content')
    <div class="row mt-4">

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
            <div class="card mb-5">


                <h5 class="card-header">Find Card</h5>
                <div class="card-body p-3 mb-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <form id="" action="/card-info" method="POST" onsubmit="return true">
                                @csrf
                                <div class="row">

                                    <div class="mb-3 col-md-6">
                                        <label for="amount" class="form-label">Enter Card ID</label>
                                        <input class="form-control" type="number" name="card_id" id="card_id"
                                            value="" />
                                    </div>


                                    <div class="text-center col-md-4 mt-1 mb-3">
                                        <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Find Card</button>
                                    </div>


                                </div>
                            </form>




                        </div>
                    </div>
                </div>


            </div>
        </div>









        <div class="col-lg-6 mb-5">
            <div class="card h-100 p-3">

                <h5 class="card-header">Card Info</h5>

            <div class="row">
                <div class="col-lg-6" >
                    <h6>Name on Card</h6>
                    <span> {{$name_on_card ?? "empty"}}</span>
                </div>

                    <div class="col-lg-6" >

                        <h5>Balance</h5>
                        <small>USD {{$balance ?? "0.00"}}</small>
                    </div>

                </div>
            </div>






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

                                <th>ID</th>
                                <th>Name on Card</th>
                                <th>Currency</th>
                                <th>Brand</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>


                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($usd_card as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name_on_card}}</td>
                                    <td>{{ $item->currency }}</td>
                                    <td>{{ $item->brand }}</td>

                                    @if($item->status  == "active")
                                      <td><span class="badge rounded-pill bg-warning ">Active</span></td>
                                      @else
                                      <td><span class="badge rounded-pill bg-success">Inactive</span></td>
                                      @endif
                                    <td>{{ date('F d, Y', strtotime($item->created_at)) }}</td>
                                    <td>
                                     <div class="col-2 offset-2">
                                        <form action="/card-info/?id={{$item->id}}" method="post">
                                         @csrf
                                         @method('get')
                                         <button type="submit" class="btn btn-block btn-success">View</button>
                                         </form>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="col-0 offset-0">
                                           <form action="/liquidate-card/?id={{$item->id}}" method="post">
                                            @csrf
                                            @method('GET')
                                            <button type="submit" class="btn btn-block btn-warning">Liquidate</button>
                                            </form>
                                        </div>
                                    </td>



                                    <td>
                                        <div class="col-0 offset-0">
                                           <form action="/delete-card/?id={{$item->id}}" method="post">
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
                </div>
            </div>
        </div>
    </div>






@endsection
