document.addEventListener('DOMContentLoaded', async () => {
    // 1. Obtener el token del almacenamiento local o de sesión
    const token = localStorage.getItem('token') || sessionStorage.getItem('token');

    if (!token) {
        alert('No has iniciado sesión como empleado.');
        window.location.href = 'accesoEmpleado.php';
        return;
    }

    const headersConToken = {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    };

    try {
        
        const respuesta = await fetch('/ProyectoPPI/perfil', {
            method: 'GET',
            headers: headersConToken
        });

        const resultado = await respuesta.json();
        console.log("Datos del empleado:", resultado);

        if (respuesta.ok && (resultado.status === 'success' || resultado.status === 'ok')) {
            const emp = resultado.data || resultado;

            
            const lblTitulo = document.getElementById('nombreEmpleadoDisplay');
            const lblUsuario = document.getElementById('lblUsuario');
            const lblNombre = document.getElementById('lblNombre');
            const lblApellido = document.getElementById('lblApellido');
            const lblRol = document.getElementById('lblRol');
            const lblCorreo = document.getElementById('lblCorreo');
            const lblTelefono = document.getElementById('lblTelefono');

            
            if (lblTitulo) lblTitulo.textContent = emp.usuario || emp.nombreUsuario || 'Empleado';
            if (lblUsuario) lblUsuario.textContent = emp.usuario || 'N/D';
            if (lblNombre) lblNombre.textContent = emp.nombreUsuario || 'N/D';
            if (lblApellido) lblApellido.textContent = emp.apellidoUsuario || 'N/D';
            if (lblRol) lblRol.textContent = emp.rol || 'N/D';
            if (lblCorreo) lblCorreo.textContent = emp.emailUsuario || 'N/D';
            if (lblTelefono) lblTelefono.textContent = emp.telefonoUsuario || 'N/D';

        } else {
            alert('Sesión expirada o inválida: ' + (resultado.message || 'Error desconocido'));
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = 'accesoEmpleado.php';
        }

    } catch (error) {
        console.error('Error al conectar con el servidor:', error);
    }

    // codigo cerrar sesion
    const btnCerrarSesion = document.getElementById('btnCerrarSesion');
    if (btnCerrarSesion) {
        btnCerrarSesion.addEventListener('click', () => {
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = 'accesoEmpleado.php';
        });
    }
});