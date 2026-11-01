document.addEventListener('DOMContentLoaded', () => {
    // 1. Autocompletar únicamente el nombre del empleado logueado desde localStorage
    const inputNombreEmpleado = document.getElementById('nombreEmpleado');
    const nombreGuardado = localStorage.getItem('nombre');
    
    if (inputNombreEmpleado && nombreGuardado) {
        inputNombreEmpleado.value = nombreGuardado;
    }


    // 2. Manejar el envío del formulario usando FormData
    const formRegistrarRepuesto = document.getElementById('formRegistrarRepuesto');

    if (formRegistrarRepuesto) {
        formRegistrarRepuesto.addEventListener('submit', async (e) => {
            e.preventDefault();

            const token = localStorage.getItem('token');
            if (!token) {
                alert('No has iniciado sesión o tu sesión ha expirado.');
                window.location.href = 'accesoEmpleado.php';
                return;
            }

            // Crear el objeto FormData para soportar textos, la fecha manual y la imagen
            const formData = new FormData();
            formData.append('tipoRepuesto', document.getElementById('tipoRepuesto').value);
            formData.append('fechaRegistro', document.getElementById('fechaRegistro').value); 
            formData.append('marcaRepuesto', document.getElementById('marcaRepuesto').value);
            formData.append('modeloRepuesto', document.getElementById('modeloRepuesto').value);
            formData.append('cantidadStock', document.getElementById('cantidadStock').value);
            formData.append('precioUnitario', document.getElementById('precioUnitario').value);
            formData.append('numeroSerie', document.getElementById('numeroSerie').value);
            formData.append('nombreEmpleado', inputNombreEmpleado.value);
            formData.append('descripcionRepuesto', document.getElementById('descripcionRepuesto').value);
            formData.append('observacionesRepuesto', document.getElementById('observacionesRepuesto').value);

            // Adjuntar el archivo de imagen si el usuario seleccionó uno
            const inputFile = document.getElementById('imagenRepuesto');
            if (inputFile.files.length > 0) {
                formData.append('imagenRepuesto', inputFile.files[0]);
            }

            try {
                
                const respuesta = await fetch('/ProyectoPPI/api/repuestos/registrar', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });    

                const resultado = await respuesta.json();

                if (respuesta.ok && resultado.status === 'success') {
                    alert('¡Repuesto registrado exitosamente!');
                    formRegistrarRepuesto.reset();
                   
                    if (inputNombreEmpleado) inputNombreEmpleado.value = nombreGuardado;
                } else {
                    alert('Error al registrar: ' + (resultado.message || 'Verifica los datos.'));
                }

            } catch (error) {
                console.error('Error de red:', error);
                alert('Ocurrió un error al conectar con el servidor.');
            }
        });
    }
});