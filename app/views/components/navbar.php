<?php
$isLogged =  isset($_SESSION['user_id']);
$role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
$userName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
?>

<header class="bg-white shadow sticky top-0">
	<nav class="container mx-auto px-6 py-0">
		<div class="flex w-full justify-between">
			<div class="text-xl font-bold text-gray-800">TOO</div>
			<div class="hidden md:flex space-x-6">
				<a href="/" class="text-gray-600 hover:text-gray-900 no-underline">Home</a>
				<?php if ($role === 'admin') : ?>
					<a href="/dashboard" class="text-gray-600 hover:text-gray-900 no-underline">Dashboard</a>
				<?php endif; ?>
				<?php if ($isLogged) : ?>
					<a href="/productos" class="text-gray-600 hover:text-gray-900 no-underline">Productos</a>
					<a href="/logout" class="text-gray-600 hover:text-gray-900 no-underline">Logout</a>
				<?php else : ?>
					<a href="/login" class="text-gray-600 hover:text-gray-900 no-underline">Login</a>
				<?php endif; ?>
			</div>
			<div class="md:hidden">
				<div class="w-full flex justify-end">
					<button id="menu-toggle" class="p-1">
						<svg class="size-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24">
							<path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
						</svg>
					</button>
				</div>
				<div id="mobile-menu" class="hidden mt-4 md:hidden ">
					<a href="/" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Home</a>
					<?php if ($role === 'admin') : ?>
						<a href="/dashboard" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Dashboard</a>
					<?php endif; ?>
					<?php if ($isLogged) : ?>
						<a href="/products" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Productos</a>
						<a href="/logout" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Logout</a>
					<?php else : ?>
						<a href="/login" class="block py-2 text-gray-600 hover:text-gray-900 no-underline">Login</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</nav>
</header>
<?php if ($isLogged) : ?>
	<div class="bg-gray-800 text-white text-center py-2">
		Hola, <?php echo $userName; ?>
		<?php if ($role === 'admin') : ?>
			<span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Admin</span>
		<?php endif; ?>
	</div>
<?php endif; ?>