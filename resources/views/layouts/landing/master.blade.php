<!DOCTYPE html>
<html lang="en">
@include('layouts.landing.head')

<body>
    @include('layouts.landing.header')
    @yield('content')
    @include('layouts.landing.footer')
    @include('layouts.landing.javascript')
</body>



</html>
