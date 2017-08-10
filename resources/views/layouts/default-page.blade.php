<!-- Esta é a abstract view default-page filha de layout -->
@extends('layouts.layout')

@include('parcial.head')
@section('head')
    @yield('head')
@endsection

@section('body')

    <div id="wrapper">

        <header>
            <div id="header">
                @include('parcial.navbar')
            </div>
        </header>


        <main>
            <div id="content">
                <div class="container">
                    <div class="conteudo">
                        @yield('conteudo')
                    </div>
                </div>
            </div>
        </main>

        <div id="footer">
            @include('parcial.footer')
        </div>
    </div>

    @include('parcial.errors')
    @include('parcial.scripts')
    @yield('scripts')

@endsection

