function generarConsumoPDF(paciente, hospitalizacion, materiales, medicamentos, enfermeras, hospitalizacionSeccion, honorariosMedicos, imgConsumo) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ format: 'letter' });
    const imageUrl = imgConsumo;
    const img = new Image();

    img.onload = function () {
        const addBackground = () => {
            doc.addImage(this, 'JPEG', 0, 0, 218, 280);
        };

        // Añadir imagen de fondo en la primera página
        addBackground();

        // Información del paciente
        doc.setFontSize(16);
        doc.setTextColor(0, 0, 0);
        doc.text(`Paciente: ${paciente.nombre} ${paciente.apellido_P} ${paciente.apellido_M}`, 10, 50);
        doc.setFontSize(14);
        doc.text(`Habitacion: ${hospitalizacion.habitacion}`, 10, 60);
        doc.text(`Dietas: ${hospitalizacion.dietas}`, 50, 60);
        doc.text(`Servicio: ${hospitalizacion.servicio}`, 100, 60);
        doc.text(`Medico tratante: ${hospitalizacion.medico_tratante}`, 10, 70);
        doc.text(`Procedimiento: ${hospitalizacion.procedimiento}`, 10, 80);
        let fecha_ingreso = new Date(hospitalizacion.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' })
        doc.text(`Fecha de ingreso: ${fecha_ingreso}`, 10, 90);
        doc.text(`Fecha de alta: ${hospitalizacion.fecha_alta}`, 100, 90);

        // Posición inicial
        let startY = 100;

        // Función para capitalizar la primera letra de cada palabra
        const capitalizeWords = (str) => {
            return str.replace(/\b\w/g, char => char.toUpperCase());
        };

        // Función para traducir nombres de columnas
        const translateColumn = (col) => {
            switch(col) {
                case 'cantidad':
                case 'cantidadArticuloHospi':
                case 'cantidadArticuloHonorario':
                    return 'Cantidad';
                case 'fecha':
                    return 'Fecha';
                case 'nombre':
                    return 'Nombre';
                case 'precio':
                    return 'Precio';
                case 'turno':
                    return 'Turno';
                default:
                    return capitalizeWords(col);
            }
        };

        // Función para añadir una tabla
        const addTable = (title, data, columns) => {
            if (startY > 220) {
                doc.addPage();
                addBackground();
                startY = 50;
            }

            doc.setFontSize(14);
            doc.text(title, 10, startY);
            startY += 10;

            let subtotal = 0;

            const formattedData = data.map(item => {
                const row = columns.map(column => item[column]);
                const precio = parseFloat(item['precio']) || 0;
                const cantidad = parseFloat(item['cantidad']) || parseFloat(item['cantidadArticuloHospi']) || parseFloat(item['cantidadArticuloHonorario']) || 0;
                const subTotal = precio * cantidad;
                row.push(subTotal.toFixed(2));
                subtotal += subTotal;
                return row;
            });

            const translatedColumns = columns.map(col => translateColumn(col));

            doc.autoTable({
                startY: startY,
                head: [translatedColumns.concat(['Subtotal'])],
                body: formattedData,
                theme: 'grid',
                headStyles: { fillColor: [22, 160, 133] },
                margin: { top: 10 },
                didDrawPage: function (data) {
                    if (data.pageCount > 1) {
                        addBackground();
                    }
                    startY = data.cursor.y + 10;
                }
            });

            startY = doc.autoTable.previous.finalY + 10; // Actualizar startY después de la tabla
            return subtotal;
        };

        // Definir las columnas para cada sección
        const materialColumns = ['fecha', 'nombre', 'cantidad' , 'precio'];
        const medicamentoColumns = ['fecha', 'nombre', 'cantidad', 'precio'];
        const enfermeraColumns = ['fecha', 'nombre', 'turno', 'cantidad', 'precio'];
        const hospitalizacionColumns = ['fecha', 'nombre', 'cantidadArticuloHospi', 'precio'];
        const honorariosMedicosColumns = ['fecha', 'nombre', 'cantidadArticuloHonorario', 'precio'];

        // Calcular y añadir tablas con subtotales
        let total = 0;
        total += addTable('Materiales', materiales, materialColumns);
        total += addTable('Medicamentos', medicamentos, medicamentoColumns);
        total += addTable('Enfermeras', enfermeras, enfermeraColumns);
        total += addTable('Hospitalización', hospitalizacionSeccion, hospitalizacionColumns);
        total += addTable('Honorarios Médicos', honorariosMedicos, honorariosMedicosColumns);

        // Añadir total al final
        if (startY > 220) {
            doc.addPage();
            addBackground();
            startY = 50;
        }

        doc.setFontSize(16);
        doc.setTextColor(0, 0, 0);
        doc.text(`Total: $${total.toFixed(2)}`, 150, startY + 10);

        // Guardar el PDF
        doc.save(`${paciente.nombre}-${paciente.apellido_P}-${paciente.apellido_M}-consumo-de-hospitalizacion.pdf`);
    };

    img.src = imageUrl;
}
