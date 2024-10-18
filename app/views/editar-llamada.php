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
			<label>
				Fecha
				<input type="date" name="fecha_llamada"
					value="<?php echo $llamada['fecha_llamada']; ?>" required>
			</label>
			<label>
				Hora
				<input type="time" name="hora_llamada"
					value="<?php echo $llamada['hora_llamada']; ?>" required>
			</label>
			<label>
				Duración (segundos)
				<input type="number" name="duracion" min="0" value="<?php echo $llamada['duracion']; ?>" required>
			</label>
			<label>
				Cliente
				<select name="cliente_id" id="cliente_id">
					<option value="">Seleccionar cliente</option>
					<?php foreach ($clientes as $cliente) : ?>
						<option value="<?php echo $cliente['id']; ?>">
							<?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>
			<label>
				Teléfono
				<input type="tel" name="telefono" required value="<?php echo $llamada['telefono'] ?>">
			</label>
			<label>
				Tipo de emergencia
				<select name="tipo_emergencia" id="tipo_emergencia">
					<?php foreach ($tipoEmergencia as $tipo) : ?>
						<option value="<?php echo $tipo; ?>" selected="<?php echo '' ?>">
							<?php echo ucfirst($tipo); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>
			<label>
				Tipo de resolución
				<select name="resolucion" id="resolucion">
					<?php foreach ($tipoResolucion as $tipo) : ?>
						<option value="<?php echo $tipo; ?>">
							<?php echo ucfirst($tipo); ?>
						</option>
					<?php endforeach; ?>
			</label>
			<label>
				Observaciones
				<textarea placeholder="Observaciones" name="observaciones" rows="3"></textarea>
			</label>
			<button type="submit">Guardar</button>
		</form>