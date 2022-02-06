<x-menu.menu>
    <x-menu.menu-item active='{{ $page["main"] }}' href='main-get'>Главная</x-menu.menu-item>
    <x-menu.menu-item active='{{ $page["statistics"] }}' href='statistics-get'>Статистика</x-menu.menu-item>
    <x-menu.menu-item active='{{ $page["history"] }}' href='history-get'>История</x-menu.menu-item>
    <x-menu.menu-item active='{{ $page["forecast"] }}' href='forecast-get'>Проноз</x-menu.menu-item>
    <x-menu.menu-item active=''>Экспорт данных</x-menu.menu-item>
    @if (session('base_transaction'))
        <x-menu.menu-item active='' href='transaction-get' href-key='transaction_id' href-value="{{ session('base_transaction')['transaction_id'] }}">Базовый товар ({{ $sum }})</x-menu.menu-item>
    @else
        <x-menu.menu-item active='' disabled>Базовый товар (не выбран)</x-menu.menu-item>
    @endif
</x-menu.menu>