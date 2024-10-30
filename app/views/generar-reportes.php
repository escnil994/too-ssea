<?php
$title = 'Generación de Reportes';
require_once __DIR__ . '/components/header.php';
date_default_timezone_set('America/El_Salvador');
?>

<script>
    const llamadas = <?php echo json_encode($llamadas); ?>;
</script>

<body>
    <?php require_once __DIR__ . '/components/navbar.php'; ?>
    <div class="container mx-auto p-8">
        <?php require_once __DIR__ . '/components/reportes/reportes-filtros.php'; ?>
        <?php if (!empty($llamadas)): ?>
            <?php
            $reports = [
                [
                    'title' => '',
                    'content' => '<div class="chart-container"><canvas id="llamadasPorTipoChart"></canvas></div>',
                    'table' => '<table id="llamadasPorTipoTable" class="table-auto w-full bg-white rounded-lg shadow-lg"></table>'
                ],
                [
                    'title' => '',
                    'content' => '<div class="chart-container"><canvas id="duracionPromedioTipoChart"></canvas></div>',
                    'table' => '<table id="duracionPromedioTipoTable" class="table-auto w-full bg-white rounded-lg shadow-lg"></table>'
                ],
                [
                    'title' => '',
                    'content' => '<div class="chart-container"><canvas id="estadoLlamadasChart"></canvas></div>',
                    'table' => '<table id="estadoLlamadasTable" class="table-auto w-full bg-white rounded-lg shadow-lg"></table>'
                ]
            ];
            ?>
            <?php foreach ($reports as $report): ?>
                <div class="bg-white p-6 rounded-lg shadow-lg mb-6 report-container">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4"><?php echo $report['title']; ?></h3>
                    <?php echo $report['content']; ?>
                    <?php echo $report['table']; ?>
                </div>
            <?php endforeach; ?>
            <div class="text-right">
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700" onclick="exportToPDF()">Exportar a PDF</button>
                <button class="bg-yellow-600 text-white px-4 py-2 rounded-lg ml-2 hover:bg-yellow-700" onclick="exportToExcel()">Exportar a Excel</button>
            </div>
        <?php elseif ($_SERVER['REQUEST_URI'] === '/generar-reporte'): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                <p class="text-xl font-semibold text-gray-700">No hay datos para mostrar</p>
            </div>
        <?php endif; ?>
    </div>
    <?php require_once __DIR__ . '/components/reportes/reportes-graficos.php'; ?>
</body>

<script>
    async function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF("p", "mm", "a4");
        const captureOptions = { scale: 3, useCORS: true };
        let xPosition = 10, yPosition = 10, imgWidth = 90, imgHeight = 45;

        function checkPageOverflow() {
            if (yPosition + imgHeight > 290) {
                pdf.addPage();
                yPosition = 10;
            }
        }

        try {
            const items = [
                { chartId: "llamadasPorTipoChart", tableId: "llamadasPorTipoTable" },
                { chartId: "duracionPromedioTipoChart", tableId: "duracionPromedioTipoTable" },
                { chartId: "estadoLlamadasChart", tableId: "estadoLlamadasTable" }
            ];

            for (const item of items) {
                const chartElement = document.getElementById(item.chartId);
                const tableElement = document.getElementById(item.tableId);
                if (chartElement && tableElement) {
                    const chartImage = await html2canvas(chartElement, captureOptions).then(canvas => canvas.toDataURL("image/jpeg", 1.0));
                    pdf.addImage(chartImage, "JPEG", xPosition, yPosition, imgWidth, imgHeight);
                    const tableImage = await html2canvas(tableElement, captureOptions).then(canvas => canvas.toDataURL("image/jpeg", 1.0));
                    pdf.addImage(tableImage, "JPEG", xPosition + imgWidth + 5, yPosition, imgWidth, imgHeight);
                    yPosition += imgHeight + 10;
                    checkPageOverflow();
                }
            }

            const llamadasTableOriginal = document.getElementById("llamadasTableOriginal");
            if (llamadasTableOriginal) {
                const originalTableImage = await html2canvas(llamadasTableOriginal, captureOptions).then(canvas => canvas.toDataURL("image/jpeg", 1.0));
                checkPageOverflow();
                pdf.addImage(originalTableImage, "JPEG", 10, yPosition, 190, imgHeight * 2);
            }

            pdf.save("reporte_llamadas.pdf");
        } catch (error) {
            console.error("Error al exportar a PDF:", error);
            alert("Hubo un error al exportar a PDF. Revisa la consola para más detalles.");
        }
    }

    function exportToExcel() {
        const workbook = XLSX.utils.book_new();
        const tables = [
            { tableId: "llamadasPorTipoTable", sheetName: "Llamadas por Tipo" },
            { tableId: "duracionPromedioTipoTable", sheetName: "Duración Promedio por Tipo" },
            { tableId: "estadoLlamadasTable", sheetName: "Estado de las Llamadas" }
        ];

        for (const table of tables) {
            const tableElement = document.getElementById(table.tableId);
            if (tableElement) {
                const sheet = XLSX.utils.table_to_sheet(tableElement);
                XLSX.utils.book_append_sheet(workbook, sheet, table.sheetName);
            }
        }

        if (llamadas && llamadas.length > 0) {
            const llamadasSheet = XLSX.utils.json_to_sheet(llamadas);
            XLSX.utils.book_append_sheet(workbook, llamadasSheet, "Llamadas Originales");
        }

        XLSX.writeFile(workbook, "reporte_completo_llamadas.xlsx");
    }
</script>
