<ul id="slide-out" class="side-nav fixed">
    <li>
        <div class="userView">
            <div class="background">
                <img src="https://unsplash.it/400/200">
            </div>
            <a href="#!user"><img class="circle" src="{{ Auth::user()->imagem }}"></a>
            <a href="#!name"><span class="white-text name">{{ Auth::user()->nome }} {{ Auth::user()->apelido }}</span></a>
            <a href="#!email"><span class="white-text email">{{ Auth::user()->email }}</span></a>
        </div>
    </li>

    <li> <a class="waves-effect" href=" {{ route('painel') }}">{{ trans('menu.inicio') }}</a></li>

    <li class="no-padding">
        <ul class="collapsible collapsible-accordion">
            <li>
                <a class="collapsible-header">@lang('menu.socios') <i class="fa fa-caret-down" aria-hidden="true"></i>
                </a>

                <div class="collapsible-body">
                    <ul>
                        <li><a href="{{ route('socios') }}" class="">@lang('menu.todos_socios')</a></li>
                        <li><a href="{{ route('sociosAtrasados') }}">@lang('menu.socios_atraso')</a></li>
                        <li><a href="{{ route('createSocio') }}">@lang('menu.add_socio')</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </li>


    <li><a class="waves-effect" href="{{ route('showUtilizadores') }}">{{ trans('menu.utilizadores') }}</a></li>

    <li><a class="waves-effect" href="{{ route('showDefinicoes') }}">{{ trans('menu.definicoes') }}</a></li>

</ul>
