@include('layouts.partials.header')
@include('layouts.partials.navbar')

@yield('contents')

@stack('js')

@include('layouts.partials.footer')