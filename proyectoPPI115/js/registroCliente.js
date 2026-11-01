document.addEventListener('DOMContentLoaded', () => {
    const formRegistro = document.getElementById('formRegistro');

    if (formRegistro) {
        formRegistro.addEventListener('submit', async (e) => {
            e.preventDefault();

            const datosCliente = {
                nombre: document.getElementById('nombreCliente').value.trim(),    
                apellido: document.getElementById('apellidoCliente').value.trim(),  
                telefono: document.getElementById('telefonoCliente').value.trim(),   
                correo: document.getElementById('correoCliente').value.trim(),        
                password: document.getElementById('password').value
            };

            try {
                const respuesta = await fetch('/ProyectoPPI/api/clientes/registrarse', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datosCliente) 
                });

                const resultado = await respuesta.json();

                if (resultado.status === 'success') {
                    alert('¡Registro exitoso! Ahora puedes iniciar sesión.');
                    window.location.href = 'login.php';
                } else {
                    alert('Aviso: ' + (resultado.message || 'Verifica tus datos.'));
                }

            } catch (error) {
                console.error('Error de red o servidor:', error);
                alert('Ocurrió un error al conectar con el servidor.');
            }
        });
    }
});