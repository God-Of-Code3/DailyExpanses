<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@yield('title')</title>
	<link rel="stylesheet" href="/css/app.css">
	<link rel="stylesheet" href="/css/form.css">
	<link rel="stylesheet" href="/css/vertical-list.css">
	<link rel="stylesheet" href="/css/modal.css">
	<link rel="stylesheet" href="/css/menu.css">
	<link rel="stylesheet" href="/css/diagram.css">
	<link rel="stylesheet" href="/css/schedule.css">
	<script src="https://kit.fontawesome.com/63d029dc8e.js" crossorigin="anonymous"></script>
</head>
<body>
	<main>
		<div class="wrapper">
			@yield('background')

			@hasSection('page-title')
				<div class="container">
					<x-panel classes="container panel-top">
						<header class='header'>
							<div class='header-element'><button class="short" data-action data-action-click='activate' data-action-click-data='menu'><img src="{{ asset('img/bar.svg') }}" alt="Bar"></button></div>
							
							<div class="header-element page-title">@yield('page-title')</div>
							<div class='header-element'></div>
						</header>
						@yield('content-up')
					</x-panel>
					@hasSection('content-down')
						<x-panel classes='container'>
							@yield('content-down')
						</x-panel>
					@endif
			</div>
			@else
				@yield('content')
			@endif
			
		</div>
		@yield('modals')
	</main>
	<x-modal title='Меню' id='menu' classes='modal'>
		<!-- <x-menu.menu>
			<x-menu.menu-item href='main-get'>Главная</x-menu.menu-item>
			<x-menu.menu-item href='statistics-get'>Статистика</x-menu.menu-item>
			<x-menu.menu-item href='history-get'>История</x-menu.menu-item>
			<x-menu.menu-item>Прогноз</x-menu.menu-item>
			<x-menu.menu-item>Экспорт данных</x-menu.menu-item>
			<x-menu.menu-item disabled>Базовый товар (не выбран)</x-menu.menu-item>
		</x-menu.menu> -->
		@yield('menu')
	</x-modal>
	<script src='/js/app.js'></script>
	<script src='/js/diagram.js'></script>
</body>
</html>