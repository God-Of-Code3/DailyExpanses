<x-menu.menu>
    <x-menu.menu-item active='{{ $page["main"] }}' href='main-get'>Главная</x-menu.menu-item>
    <x-menu.menu-item active='{{ $page["statistics"] }}' href='statistics-get'>Статистика</x-menu.menu-item>
    <x-menu.menu-item active='{{ $page["history"] }}' href='history-get'>История</x-menu.menu-item>
    <x-menu.menu-item active=''>Проноз</x-menu.menu-item>
    <x-menu.menu-item active=''>Экспорт данных</x-menu.menu-item>
    <x-menu.menu-item active='' disabled>Базовый товар (не выбран)</x-menu.menu-item>
</x-menu.menu>