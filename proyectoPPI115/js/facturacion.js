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
      pTextos[1].innerText = reg.telefono || "N/D";
      pTextos[2].innerText = reg.marca_dispositivo || reg.marca || "N/D";
      pTextos[3].innerText = reg.modelo_dispositivo || reg.modelo || "N/D";
      pTextos[4].innerText = reg.numero_imei || reg.imei_serie || "N/D";
      pTextos[5].innerText = reg.estado_dispositivo || "N/D";
    }

    // Tarjeta 2: Diagnóstico Técnico Inicial 
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

    actualizarFacturaYCobro(reg);
  }

  // Función para renderizar la factura y conceptos al seleccionar una orden
  function actualizarFacturaYCobro(ord) {
    const tbody = document.getElementById("tabla-cuerpo-factura");
    const spanTotal = document.getElementById("txt-total-pagar");
    const spanComprobante = document.querySelector(".card-header span .text-secondary") || document.getElementById("span-codigo-factura");

    if (!tbody) return;

    // 1. Número de comprobante dinámico
    if (spanComprobante) {
      spanComprobante.innerText = `FAC-2026-${String(ord.id_orden || 1).padStart(4, '0')}`;
    }

    // 2. Definir costos 
    let costoServicio = parseFloat(ord.costo_reparacion || 15.00); 
    let costoRepuesto = regHasRepuesto(ord) ? 25.00 : 0.00; 
    
   
    if (ord.precio_repuesto) {
      costoRepuesto = parseFloat(ord.precio_repuesto);
    }

    let totalPagar = costoServicio + (ord.nombre_repuesto ? costoRepuesto : 0);

    // 3. Construir filas de la tabla de forma dinámica
    let htmlFilas = "";

   
    if (ord.nombre_repuesto && ord.nombre_repuesto !== "Ninguno") {
      htmlFilas += `
        <tr>
          <td class="py-3 px-3 small text-dark">Repuesto: ${ord.nombre_repuesto} (${ord.marca_repuesto || 'Original'})</td>
          <td class="py-3 px-3 text-center small">${ord.cantidad_repuesto || 1}</td>
          <td class="py-3 px-3 text-end small fw-semibold">$${costoRepuesto.toFixed(2)}</td>
        </tr>
      `;
    }

   
    htmlFilas += `
      <tr>
        <td class="py-3 px-3 small text-dark">Servicio: ${ord.tipo_servicio || 'Servicio técnico especializado'}</td>
        <td class="py-3 px-3 text-center small">1</td>
        <td class="py-3 px-3 text-end small fw-semibold">$${costoServicio.toFixed(2)}</td>
      </tr>
    `;

    
    tbody.innerHTML = htmlFilas;
    spanTotal.innerText = `$${totalPagar.toFixed(2)}`;
  }

  function regHasRepuesto(ord) {
    return ord.nombre_repuesto && ord.nombre_repuesto !== "" && ord.nombre_repuesto !== "Ninguno";
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

  // Evento para el botón "Pagar y Procesar"
  const btnPagar = document.querySelector(".btn-success");
  if (btnPagar) {
    btnPagar.addEventListener("click", async () => {
      // Tomamos el ID de la orden del elemento activo actual
      const elementoActivo = document.querySelector(".list-group-item.active");
      if (!elementoActivo) {
        alert("Por favor, seleccione un cliente de la lista primero.");
        return;
      }

      // Extraemos el id que está escrito en la tarjeta de la izquierda 
      const textoId = elementoActivo.querySelector("small").innerText; 
      const idOrden = textoId.replace("ID: ", "").trim();

      const metodoPago = document.querySelector("select.form-select").value;
      const referencia = document.querySelector("input[placeholder='Ingrese número de referencia...']").value;
      const totalTexto = document.getElementById("txt-total-pagar").innerText.replace('$', '');
      const codigoFactura = document.querySelector(".card-header span .text-secondary").innerText;

      const datosPago = {
        id_orden: idOrden,
        codigo_factura: codigoFactura,
        metodo_pago: metodoPago,
        referencia_pago: referencia,
        total: parseFloat(totalTexto)
      };

      try {
        const respuesta = await fetch('/ProyectoPPI/api/facturas/guardar', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(datosPago)
        });

        const resultado = await respuesta.json();

        if (respuesta.ok && resultado.status === "success") {
          alert("¡Pago procesado y registrado con éxito!");
          location.reload(); // Recargar la página para actualizar estados
        } else {
          alert("Error: " + (resultado.message || "No se pudo procesar el pago."));
        }
      } catch (error) {
        console.error("Error de red al procesar el pago:", error);
        alert("Ocurrió un error al intentar procesar la factura.");
      }
    });
  }

  // Evento para el botón "Descargar Factura (PDF)"
  const btnDescargarPdf = document.querySelector(".btn-outline-success");
  if (btnDescargarPdf) {
    btnDescargarPdf.addEventListener("click", (e) => {
      e.preventDefault();
      
      // Validar que haya un cliente seleccionado antes de imprimir
      const elementoActivo = document.querySelector(".list-group-item.active");
      if (!elementoActivo) {
        alert("Por favor, seleccione una orden de la lista para generar la factura.");
        return;
      }

      // Ejecutar la ventana de impresión nativa (el usuario puede elegir "Guardar como PDF")
      window.print();
    });
  }


  // Inicializar carga al abrir la vista
  cargarDiagnosticos();
});