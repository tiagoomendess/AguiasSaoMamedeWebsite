<!-- Aqui apenas fica a navbar -->

<div class="navbar-fixed">
    <nav class="top-nav verde-mamede">
        <div class="container">
            <div class="row">
                <div class="nav-wrapper">

                    <div class="brand-logo center">
                        <img class="navbar-logo" src="/imagens/emblema-white-border.png">
                    </div>

                    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>

                    <ul class="left hide-on-med-and-down">
                        <li><a href="/">@lang('navbar.index')</a></li>
                        <li><a href="/noticias">@lang('navbar.news')</a></li>
                        <li><a href="/noticias">@lang('navbar.squad')</a></li>
                    </ul>

                    <ul class="right hide-on-med-and-down">
                    @if( Auth::check() )
                        <li><a class="dropdown-button" href="#" data-activates="dropdown-user">{{ Auth::user()->nome }} {{ Auth::user()->apelido }}<i class="material-icons right">arrow_drop_down</i></a></li>
                    @else
                        <li><a href="/login">@lang('navbar.login')</a></li>
                        <li><a href="/registar">@lang('navbar.register')</a></li>
                    @endif
                    </ul>

                    <ul id="dropdown-user" class="dropdown-content dropdown-content-custom">
                        <li><a href="/perfil">@lang('navbar.perfil')</a></li>
                        @if(Auth::check() && Auth::user()->perm_level > 1)
                            <li><a href="{{ route('painel') }}">@lang('navbar.pannel')</a></li>
                        @endif
                        <li><a href="/logout">@lang('navbar.logout')</a></li>
                    </ul>

                </div>
            </div>

        </div>
    </nav>
</div>
