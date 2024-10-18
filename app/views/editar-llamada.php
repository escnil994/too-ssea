<?php
$title = 'Editar llamada';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');
?>

<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>
	<main class="flex items-center justify-center">
		<form action="/atender-llamada" method="POST" class="w-96">
			<h2 class="text-center">Editar llamada</h2>
		</form>