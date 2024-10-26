<?php
$title = 'Seguimiento llamada';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');

$tipoCalificacion = [
	'mala',
	'aceptable',
	'Excelente'
];
?>

<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>
	<main class="flex items-center justify-center">
		<form action="/seguimiento-llamada?id=<?php echo $llamada['id'] ?>" method="POST" class="w-96">
			<h2 class="text-center">Seguimiento llamada</h2>
			<label>
				Calificación de llamada
				<select name="calidad_servicio" id="calidad_servicio">
					<?php foreach ($tipoCalificacion as $tipo) : ?>
						<option value="<?php echo $tipo; ?>">
							<?php echo ucfirst($tipo); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>
			<label>
				Comentario
				<textarea required placeholder="observaciones" name="observaciones" rows="3"></textarea>
			</label>			
			<button type="submit">Guardar</button>
		</form>