<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{url('')}}/public/assets/"
  data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('') }}/public/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ url('') }}/public/assets/img/favicon.png">
    <title>
        Verify Code    </title>
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


    <body class="">
        <div class="container position-sticky z-index-sticky top-0">
            <div class="row">
                <div class="col-12">
                    <!-- Navbar -->

                    <!-- End Navbar -->
                </div>
            </div>
        </div>
        <main class="main-content  mt-0">
            <section>
                <div class="page-header min-vh-75">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                                <div class="card card-plain mt-8">
                                    <div class="card-header pb-0 text-left bg-transparent">

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
                                        @if (session()->has('error'))
                                            <div class="alert alert-warning">
                                                {{ session()->get('error') }}
                                            </div>
                                        @endif
                                        <h4 class="mb-2">Hello {{Auth::user()->f_name}} 👋</h4>
                                        <p class="mb-4">Verify your Email</p>
                                    </div>

                                    <form action="/verify-email-code-now" method="POST">
                                        @csrf

                                        <div class="card-body">
                                            <form role="form">
                                                <label>Code</label>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control" name="code"
                                                        placeholder="Enter code" aria-label="code"
                                                        aria-describedby="code">
                                                </div>


                                                <div class="text-center">
                                                    <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Continue</button>
                                                </div>

                                                <p class="text-center">
                                                    <p> No code yet?  Please wait for 1 min before you can resend code or check your spam folder and report not spam. </p>
                                                    <span></span>

                                                    <a href="/send-verification-code">
                                                      <span>Resend Code</span>
                                                    </a>



                                            </form>
                                        </div>
                                        <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                            <p class="mb-4 text-sm mx-auto">
                                            </p>
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                    <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                        style="background-image:url('{{ url('') }}/public/assets/img/curved-images/curved6.jpg')">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </section>
        </main>
        <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->

        <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
        <!--   Core JS Files   -->
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
    </body>

</html>





















