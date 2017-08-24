@extends('painel.layouts.default-page')

@section('page_title')
    @lang('menu.utilizadores')
@endsection

@section('page_content')


    <div class="row">

        <div class="col l8 m12 s12">

            <div class="caixa-delimitadora-fina">
                <h5>Pesquisar Utilizadores</h5>
                <div class="divider"></div>
                <p>Preencha pelo menos um campo que sabe.</p>
                <form method="POST" action="{{ route('showUtilizadoresProcura') }}">
                    <div class="row">

                        {{ csrf_field() }}

                        <input type="hidden" name="procura" value="true">

                        <div class="input-field col s12 m12 l12">
                            <input name="nome" id="nome" type="text" class="validate" value="@if (isset($nome)){{ $nome }}@endif">
                            <label for="nome">@lang('auth.form_name')</label>
                        </div>

                        <div class="input-field col s12 m12 l12">
                            <input name="email" id="email" type="email" class="validate" value="@if (isset($email)){{ $email }}@endif">
                            <label for="email">@lang('auth.form_email')</label>
                        </div>

                        <div class="col s6 m6 l6">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('forms.procurar')
                                <i class="material-icons right">send</i>
                            </button>
                        </div>

                        @if(isset($nome) || isset($email))
                            <div class="col s6 m6 l6">
                                <a href="{{ route('showUtilizadores') }}" class="right waves-effect waves-light btn red"><i class="material-icons left">close</i>Apagar filtro</a>
                            </div>
                        @endif

                    </div>
                </form>
            </div>

            <div class="caixa-delimitadora-fina">
                <h5>Todos os utilizadores</h5>

                <div class="divider"></div>

                <ul class="collection">

                    @foreach ($users as $user)

                        <li class="collection-item avatar">

                            <img src="{{ $user->imagem }}" alt="" class="circle">
                            <span class="title"><b>{{ $user->nome . ' ' . $user->apelido }}</b></span>
                            <p>{{ $user->email }} <br> {{ $user->created_at }}</p>

                            <a href="{{ route('editUtilizador', ['user' => $user->id]) }}" class="secondary-content btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>

                        </li>

                    @endforeach

                </ul>

                {{ $users->links() }}

            </div>

        </div>

        <div class="col l4 m12 s12">
            <div class="caixa-delimitadora-fina">

                <h5>Administradores</h5>

                <div class="divider"></div>

                <ul class="collection">

                    @foreach ($admins as $admin)

                        <li class="collection-item avatar">

                            <img src="{{ $admin->imagem }}" alt="" class="circle">
                            <span class="title"><b>{{ $admin->nome . ' ' . $admin->apelido }}</b></span>
                            <p>{{ $admin->getRank() }} <br> {{ $admin->created_at }}</p>

                            <a href="{{ route('editUtilizador', ['user' => $admin->id]) }}" class="secondary-content btn-floating btn-medium waves-effect waves-light blue"><i class="material-icons">mode_edit</i></a>

                        </li>

                    @endforeach

                </ul>

            </div>
        </div>


    </div>

@endsection