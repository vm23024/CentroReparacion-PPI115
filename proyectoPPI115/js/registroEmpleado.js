document.addEventListener('DOMContentLoaded', () => {
  const formRegistro = document.getElementById('formRegistro');

  if (formRegistro) {
    formRegistro.addEventListener('submit', async function(e) {
      e.preventDefault(); // Evita que la página se recargue

      // Recoger los datos de los inputs
      const datos = {
        usuario: document.getElementById('usuario').value,
        nombreUsuario: document.getElementById('nombreUsuario').value,
        apellidoUsuario: document.getElementById('apellidoUsuario').value,
        telefonoUsuario: document.getElementById('telefonoUsuario').value,
        emailUsuario: document.getElementById('emailUsuario').value,
        password: document.getElementById('password').value,
        rol: document.getElementById('rolUsuario').value
      };

      try {
        
        const respuesta = await fetch('/ProyectoPPI/registro', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(datos)
        });

        const resultado = await respuesta.json();

        if (respuesta.ok && resultado.status === 'success') {
          alert('¡Registro exitoso! Redirigiendo al login...');
          window.location.href = 'accesoEmpleado.php';
        } else {
          alert('Error: ' + (resultado.message || 'No se pudo completar el registro.'));
        }

      } catch (error) {
        console.error('Error en la petición:', error);
        alert('Ocurrió un error de red al intentar conectar con el servidor.');
      }
    });
  }
});