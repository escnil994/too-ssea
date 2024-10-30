<?php
$filters = [

    [
        'type' => 'date',
        'label' => 'Fecha Inicio',
        'name' => 'fecha_inicio',
        'attributes' => [
            'class' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg'
        ]
    ],
    [
        'type' => 'date',
        'label' => 'Fecha Fin',
        'name' => 'fecha_fin',
        'attributes' => [
            'class' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg'
        ]
    ],
    [
        'type' => 'text',
        'label' => 'Operador',
        'id' => 'searchOperator',
        'name' => 'operador',
        'hidden_field_name' => 'operador_id',
        'hidden_field_id' => 'operatorId',
        'placeholder' => 'Buscar operador...',
        'autocomplete' => 'off',
        'attributes' => [
            'class' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg'
        ],
        'resultDiv' => [
            'id' => 'resultOperator',
            'class' => 'bg-white border border-gray-300 rounded-lg shadow-lg max-h-40 overflow-y-auto mt-1 absolute z-10 hidden'
        ]
    ],
    [
        'type' => 'text',
        'label' => 'Clientes',
        'id' => 'searchClient',
        'name' => 'clientes',
        'hidden_field_name' => 'cliente_id',
        'hidden_field_id' => 'clientId',
        'placeholder' => 'Buscar cliente...',
        'autocomplete' => 'off',
        'attributes' => [
            'class' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg'
        ],
        'resultDiv' => [
            'id' => 'resultClient',
            'class' => 'bg-white border border-gray-300 rounded-lg shadow-lg max-h-40 overflow-y-auto mt-1 absolute z-10 hidden'
        ]
    ],
    [
        'type' => 'select',
        'label' => 'Estado de llamada',
        'name' => 'estado',
        'options' => $llamadaestado,
        'option_key' => 'estado',
        'attributes' => [
            'class' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg h-12'
        ]
    ],
    [
        'type' => 'select',
        'label' => 'Tipo de Emergencia',
        'name' => 'tipo',
        'options' => $llamadatipo,
        'option_key' => 'tipo_emergencia',
        'attributes' => [
            'class' => 'w-full mt-1 p-2 border border-gray-300 rounded-lg h-12'
        ]
    ]
];
?>

