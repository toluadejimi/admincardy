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
        <div class="card mb-6 mr-3">
            <div class="card-header pb-0">
                <h6>{{$f_name." ".$m_name. " ". $l_name}}</h6>
            </div>
            <div class="card-body mr-3 ml-4 px-0 pt-0 pb-2">


            <form action="/customer-register" enctype="multipart/form-data" method="post">
            @csrf



                <div class="row mb-3">

                    <input type="text"  hidden class="form-control" name="f_name"value="{{$f_name}}">
                    <input type="text" hidden  class="form-control" name="m_name"value="{{$m_name}}">
                    <input type="text" hidden  class="form-control" name="l_name"value="{{$l_name}}">


                        <div class="col-sm">
                            <div class="">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email"value="{{$email}}">
                            </div>

                        </div>

                        <div class="col-sm">
                            <div class="">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone"value="{{$phone}}">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="">
                                <label>DOB</label>
                                <input type="text" class="form-control" name="dob"value="{{$dob}}">
                            </div>
                        </div>

                        <div class="col-sm">
                            <div class="">
                                <label>ID IMAGE</label>
                                <input type="file" class="form-control" name="identification_url"value="{{$identification_url}}">
                            </div>
                        </div>



                </div>



                <div class="row mb-3">

                    <div class="col-sm">
                        <div class="">
                            <label>Gender</label>
                            <input type="text" class="form-control" name="gender"value="{{$gender}}">
                        </div>

                    </div>

                    <div class="col-sm">
                        <div class="">
                            <label>Idendtification Type</label>
                            <input type="text" class="form-control" name="identification_type"value="{{$identification_type}}">
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="">
                            <label>Identification Number</label>
                            <input type="text" class="form-control" name="identification_number"value="{{$identification_number}}">
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="">
                            <label>BVN</label>
                            <input type="text" class="form-control" name="bvn"value="{{$bvn}}">
                        </div>
                    </div>

                </div>



                <div class="row mb-3">

                    <div class="col-sm">
                        <div class="">
                            <label>Street</label>
                            <input type="text" class="form-control" name="address_line1"value="{{$address_line1}}">
                        </div>

                    </div>

                    <div class="col-sm">
                        <div class="">
                            <label>City</label>
                            <input type="text" class="form-control" name="city"value="{{$city}}">
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="">
                            <label>State</label>
                            <input type="text" class="form-control" name="state"value="{{$state}}">
                        </div>
                    </div>

                    <div class="col-sm">
                        <div class="">
                            <label>Country</label>
                            <select name="country" class="form-control">
                                <option value="NG">Nigeria</option>
                                <option value="GH">Ghana</option>
                                <option value="KE">Kenya</option>
                                <option value="CM">Cameroon</option>
                            </select>
                        </div>
                    </div>



                </div>


                <button type="submit" class="btn btn-block btn-primary">Api Update</button>






            </form>


            <div class="row">


                <div class="col-3">
                    <form action="/suspend-customer/?id={{$id}}" method="post">
                    @csrf
                    @method('GET')
                    <button type="submit" class="btn btn-block btn-warning">Suspend Customer</button>
                    </form>
                </div>


                <div class="col-3">
                    <form action="/unsuspend-customer/?id={{$id}}" method="post">
                    @csrf
                    @method('GET')
                    <button type="submit" class="btn btn-block btn-success">Unsuspend Customer</button>
                    </form>
                </div>

            </div>











            </div>
        </div>
    </div>






@endsection
