@include('layouts.partials.header')
@include('layouts.partials.navbar')
@include('layouts.partials.messages')

@yield('contents')

@stack('js')

@include('layouts.partials.footer')