<div class="bg-gray-100 p-6 rounded-lg shadow-lg mb-6">
    <h2 class="text-2xl font-bold text-gray-700 mb-4">Panel de Reportes de Llamadas</h2>

    <form action="/generar-reporte" method="post">
        <div class="flex flex-wrap gap-4 mb-4">
            <?php foreach ($filters as $filter): ?>
                <!-- Div para cada filtro -->
                <div class="flex-1 min-w-[200px] <?php echo ($filter['name'] === 'fecha_fin') ? 'hidden' : ''; ?>" id="<?php echo ($filter['name'] === 'fecha_fin') ? 'fechaFinContainer' : ''; ?>">
                    <label class="text-gray-600 font-semibold"><?php echo $filter['label']; ?></label>
                    <?php if ($filter['type'] == 'text' || $filter['type'] == 'date'): ?>
                        <input type="<?php echo $filter['type']; ?>"
                            id="<?php echo $filter['id'] ?? ''; ?>"
                            name="<?php echo $filter['name'] ?? ''; ?>"
                            placeholder="<?php echo $filter['placeholder'] ?? ''; ?>"
                            autocomplete="<?php echo $filter['autocomplete'] ?? 'on'; ?>"
                            <?php foreach ($filter['attributes'] as $attr => $value) echo "$attr=\"$value\" "; ?> 
                            <?php if($filter['name'] === 'fecha_inicio') echo 'onchange="updateEndDate(this)"'; ?>
                        />

                        <?php if (isset($filter['hidden_field_name'])): ?>
                            <input type="hidden" name="<?php echo $filter['hidden_field_name']; ?>" id="<?php echo $filter['hidden_field_id']; ?>">
                        <?php endif; ?>

                        <?php if (isset($filter['resultDiv'])): ?>
                            <div id="<?php echo $filter['resultDiv']['id']; ?>" class="<?php echo $filter['resultDiv']['class']; ?>"></div>
                        <?php endif; ?>
                    <?php elseif ($filter['type'] == 'select'): ?>
                        <select name="<?php echo $filter['name'] ?? ''; ?>"
                            <?php foreach ($filter['attributes'] as $attr => $value) echo "$attr=\"$value\" "; ?>>
                            <option>Todos</option>
                            <?php foreach ($filter['options'] as $option): ?>
                                <option value="<?php echo htmlspecialchars($option[$filter['option_key']]); ?>">
                                    <?php echo htmlspecialchars($option[$filter['option_key']]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4 hover:bg-blue-700">Generar Reporte</button>
    </form>
</div>

<script>
    // Función para mostrar el contenedor de Fecha Fin cuando se selecciona Fecha Inicio y asignarle la misma fecha
    function updateEndDate(startDateInput) {
        const startDate = new Date(startDateInput.value);
        const endDateContainer = document.getElementById('fechaFinContainer');
        const endDateInput = document.querySelector('input[name="fecha_fin"]');
        
        if (endDateContainer && endDateInput) {
            endDateInput.value = startDateInput.value;
            endDateInput.min = startDateInput.value;
            endDateContainer.classList.remove('hidden'); // Muestra el contenedor de Fecha Fin
        }
    }

    // Función para asegurar que la fecha fin no sea menor que la fecha inicio
    function checkEndDate(endDateInput) {
        const startDateInput = document.querySelector('input[name="fecha_inicio"]');
        const startDate = new Date(startDateInput.value);
        const endDate = new Date(endDateInput.value);

        if (endDate < startDate) {
            alert("La fecha fin no puede ser menor que la fecha inicio.");
            endDateInput.value = startDateInput.value;
        }
    }
</script>




<script>
    const operadores = <?php echo json_encode($detallesoperadores); ?>;
    const clientes = <?php echo json_encode($detallesClientes); ?>;

    document.addEventListener("DOMContentLoaded", () => {
        ["Operator", "Client"].forEach(type => setupSearch(`search${type}`, `result${type}`, type === "Operator" ? operadores : clientes, `${type.toLowerCase()}Id`));

        function setupSearch(searchId, resultId, data, hiddenFieldId) {
            const searchInput = document.getElementById(searchId);
            const resultDiv = document.getElementById(resultId);
            const hiddenField = document.getElementById(hiddenFieldId); // Campo oculto para almacenar el ID

            // Mostrar sugerencias al enfocar o escribir en el campo de búsqueda
            searchInput.addEventListener("focus", () => showSuggestions("", data, resultDiv, searchInput, hiddenField));
            searchInput.addEventListener("input", () => showSuggestions(searchInput.value.toLowerCase(), data, resultDiv, searchInput, hiddenField));

            // Ocultar sugerencias si se hace clic fuera
            document.addEventListener("click", (e) => {
                if (!resultDiv.contains(e.target) && e.target !== searchInput) resultDiv.classList.add("hidden");
            });
        }

        function showSuggestions(query, data, resultDiv, searchInput, hiddenField) {
            resultDiv.classList.remove("hidden");
            resultDiv.innerHTML = data
                .filter(item => `${item.nombre} ${item.apellido}`.toLowerCase().includes(query))
                .slice(0, 3)
                .map(item => `<div class="p-2 cursor-pointer hover:bg-gray-200" data-id="${item.id}">${item.nombre} ${item.apellido}</div>`)
                .join('');

            // Agregar evento a cada sugerencia
            Array.from(resultDiv.children).forEach(option => {
                option.addEventListener("click", () => {
                    searchInput.value = option.textContent; // Muestra el nombre en el campo visible
                    hiddenField.value = option.getAttribute("data-id"); // Guarda el ID en el campo oculto
                    resultDiv.classList.add("hidden"); // Oculta las sugerencias
                });
            });
        }
    });
</script>

<style>
    #resultClient,
    #resultOperator {
        width: 260px;
    }

    #searchOperator,
    #searchClient {
        margin-bottom: 0px;
    }
</style>