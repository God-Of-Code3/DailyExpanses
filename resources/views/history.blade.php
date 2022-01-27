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
	<x-tabs.tabs>
		<x-tabs.tab active>Расходы</x-tabs.tab>
		<x-tabs.tab>Доходы</x-tabs.tab>
	</x-tabs.tabs>
	<div class="row row-aic row-jcsb">
		Фильтры
		<button>Настроить</button>
	</div>
@endsection

@section('content-down')
	
@endsection

@section('modals')
	
@endsection