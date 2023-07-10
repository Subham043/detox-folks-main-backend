<head>

    <meta charset="utf-8" />
    <title>DETOX FOLKS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="DETOX FOLKS - Admin Panel" name="description" />
    <meta content="DETOX FOLKS - Admin Panel" name="author" />
    @cspMetaTag(App\Http\Policies\ContentSecurityPolicy::class)
    <!-- App favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/logo-sm.png') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('admin/js/layout.js') }}"></script>

    <!-- App Css-->
    @vite(['resources/admin/css/main.css'])

    @yield('css')
</head>
