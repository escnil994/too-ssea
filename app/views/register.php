<?php
$title = 'Resiter';
require_once __DIR__ . '/components/header.php';
?>

<body class="h-screen flex items-center justify-center">
	<main class="w-96">
		<h2 class="text-center">Register</h2>
		<form action="/register" method="POST">
			<input type="text" name="name" placeholder="Name" required>
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<button type="submit">Registrarse</button>
		</form>
		<p class="text-center">
			Ya tienes una cuenta? <a href="/login" class="text-blue-500">Iniciar sesión</a>
		</p>
		<p class="text-center">
			<a href="/" class="text-blue-500">Volver al inicio</a>
		</p>

		<?php if (isset($error)): ?>
			<div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
				<span class="font-medium">Error!</span> <?php echo $error; ?>
			</div>
		<?php endif; ?>
	</main>
</body>