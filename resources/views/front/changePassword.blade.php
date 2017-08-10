@extends('layouts.default-page')

@section('head')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <title>São Mamede | Nova Password</title>
@endsection

@section('conteudo')

    <div class="row">

        <div class="col s12 m12 l6 offset-l3 center">

            <div class="row">
                <div class="col s12 center">
                    <h1>@lang('auth.change_password_title')</h1>
                    <p>@lang('auth.change_password_tip')</p>
                </div>
            </div>

            <form action="/password/change" method="POST">

                {!! csrf_field() !!}

                <input type="hidden" name="token" value="{{ $token }}">

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

                <div class="row">
                    <div class="input-field center center-block">
                        {!! app('captcha')->display([], Lang::getLocale()) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m12 l12 center">
                        <button class="btn waves-effect waves-light green" type="submit" name="action">@lang('auth.change_password_btn')
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
