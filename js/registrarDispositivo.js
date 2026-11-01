document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formRegistrarDispositivo');

    if (form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // Evitamos que recargue la página

            // Recuperamos el token del cliente almacenado en localStorage 
            const token = localStorage.getItem('token') || sessionStorage.getItem('token');

            if (!token) {
                alert('No se encontró una sesión activa. Por favor, inicia sesión.');
                window.location.href = 'login.php';
                return;
            }

            const formData = new FormData(form);

            try {
                
                const respuesta = await fetch('/ProyectoPPI/api/clientes/dispositivos', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });

                const resultado = await respuesta.json();

                if (respuesta.ok && resultado.status === 'success') {
                    alert('¡Dispositivo registrado con éxito!');
                    form.reset(); 
                    window.location.href = 'perfilCliente.php';
                } else {
                    alert('Error al registrar: ' + (resultado.message || 'Ocurrió un error inesperado.'));
                }

            } catch (error) {
                console.error('Error en la petición:', error);
                alert('Error de conexión con el servidor.');
            }
        });
    }
});