@extends('layouts.default-page')

@section('head')
    <title>São Mamede | Entrar</title>
@endsection

@section('conteudo')

    <div class="row">
        <h1 class="center-align">@lang('auth.login_title')</h1>
        <p class="center">@lang('auth.login_tip')</p>
    </div>

        <div class="row">

            <div class="col l6 m12 s12 center offset-l3">
                @include('parcial.errors', ['errors' => $errors])
            </div>

            <div class="col l6 m12 s12 center offset-l3">

                <form method="POST" action="/login" class="">

                    {{ csrf_field() }}

                    <div class="row">

                        <div class="input-field col s12 m12 l6">
                            <input name="email" id="email" type="email" class="validate" value="{{ old('email') }}" required>
                            <label for="email">@lang('auth.form_email') @lang('')</label>
                        </div>

                        <div class="input-field col s12 m12 l6">
                            <input name="password" id="password" type="password" class="validate" required>
                            <label for="password">@lang('auth.form_password')</label>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col s6">
                            <input name="remember" type="checkbox" id="remember-me" />
                            <label for="remember-me">@lang('auth.remember')</label>
                        </div>

                        <div class="col s6">
                            <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('auth.login_btn')
                                <i class="material-icons right">send</i>
                            </button>
                        </div>

                    </div>

                </form>

                @if($errors->has('auth_error'))
                    <a href="/password/reset">@lang('auth.forgot_password')</a>
                @endif


                <div>

                </div>
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