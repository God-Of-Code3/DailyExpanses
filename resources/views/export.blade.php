@extends('layouts.base')

@section('title')
	Экспорт данных
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: 100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -52px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Экспорт данных
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
	<x-tabs.tabs>
		<x-tabs.tab active data-action data-action-click='activate' data-action-click-data='xlsx-export'>XLSX</x-tab>
		<x-tabs.tab data-action data-action-click='activate' data-action-click-data='csv-export'>CSV</x-tab>
	</x-tabs.tabs>
	<button class='hidden active' id='xlsx-export' data-active-group='export-button' 
	data-action 
	data-action-click='locate' 
	data-action-click-data='{{ route("export-get", ["export" => "xlsx"]) }}'
	>Экспортировать в xlsx</button>
	<button class='hidden' id='csv-export' data-active-group='export-button' 
	data-action 
	data-action-click='locate' 
	data-action-click-data='{{ route("export-get", ["export" => "csv"]) }}'
	>Экспортировать в csv</button>
@endsection

@section('modals')
	<x-transaction-settings 
		type='export'
		periodValue='{{ $settings["period"] ? $settings["period"] : "" }}'
		categoryValue='{{ $settings["category"] ? $settings["category"] : "" }}'
		typeValue='{{ $settings["type"] ? $settings["type"] : "" }}'
		fromValue='{{ $settings["start-period-date"] ? $settings["start-period-date"] : "" }}'
		toValue='{{ $settings["end-period-date"] ? $settings["end-period-date"] : "" }}'
	/>
@endsection

@section('menu')
	<x-menu.real-menu page='export' />
@endsection