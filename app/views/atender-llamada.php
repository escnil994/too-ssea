<?php
$title = 'Atender llamada';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');

$tipoEmergencia = [
	'accidente',
	'incendio',
	'robo',
	'emergencia médica',
	'otro'
];

$tipoResolucion = [
	'grúa',
	'asistencia en accidente',
	'compra de combustible',
	'batería',
	'otro'
];

?>
<script>
	const clientes = <?php echo json_encode($clientes); ?>;
</script>

<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>
	<main class="flex items-center justify-center">
		<form action="/atender-llamada" method="POST" class="w-96">
			<h2 class="text-center">Atender llamada</h2>
			<label>
				Fecha
				<input type="date" name="fecha_llamada"
					value="<?php echo date('Y-m-d'); ?>" required>
			</label>
			<label>
				Hora
				<input type="time" name="hora_llamada"
					value="<?php echo date('H:i'); ?>" required>
			</label>
			<label>
				Duración (segundos)
				<input type="number" name="duracion" min="0" required>
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
				<input type="tel" name="telefono" required>
				<script>
					const iTelefono = document.querySelector('input[name="telefono"]');
					const sCliente = document.getElementById('cliente_id');

					sCliente.addEventListener('change', () => {
						const cliente = clientes.find(c => c.id == sCliente.value);
						iTelefono.value = cliente.telefono;
					});
				</script>
			</label>
			<label>
				Tipo de emergencia
				<select name="tipo_emergencia" id="tipo_emergencia">
					<?php foreach ($tipoEmergencia as $tipo) : ?>
						<option value="<?php echo $tipo; ?>">
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
	</main>