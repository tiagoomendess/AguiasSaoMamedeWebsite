<nav class="top-nav green darken-2">
        <div class="nav-wrapper">
            <a href="{{ route('painel') }}" class="brand-logo center hidden-md hidden-sm hidden-xs">Painel S. Mamede</a>
            <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right">
                <li><a href="#modal_logout" class="modal-trigger"><i class="fa fa-power-off" aria-hidden="true"></i></a></li>
            </ul>
        </div>
</nav>

<div id="modal_logout" class="modal">
    <div class="modal-content">
        <div class="row">
            <div class=" input-field col s12">
                <a href="{{ route('index') }}" style="width: 100%" class="waves-effect waves-light btn-large green"> Voltar ao Site</a>
            </div>

            <div class="input-field col s12">
                <a href="{{ route('Logout') }}" style="width: 100%" class="waves-effect waves-light btn-large orange"> Terminar sessão</a>
            </div>

            <div class="input-field col s12">
                <a style="width: 100%" class="waves-effect waves-light btn-large blue modal-close"> Cancelar</a>
            </div>
        </div>


    </div>
</div>



