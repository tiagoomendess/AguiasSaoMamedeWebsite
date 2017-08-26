@extends('painel.layouts.default-page')

@section('page_title')
    Definições
@endsection

@section('page_content')

    @include('painel.parcial.message')

    <div class="divider"></div>

    <form action="{{ route('updateSettings') }}" method="POST">

        {{ csrf_field() }}

        @foreach($settings as $setting => $value)

            <div class="row" style="padding-top: 5px;">

                <div class="col s6">
                    <p style="font-size: 16px;">{{ \App\Http\Controllers\SettingsController::getName($setting) }}<br> <small style="color: gray;">{{ $setting }}</small></p>
                </div>

                @if (gettype($value) == 'boolean')
                    <div class="col s6">
                        <div class="">
                            <div style="margin-top: 25px;" class="switch right">
                                <label>
                                    Off
                                    <input name="{{ $setting }}" type="checkbox" @if($value == true) checked @endif>
                                    <span class="lever"></span>
                                    On
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                @if (gettype($value) == 'string')
                    <div class="col s6 m6 l3 offset-l3">

                        <div class="">
                            <input style="margin-bottom: 0px;" name="{{ $setting }}" id="{{ $setting }}" type="text" value="{{ $value }}">
                        </div>

                    </div>
                @endif

                @if (gettype($value) == 'integer')
                    <div class="col s6 m6 l2 offset-l4">

                        <input style="margin-bottom: 0px;" name="{{ $setting }}" id="{{ $setting }}" type="number" value="{{ $value }}">

                    </div>
                @endif


            </div>

            <div class="divider"></div>
        @endforeach

    </form>

@endsection