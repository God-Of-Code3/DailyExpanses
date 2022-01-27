@extends('layouts.base')

@section('title')
Транзакция
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: -120px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -64px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Транзакция
@endsection

@section('panel-full')
@endSection

@section('content-up')
	<div class="panel container">
		<div class="t-center">
			<div class="value value-big">
				-48 000 Р
			</div>
		</div>
		<div class="row row-jcsb">
			Категория
			<div class="badge badge-yellow">Электроника</div>
		</div>
	</div>
	<div class="panel container">
		<div class="t-center">
			Детали транзакции
		</div>
		<div class="row row-jcsb">
			<div class="">Дата</div>
			<div class="">7 янв 2022</div>
		</div>
		<div class="row row-jcsb">
			<div class="">Время</div>
			<div class="">15:03</div>
		</div>
	</div>
	<button>Сделать базовым</button>
@endsection

	

@section('modals')

@endsection