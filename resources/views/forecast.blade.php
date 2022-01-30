@extends('layouts.base')

@section('title')
Прогноз
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; bottom: -100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -100px; top: 40px;"></div>
@endsection

@section('page-title')
Прогноз
@endsection

@section('content-up')
	<x-panel classes='container'>
		<div class="t-center fz-2">Февраль 2022</div>
		<div class="t-center fz-1 fw-2">45 000/50 000 Р</div>
		<div class="t-center fz-3 fw-4">Потрачено/Прогноз трат</div>
	</x-panel>
	<x-panel classes='container'>
		<div class="t-center">Прогноз текущего остатка с учетом инфляции на срок</div>
		<x-tabs.tabs classes='tabs-3'>
			<x-tabs.tab active data-action data-action-click='activate' data-action-click-data='month-3-forecast'>3 мес</x-tabs.tab>
			<x-tabs.tab data-action data-action-click='activate' data-action-click-data='month-6-forecast'>6 мес</x-tabs.tab>
			<x-tabs.tab data-action data-action-click='activate' data-action-click-data='year-forecast'>Год</x-tabs.tab>
		</x-tabs.tabs>
		<div class="t-center">
			<div data-active-group='forecast' id='month-3-forecast' class="hidden active fz-1 fw-2">35 000 Р</div>
			<div data-active-group='forecast' id='month-6-forecast' class="hidden fz-1 fw-2">34 000 Р</div>
			<div data-active-group='forecast' id='year-forecast' class="hidden fz-1 fw-2">33 000 Р</div>
		</div>
			
	</x-panel>
@endsection


@section('modals')

@endsection