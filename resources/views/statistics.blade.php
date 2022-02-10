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
		<x-diagram.diagram left='пред.' left-action='{{ route("statistics-get", ["shift" => $shift - 1]) }}' right='след.' right-action='{{ route("statistics-get", ["shift" => $shift + 1]) }}' text='{{ $sum }}' period='{{ $periodText }}' null='{{ !$categories }}' block-period='{{ $settings["period"] == "other" }}'>
			@foreach($diagramSectors as $diagramSector)
				<x-diagram.sector color='{{ $diagramSector["color"] }}' percent='{{ $diagramSector["percent"] }}' />
			@endforeach
			
			<!-- <x-diagram.sector color='#5DCF76' percent='33' />
			<x-diagram.sector color='#499DFF' percent='10' />
			<x-diagram.sector color='#C549FF' percent='7' /> -->
		</x-diagram.diagram>
	</div>
	<div class="hidden" id='schedule' data-active-group='visualisation-type'>
		<div class="t-center fz-3 fw-3">
			{{ $mode }}

		</div><br>
		<x-schedule.schedule left='пред.' left-action='{{ route("statistics-get", ["shift" => $shift - 1]) }}' right='след.' right-action='{{ route("statistics-get", ["shift" => $shift + 1]) }}' text='{{ $sum }}' period='{{ $periodText }}' block-period='{{ $settings["period"] == "other" }}'>
			<div class="schedule-columns">
				@foreach($sectors as $sector)
					<x-schedule.column height="{{ $sector['height'] }}" text="{{ $sector['number'] }}">
						@foreach($sector['transactions'] as $trs)
							<x-schedule.column-filler height="{{ $trs['sum'] / $sector['sum'] * 100 }}" color="{{ $trs['color'] }}"/>
						@endforeach
					</x-schedule.column>
				@endforeach
			</div>
			<div class="legend">
				@foreach ($indicators as $indicator)
					<x-schedule.indicator percent='{{ $indicator[0] }}'>{{ $indicator[1] }}</x-schedule.indicator>
				@endforeach
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
		@foreach($categories as $i => $category)
			@if($i == $otherLevel and $otherLevel != 0)
			<div class="row row-center">
				<div class="badge" style="background-color: #ABABAB">Другое</div>
			</div>
			@endif
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