function generarDiagnosticoPDF(diagnostico, paciente, triaje, imgDiagnostico, medico) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ format: 'letter' });
    const imageUrl = imgDiagnostico;
    const img = new Image();

    img.onload = function () {
        // Obtener la fecha de nacimiento  y convertirla a objeto Date
        const fechaNacimiento = new Date(paciente.fecha_nacimiento);
        // Obtener la fecha actual
        const hoy = new Date();
        // Calcular la edad
        let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();

        // Ajustar la edad si todavía no ha pasado el cumpleaños este año
        if (hoy.getMonth() < fechaNacimiento.getMonth() ||
            (hoy.getMonth() === fechaNacimiento.getMonth() && hoy.getDate() < fechaNacimiento.getDate())) {
            edad--;
        }

        // Añadir imagen
        doc.addImage(this, 'JPEG', 0, 0, 218, 280);
        // Agregar texto
        doc.setFontSize(15);
        doc.setTextColor("#383838");

        doc.text(medico.name, 110, 28.5,);
        doc.text(`${paciente.apellido_P}`, 81, 40);
        doc.text(`${paciente.apellido_M}`, 115, 40);
        doc.text(`${paciente.nombre}`, 148, 40);
        doc.text(new Date(triaje.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }), 28, 47);
        doc.text(`${edad}`, 180, 47);
        doc.text(`Años`, 188, 47);
        doc.text(triaje.tomaSignosVitales.peso, 180, 54,);
        doc.text(triaje.tomaSignosVitales.tension_arterial_toma, 180, 60,);
        doc.text(`Diagnostico:`, 15, 65);
        if (diagnostico.diagnostico) {
            doc.text(diagnostico.diagnostico, 15, 75,);
        }
        doc.text(`Receta medica:`, 15, 162);
        if (diagnostico.receta_medica) {
            doc.text(diagnostico.receta_medica, 15, 172,);
        }
        doc.save(`${paciente.nombre}-${paciente.apellido_P}-${paciente.apellido_M}-diagnostico y receta.pdf`);
    };

    img.src = imageUrl;
}