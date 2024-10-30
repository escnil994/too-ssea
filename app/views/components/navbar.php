<?php
$isLogged = isset($_SESSION['usuario_id']);
$role = isset($_SESSION['usuario_rol']) ? $_SESSION['usuario_rol'] : null;
$userName = isset($_SESSION['usuario_nombre']) ? $_SESSION['usuario_nombre'] : null;
?>

<header class="bg-white shadow sticky top-0">
	<nav class="container mx-auto px-6 py-0">
		<div class="flex w-full justify-between">
			<div class="text-xl font-bold text-gray-800">TOO</div>
			<div class="hidden md:flex space-x-6 text-sm items-center">
				<a href="/" class="text-gray-600 hover:text-gray-900 no-underline">Home</a>
				<?php if ($role === 'admin'): ?>
					<a href="/dashboard" class="text-gray-600 hover:text-gray-900 no-underline">Dashboard</a>
				<?php endif; ?>
				<?php if ($role === 'operador'): ?>
					<a href="/llamadas-atendidas" class="text-gray-600 hover:text-gray-900 no-underline">Atenciones</a>
					<a href="/atender-llamada" class="text-gray-600 hover:text-gray-900 no-underline">
						Atender llamada
					</a>
				<?php endif; ?>
				<?php if ($isLogged): ?>
					<?php if ($role === 'gerente'): ?>
						<a href="/seguimiento-llamadas-atendidas"
							class="text-gray-600 hover:text-gray-900 no-underline">Llamadas atendidas</a>
						<a href="/seguimiento-llamadas-pendientes" class="text-gray-600 hover:text-gray-900 no-underline">
							Llamadas pendientes
						</a>
						<a href="/seguimiento-llamadas-canceladas"
							class="text-gray-600 hover:text-gray-900 no-underline">Llamadas Canceladas</a>

						<a href="/reportes" class="text-gray-600 hover:text-gray-900 no-underline">
							Reportes
						</a>



					<?php endif; ?>

					<?php if ($role === 'administrador'): ?>
						<a href="/administrar-usuarios"
							class="text-gray-600 hover:text-gray-900 no-underline">Usuarios</a>
					

					<?php endif; ?>




					<a href="/logout" class="text-gray-600 hover:text-gray-900 no-underline">Logout</a>
				<?php else: ?>
					<a href="/login" class="text-gray-600 hover:text-gray-900 no-underline">Login</a>
				<?php endif; ?>
			</div>
			<div class="md:hidden">
				<div class="w-full flex justify-end">
					<button id="menu-toggle" class="p-1">
						<svg class="size-5 text-gray-800 dark:text-white" aria-hidden="true"
							xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24">
							<path stroke="currentColor" stroke-linecap="round" stroke-width="2"
								d="M5 7h14M5 12h14M5 17h14" />
						</svg>
					</button>
				</div>
				<div id="mobile-menu" class="hidden mt-4 md:hidden ">
					<a href="/" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Home</a>
					<?php if ($role === 'admin'): ?>
						<a href="/dashboard" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Dashboard</a>
					<?php endif; ?>
					<?php if ($isLogged): ?>
						<a href="/products" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Productos</a>
						<a href="/logout" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Logout</a>
					<?php else: ?>
						<a href="/login" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Login</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</nav>
</header>
<?php if ($isLogged): ?>
	<div class="bg-gray-800 text-white text-center py-2">
		Hola, <?php echo $userName; ?>
		<?php switch ($role):
			case 'administrador': ?>
				<span
					class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Admin</span>
				<?php break; ?>
				<?php
			case 'operador': ?>
				<span
					class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Operador</span>
				<?php break; ?>
				<?php

			case 'gerente': ?>
				<span
					class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Gerente</span>
				<?php break; ?>
				<?php
			default: ?>
				<span
					class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-gray-900 dark:text-gray-300">Cliente</span>
				<?php break; ?>
		<?php endswitch; ?>
	</div>
<?php endif; ?>