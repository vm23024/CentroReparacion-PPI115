document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token");
  const listaContainer = document.getElementById("lista-ordenReparacion");
  const inputBuscar = document.getElementById("buscar-ordenReparacion");
  const formEstado = document.getElementById("form-estado");

  let todasLasOrdenes = [];
  let ordenSeleccionadaId = null;

  // 1. Cargar las órdenes de reparación desde el backend
  async function cargarOrdenes() {
    try {
      const respuesta = await fetch('/ProyectoPPI/api/ordenes/todas', {
        method: 'GET',
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const resultado = await respuesta.json();
      if (respuesta.ok && resultado.status === "success") {
        todasLasOrdenes = resultado.data;
        renderizarLista(todasLasOrdenes);
      }
    } catch (error) {
      console.error("Error al cargar órdenes:", error);
    }
  }

  // 2. Renderizar la lista de tarjetas a la izquierda
  function renderizarLista(ordenes) {
    listaContainer.innerHTML = "";
    if (!ordenes || ordenes.length === 0) {
      listaContainer.innerHTML = `<li class="p-3 text-muted text-center">No hay órdenes registradas</li>`;
      return;
    }

    ordenes.forEach(ord => {
      const li = document.createElement("li");
      li.innerHTML = `
        <button class="item w-100 text-start border-0 bg-transparent p-2 mb-1 rounded" type="button" data-id="${ord.id_orden}">
            <span class="item__miniatura d-inline-block p-2 bg-light rounded-circle me-2">
              <i class="bi bi-person-fill fs-5 text-success"></i>
            </span>
            <span class="item__textos d-inline-block align-middle" style="width: 60%;">
              <span class="item__titulo d-block fw-bold">${ord.nombre_cliente || 'Cliente sin nombre'}</span>
              <span class="item__detalle d-block text-muted small">${ord.marca_dispositivo || ord.marca || 'Dispositivo'}</span>
            </span>
            <span class="item__extra float-end text-secondary small mt-2">${ord.estado_dispositivo || 'Recibido'}</span>
        </button>
      `;

      li.querySelector("button").addEventListener("click", () => {
        seleccionarOrden(ord);
      });

      listaContainer.appendChild(li);
    });
  }

  // 3. Seleccionar orden, cambiar estilo a verde y rellenar el formulario de la derecha
  function seleccionarOrden(ord) {
    ordenSeleccionadaId = ord.id_orden;

    // A. Marcar la tarjeta seleccionada en verde
    document.querySelectorAll("#lista-ordenReparacion .item").forEach(btn => {
      btn.style.removeProperty("background-color");
      btn.style.removeProperty("border-left");
      btn.style.removeProperty("border-radius");
    });

    const btnSel = document.querySelector(`[data-id="${ord.id_orden}"]`);
    if (btnSel) {
      btnSel.style.setProperty("background-color", "#e8f5e9", "important");
      btnSel.style.setProperty("border-left", "5px solid #2d5a27", "important");
      btnSel.style.setProperty("border-radius", "4px", "important");
    }

    // B. Rellenar datos del panel derecho
    document.getElementById("nombre-cliente").innerText = ord.nombre_cliente || "Nombre cliente";
    
    // Insignia amarilla superior derecha
    const badgeEstado = document.querySelector(".estado-actual");
    if (badgeEstado) {
      badgeEstado.innerText = ord.estado_dispositivo || "En diagnóstico";
    }

    document.getElementById("marca").value = ord.marca_dispositivo || ord.marca || "";
    document.getElementById("serie").value = ord.numero_imei || ord.imei_serie || "";
    
    // Campo de texto de diagnóstico
    document.getElementById("diagnostico").value = ord.diagnostico || "";
    
    // Descripción del problema
    document.getElementById("problema").value = ord.falla_cliente || ord.observaciones || "";
    
    // Selector desplegable del estado
    const selectEstado = document.getElementById("estado-reparacion");
    if (ord.estado_dispositivo) {
      selectEstado.value = ord.estado_dispositivo;
    }

    // Selector desplegable del tipo de servicio
    const selectServicio = document.getElementById("tipo-servicio");
    if (selectServicio) {
      selectServicio.value = ord.tipo_servicio || "";
    }

    const inputRepuesto = document.getElementById("repuestoUtilizado");
    if (inputRepuesto) {
      if (ord.nombre_repuesto) {
        inputRepuesto.value = `${ord.nombre_repuesto} (${ord.marca_repuesto || 'Genérico'})`;
        inputRepuesto.style.color = "#030303"; 
      } else {
        inputRepuesto.value = "Ninguno / Sin repuesto";
        inputRepuesto.style.fontWeight = "normal";
        inputRepuesto.style.color = "#6c757d"; 
      }
    }

    // C. Mostrar la imagen del dispositivo
    const imgElement = document.querySelector(".dispositivo__imagen");
    if (imgElement) {
      if (ord.imagen) {
        imgElement.src = `/ProyectoPPI/${ord.imagen}`;
        imgElement.style.display = "block";
      } else {
        imgElement.src = "img/telefono.png";
      }
    }
  }

  // 4. Filtrar órdenes mediante la barra de búsqueda
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

  // 5. Enviar el formulario para actualizar el estado, diagnóstico y tipo de servicio
  if (formEstado) {
    formEstado.addEventListener("submit", async function (e) {
      e.preventDefault();

      if (!ordenSeleccionadaId) {
        alert("Por favor, selecciona una orden de reparación de la lista.");
        return;
      }

      const datosActualizados = {
        id_orden: ordenSeleccionadaId,
        estado_dispositivo: document.getElementById("estado-reparacion").value,
        diagnostico: document.getElementById("diagnostico").value,
        tipo_servicio: document.getElementById("tipo-servicio") ? document.getElementById("tipo-servicio").value : null
      };

      try {
        const respuesta = await fetch('/ProyectoPPI/api/ordenes/actualizar-estado', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify(datosActualizados)
        });

        const resultado = await respuesta.json();

        if (respuesta.ok && resultado.status === "success") {
          alert("¡Orden actualizada con éxito!");
          cargarOrdenes(); 
        } else {
          alert("Error: " + (resultado.message || "No se pudo actualizar."));
        }
      } catch (error) {
        console.error("Error de red:", error);
        alert("Ocurrió un error al intentar actualizar la orden.");
      }
    });
  }

  // Cargar las órdenes al iniciar la página
  cargarOrdenes();
});