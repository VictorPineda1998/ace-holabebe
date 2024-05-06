function generarDiagnosticoPDF(diagnostico, paciente, triaje, imgDiagnostico){
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ format: 'letter' });
    const imageUrl = imgDiagnostico;
    const img = new Image();

    img.onload = function () {
        // Añadir imagen
        doc.addImage(this, 'JPEG', 0, 0, 218, 280);
        doc.text(`${paciente.apellido_P}`, 30, 36.5);
        doc.text(`${paciente.apellido_M}`, 65, 36.5);
        doc.text(`${paciente.nombre}`, 95, 36.5); 
        doc.text(new Date(triaje.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }), 180,36.5,);        
        doc.text(`${paciente.edad}`, 32, 43);      
        doc.text(`Años`, 41, 43);              
        doc.text(triaje.tomaSignosVitales.peso, 85, 43,); 
        doc.text(triaje.tomaSignosVitales.tension_arterial_toma, 128, 44,);     
        doc.text(`Diagnostico:`, 15, 60);
        doc.text(diagnostico.diagnostico, 15, 70,); 
        doc.text(`Receta medica:`, 15, 160);
        doc.text(diagnostico.receta_medica, 15, 170,); 
        doc.save(`${paciente.nombre}-${paciente.apellido_P}-${paciente.apellido_M}-diagnostico y receta.pdf`);
    };

    img.src = imageUrl;
}