@extends('layouts.base')

@section('title')
Главная 2
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: 100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -52px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Личный кабинет
@endsection

@section('content-up')
	<x-panel>
		Остаток
		<div class="t-1">45 134,04 Р</div>
	</x-panel>
	<button>Добавить траанзакцию</button>
@endsection

@section('content-down')
	<div class="t-center">
		Последние транзакции
	</div>
	<x-vertical-list.vertical-list>
		<x-vertical-list.vertical-list-item sum='10000' color='yellow' category-name='Электроника' />
		<x-vertical-list.vertical-list-item sum='-2000' color='yellow' category-name='Электроника' />
		<x-vertical-list.vertical-list-item sum='13000' color='yellow' category-name='Электроника' />
	</x-vertical-list.vertical-list>
	<!-- <div class="vertical-list">
		<div class="vertical-list-item">
			<div class="left"><div class="badge badge-yellow">Электроника</div></div>
			<div class="right"><div class="value value-red">-48 000 Р</div><img src="img/arrow.svg" alt="Arrow" class="arrow-button"></div>
		</div>
	</div> -->
@endsection

@section('modals')
	
	<!-- <div class="modal">
		<div class="header">
			<div class="header-element modal-close">
				<img src="{{ asset('img/cross.svg') }}" alt="cross">
			</div>
			<div class="header-element page-title">Меню</div>
			<div class="header-element"></div>
		</div>
		
	</div> -->
@endsection