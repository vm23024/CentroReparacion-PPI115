document.addEventListener('DOMContentLoaded', () => {
    const formLogin = document.getElementById('formLogin');

    if (formLogin) {
        formLogin.addEventListener('submit', async function(e) {
            e.preventDefault(); // Evita que la página recargue de forma clásica
            console.log("Formulario interceptado, enviando datos...");

            const datos = {
                usuario: document.getElementById('usuario').value,
                password: document.getElementById('password').value
            };

            try {
                // Petición Fetch hacia la ruta limpia del controlador de login
                const respuesta = await fetch('/ProyectoPPI/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datos)
                });

                const resultado = await respuesta.json();
                console.log("Respuesta del servidor:", resultado);

                if (respuesta.ok && resultado.status === 'success') {
                    // Guardamos el token JWT y el rol en el almacenamiento local del navegador
                    localStorage.setItem('token', resultado.token);
                    localStorage.setItem('rol', resultado.rol);
                    localStorage.setItem('nombre', resultado.nombre || resultado.usuario || 'Técnico');
                    localStorage.setItem('tipoUsuario', 'empleado');
                    console.log("Datos guardados en localStorage con éxito.");

                    alert('¡Login exitoso! Bienvenido.');

                    // Redirigir a la página principal del sistema
                    window.location.href = 'menuEmpleado.php';
                } else {
                    alert('Error: ' + (resultado.message || 'Credenciales incorrectas.'));
                }

            } catch (error) {
                console.error('Error en la petición:', error);
                alert('Ocurrió un error de red al intentar conectar con el servidor.');
            }
        });
    }
});