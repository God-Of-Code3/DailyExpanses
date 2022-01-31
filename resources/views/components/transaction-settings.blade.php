<x-modal id='transaction-setting-modal' classes='modal-bottom' title='{{ $title }}'>
    <x-form action='{{ $action }}' button-text='{{ $buttonText }}'>
        <x-form.select name="type" label-text='Тип транзакций' data-action data-action-change='doSelectedOptionAction' data-action-change-data=''>
            @if ($renderAllCategories)
                <option value="all" data-action data-action-select-option='activate' data-action-select-option-data='all-categories'>Все</option>
            @endif
            <option value="income" data-action data-action-select-option='activate' data-action-select-option-data='income-categories'>Доходы</option>
            <option value="outcome" selected data-action data-action-select-option='activate' data-action-select-option-data='outcome-categories'>Расходы</option>
        </x-form.select>
        
        @if ($renderPeriod)
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
        @endif

        @if ($renderSum)
            <x-form.input type="number" name="sum" label-text='Сумма, ₽'/>
        @endif

        @if ($renderCategories)
            <div class="hidden mt-1 active" data-active-group='categories' id='outcome-categories'>
                <x-form.material-select name='category-outcome' label-text='Категория'>
                    @if ($renderAllCategories)
                        <div class="selectable selected" data-value='0'><x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge></div>
                    @endif
                    <!-- Отображение всех расходных транзакций -->
                    @foreach ($outcomeCategories as $category)
                        <div class="selectable" data-value='{{ $category->id }}'><x-badge color='{{ $category->color }}' icon='{{ $category->icon }}'>{{ $category->name }}</x-badge></div>
                    @endforeach
                </x-form.material-select>
            </div>
            <div class="hidden mt-1" id='income-categories' data-active-group='categories'>
                <x-form.material-select name='category-income' label-text='Категория'>
                    @if ($renderAllCategories)
                        <div class="selectable selected" data-value='0'><x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge></div>
                    @endif
                    <!-- Отображение всех доходных транзакций -->
                    @foreach ($incomeCategories as $category)
                        <div class="selectable" data-value='{{ $category->id }}'><x-badge color='{{ $category->color }}' icon='{{ $category->icon }}'>{{ $category->name }}</x-badge></div>
                    @endforeach
                </x-form.material-select>
            </div>
            @if ($renderAllTypesOption)
                <div class="hidden mt-1" id='all-categories' data-active-group='categories'>
                    <x-form.material-select name='category-all' label-text='Категория'>
                        @if ($renderAllCategories)
                            <div class="selectable selected" data-value='0'><x-badge color='#fff' inverse icon="fas fa-circle">Все категории</x-badge></div>
                        @endif
                        <!-- Отображение всех транзакций -->
                        @foreach ($allCategories as $category)
                            <div class="selectable" data-value='{{ $category->id }}'><x-badge color='{{ $category->color }}' icon='{{ $category->icon }}'>{{ $category->name }}</x-badge></div>
                        @endforeach
                    </x-form.material-select>
                </div>
            @endif
        @endif
    </x-form>
</x-modal>