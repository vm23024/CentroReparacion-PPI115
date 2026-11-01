document.addEventListener("DOMContentLoaded", () => {
    const token = localStorage.getItem('token');
    const tipoUsuario = localStorage.getItem('tipoUsuario') ? localStorage.getItem('tipoUsuario').toLowerCase() : '';
    const rol = localStorage.getItem('rol') ? localStorage.getItem('rol').toLowerCase() : '';

    const divCliente = document.getElementById('seccion-cliente');
    const divEmpleado = document.getElementById('seccion-empleado');
    const divPublica = document.getElementById('seccion-publica');
    const divCerrar = document.getElementById('seccion-cerrar');

    if (token) {
        if (divPublica) divPublica.style.display = 'none';
        if (divCerrar) divCerrar.style.display = 'block';

        
        if (tipoUsuario === 'empleado' || rol === 'empleado') {
            if (divEmpleado) divEmpleado.style.display = 'block';
            if (divCliente) divCliente.style.display = 'none';
        } else {
            if (divCliente) divCliente.style.display = 'block';
            if (divEmpleado) divEmpleado.style.display = 'none';
        }
    } else {
        if (divCliente) divCliente.style.display = 'none';
        if (divEmpleado) divEmpleado.style.display = 'none';
        if (divPublica) divPublica.style.display = 'block';
        if (divCerrar) divCerrar.style.display = 'none';
    }

    document.getElementById('btn-cerrar-sesion-general')?.addEventListener('click', (e) => {
        e.preventDefault();
        localStorage.clear();
        window.location.href = 'index.php';
    });
});