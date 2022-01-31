@extends('layouts.base')

@section('title')
Главная
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: 100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -52px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Личный кабинет
@endsection

@section('content-up')
	<x-panel>
		Остаток
		<div class="t-1">{{ $money }}</div>
	</x-panel>
	<button data-action data-action-click='activate' data-action-click-data='transaction-setting-modal'>Добавить транзакцию</button>
@endsection

@section('content-down')
	<div class="t-center">
		Последние транзакции
	</div>

	<x-vertical-list.vertical-list>
		<!-- <x-vertical-list.vertical-list-item sum='-10000' color='#FECE54' category-name='Электроника' icon='fas fa-bolt' />
		<x-vertical-list.vertical-list-item sum='-1300' color='#499DFF' category-name='Транспорт' icon='fas fa-bus' />
		<x-vertical-list.vertical-list-item sum='1000' color='#51D600' category-name='Банкомат' icon='fas fa-cash-register' />
		<x-vertical-list.vertical-list-item sum='-7600' color='#553AFA' category-name='Одежда' icon='fas fa-tshirt' /> -->
		@foreach ($transactions as $transaction)
			<x-transaction-item transaction-id='{{ $transaction->id }}' />
		@endforeach
	</x-vertical-list.vertical-list>
	<!-- <div class="vertical-list">
		<div class="vertical-list-item">
			<div class="left"><div class="badge badge-yellow">Электроника</div></div>
			<div class="right"><div class="value value-red">-48 000 Р</div><img src="img/arrow.svg" alt="Arrow" class="arrow-button"></div>
		</div>
	</div> -->
@endsection

@section('modals')
	<x-transaction-settings type='main' />
@endsection