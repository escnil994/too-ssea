<?php
$title = 'Cancelar llamada';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');
?>

<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>
	<main class="flex items-center justify-center">
		<form action="/cancelar-llamada?id=<?php echo $llamada['id'] ?>" method="POST" class="w-96">
			<h2 class="text-center">Cancelar llamada</h2>
			<label>
				Describa por que se cancelo la llamada
				<textarea required placeholder="Comentario" name="comentario_cancel" rows="3"></textarea>
			</label>
			<button type="submit">Guardar</button>
		</form>