@extends('layouts.base')

@section('title')
	Экспорт данных
@endsection

@section('background')
	<div class="background-effect reverse" style="width:256px; height:256px; right:-130px; top: 100px"></div>
	<div class="background-effect" style="width: 120px; height: 120px; left: -52px; top: calc(50% + 20px);"></div>
@endsection

@section('page-title')
	Экспорт данных
@endsection

@section('content-up')
	<button data-action data-action-click="activate" data-action-click-data="filter-modal">Настроить фильтры</button>
	<div class="row row-aic row-jcsb">
		<div>Период<br>янв 2022</div>
		<x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge>
	</div>
	<x-tabs.tabs>
		<x-tabs.tab active data-action data-action-click='activate' data-action-click-data='xlsx-export'>XLSX</x-tab>
		<x-tabs.tab data-action data-action-click='activate' data-action-click-data='csv-export'>CSV</x-tab>
	</x-tabs.tabs>
	<button class='hidden active' id='xlsx-export' data-active-group='export-button'>Экспортировать в xlsx</button>
	<button class='hidden' id='csv-export' data-active-group='export-button'>Экспортировать в csv</button>
@endsection

@section('modals')
	<x-modal id='filter-modal' classes='modal-bottom' title='Настройки фильтра'>
		<x-form action='history-post' button-text='Применить'>
			<x-form.select name="type" label-text='Тип транзакций' data-action data-action-change='doSelectedOptionAction' data-action-change-data=''>
				<option value="all" data-action data-action-select-option='activate' data-action-select-option-data='all-categories'>Все</option>
				<option value="income" data-action data-action-select-option='activate' data-action-select-option-data='income-categories'>Доходы</option>
				<option value="outcome" selected data-action data-action-select-option='activate' data-action-select-option-data='outcome-categories'>Расходы</option>
			</x-form.select>
			
			<x-form.select name="period" label-text='Период' data-action data-action-change='doSelectedOptionAction' data-action-change-data=''>
				<option value="week" data-action data-action-select-option='deactivate' data-action-select-option-data='other-period-elements'>Неделя</option>
				<option value="month" data-action data-action-select-option='deactivate' data-action-select-option-data='other-period-elements'>Месяц</option>
				<option value="quarter" data-action data-action-select-option='deactivate' data-action-select-option-data='other-period-elements'>Квартал</option>
				<option value="year" data-action data-action-select-option='deactivate' data-action-select-option-data='other-period-elements'>Год</option>
				<option value="other" data-action data-action-select-option='activate' data-action-select-option-data='other-period-elements'>Свой период</option>
			</x-form.select>

			<div class="hidden mt-1" id='other-period-elements'>
				<x-form.input type="date" name="start-period-date" label-text='От' horizontal/>
				<x-form.input type="date" name="end-period-date" label-text='До' horizontal/>
			</div>

			<div class="hidden mt-1 active" data-active-group='categories' id='outcome-categories'>
				<x-form.material-select name='category-outcome' label-text='Категория'>
					<div class="selectable selected" data-value='0'><x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge></div>
					<div class="selectable" data-value='1'><x-badge color='#FECE54' icon='fas fa-bolt'>Электроника</x-badge></div>
					<div class="selectable" data-value='2'><x-badge color='#5DCF76' icon='fas fa-utensils'>Продукты</x-badge></div>
					<div class="selectable" data-value='3'><x-badge color='#499DFF' icon='fas fa-bus'>Транспорт</x-badge></div>
					<div class="selectable" data-value='4'><x-badge color='#C549FF' icon='fas fa-long-arrow-alt-right'>Переводы</x-badge></div>
				</x-form.material-select>
			</div>
			<div class="hidden mt-1" id='income-categories' data-active-group='categories'>
				<x-form.material-select name='category-income' label-text='Категория'>
					<div class="selectable selected" data-value='0'><x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge></div>
					<div class="selectable" data-value='1'><x-badge color='#5ED600' icon='fas fa-cash-register'>Банкомат</x-badge></div>
					<div class="selectable" data-value='2'><x-badge color='#5DCF76' icon='fas fa-long-arrow-alt-left'>Переводы</x-badge></div>
				</x-form.material-select>
			</div>
			<div class="hidden mt-1" id='all-categories' data-active-group='categories'>
				<x-form.material-select name='category-all' label-text='Категория'>
					<div class="selectable selected" data-value='0'><x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge></div>
					<div class="selectable" data-value='1'><x-badge color='#FECE54' icon='fas fa-bolt'>Электроника</x-badge></div>
					<div class="selectable" data-value='2'><x-badge color='#5DCF76' icon='fas fa-utensils'>Продукты</x-badge></div>
					<div class="selectable" data-value='3'><x-badge color='#499DFF' icon='fas fa-bus'>Транспорт</x-badge></div>
					<div class="selectable" data-value='4'><x-badge color='#C549FF' icon='fas fa-long-arrow-alt-right'>Переводы</x-badge></div>
					<div class="selectable" data-value='1'><x-badge color='#5ED600' icon='fas fa-cash-register'>Банкомат</x-badge></div>
					<div class="selectable" data-value='2'><x-badge color='#5DCF76' icon='fas fa-long-arrow-alt-left'>Переводы</x-badge></div>
				</x-form.material-select>
			</div>
		</x-form>
	</x-modal>
@endsection