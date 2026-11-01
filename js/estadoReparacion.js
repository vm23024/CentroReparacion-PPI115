document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token");
  
  // Apuntando directamente al ID del contenedor
  const contenedorLista = document.getElementById("listaOrdenesCliente");

  if (!token) {
    console.warn("No hay un token de autenticación activo.");
    if (contenedorLista) {
      contenedorLista.innerHTML = `<div class="alert alert-warning text-center">Debes iniciar sesión para ver el estado de tus reparaciones.</div>`;
    }
    return;
  }

  try {
    const respuesta = await fetch('/ProyectoPPI/api/ordenes/mis-ordenes', {
      method: 'GET',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });

    const resultado = await respuesta.json();

    if (respuesta.ok && resultado.status === "success") {
      renderizarTarjetas(resultado.data);
    } else {
      if (contenedorLista) {
        contenedorLista.innerHTML = `<div class="alert alert-info text-center">${resultado.message || 'No hay órdenes registradas.'}</div>`;
      }
    }
  } catch (error) {
    console.error("Error de conexión al cargar las órdenes del cliente:", error);
    if (contenedorLista) {
      contenedorLista.innerHTML = `<div class="alert alert-danger text-center">Error al conectar con el servidor.</div>`;
    }
  }

  function renderizarTarjetas(ordenes) {
    if (!contenedorLista) return;

    contenedorLista.innerHTML = ""; 

    if (!ordenes || ordenes.length === 0) {
      contenedorLista.innerHTML = `
        <div class="text-center p-4 text-muted bg-light rounded-4">
          <i class="bi bi-inbox fs-2 d-block mb-2"></i>
          No tienes dispositivos en proceso de reparación actualmente.
        </div>`;
      return;
    }

    ordenes.forEach(orden => {
      const imagenSrc = orden.imagen ? `/ProyectoPPI/${orden.imagen}` : 'Img7/Oppo.jpg';
      
      const estado = orden.estado_dispositivo || 'En proceso';
      let claseBadge = "bg-warning text-dark";
      if (estado.toLowerCase() === 'completado' || estado.toLowerCase() === 'reparado') {
        claseBadge = "text-success bg-success bg-opacity-25 border border-success";
      }

      const fechaEntrega = orden.reparacion_prometida_para ? orden.reparacion_prometida_para : 'Por definir';

      // Creamos el elemento div de la tarjeta dinámicamente para manejar mejor el evento click
      const tarjetaDiv = document.createElement("div");
      tarjetaDiv.className = "card border-0 shadow-sm rounded-4 p-3 bg-light tarjeta-orden";
      tarjetaDiv.style.cursor = "pointer";
      tarjetaDiv.style.transition = "transform 0.2s ease, box-shadow 0.2s ease";

     
      tarjetaDiv.addEventListener("mouseenter", () => {
        tarjetaDiv.style.transform = "translateY(-2px)";
        tarjetaDiv.style.boxShadow = "0 .5rem 1rem rgba(0,0,0,.15)";
      });
      tarjetaDiv.addEventListener("mouseleave", () => {
        tarjetaDiv.style.transform = "translateY(0)";
        tarjetaDiv.style.boxShadow = "";
      });

      // Evento Click para redireccionar a la página de seguimiento pasando el ID por URL
      tarjetaDiv.addEventListener("click", (e) => {
        if (e.target.closest('.dropdown')) return;

        window.location.href = `seguimientoOrdenReparacion.php?id=${orden.id_orden}`;
      });

      tarjetaDiv.innerHTML = `
        <div class="d-flex align-items-start justify-content-between">
          <div class="d-flex align-items-center gap-3">
            <div class="bg-white p-2 border rounded-3 d-flex align-items-center justify-content-center"
              style="width: 70px; height: 70px; overflow: hidden;">
              <img src="${imagenSrc}" alt="Dispositivo" class="w-100 h-100 object-fit-contain">
            </div>
            <div>
              <h5 class="fw-bold text-dark mb-1">${orden.marca_dispositivo || orden.marca || 'Dispositivo'} ${orden.modelo_dispositivo || orden.modelo || ''}</h5>
              <p class="text-muted mb-1 small">Serie / IMEI: ${orden.numero_imei || 'N/D'}</p>
              <p class="text-secondary mb-1 small">${orden.falla_cliente || orden.observaciones || 'Sin descripción'}</p>
              <span class="fw-bold small text-success">Fecha de entrega: ${fechaEntrega}</span>
            </div>
          </div>

          <!-- Menú Desplegable Interactivo -->
          <div class="d-flex flex-column align-items-end justify-content-between gap-4">
            <div class="dropdown">
              <button class="btn btn-link text-secondary p-0 border-0" type="button" data-bs-toggle="dropdown"
                aria-expanded="false" title="Opciones">
                <i class="bi bi-three-dots-vertical fs-5"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item small" href="seguimientoOrdenReparacion.php?id=${orden.id_orden}"><i class="bi bi-eye me-2"></i>Ver detalles</a></li>
                <li><a class="dropdown-item small" href="#"><i class="bi bi-file-earmark-pdf me-2"></i>Descargar comprobante</a></li>
                <li><a class="dropdown-item small" href="#"><i class="bi bi-chat-dots me-2"></i>Contactar con soporte</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item small text-danger" href="#"><i class="bi bi-x-circle me-2"></i>Reportar problema</a></li>
              </ul>
            </div>
            <span class="badge ${claseBadge} px-3 py-2 rounded-pill fw-bold">${estado}</span>
          </div>
        </div>
      `;

      contenedorLista.appendChild(tarjetaDiv);
    });
  }
});