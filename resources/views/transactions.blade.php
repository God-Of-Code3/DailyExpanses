@extends('layouts.base')

@section('title')
Транзакции
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: 40vh"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: 52px; top: -60px;"></div>
@endsection

@section('page-title')
	Транзакции
@endsection

@section('content-up')
	<div class="">
		<x-form.select name='transaction-type' label-text='Тип транзакции' horizontal>
			<option value="all">Все</option>
			<option value="income">Доход</option>
			<option value="outcome">Расход</option>
		</x-form.select>
		<x-form.select name='period' label-text='Период' horizontal>
			<option value="month">Месяц</option>
			<option value="year">Год</option>
			<option value="week">Неделя</option>
		</x-form.select>
		<x-form.select name='category' label-text='Категория' horizontal>
			<option value="all">Все</option>
			<option value="1">Электроника</option>
			<option value="2">Продукты</option>
		</x-form.select>
	</div>
		
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
@endsection

@section('modals')

@endsection