<?php
$title = 'Llamadas atendidas';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');
?>

<script>
	const llamadas = <?php echo json_encode($llamadas); ?>;
	console.log(llamadas);
</script>

<body>
	<?php require_once __DIR__ . '/components/navbar.php'; ?>
	<main class="flex w-full overflow-x-auto">
		<table class="table-auto text-sm">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Hora</th>
					<th class="text-nowrap">Duración (s)</th>
					<th>Cliente</th>
					<th>Teléfono</th>
					<th>Tipo de emergencia</th>
					<th>Resolución</th>
					<th>Operador</th>
					<th>Observaciones</th>
					<th>Estado</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($llamadas as $llamada) : ?>
					<tr class="group">
						<td class="text-nowrap"><?php echo $llamada['fecha_llamada']; ?></td>
						<td><?php echo $llamada['hora_llamada']; ?></td>
						<td><?php echo $llamada['duracion']; ?></td>
						<td><?php echo $llamada['cliente']['nombre'] . " " . $llamada['cliente']['apellido']; ?></td>
						<td><?php echo $llamada['telefono']; ?></td>
						<td><?php echo ucfirst($llamada['tipo_emergencia']); ?></td>
						<td><?php echo ucfirst($llamada['resolucion']); ?></td>
						<?php if ($role === 'gerente'): ?>
							<td><?php echo $llamada['operador_nombre']; ?></td> <?php endif; ?>
						<td class="text-xs"><?php echo $llamada['observaciones']; ?></td>
						<td><?php echo ucfirst($llamada['estado']); ?></td>
						<td>
							<?php 
								if(strtolower($llamada['estado']) == 'pendiente'){ ?>
							<div class="flex gap-2">
								<abbr class="transition-opacity opacity-0 group-hover:opacity-100" title="Seguimiento">
									<a href="/seguimiento-llamada?id=<?php echo $llamada['id']; ?>" class="text-blue-500">
										<svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
											<path fill-rule="evenodd" d="M2 6a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6Zm4.996 2a1 1 0 0 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 8a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 11a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Zm-4.004 3a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM11 14a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2h-6Z" clip-rule="evenodd" />
										</svg>
									</a>
								</abbr>
								<abbr class="transition-opacity opacity-0 group-hover:opacity-100" title="Editar">
									<a href=" /editar-llamada?id=<?php echo $llamada['id']; ?>" class="text-yellow-500">
										<svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
											<path fill-rule="evenodd" d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z" clip-rule="evenodd" />
										</svg>
									</a>
								</abbr>
								<abbr class="transition-opacity opacity-0 group-hover:opacity-100" title="Cancelar">
									<a href="/cancelar-llamada?id=<?php echo $llamada['id']; ?>" class="text-red-500">
										<svg class="size-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
											<path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd" />
										</svg>
									</a>
								</abbr>
							</div>
							<?php } ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</main>