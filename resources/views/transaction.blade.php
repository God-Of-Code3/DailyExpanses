@extends('layouts.base')

@section('title')
Транзакция
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: -120px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -64px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Транзакция
@endsection

@section('panel-full')
@endSection

@section('content-up')
	<div class="panel container">
		<div class="t-center">
			<div class="value value-big {{ $valueClass }}">
				{{ $sum }}
			</div>
		</div>
		<div class="row row-jcsb">
			Категория
			<x-badge color='{{ $category->color }}' icon='{{ $category->icon }}'>{{ $category->name }}</x-badge>
		</div>
	</div>
	<div class="panel container">
		<div class="t-center">
			Детали транзакции
		</div>
		<div class="row row-jcsb">
			<div class="">Дата</div>
			<div class="">{{ $date }}</div>
		</div>
		<div class="row row-jcsb">
			<div class="">Время</div>
			<div class="">{{ $time }}</div>
		</div>
	</div>
	<div class="row-2">
		<button data-action data-action-click='activate' data-action-click-data='transaction-setting-modal'>Изменить</button>
		<button class='red' data-action data-action-click='locate' data-action-click-data='{{ route("transaction-get-remove", ["transaction_id"=>$transaction->id]) }}'>Удалить</button>
	</div>
	<button>Сделать базовым</button>
@endsection

	

@section('modals')
	<x-transaction-settings 
		type='transaction' 
		transaction-id='{{ $transaction->id }}' 
		type-value='{{ $transaction->sum < 0 ? "outcome" : "income" }}'
		sum-value='{{ abs($transaction->sum) }}'
		category-value='{{ $category->id }}'
	/>
@endsection

@section('menu')
	<x-menu.real-menu page='' />
@endsection