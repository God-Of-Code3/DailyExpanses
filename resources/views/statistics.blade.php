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
		<div>Период<br>{{ $periodText }}</div>
		<div>{{ $typeText }}</div>
	</div>
	<button data-action data-action-click="activate" data-action-click-data="transaction-setting-modal">Настроить фильтры</button>
	<div class="hidden active" id='diagram' data-active-group='visualisation-type'>
		<x-diagram.diagram left='пред.' left-action='{{ route("statistics-get", ["shift" => $shift - 1]) }}' right='след.' right-action='{{ route("statistics-get", ["shift" => $shift + 1]) }}' text='{{ $sum }}' period='{{ $periodText }}'>
			@foreach($categories as $category)
				<x-diagram.sector color='{{ $category["color"] }}' percent='{{ $category["percent"] }}' />
			@endforeach
			
			<!-- <x-diagram.sector color='#5DCF76' percent='33' />
			<x-diagram.sector color='#499DFF' percent='10' />
			<x-diagram.sector color='#C549FF' percent='7' /> -->
		</x-diagram.diagram>
	</div>
	<div class="hidden" id='schedule' data-active-group='visualisation-type'>
		<x-schedule.schedule left='2021' right='' period='янв 2022'>
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
		@foreach($categories as $category)
			<x-vertical-list.vertical-list-item-progress percent='{{ $category["percent"] }}' sum='{{ $category["sum"] }}' color='{{ $category["color"] }}' category-name='{{ $category["name"] }}' />
		@endforeach 
	</x-vertical-list.vertical-list>
@endsection

@section('modals')
	<x-transaction-settings 
		type='statistics'
		periodValue='{{ $settings["period"] ? $settings["period"] : "" }}'
		typeValue='{{ $settings["type"] ? $settings["type"] : "" }}'
		fromValue='{{ $settings["start-period-date"] ? $settings["start-period-date"] : "" }}'
		toValue='{{ $settings["end-period-date"] ? $settings["end-period-date"] : "" }}'
	/>
@endsection

@section('menu')
	<x-menu.real-menu page='statistics' />
@endsection