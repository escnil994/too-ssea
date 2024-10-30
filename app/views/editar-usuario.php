<?php
$title = 'Editar llamada';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');
?>

<body>
    <?php require_once __DIR__ . '/components/navbar.php'; ?>

    <?php
    // Obtener los datos enviados por POST
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $apellido = $_POST['apellido'] ?? '';
    $codigo_empleado = $_POST['codigo_empleado'] ?? '';
    $extension_tel = $_POST['extension_tel'] ?? '';
    $status = $_POST['status'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $dui = $_POST['dui'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    ?>

    <div class="w-full max-w-3xl mx-auto bg-white p-6 shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-4">Información del Usuario</h2>
        <form id="userForm" action="/modificar-usuario" method="POST">

        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-3">
                    <label for="nombre" class="block text-gray-700 font-medium text-center">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" 
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-3">
                    <label for="apellido" class="block text-gray-700 font-medium text-center">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($apellido) ?>" 
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <!-- Campos para empleados -->
                <div class="mb-3 empleado-field">
                    <label for="codigo_empleado" class="block text-gray-700 font-medium text-center">Código Empleado:</label>
                    <input type="number" id="codigo_empleado" name="codigo_empleado" 
                        value="<?= htmlspecialchars($codigo_empleado) ?>"
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-3 empleado-field">
                    <label for="extension_tel" class="block text-gray-700 font-medium text-center">Extensión Tel.:</label>
                    <input type="number" id="extension_tel" name="extension_tel"
                        value="<?= htmlspecialchars($extension_tel) ?>" 
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-3">
                    <label for="status" class="block text-gray-700 font-medium text-center">Estado:</label>
                    <select id="status" name="status"
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                        <option value="activo" <?= ($status == 'activo') ? 'selected' : '' ?>>activo</option>
                        <option value="inactivo" <?= ($status == 'inactivo') ? 'selected' : '' ?>>inactivo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="correo" class="block text-gray-700 font-medium text-center">Correo Electrónico:</label>
                    <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($correo) ?>" 
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-3">
                    <label for="rol" class="block text-gray-700 font-medium text-center">Rol:</label>
                    <select id="rol" name="rol"
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                        <option value="gerente" <?= ($rol == 'gerente') ? 'selected' : '' ?>>gerente</option>
                        <option value="operador" <?= ($rol == 'operador') ? 'selected' : '' ?>>operador</option>
                        <option value="cliente" <?= ($rol == 'cliente') ? 'selected' : '' ?>>cliente</option>
                    </select>
                </div>

                <!-- Campos para clientes -->
                <div class="mb-3 cliente-field">
                    <label for="dui" class="block text-gray-700 font-medium text-center">DUI (Cliente):</label>
                    <input type="text" id="dui" name="dui" value="<?= htmlspecialchars($dui) ?>" 
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-3 cliente-field">
                    <label for="telefono" class="block text-gray-700 font-medium text-center">Teléfono (Cliente):</label>
                    <input type="text" id="telefono" name="telefono" value="<?= htmlspecialchars($telefono) ?>" 
                        class="mt-1 mx-auto block w-3/4 px-3 py-2 text-sm border rounded-md border-gray-300 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="text-center mt-7">
                    <button type="submit" class="btn btn-warning btn-sm">Modificar</button>
                </div>

            </div>

            <div class="text-center mt-4">
                <a href="/administrar-usuarios" class="text-blue-600 font-semibold hover:underline">Regresar</a>
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const rolSelect = document.getElementById('rol');
        const empleadoFields = document.querySelectorAll('.empleado-field');
        const clienteFields = document.querySelectorAll('.cliente-field');

        function toggleFields() {
            if (rolSelect.value === 'cliente') {
                empleadoFields.forEach(field => field.style.display = 'none');
                clienteFields.forEach(field => field.style.display = 'block');
            } else {
                empleadoFields.forEach(field => field.style.display = 'block');
                clienteFields.forEach(field => field.style.display = 'none');
            }
        }

        toggleFields();

        rolSelect.addEventListener('change', toggleFields);

        const form = document.getElementById('userForm');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            if (validateForm()) {
                form.submit();
            }
        });

        function validateForm() {
            let isValid = true;
            let errorMessage = '';

            const nombre = document.getElementById('nombre').value.trim();
            const apellido = document.getElementById('apellido').value.trim();
            const correo = document.getElementById('correo').value.trim();
            const rol = document.getElementById('rol').value;

            if (nombre === '') {
                isValid = false;
                errorMessage += 'El campo Nombre es obligatorio.\n';
            }
            if (apellido === '') {
                isValid = false;
                errorMessage += 'El campo Apellido es obligatorio.\n';
            }
            if (correo === '') {
                isValid = false;
                errorMessage += 'El campo Correo Electrónico es obligatorio.\n';
            }

            if (rol === 'cliente') {
                const dui = document.getElementById('dui').value.trim();
                const telefono = document.getElementById('telefono').value.trim();

                if (dui === '') {
                    isValid = false;
                    errorMessage += 'El campo DUI es obligatorio para clientes.\n';
                }
                if (telefono === '') {
                    isValid = false;
                    errorMessage += 'El campo Teléfono es obligatorio para clientes.\n';
                }
            } else {
                const codigo_empleado = document.getElementById('codigo_empleado').value.trim();
                const extension_tel = document.getElementById('extension_tel').value.trim();

                if (codigo_empleado === '') {
                    isValid = false;
                    errorMessage += 'El campo Código Empleado es obligatorio para empleados.\n';
                }
                if (extension_tel === '') {
                    isValid = false;
                    errorMessage += 'El campo Extensión Tel. es obligatorio para empleados.\n';
                }
            }

            if (!isValid) {
                alert(errorMessage);
            }

            return isValid;
        }
    });
</script>

    <style>
        .empleado-field, .cliente-field {
            transition: all 0.3s ease;
        }
    </style>
</body>
