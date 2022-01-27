@extends('layouts.base')

@section('title')
Прогноз расходов
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; bottom: -100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -100px; top: 40px;"></div>
@endsection

@section('page-title')
Прогноз расходов
@endsection

@section('content-up')
	<div class="t-center">
		Нажмите на столбец интересующего месяца, чтобы узнать траты за этот месяц
		<div class="fz-1"></div>
	</div>
	<div class="t-center">
		<div class="fz-3">Данные за последние 4 месяца</div>
	</div>
	<x-schedule.schedule>
		<div class="schedule-columns">
			<x-schedule.column main-percent="20">ноя</x-schedule.column>
			<x-schedule.column main-percent="30">дек</x-schedule.column>
			<x-schedule.column main-percent="40">янв</x-schedule.column>
			<x-schedule.column main-percent="50" transparent-percent="100">фев</x-schedule.column>
		</div>
		<div class="legend">
			<x-schedule.indicator percent="0">0 Р</x-schedule.indicator>
			<x-schedule.indicator percent="20">80 000 Р</x-schedule.indicator>
			<x-schedule.indicator percent="100">400 000 Р</x-schedule.indicator>
		</div>
	</x-schedule>
	<div class="row row-center">
		<div class="">
			<div class="row row-aic row-inline"><span class='green-squad'></span> - Потрачено</div><br>
			<div class="row row-aic row-inline"><span class='green-transparent-squad'></span> - Прогноз трат</div>
		</div>
	</div>
	<x-panel>
		<div class="fz-2">Февраль 2022</div>
		<div class="fz-1 fw-2">45 000/<big class='fw-2'>50 000 Р</big></div>
		<div class="fz-3 fw-4">Потрачено/Прогноз трат</div>
	</x-panel>
@endsection


@section('modals')

@endsection