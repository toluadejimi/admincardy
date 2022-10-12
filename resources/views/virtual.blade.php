<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('') }}/public/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ url('') }}/public/assets/img/favicon.png">
    <title>
        Cardy Admin
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ url('') }}/public/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ url('') }}/public/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ url('') }}/public/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ url('') }}/public/assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100 virtual-reality">
    <div>


    </div>
    <div class="border-radius-xl mt-3 mx-3 position-relative"
        style="background-image: url('{{ url('') }}/public/assets/img/vr-bg.jpg') ; background-size: cover;">

        <main class="main-content mt-1 border-radius-lg">
            <div class="section min-vh-95 position-relative transform-scale-0 transform-scale-md-7">
                <div class="container">
                    <div class="row pt-10">
                        <div class="col-lg-1 col-md-1 pt-5 pt-lg-0 ms-lg-5 text-center">
                            <a href="javascript:;" class="avatar avatar-md border-0" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="My Profile">
                                <img class="border-radius-lg" alt="Image placeholder"
                                    src="{{ url('') }}/public/assets/img/team-1.jpg">
                            </a>
                            <button class="btn btn-white border-radius-lg p-2 mt-2" type="button"
                                data-bs-toggle="tooltip" data-bs-placement="left" title="Home">
                                <i class="fas fa-home p-2"></i>
                            </button>
                            <button class="btn btn-white border-radius-lg p-2" type="button" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Search">
                                <i class="fas fa-search p-2"></i>
                            </button>
                            <button class="btn btn-white border-radius-lg p-2" type="button" data-bs-toggle="tooltip"
                                data-bs-placement="left" title="Minimize">
                                <i class="fas fa-ellipsis-h p-2"></i>
                            </button>
                        </div>
                        <div class="col-lg-10 col-md-11">
                            <div class="d-flex">
                                <div class="me-auto">
                                    <h1 class="display-1 font-weight-bold mt-0 mb-3">NGN {{$cardy_rate}} / $</h1>
                                    <h6 class="text-uppercase mb-0 ms-1">Cardy Today Rate</h6>
                                </div>
                                <div class="ms-auto">
                                    <img class="w-50 float-end mt-lg-n4"
                                        src="{{ url('') }}/public/assets/img/small-logos/icon-sun-cloud.png"
                                        alt="image sun">
                                </div>
                            </div>




                            <div class="row mt-4">
                                <div class="col-lg-4 col-md-4">





                                    <div class="card move-on-hover overflow-hidden card bg-gradient-dark move-on-hove">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <h2 id="time" value="time" class="mb-0 text-white"></h2>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-4 mb-11">
                                    <div class="card move-on-hover overflow-hidden mb-11">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <h1 class="mt-0 mb-0">$ {{$usd_wallet}}
                                                </h1>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-4 col-md-4 mt-4 mt-sm-0">
                                    <div class="card bg-gradient-dark move-on-hover">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <h5 class="mb-0 text-white">Users</h5>
                                                <div class="ms-auto">
                                                    <h1 class="text-white text-end mb-0 mt-n2">{{$users}}</h1>
                                                </div>
                                            </div>

                                        </div>
                                        <a href="/admin-dashboard" class="w-100 text-center py-1" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="Show More">
                                            <i class="fas fa-chevron-down text-white"></i>
                                        </a>
                                    </div>
                                    <div class="card move-on-hover mt-4">

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 mt-4 mt-sm-0">
                                    <div
                                        class="card card-background card-background-mask-primary move-on-hover align-items-start">
                                        <div class="cursor-pointer">
                                            <div class="full-background"
                                                style="background-image: url('{{ url('') }}/public/assets/img/curved-images/curved1.jpg')">
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card move-on-hover mt-4">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p class="my-auto">Messages</p>
                                                <div class="ms-auto">
                                                    <div class="avatar-group">
                                                        <a href="javascript:;"
                                                            class="avatar avatar-sm border-0 rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="2 New Messages">
                                                            <img alt="Image placeholder"
                                                                src="{{ url('') }}/public/assets/img/team-1.jpg">
                                                        </a>
                                                        <a href="javascript:;"
                                                            class="avatar avatar-sm border-0 rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="1 New Message">
                                                            <img alt="Image placeholder"
                                                                src="{{ url('') }}/public/assets/img/team-2.jpg">
                                                        </a>
                                                        <a href="javascript:;"
                                                            class="avatar avatar-sm border-0 rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="13 New Messages">
                                                            <img alt="Image placeholder"
                                                                src="{{ url('') }}/public/assets/img/team-3.jpg">
                                                        </a>
                                                        <a href="javascript:;"
                                                            class="avatar avatar-sm border-0 rounded-circle"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="7 New Messages">
                                                            <img alt="Image placeholder"
                                                                src="{{ url('') }}/public/assets/img/team-4.jpg">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>



    <script src="{{ url('') }}/public/assets/js/core/popper.min.js"></script>
    <script src="{{ url('') }}/public/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ url('') }}/public/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ url('') }}/public/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ url('') }}/public/assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>



<script type="text/javascript">
  function showTime() {
    var date = new Date(),
        utc = new Date(Date.UTC(
          date.getFullYear(),
          date.getMonth(),
          date.getDate(),
          date.getHours(),
          date.getMinutes(),
          date.getSeconds()
        ));

    document.getElementById('time').innerHTML = utc.toLocaleTimeString();
  }

  setInterval(showTime, 1000);
</script>










</body>

</html>
