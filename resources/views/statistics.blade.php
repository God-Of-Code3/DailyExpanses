@extends('layouts.base')

@section('title')
Статистика
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: -120px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -64px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Статистика
@endsection

@section('content-up')
	<div class="row row-aic row-jcsb">
		<div>Период<br>янв 2022</div>
		<div>Расходы</div>
	</div>
	<button data-action data-action-click="activate" data-action-click-data="transaction-setting-modal">Настроить фильтры</button>
	<div class="hidden active" id='diagram' data-active-group='visualisation-type'>
		<x-diagram.diagram left='2021' right='2023' text='64 000 Р' period='янв 2022'>
			<x-diagram.sector color='#FECE54' percent='50' />
			<x-diagram.sector color='#5DCF76' percent='33' />
			<x-diagram.sector color='#499DFF' percent='10' />
			<x-diagram.sector color='#C549FF' percent='7' />
		</x-diagram.diagram>
	</div>
	<div class="hidden" id='schedule' data-active-group='visualisation-type'>
		<x-schedule.schedule left='2021' right='2023' period='янв 2022'>
			<div class="schedule-columns">
				<x-schedule.column height="100" text='1'>
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="90">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="80" text='3'>
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="76" text='29'>
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="50">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="43">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="62">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="80">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="20" text='9'>
					<x-schedule.column-filler height="40" color='#FECE54'/>
					<x-schedule.column-filler height="60" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="10">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="0" text='31'>
					<x-schedule.column-filler height="50" color='#FECE54'/>
					<x-schedule.column-filler height="50" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="100">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="76" text='29'>
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="50">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="43">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="62">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="80">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="21">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="15" color='#5DCF76'/>
					<x-schedule.column-filler height="75" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="10">
					<x-schedule.column-filler height="40" color='#FECE54'/>
					<x-schedule.column-filler height="60" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="57">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="98">
					<x-schedule.column-filler height="50" color='#FECE54'/>
					<x-schedule.column-filler height="50" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="100">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="76">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="50">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="43">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="62">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="80">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="90" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="21">
					<x-schedule.column-filler height="10" color='#FECE54'/>
					<x-schedule.column-filler height="15" color='#5DCF76'/>
					<x-schedule.column-filler height="75" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="10">
					<x-schedule.column-filler height="40" color='#FECE54'/>
					<x-schedule.column-filler height="60" color='#C549FF'/>
				</x-schedule.column>
				<x-schedule.column height="57">
					<x-schedule.column-filler height="25" color='#FECE54'/>
					<x-schedule.column-filler height="25" color='#5DCF76'/>
					<x-schedule.column-filler height="50" color='#499DFF'/>
				</x-schedule.column>
				<x-schedule.column height="98">
					<x-schedule.column-filler height="50" color='#FECE54'/>
					<x-schedule.column-filler height="50" color='#C549FF'/>
				</x-schedule.column>
			</div>
			<div class="legend">
				<x-schedule.indicator percent='0'>0 Р</x-schedule.indicator>
				<x-schedule.indicator percent='50'>20 000 Р</x-schedule.indicator>
				<x-schedule.indicator percent='100'>40 000 Р</x-schedule.indicator>
			</div>
		</x-schedule>
	</div>
	
	<x-tabs.tabs>
		<x-tabs.tab active data-action data-action-click='activate' data-action-click-data='diagram'><i class="fas fa-chart-pie"></i></x-tabs.tab>
		<x-tabs.tab data-action data-action-click='activate' data-action-click-data='schedule'><i class="fas fa-chart-bar"></i></x-tabs.tab>
	</x-tabs.tabs>
	<div class="t-center">
		Категории расходов
	</div>
	<x-vertical-list.vertical-list>
		<x-vertical-list.vertical-list-item-progress percent='50' sum='32000' color='#FECE54' category-name='Электроника' />
		<x-vertical-list.vertical-list-item-progress percent='33' sum='21120' color='#5DCF76' category-name='Продукты' />
		<x-vertical-list.vertical-list-item-progress percent='10' sum='6400' color='#499DFF' category-name='Транспорт' />
		<x-vertical-list.vertical-list-item-progress percent='7' sum='4480' color='#C549FF' category-name='Категория' />
	</x-vertical-list.vertical-list>
@endsection

@section('modals')
	<x-transaction-settings type='statistics' />
@endsection