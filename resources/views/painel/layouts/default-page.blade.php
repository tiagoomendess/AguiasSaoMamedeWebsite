<html>
    <head>
        @include('painel.parcial.head')
        @yield('head')
    </head>
    <body>
    @include('painel.parcial.menu')

    <div class="desktop-content">
        @include('painel.parcial.navbar')

        <div class="container contentor">
            <h4>@yield('page_title') </h4>
        </div>

        <div class="container contentor">
            <div class="page-content">
                @yield('page_content')
            </div>

        </div>

    </div>

    @yield('footer')
    @include('painel.parcial.footer')
    @include('painel.parcial.scripts')
    @yield('after-scripts')
    </body>
</html>