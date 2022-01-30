@extends('layouts.base')

@section('title')
Регистрация
@endsection

@section('background')
	<div class="background-effect" style="width:256px; height:256px; left:-108px; top: -128px"></div>
	<div class="background-effect reverse" style="width: 384px; height: 384px; right: -192px; bottom: -192px;"></div>
@endsection

@section('content')
	<x-title>Регистрация</x-title>
	<x-container inner>
		<x-panel>
			<x-form action='register-post' button-text='Войти'>
				<x-form.input name='email' label-text='Логин' placeholder='example@site.com' type='email'/>
				<x-form.input name='password' label-text='Пароль' type='password'/>
			</x-form>
		</x-panel>
	</x-container>
@endsection