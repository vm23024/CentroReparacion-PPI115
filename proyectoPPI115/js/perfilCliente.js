document.addEventListener('DOMContentLoaded', async () => {
    // 1. Obtener el token del almacenamiento local o de sesión
    const token = localStorage.getItem('token') || sessionStorage.getItem('token');

    if (!token) {
        alert('No has iniciado sesión.');
        window.location.href = 'login.php';
        return;
    }

    // Configuración común de headers con el token JWT
    const headersConToken = {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
    };

    try {
        // PARTE A: CARGAR PERFIL DEL CLIENTE 
        const respuestaPerfil = await fetch('/ProyectoPPI/api/clientes/perfil', {
            method: 'GET',
            headers: headersConToken
        });

        const resultadoPerfil = await respuestaPerfil.json();

        if (respuestaPerfil.ok && (resultadoPerfil.status === 'success' || resultadoPerfil.status === 'ok')) {
            const cliente = resultadoPerfil.data || resultadoPerfil;
            const lblNombre = document.getElementById('lblNombreCompleto');
            const lblCorreo = document.getElementById('lblCorreo');
            const lblTelefono = document.getElementById('lblTelefono');

            if (lblNombre) lblNombre.textContent = `${cliente.nombre || ''} ${cliente.apellido || ''}`;
            if (lblCorreo) lblCorreo.textContent = cliente.correo || cliente.email || 'No registrado';
            if (lblTelefono) lblTelefono.textContent = cliente.telefono || 'No registrado';
        } else {
            alert('Sesión expirada o inválida: ' + (resultadoPerfil.message || 'Error desconocido'));
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = 'login.php';
            return;
        }

        //  PARTE B: CARGAR DISPOSITIVOS DEL CLIENTE 
        const respuestaDispositivos = await fetch('/ProyectoPPI/api/clientes/dispositivos', {
            method: 'GET',
            headers: headersConToken
        });

        const resultadoDispositivos = await respuestaDispositivos.json();
        console.log("Respuesta de dispositivos:", resultadoDispositivos); 

        // Extraemos la lista de dispositivos de forma flexible (ya sea .data o directo)
        const listaDispositivos = resultadoDispositivos.data || resultadoDispositivos;

        const contenedor = document.getElementById('contenedorDispositivos');
        if (contenedor) {
            contenedor.innerHTML = ''; 

            if (!Array.isArray(listaDispositivos) || listaDispositivos.length === 0) {
                contenedor.innerHTML = '<p class="text-muted text-center py-3">No tienes dispositivos registrados todavía.</p>';
            } else {
                listaDispositivos.forEach(disp => {
                    // Validar imagen de manera segura
                    const rutaImagen = disp.imagen ? `/ProyectoPPI/${disp.imagen}` : 'Img7/Oppo.jpg';
                    
                    // Validar fecha de registro de forma segura para evitar que .split() falle
                    let fechaMostrar = 'Sin fecha';
                    if (disp.fecha_cita) {
                        fechaMostrar = disp.fecha_cita;
                    } else if (disp.fecha_registro) {
                        fechaMostrar = disp.fecha_registro.split(' ')[0];
                    }

                    const cardHTML = `
                        <div class="card mb-3 shadow-sm border-0 rounded-3 p-2">
                            <div class="card-body d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white p-1 border rounded text-center d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; overflow: hidden;">
                                        <img src="${rutaImagen}" alt="${disp.marca || 'Dispositivo'}" class="w-100 h-100 object-fit-contain">
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">${disp.marca || ''} ${disp.modelo || 'Dispositivo'}</h6>
                                        <span class="text-muted small" style="font-size: 0.8rem;">Fecha: ${fechaMostrar}</span>
                                    </div>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm text-secondary border-0" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    contenedor.innerHTML += cardHTML;
                });
            }
        }

    } catch (error) {
        console.error('Error de red o servidor:', error);
    }

    //  codigo cerrar sesion
    const btnCerrarSesion = document.getElementById('btnCerrarSesion');
    if (btnCerrarSesion) {
        btnCerrarSesion.addEventListener('click', () => {
            localStorage.clear();
            sessionStorage.clear();
            window.location.href = 'login.php';
        });
    }
});