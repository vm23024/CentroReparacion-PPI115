document.addEventListener('DOMContentLoaded', () => {
    const formLogin = document.getElementById('formLogin');

    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();

            const credenciales = {
                email: document.getElementById('emailLogin').value.trim(),
                password: document.getElementById('passwordLogin').value
            };

            try {
                const respuesta = await fetch('/ProyectoPPI/api/clientes/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(credenciales)
                });

                const resultado = await respuesta.json();

                if (respuesta.ok && resultado.status === 'success') {
                    localStorage.setItem('token', resultado.token);
                    localStorage.setItem('nombreCliente', resultado.nombre);
                    localStorage.setItem('tipoUsuario', 'cliente');

                    alert(`¡Bienvenido, ${resultado.nombre}!`);
                    
                    
                    window.location.href = 'perfilCliente.php'; 
                } else {
                    alert('Error: ' + (resultado.message || 'Credenciales incorrectas.'));
                }

            } catch (error) {
                console.error('Error de red o servidor:', error);
                alert('Ocurrió un error al intentar iniciar sesión.');
            }
        });
    }
});