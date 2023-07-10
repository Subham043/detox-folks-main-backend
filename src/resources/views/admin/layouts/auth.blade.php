<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="sm-hover">

    @include('admin.includes.common_head')

    <body>

        <div class="auth-page-wrapper pt-5">
            <!-- auth page bg -->
            <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
                <div class="bg-overlay"></div>

                <div class="shape">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                        <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                    </svg>
                </div>
            </div>

            <!-- auth page content -->
            <div class="auth-page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center mt-sm-5 mb-4 text-white-50">
                                <div>
                                    <a href="index.html" class="d-inline-block auth-logo">
                                        <img src="{{ asset('admin/images/logo.png') }}" alt="">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                        @yield('content')

                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->


        </div>
        <!-- end auth-page-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('admin/js/pages/Jquery.min.js') }}"></script>
        @include('admin.includes.common_script')
        <!-- particles js -->
        <script src="{{ asset('admin/js/pages/plugins/particles.js') }}"></script>
        <!-- particles app js -->
        <script src="{{ asset('admin/js/pages/particles.app.js') }}"></script>
        @yield('javascript')
    </body>


</html>
