document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token");
  const listaContainer = document.querySelector(".list-group");
  const inputBuscar = document.querySelector("input[placeholder='Nombre o teléfono...']");

  let todasLasOrdenes = [];

  // 1. Cargar todas las órdenes con detalles desde el backend
  async function cargarDiagnosticos() {
    try {
      const respuesta = await fetch('/ProyectoPPI/api/diagnostico/todos', {
        method: 'GET',
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const resultado = await respuesta.json();
      if (respuesta.ok && resultado.status === "success") {
        todasLasOrdenes = resultado.data;
        renderizarLista(todasLasOrdenes);
        
        // Seleccionar automáticamente el primer elemento si existe
        if (todasLasOrdenes.length > 0) {
          seleccionarRegistro(todasLasOrdenes[0], 0);
        }
      }
    } catch (error) {
      console.error("Error al cargar diagnósticos:", error);
    }
  }

  // 2. Renderizar la lista de clientes a la izquierda
  function renderizarLista(registros) {
    listaContainer.innerHTML = "";
    if (!registros || registros.length === 0) {
      listaContainer.innerHTML = `<div class="p-3 text-muted text-center">No hay registros en espera</div>`;
      return;
    }

    registros.forEach((reg, index) => {
      const a = document.createElement("a");
      a.href = "#";
      const esPrimero = index === 0;
      a.className = `list-group-item list-group-item-action border rounded-3 p-3 mb-2 ${esPrimero ? 'active' : ''}`;
      
      if (esPrimero) {
        a.style.backgroundColor = "#e8f0e3";
        a.style.color = "#1b3318";
        a.style.borderColor = "#2d5a27";
      }

      a.innerHTML = `
        <div class="d-flex w-100 justify-content-between align-items-center">
          <h3 class="h6 mb-1 fw-bold text-dark">${reg.nombre_cliente || 'Cliente sin nombre'}</h3>
          <small class="text-muted">ID: ${reg.id_orden}</small>
        </div>
        <p class="mb-1 small text-muted">${reg.marca_dispositivo || reg.marca || 'Dispositivo'} ${reg.modelo_dispositivo || reg.modelo || ''}</p>
        ${esPrimero ? '<small class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Seleccionado</small>' : ''}
      `;

      a.addEventListener("click", (e) => {
        e.preventDefault();
        
        // Quitar estilos activos de todos
        document.querySelectorAll(".list-group-item").forEach(el => {
          el.classList.remove("active");
          el.style.backgroundColor = "";
          el.style.borderColor = "";
          el.style.color = "";
          const badgeSel = el.querySelector(".text-success");
          if (badgeSel) badgeSel.remove();
        });

        // Aplicar estilos activos al presionado
        a.classList.add("active");
        a.style.backgroundColor = "#e8f0e3";
        a.style.color = "#1b3318";
        a.style.borderColor = "#2d5a27";
        
        const smallSel = document.createElement("small");
        smallSel.className = "text-success fw-semibold";
        smallSel.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> Seleccionado`;
        a.appendChild(smallSel);

        seleccionarRegistro(reg, index);
      });

      listaContainer.appendChild(a);
    });
  }

  // 3. Rellenar los campos del panel derecho al hacer clic
  function seleccionarRegistro(reg) {
    const infoContainer = document.querySelector(".col-lg-8");
    if (!infoContainer) return;

    // Tarjeta 1: Información del Cliente y Dispositivo
    const pTextos = infoContainer.querySelectorAll(".card.border.shadow-sm.mb-3 .card-body .fw-bold.text-dark");
    if (pTextos.length >= 6) {
      pTextos[0].innerText = reg.nombre_cliente || "N/D";
      pTextos[1].innerText = reg.telefono || reg.telefono || "N/D";
      pTextos[2].innerText = reg.marca_dispositivo || reg.marca || "N/D";
      pTextos[3].innerText = reg.modelo_dispositivo || reg.modelo || "N/D";
      pTextos[4].innerText = reg.numero_imei || reg.imei_serie || "N/D";
      pTextos[5].innerText = reg.estado_dispositivo || "N/D";
    }

    // Tarjeta 2: Diagnóstico Técnico Inicial (Fallas, accesorios, diagnóstico)
    const diagnosticoTextos = infoContainer.querySelectorAll(".card.border.shadow-sm.mb-3 .card-body .p-2.bg-light");
    if (diagnosticoTextos.length >= 3) {
      diagnosticoTextos[0].innerText = reg.falla_cliente || reg.observaciones || "Sin falla reportada";
      diagnosticoTextos[1].innerText = reg.accesorios || "Ninguno";
      diagnosticoTextos[2].innerText = reg.diagnostico || "Pendiente de diagnóstico técnico";
    }

    // Tarjeta 3: Imágenes del Dispositivo / Inspección
    const contenedorImagen = infoContainer.querySelector(".card.border.shadow-sm .card-body .d-flex.gap-3.align-items-center");
    if (contenedorImagen) {
      if (reg.imagen) {
        contenedorImagen.innerHTML = `
          <div class="border rounded p-1 text-center bg-white shadow-sm" style="width: 120px;">
            <img src="/ProyectoPPI/${reg.imagen}" class="img-fluid rounded" style="width: 110px; height: 100px; object-fit: cover;" alt="Dispositivo">
            <small class="text-muted d-block mt-1" style="font-size: 0.65rem;">Vista frontal</small>
          </div>
        `;
      } else {
        contenedorImagen.innerHTML = `
          <div class="bg-light border rounded d-flex flex-column align-items-center justify-content-center text-muted p-2" style="width: 110px; height: 110px;">
            <i class="bi bi-image fs-3 mb-1"></i>
            <small style="font-size: 0.65rem;">Sin imagen</small>
          </div>
        `;
      }
    }
  }

  // 4. Filtrar clientes en tiempo real con la barra de búsqueda
  if (inputBuscar) {
    inputBuscar.addEventListener("input", (e) => {
      const texto = e.target.value.toLowerCase();
      const filtradas = todasLasOrdenes.filter(o => 
        (o.nombre_cliente && o.nombre_cliente.toLowerCase().includes(texto)) ||
        (o.marca_dispositivo && o.marca_dispositivo.toLowerCase().includes(texto)) ||
        (o.modelo_dispositivo && o.modelo_dispositivo.toLowerCase().includes(texto))
      );
      renderizarLista(filtradas);
    });
  }

  // Inicializar carga al abrir la vista
  cargarDiagnosticos();
});