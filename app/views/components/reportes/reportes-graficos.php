<script>
    function contarPorCampo(llamadas, campo) {
        return llamadas.reduce((conteo, llamada) => {
            const valor = llamada[campo];
            conteo[valor] = (conteo[valor] || 0) + 1;
            return conteo;
        }, {});
    }

    function calcularPromedioPorCampo(llamadas, campoAgrupacion, campoValor) {
        const suma = {}, conteo = {};

        llamadas.forEach(llamada => {
            const clave = llamada[campoAgrupacion];
            const valor = parseFloat(llamada[campoValor]) || 0;
            suma[clave] = (suma[clave] || 0) + valor;
            conteo[clave] = (conteo[clave] || 0) + 1;
        });

        const promedio = {};
        Object.keys(suma).forEach(clave => {
            promedio[clave] = parseFloat((suma[clave] / conteo[clave]).toFixed(2));
        });

        return promedio;
    }

    // Procesamiento de datos
    const llamadasPorTipo = contarPorCampo(llamadas, 'tipo_emergencia');
    const estadoDeLlamadas = contarPorCampo(llamadas, 'estado');
    const duracionPromedioPorTipo = calcularPromedioPorCampo(llamadas, 'tipo_emergencia', 'duracion');

    // Función para crear gráficos
    function crearChart(contextId, chartType, labels, dataValues, chartLabel, chartTitle, backgroundColors) {
        const ctx = document.getElementById(contextId).getContext('2d');
        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: chartLabel,
                    data: dataValues,
                    backgroundColor: backgroundColors || 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: chartTitle }
                }
            }
        });
    }

    // Creación de gráficos
    crearChart(
        'llamadasPorTipoChart',
        'bar',
        Object.keys(llamadasPorTipo),
        Object.values(llamadasPorTipo),
        'Cantidad de Llamadas',
        'Cantidad de Llamadas por Tipo de Emergencia'
    );

    crearChart(
        'duracionPromedioTipoChart',
        'bar',
        Object.keys(duracionPromedioPorTipo),
        Object.values(duracionPromedioPorTipo),
        'Duración Promedio (minutos)',
        'Duración Promedio de Llamadas por Tipo de Emergencia',
        'rgba(153, 102, 255, 0.6)'
    );

    crearChart(
        'estadoLlamadasChart',
        'pie',
        Object.keys(estadoDeLlamadas),
        Object.values(estadoDeLlamadas),
        'Estado de Llamadas',
        'Estado de las Llamadas',
        ['rgba(54, 162, 235, 0.6)', 'rgba(255, 99, 132, 0.6)', 'rgba(255, 205, 86, 0.6)']
    );

    // Función para llenar tablas
    function llenarTablaResumen(idTabla, datos, encabezados) {
        const tabla = document.getElementById(idTabla);
        let contenidoHTML = `<thead><tr>${encabezados.map(header => `<th class="px-4 py-2">${header}</th>`).join('')}</tr></thead><tbody>`;

        Object.entries(datos).forEach(([key, value]) => {
            contenidoHTML += `<tr>
                <td class="border px-4 py-2">${key}</td>
                <td class="border px-4 py-2">${value}</td>
            </tr>`;
        });

        contenidoHTML += '</tbody>';
        tabla.innerHTML = contenidoHTML;
    }

    // Llenado de tablas al cargar el DOM
    document.addEventListener('DOMContentLoaded', function() {
        llenarTablaResumen('llamadasPorTipoTable', llamadasPorTipo, ['Tipo de Emergencia', 'Cantidad']);
        llenarTablaResumen('duracionPromedioTipoTable', duracionPromedioPorTipo, ['Tipo de Emergencia', 'Duración Promedio (seg)']);
        llenarTablaResumen('estadoLlamadasTable', estadoDeLlamadas, ['Estado', 'Cantidad']);
    });
</script>

<style>
    .chart-container {
        max-width: 400px;
        max-height: 300px;
        margin: 0 auto;
    }
    .report-container {
        display: flex;
        justify-content: center;
        padding: 10px;
    }
    .table-auto {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .table-auto th,
    .table-auto td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }
    .table-auto th {
        background-color: #f4f4f4;
        font-weight: bold;
    }
</style>
