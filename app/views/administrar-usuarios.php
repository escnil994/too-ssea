<?php
$title = 'Generación de Reportes';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');


?>

<body>
    <?php require_once __DIR__ . '/components/navbar.php'; ?>


    <div class="container mt-5">
        <h1 class="mb-4 text-center">Administrar Usuarios</h1>
        <form id="filtro-form" method="GET" action="/buscar-usuarios" class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <label for="rol-select" class="form-label">Seleccionar Rol:</label>
                    <select id="rol-select" name="rol" class="form-control">
                        <option value="Cliente">Cliente</option>
                        <option value="Operador">Operador</option>
                        <option value="Gerente">Gerente</option>
                    </select>
                </div>

                <div>
                    <label for="email-buscar" class="form-label">Buscar por Correo Electrónico:</label>
                    <input type="text" id="email-buscar" name="email" placeholder="Correo electrónico"
                        class="form-control">
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>





        <?php
        $mostrarTabla = isset($_GET['rol'], $_GET['email']);
        ?>

        <?php if ($mostrarTabla): ?>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Correo Electrónico</th>
                        <th>Rol</th>
                        <th id="col-dynamic">Extensión Tel. / DUI</th>
                        <th id="col-dynamic-2">Estado / Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($usuarios)): ?>
                        <?php foreach ($usuarios as $usuario): ?>
                            <?php
                            $col1_title = $usuario['rol'] === 'cliente' ? 'DUI' : 'Extensión Tel.';
                            $col2_title = $usuario['rol'] === 'cliente' ? 'Teléfono' : 'Estado';
                            ?>

                            <tr>
                                <td><?= htmlspecialchars($usuario['id']) ?></td>
                                <td><?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?></td>
                                <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                <td><?= htmlspecialchars(ucfirst($usuario['rol'])) ?></td>

                                <!-- Columnas dinámicas para mostrar DUI/Teléfono o Extensión Tel./Estado -->
                                <td><?= htmlspecialchars(
                                    $usuario['rol'] === 'cliente'
                                    ? ($usuario['dui'] ?? '')
                                    : ($usuario['extension_tel'] ?? '')
                                ) ?></td>

                                <td><?= htmlspecialchars(
                                    $usuario['rol'] === 'cliente'
                                    ? ($usuario['telefono'] ?? '')
                                    : ucfirst($usuario['estado'] ?? '')
                                ) ?></td>


                                <td class="text-center">


                                    <form action="editar-usuario" method="POST" style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($usuario['id']) ?>">
                                        <input type="hidden" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>">
                                        <input type="hidden" name="apellido"
                                            value="<?= isset($usuario['apellido']) ? htmlspecialchars(string: $usuario['apellido']) : '' ?>">

                                        <input type="hidden" name="codigo_empleado"
                                            value="<?= isset($usuario['codigo_empleado']) ? htmlspecialchars(string: $usuario['codigo_empleado']) : '' ?>">
                                        <input type="hidden" name="extension_tel"
                                            value="<?= isset($usuario['extension_tel']) ? htmlspecialchars(string: $usuario['extension_tel']) : '' ?>">
                                        <input type="hidden" name="status"
                                            value="<?= isset($usuario['status']) ? htmlspecialchars($usuario['status']) : '' ?>">
                                        <input type="hidden" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>">
                                        <input type="hidden" name="rol" value="<?= htmlspecialchars($usuario['rol']) ?>">
                                        <input type="hidden" name="estado"
                                            value="<?= isset($usuario['estado']) ? htmlspecialchars($usuario['estado']) : '' ?>">
                                        <input type="hidden" name="dui"
                                            value="<?= isset($usuario['dui']) ? htmlspecialchars($usuario['dui']) : '' ?>">
                                        <input type="hidden" name="telefono"
                                            value="<?= isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '' ?>">
                                        <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                                    </form>



                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <script>
                // Cambiar títulos de las columnas dinámicamente
                document.querySelector('#col-dynamic').innerText = '<?= $col1_title ?>';
                document.querySelector('#col-dynamic-2').innerText = '<?= $col2_title ?>';
            </script>
        <?php else: ?>
        <?php endif; ?>







    </div>
</body>