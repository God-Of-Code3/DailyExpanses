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
		<div>Период<br>янв 2022</div>
		<x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge>
	</div>
@endsection

@section('content-down')
	<div class="t-center">
		Транзакции
	</div>
	<x-vertical-list.vertical-list>
		<x-vertical-list.vertical-list-item sum='-10000' color='#FECE54' category-name='Электроника' icon='fas fa-bolt' />
		<x-vertical-list.vertical-list-item sum='-1300' color='#499DFF' category-name='Транспорт' icon='fas fa-bus' />
		<x-vertical-list.vertical-list-item sum='1000' color='#51D600' category-name='Банкомат' icon='fas fa-cash-register' />
		<x-vertical-list.vertical-list-item sum='-7600' color='#553AFA' category-name='Одежда' icon='fas fa-tshirt' />
	</x-vertical-list.vertical-list>
@endsection

@section('modals')
	<x-transaction-settings type='history' />
@endsection