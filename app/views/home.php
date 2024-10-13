<?php
$title = 'Home';
require_once __DIR__ . '/components/header.php';
?>

<body class="bg-gray-50">
	<?php require_once __DIR__ . '/components/navbar.php'; ?>

	<section class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-20">
		<div class="container mx-auto px-6 text-center">
			<h1 class="text-4xl md:text-6xl font-bold mb-4">MVC</h1>
			<p class="text-xl md:text-2xl mb-8 text-gray-100">Modelo Vista Controlador</p>
			<a href="<?= $isLogged ? ($role === 'admin' ? '/dashboard' : '/productos') : '/login' ?>" class="bg-white text-indigo-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition duration-300 inline-flex items-center no-underline">
				Empezar
				<i class="fas fa-arrow-right ml-2"></i>
			</a>
		</div>
	</section>

	<section class="py-20 bg-gray-50">
		<div class="container mx-auto px-6">
			<h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Funciones</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-12">
				<div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300">
					<div class="text-indigo-500 mb-4">
						<i class="fas fa-bolt text-4xl"></i>
					</div>
					<h3 class="text-xl font-semibold mb-2 text-gray-600">Inicio de sesión</h3>
					<p class="text-gray-600">
						Permite a los usuarios iniciar sesión en la aplicación.
					</p>
				</div>
				<div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300">
					<div class="text-indigo-500 mb-4">
						<i class="fas fa-shield-alt text-4xl"></i>
					</div>
					<h3 class="text-xl font-semibold mb-2 text-gray-600">Productos</h3>
					<p class="text-gray-600">
						Permite a los usuarios ver, agregar, editar y eliminar productos.
					</p>
				</div>
				<div class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition duration-300">
					<div class="text-indigo-500 mb-4">
						<i class="fas fa-smile text-4xl"></i>
					</div>
					<h3 class="text-xl font-semibold mb-2 text-gray-600">
						Interfaz intuitiva
					</h3>
					<p class="text-gray-600">
						Interfaz de usuario fácil de usar para una mejor experiencia.
					</p>
				</div>
			</div>
		</div>
	</section>

	<footer class="bg-gray-800 text-white py-8">
		<div class="container mx-auto px-6">
			<h4 class="text-lg font-bold mb-4 text-center">Tecnología Orientada a Objetos</h4>
			<p class="text-gray-400 text-center">Tecnología Orientada a Objetos</p>
			<div class="border-t border-gray-700 mt-8 pt-8 text-sm text-center">
				<p>&copy; 2024 Universidad de El Salvador.</p>
			</div>
		</div>
	</footer>

	<script>
		document.getElementById('menu-toggle').addEventListener('click', function() {
			document.getElementById('mobile-menu').classList.toggle('hidden');
		});
	</script>
</body>