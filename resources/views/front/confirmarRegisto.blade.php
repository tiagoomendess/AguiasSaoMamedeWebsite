@extends('layouts.default-page')
@section('head')
    <title>Confirmar Registo</title>
@endsection

@section('conteudo')


    <div class="valign-wrapper">
        <div class="valign">

            <div class="row">
                <div class="col l6 m12 s12 center offset-l3">

                    @if(isset($infos))
                    @endif

                    @if($email != null)
                        <p>@lang('auth.email_confirm_tip', ['email' => $email])</p>
                    @else
                        <p>@lang('auth.email_confirm_tip', ['email' => ''])</p>
                    @endif

                    @include('parcial.errors', ['errors' => $errors])

                    <form action="/registar/confirmar" method="POST">

                        {{ csrf_field() }}

                        <div class="row">

                            @if($email == null)
                                <div class="input-field col s12 m12 l12">
                                    <input name="email" id="email" type="email" class="validate" value="{{ old('email') }}" required>
                                    <label for="email">@lang('auth.form_email')</label>
                                </div>
                            @else
                                <input type="hidden" name="email" value="{{ $email }}">
                            @endif

                            @if($token == null)
                                <div class="input-field col s12 m12 l12">
                                    <input name="token" id="token" type="text" class="validate" required>
                                    <label for="token">@lang('auth.email_confirm_token')</label>
                                </div>
                            @else
                                <input type="hidden" name="token" value="{{ $token }}">
                            @endif

                            <div class="form-group">
                                <div class="col s12 m12 l12 center">

                                    <div class="col s6 m6 l6">
                                        <a href="#">@lang('auth.email_confirm_resend')</a>
                                    </div>

                                    <div class="col s6 m6 l6">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('auth.email_confirm_submit')
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection