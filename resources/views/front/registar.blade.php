@extends('layouts.default-page')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>São Mamede | Registar</title>
@endsection

@section('conteudo')

        <div class="row">
            <h1 class="center">Registar</h1>
            <p class="center">Preencha os campos abaixo para criar uma nova conta no site do São Mamede</p>
        </div>

        <div class="row">
            
            <div class="col l6 m12 s12 center offset-l3">
                @include('parcial.errors', ['errors' => $errors])
            </div>

            <div class="col l6 m12 s12 center offset-l3">

                <form method="POST" action="/registar" class="col s12">

                    <div class="row">
                        <div class="input-field col s6">
                            <input name="nome" id="first_name" type="text" class="validate" value="{{ old('nome') }}" required>
                            <label for="first_name">@lang('auth.form_name')</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="apelido" id="last_name" type="text" class="validate" value="{{ old('apelido') }}" required>
                            <label for="last_name">@lang('auth.form_last_name')</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="email" id="email" type="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">@lang('auth.form_email')</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password" id="password" type="password" class="validate" required>
                            <label for="password">@lang('auth.form_password')</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password_confirmation" id="password_confirmation" type="password" class="validate" required>
                            <label for="password_confirmation">@lang('auth.form_password_confirm')</label>
                        </div>
                    </div>

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="row">
                        <div class="input-field center center-block">
                            {!! app('captcha')->display($attributes = [], $lang = Lang::getLocale()) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m12 l12 center">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('auth.register_btn')
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>

                </form>


                <p>Ou</p>

                <div class="col l8 m12 s12 offset-l2 center">
                    <a href="/login/social/facebook"><button class="login-facebook-btn"><i class="fa fa-facebook-official" aria-hidden="true"></i> @lang('auth.login_with_facebook_btn')</button></a>
                    <a href="/login/social/twitter"><button class="login-twitter-btn"><i class="fa fa-twitter-square" aria-hidden="true"></i> @lang('auth.login_with_twitter_btn')</button></a>
                    <a href="/login/social/google"><button class="login-google-btn"><i class="fa fa-google-plus-square" aria-hidden="true"></i> @lang('auth.login_with_google_btn')</button></a>
                </div>

            </div>
        </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            Materialize.updateTextFields();
        });
    </script>
@endsection