@extends('painel.layouts.default-page')

@section('page_title')
    Editar sócio número {{ $socio->numero }}
@endsection

@section('page_content')

    @include('painel.parcial.message')

    <div class="row">

        <div class="col l5 m12 s12">
            <div class="caixa-delimitadora-fina">

                <table>
                    <tr>
                        <td>
                            {{ Html::image('storage/uploads/avatars/socios/' . $socio->imagem, 'Imagem de perfil de ' . $socio->nome, ['style' => 'width:100%']) }}
                        </td>
                        <td>
                            <h5>{{ $user->nome }}</h5>
                            <p> <b>Registo criado em:</b> <br> {{ $socio->created_at }} <br>
                                <b>Actualizado em:</b> <br> {{ $socio->updated_at }} <br>
                            </p>
                        </td>
                    </tr>
                </table>

            </div>


        </div>


        <div class="col l7 m12 s12">

            <div class="caixa-delimitadora-fina">

                <div class="row">
                    <div class="col l12">
                        @include('parcial.errors', ['errors' => $errors])
                    </div>
                </div>


                <form method="POST" action="{{ route('updateSocio', ['socio' => $socio]) }}">

                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <input name="nome" id="nome" type="text" class="validate" value="{{ old('nome', $socio->nome)}}" required>
                            <label for="nome">@lang('auth.form_name')</label>
                        </div>

                        <div class="row">
                            <div class="input-field col s12">
                                <input name="email" id="email" type="email" class="validate" value="{{ old('email', $socio->email)}}" required>
                                <label for="email">@lang('auth.form_email')</label>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        <div class="row">
                            <div class="input-field col s12 m12 l12 center">
                                <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('forms.guardar')
                                    <i class="material-icons right">save</i>
                                </button>

                                <a href="{{ route('showSocio', $socio) }}" class="white-text-btn waves-effect waves-light btn light-blue">CANCELAR <i class="material-icons right">cancel</i></a>

                            </div>


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