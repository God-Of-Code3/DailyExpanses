@extends('layouts.base')

@section('title')
	История
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: 100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -52px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	История
@endsection

@section('content-up')
	<button data-action data-action-click="activate" data-action-click-data="transaction-setting-modal">Настроить фильтры</button>
	<div class="row row-aic row-jcsb">
		<div>Период<br>{{ $periodText }}<br>{{ $typeText }}</div>
		@if (!$category)
			<x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge>
		@else
			<x-badge color='{{ $category->color }}' icon="{{ $category->icon }}">{{ $category->name }}</x-badge>
		@endif
	</div>
@endsection

@section('content-down')
	<div class="t-center">
		Транзакции
	</div>
	<x-vertical-list.vertical-list>
		@foreach ($transactions as $transaction)
			<x-transaction-item transaction-id='{{ $transaction->id }}' />
		@endforeach
	</x-vertical-list.vertical-list>
@endsection

@section('modals')
	<x-transaction-settings 
		type='history'
		periodValue='{{ $settings["period"] ? $settings["period"] : "" }}'
		categoryValue='{{ $settings["category"] ? $settings["category"] : "" }}'
		typeValue='{{ $settings["type"] ? $settings["type"] : "" }}'
		fromValue='{{ $settings["start-period-date"] ? $settings["start-period-date"] : "" }}'
		toValue='{{ $settings["end-period-date"] ? $settings["end-period-date"] : "" }}'
	/>
@endsection