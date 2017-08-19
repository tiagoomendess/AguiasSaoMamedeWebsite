@extends('painel.layouts.default-page')

@section('page_title')
    @lang('menu.utilizador')
@endsection

@section('page_content')

    @include('painel.parcial.message')

    <div class="row">

        <div class="col l5 m12 s12">
            <div class="caixa-delimitadora-fina">

                <table>
                    <tr>
                        <td>
                            <img class="circle" style="width: 70%" src="{{ $user->imagem }}" alt="">
                        </td>
                        <td>
                            <h5>{{ $user->nome . ' ' . $user->apelido }}</h5>
                            <p> <b>Registado em:</b> <br> {{ $user->created_at }} <br>
                                <b>Último Login:</b> <br>{{ $user->last_login }} <br>
                                <b>Actualizado em:</b> <br> {{ $user->updated_at }} <br>
                                <b>User ID:</b> <br> {{ $user->id }}
                            </p>
                        </td>
                    </tr>
                </table>

                <div class="row">
                    <div class="col l12">

                        @if ($user->isBanned())

                            <a class="waves-effect waves-light btn modal-trigger orange" href="#modal-unban"><i class="material-icons left">redo </i>Desbanir</a>

                            <div id="modal-unban" class="modal">
                                <div class="modal-content">
                                    <div class="col s10 m10 l10 offset-l1 offset-m1 offset-s1">
                                        <form method="POST" action="{{ route('unbanUser') }}">
                                            {{ csrf_field() }}

                                            <input type="hidden" name="user_id" value="{{ $user->id }}"> </input>

                                            <h4 class="center">
                                                Desbanir utilizador
                                            </h4>

                                            <p class="flow-text center">Tem a certeza que quer desbanir {{ $user->nome }} {{ $user->apelido }}</p>

                                            <div class="input-field">
                                                <div class="row">
                                                    <div class="col l6 m6 s6">
                                                        <a class="modal-action modal-close waves-effect waves-green btn green right">Não</a>
                                                    </div>

                                                    <div class="col s6 m6 l6">
                                                        <button type="submit" class="modal-action modal-close waves-effect waves-green btn red left">Sim</button>

                                                    </div>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        @else
                        <!-- Modal Trigger -->
                            <a class="waves-effect waves-light btn modal-trigger red" href="#modal-ban"><i class="material-icons left">gavel </i>Banir</a>

                            <!-- Modal Structure -->
                            <div id="modal-ban" class="modal">
                                <div class="modal-content">

                                    <div class="col s10 m10 l10 offset-l1 offset-m1 offset-s1">


                                        <h4 class="center">Banir utilizador</h4>
                                        <p class="flow-text center">Qual a razão para banir o utilizador {{ $user->nome }} {{ $user->apelido }}?</p>

                                        <div class="row">
                                            <form action="{{ route('banUser') }}" method="POST">
                                                <div class="input-field">

                                                    <div class="row">


                                                        <textarea id="description" name="description" class="materialize-textarea"></textarea>
                                                        <label for="description">Razão</label>

                                                    </div>

                                                    {{ csrf_field() }}

                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                                                </div>

                                                <div class="input-field">
                                                    <div class="row">
                                                        <div class="col l6 m6 s6">
                                                            <a class="modal-action modal-close waves-effect waves-green btn green right">Cancelar</a>
                                                        </div>

                                                        <div class="col s6 m6 l6">
                                                            <button type="submit" class="modal-action modal-close waves-effect waves-green btn red left">Banir</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        @endif
                    </div>
                </div>
            </div>


        </div>


        <div class="col l7 m12 s12">

            <div class="caixa-delimitadora-fina">

                <div class="row">
                    <div class="col l12">
                        @include('parcial.errors', ['errors' => $errors])
                    </div>
                </div>


                <form method="POST" action="{{ route('updateUtilizador', ['user' => $user]) }}">

                    <div class="row">
                        <div class="input-field col s6 m6 l6">
                            <input name="nome" id="first_name" type="text" class="validate" value="{{ old('nome', $user->nome)}}" required>
                            <label for="first_name">@lang('auth.form_name')</label>
                        </div>
                        <div class="input-field col s6 m6 l6">
                            <input name="apelido" id="last_name" type="text" class="validate" value="{{ old('apelido', $user->apelido)}}" required>
                            <label for="last_name">@lang('auth.form_last_name')</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="email" id="email" type="email" class="validate" value="{{ old('email', $user->email)}}" required>
                            <label for="email">@lang('auth.form_email')</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <p>Permissões:</p>

                            <select id="perm_level" name="perm_level" class="browser-default">
                                {{ $i = 0 }}
                                @for ($i = 1; $i <= Auth::user()->perm_level; $i = $i + 1)
                                    <option value="{{ $i }}" @if($i == $user->perm_level) selected @endif > {{ $user->getRankName($i) }} </option>
                                @endfor
                            </select>


                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="imagem" id="imagem" type="text" class="validate" value="{{ old('imagem', $user->imagem)}}" required>
                            <label for="imagem">@lang('forms.imagem_url')</label>
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <div class="row">
                        <div class="input-field col s12 m12 l12 center">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('forms.guardar')
                                <i class="material-icons right">save</i>
                            </button>

                            <a href="{{ route('showUtilizadores') }}" class="white-text-btn waves-effect waves-light btn light-blue">CANCELAR <i class="material-icons right">cancel</i></a>

                        </div>



                    </div>

                    {{ csrf_field() }}

                </form>
            </div>
        </div>


    </div>
    </div>

@endsection

@section ('after-scripts')
    <script>
        $('#modal-ban').modal()
        $('#modal-unban').modal();
    </script>
@endsection