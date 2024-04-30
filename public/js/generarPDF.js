function generarPDF(colposcopia, imgData2, imgData3, paciente, triaje) {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ format: 'letter' });

    const loadImage = (src) => {
        return new Promise((resolve, reject) => {
            const img = new Image();
            img.onload = () => resolve(img);
            img.onerror = reject;
            img.crossOrigin = 'Anonymous'; // Intenta evitar problemas de CORS
            img.src = src;
        });
    };

    Promise.all([
        loadImage(imgData3),
        loadImage(imgData2)
    ]).then(images => {
        const [image1, image2] = images;

        // Agregar la primera imagen
        doc.addImage(image1, 'JPEG', 0, 0, 218, 280 );

        // Agregar la segunda imagen
        doc.addImage(image2, 'JPEG', 10, 169, 43.5, 40);

        // Agregar texto
        doc.setFontSize(12);
        doc.setTextColor("#3f3f3f");
        
        doc.text(`${new Date(colposcopia.created_at).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' })}`, 49, 48.5);
        doc.text(`${new Date(paciente.fecha_nacimiento).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' })}`, 165, 48.5);
        doc.text(`${paciente.apellido_P}`, 45, 56);
        doc.text(`${paciente.apellido_M}`, 90, 56);
        doc.text(`${paciente.nombre}`, 125, 56);        
        doc.text(`${paciente.edad}`, 190, 56);       
        doc.text(`Años`, 196, 56);              
        doc.text(`${paciente.lugar_procedencia}`, 55, 66);
        doc.text(`${paciente.telefono}`, 165, 66);   
        doc.text(colposcopia.ahf.cancer, 65, 76,);  
        doc.text(colposcopia.ahf.diabetes_heredica, 130, 76,);
        doc.text(colposcopia.app.has, 65, 83,);  
        doc.text(colposcopia.app.cardiopatia, 130, 83,);
        doc.text(colposcopia.app.tabaquismo, 65, 89,);  
        doc.text(colposcopia.app.hipertension, 130, 89,);
        doc.text(colposcopia.app.alcoholismo, 65, 95,);  
        doc.text(colposcopia.app.diabetes, 130, 95,);
        doc.text(colposcopia.app.alergicos, 185, 89,);  
        doc.text(colposcopia.app.otros, 185, 95,);
        doc.text(colposcopia.ago.menarca, 62, 101.5,);     
        doc.text(`Años`, 68, 101.5);      
        doc.text(colposcopia.ago.ritmo, 92, 101.5,); 
        doc.text(colposcopia.ago.ivsa, 128, 101.5,);  
        doc.text(`Años`, 135, 101.5);      
        doc.text(colposcopia.ago.pSexuales, 185, 101.5,); 
        doc.text(colposcopia.ago.gestas, 35, 108.3,);  
        doc.text(colposcopia.ago.partos, 71, 108.3,);          
        doc.text(colposcopia.ago.cesareas, 107, 108.3,);  
        doc.text(colposcopia.ago.abortos, 144, 108.3,);   
        doc.text(colposcopia.ago.pf, 35, 115,);  
        doc.text(colposcopia.ago.fur, 141, 115,);  
        doc.text(colposcopia.ago.citologia, 78, 121.5,); 
        doc.text(colposcopia.ago.otros_antecendes, 78, 127.5,); 
        doc.text(colposcopia.ago.capt, 71, 134,); 
        doc.text(colposcopia.ago.resultados, 155, 133.5,); 
        doc.text(colposcopia.ago.tx, 71, 140,); 
        doc.text(colposcopia.ago.cuales, 155, 140,); 
        doc.text(new Date(colposcopia.ago.fecha_de_toma).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }), 41, 146,); 
        doc.text(new Date(colposcopia.ago.fecha_de_interpretacion).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }), 122, 146,); 
        doc.text(new Date(colposcopia.ago.fecha_de_envio).toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' }), 184, 146,); 
        doc.text(colposcopia.ago2.diagnostico_citologico, 60, 153,); 
        doc.text(colposcopia.ago2.sintomatologia, 45, 159,);
        doc.text(triaje.tomaSignosVitales.talla, 55, 166,); 
        doc.text(triaje.tomaSignosVitales.peso, 87, 166,); 
        doc.text(triaje.tomaSignosVitales.tension_arterial_toma, 118, 166,); 
        doc.text(triaje.tomaSignosVitales.frecuencia_cardiaca_toma, 150, 166,); 
        doc.text(triaje.tomaSignosVitales.temperatura_toma, 185, 166,); 
        doc.text(colposcopia.ago2.comentarios, 60, 174,);
        doc.text(colposcopia.ago2.indice_colposcopico_REID, 60, 214.5,);
        doc.text(colposcopia.ago2.color, 91, 214.5,);
        doc.text(colposcopia.ago2.margen, 130, 214.5,);
        doc.text(colposcopia.ago2.tincion_con_yodo, 183, 214.5,);
        doc.text(colposcopia.ago2.vasos, 26, 220.5,);
        doc.text(colposcopia.ago2.biopsia, 26, 226.5,);
        doc.text(colposcopia.ago2.radio, 76, 226,);
        doc.text(colposcopia.ago2.cepillado_endocervical, 156, 226.5,);
        doc.text(colposcopia.ago2.dx, 47, 231.5,);
        doc.text(colposcopia.ago2.grado, 131, 231.5,);
        doc.text(colposcopia.ago2.otros_dx, 31, 237,);
        doc.text(colposcopia.ago2.observaciones, 41, 243,);
        doc.text(colposcopia.ago2.proxima_cita, 37, 249,);
        
        // Guardar el PDF
        doc.save(`${paciente.nombre}-${paciente.apellido_P}-${paciente.apellido_M}-colposcopia.pdf`);
    }).catch(error => {
        console.error('Error al cargar imágenes:', error);
    });
}
