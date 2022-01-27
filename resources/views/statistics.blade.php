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
	<x-form.select name='period' label-text='Период' horizontal>
		<option value="month">Месяц</option>
		<option value="year">Год</option>
		<option value="week">Неделя</option>
	</x-form.select>
	<x-diagram.diagram>
		<x-diagram.sector color='#FECE54' percent='50' />
		<x-diagram.sector color='#5DCF76' percent='33' />
		<x-diagram.sector color='#499DFF' percent='10' />
		<x-diagram.sector color='#C549FF' percent='7' />
	</x-diagram.diagram>
	<x-tabs.tabs>
		<x-tabs.tab active>Расходы</x-tabs.tab>
		<x-tabs.tab>Доходы</x-tabs.tab>
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

@endsection