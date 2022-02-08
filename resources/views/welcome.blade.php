@extends('layouts.base')

@section('title')
Сервис для контроля повседневных расходов
@endsection

@section('background')
    <div class="background-effect" style="width:256px; height:256px; left:-108px; top: -128px"></div>
    <div class="background-effect reverse" style="width: 384px; height: 384px; right: -192px; bottom: -192px;"></div>
@endsection

@section('content')
    <x-title><br>Сервис для контроля повседневных расходов</x-title>
    <x-container inner>
        <x-panel classes='container'>
            <button data-action data-action-click='locate' data-action-click-data='{{ route("register-get") }}'>Регистрация</button>
            <button data-action data-action-click='locate' data-action-click-data='{{ route("login-get") }}'>Вход</button>
        </x-panel>
    </x-container>
@endsection