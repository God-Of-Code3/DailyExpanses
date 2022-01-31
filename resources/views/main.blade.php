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
		@foreach ($transactions as $transaction)
			<x-transaction-item transaction-id='{{ $transaction->id }}' />
		@endforeach
	</x-vertical-list.vertical-list>
@endsection

@section('modals')
	<x-transaction-settings type='main' />
@endsection