document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token") || "";
  const listaContainer = document.getElementById("lista-clientes-container");

  if (!listaContainer) {
    console.error("No se encontró el contenedor de la lista de clientes en el DOM.");
    return;
  }

  // Función principal para cargar clientes y dispositivos
  async function cargarClientesYDispositivos() {
    try {
      const respuesta = await fetch('/ProyectoPPI/api/clientes/dispositivos-todos', {
        method: 'GET',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      if (!respuesta.ok) {
        throw new Error(`Error en el servidor: ${respuesta.status}`);
      }

      const resultado = await respuesta.json();
      
      if (resultado.status === "success" && Array.isArray(resultado.data)) {
        const listaClientesGlobal = resultado.data;
        renderizarListaClientes(listaClientesGlobal);

        // Si hay clientes, cargamos el primero por defecto en el panel derecho
        if (listaClientesGlobal.length > 0) {
          mostrarDetalleCliente(listaClientesGlobal[0]);
        }
      } else {
        listaContainer.innerHTML = `<div class="p-3 text-muted text-center">No se encontraron clientes registrados.</div>`;
      }
    } catch (error) {
      console.error("Error al conectar con la API:", error);
      listaContainer.innerHTML = `<div class="p-3 text-danger text-center">Error al cargar la información.</div>`;
    }
  }

  // Dibuja la lista de clientes en la columna izquierda
  function renderizarListaClientes(clientes) {
    listaContainer.innerHTML = "";
    
    if (!clientes || clientes.length === 0) {
      listaContainer.innerHTML = `<div class="p-3 text-muted text-center">No hay clientes en espera</div>`;
      return;
    }

    clientes.forEach((cli, index) => {
      const divCard = document.createElement("div");
      const esPrimero = index === 0;
      
      divCard.className = `p-3 rounded-3 border bg-white shadow-sm d-flex justify-content-between align-items-center mb-2`;
      divCard.style.cursor = "pointer";
      
      // Resaltar visualmente el primero por defecto
      if (esPrimero) {
        divCard.style.borderColor = "#2d5a27";
        divCard.style.backgroundColor = "#f4f9f2";
      }

      const nombreCliente = cli.nombre_cliente || 'Cliente sin nombre';
      const fechaRegistro = cli.fecha_registro || 'Reciente';

      divCard.innerHTML = `
        <div class="d-flex align-items-center gap-3">
          <div class="bg-white p-2 rounded-3 border d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
            <i class="bi bi-person-fill ${esPrimero ? 'text-success' : 'text-secondary'} fs-4"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark">${nombreCliente}</h6>
            <span class="text-muted small" style="font-size: 0.78rem;">Fecha : ${fechaRegistro}</span>
          </div>
        </div>
        <i class="bi bi-three-dots-vertical text-secondary fs-5"></i>
      `;

      // Evento de clic para cambiar la selección y mostrar el detalle a la derecha
      divCard.addEventListener("click", () => {
        document.querySelectorAll("#lista-clientes-container > div").forEach(el => {
          el.style.borderColor = "";
          el.style.backgroundColor = "#fff";
          const icono = el.querySelector(".bi-person-fill");
          if (icono) {
            icono.classList.remove("text-success");
            icono.classList.add("text-secondary");
          }
        });

        divCard.style.borderColor = "#2d5a27";
        divCard.style.backgroundColor = "#f4f9f2";
        const iconoActivo = divCard.querySelector(".bi-person-fill");
        if (iconoActivo) {
          iconoActivo.classList.remove("text-secondary");
          iconoActivo.classList.add("text-success");
        }

        mostrarDetalleCliente(cli);
      });

      listaContainer.appendChild(divCard);
    });
  }

  // Muestra la información del cliente seleccionado y sus dispositivos en el panel derecho
  function mostrarDetalleCliente(cli) {
    const nombreElem = document.getElementById("detalle-nombre");
    const contactoElem = document.getElementById("detalle-contacto");
    
    if (nombreElem) nombreElem.innerText = cli.nombre_cliente || "Sin nombre";
    if (contactoElem) contactoElem.innerHTML = `${cli.correo || 'correo@email.com'} &nbsp;•&nbsp; ${cli.telefono || '0000-0000'}`;

    const contenedorDispositivos = document.getElementById("lista-dispositivos-container");
    if (!contenedorDispositivos) return;

    contenedorDispositivos.innerHTML = "";

    if (!cli.dispositivos || cli.dispositivos.length === 0) {
      contenedorDispositivos.innerHTML = `<p class="text-muted small">Este cliente no registra dispositivos asociados.</p>`;
      return;
    }

    cli.dispositivos.forEach(disp => {
      const itemDisp = document.createElement("div");
      itemDisp.className = "p-3 border rounded-3 bg-white d-flex align-items-center gap-3 shadow-sm mb-2";
      
      const rutaImagen = disp.imagen ? `/ProyectoPPI/${disp.imagen}` : '/ProyectoPPI/IMG/icono.png';

      itemDisp.innerHTML = `
        <div class="bg-light p-1 border rounded d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; flex-shrink: 0; overflow: hidden;">
          <img src="${rutaImagen}" alt="Dispositivo" class="w-100 h-100 object-fit-contain">
        </div>
        <div>
          <h6 class="fw-bold mb-1 text-dark small">${disp.marca || 'Dispositivo'} ${disp.modelo || ''}</h6>
          <span class="text-muted small" style="font-size: 0.75rem;">IMEI/Serie: ${disp.numero_serie || 'Sin serie'}</span><br>
          <span class="text-secondary small" style="font-size: 0.75rem;">Obs: ${disp.descripcion_reparacion || 'Sin observaciones'}</span><br>
          <span class="text-success fw-bold small" style="font-size: 0.75rem;">Estado: ${disp.diagnostico || 'Pendiente'}</span>
        </div>
      `;
      contenedorDispositivos.appendChild(itemDisp);
    });
  }

  // Ejecutamos la carga inicial
  cargarClientesYDispositivos();
});