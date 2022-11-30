@extends('layouts.downtimemails')

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

            <div class="col-md-12 mb-lg-0 mb-4">
                <div class="card mt-4">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                           
                            <div class="col-3">
                                <a class="btn bg-gradient-dark mb-0" href="/usd-downtime">USD CARD DOWNTIME</a>
                            </div>

                            <div class="col-3">
                                <a class="btn bg-gradient-success mb-0" href="/usd-card-active">USD CARD ACTIVE</a>
                            </div>

                            <div class="col-3">
                                <a class="btn bg-gradient-dark mb-0" href="javascript:;">Add New Card</a>
                            </div>

                            <div class="col-3">
                                <a class="btn bg-gradient-dark mb-0" href="javascript:;">Add New Card</a>
                            </div>



                        </div>
                    </div>


                </div>
            </div>






        @endsection
