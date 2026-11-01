document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token"); 
  const listaDispositivosContainer = document.getElementById("lista-dispositivo");
  const inputBuscar = document.getElementById("buscar-cliente");
  const formOrden = document.getElementById("form-orden");
  const selectRepuesto = document.getElementById("selectRepuesto"); 

  let todosLosDispositivos = [];
  let dispositivoSeleccionadoId = null;

  // 1. Cargar dispositivos desde el backend
  async function cargarDispositivos() {
    try {
      const respuesta = await fetch('/ProyectoPPI/api/dispositivos/todos', {
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
      const resultado = await respuesta.json();

      if (respuesta.ok && resultado.status === "success") {
        todosLosDispositivos = resultado.data;
        renderizarLista(todosLosDispositivos);
      } else {
        console.error("Error al cargar dispositivos:", resultado.message);
      }
    } catch (error) {
      console.error("Error de red:", error);
    }
  }

 
  async function cargarRepuestos() {
    try {
      const respuesta = await fetch('/ProyectoPPI/api/repuestos/todos', { 
        method: 'GET',
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
      const resultado = await respuesta.json();

      if (respuesta.ok && resultado.status === "success") {
        selectRepuesto.innerHTML = '<option value="">Sin repuesto</option>'; 
        resultado.data.forEach(rep => {
          const option = document.createElement("option");
          option.value = rep.id_repuesto; 
          option.textContent = `${rep.nombre || rep.descripcion} (Stock: ${rep.stock})`;
          selectRepuesto.appendChild(option);
        });
      }
    } catch (error) {
      console.error("Error al cargar repuestos:", error);
    }
  }

  // 2. Renderizar tarjetas en la lista izquierda
  function renderizarLista(dispositivos) {
    listaDispositivosContainer.innerHTML = "";
    
    if (dispositivos.length === 0) {
      listaDispositivosContainer.innerHTML = `<li class="p-3 text-muted text-center">No hay dispositivos registrados</li>`;
      return;
    }

    dispositivos.forEach(disp => {
      const li = document.createElement("li");
      li.innerHTML = `
        <button class="item w-100 text-start border-0 bg-transparent p-2 mb-1 rounded" type="button" data-id="${disp.id_dispositivo}">
            <span class="item__miniatura d-inline-block p-2 bg-light rounded-circle me-2">
              <i class="bi bi-phone fs-5 text-success"></i>
            </span>
            <span class="item__textos d-inline-block align-middle">
              <span class="item__titulo d-block fw-bold">${disp.nombre_cliente || 'Sin cliente'}</span>
              <span class="item__detalle d-block text-muted small">${disp.marca}</span>
            </span>
            <span class="item__extra float-end text-secondary small mt-1">${disp.modelo}</span>
        </button>
      `;

      li.querySelector("button").addEventListener("click", () => {
        seleccionarDispositivo(disp);
      });

      listaDispositivosContainer.appendChild(li);
    });
  }

  // 3. Rellenar el formulario con los datos de la BD y marcar tarjeta en verde
  function seleccionarDispositivo(disp) {
    dispositivoSeleccionadoId = disp.id_dispositivo;

    document.querySelectorAll("#lista-dispositivo .item").forEach(btn => {
      btn.style.removeProperty("background-color");
      btn.style.removeProperty("border-left");
      btn.style.removeProperty("border-radius");
    });

    const botonSeleccionado = document.querySelector(`[data-id="${disp.id_dispositivo}"]`);
    if (botonSeleccionado) {
      botonSeleccionado.style.setProperty("background-color", "#e8f5e9", "important");
      botonSeleccionado.style.setProperty("border-left", "5px solid #2d5a27", "important");
      botonSeleccionado.style.setProperty("border-radius", "4px", "important");
    }

    document.getElementById("fechaIngresoOrden").value = disp.fecha_registro ? disp.fecha_registro.split(' ')[0] : new Date().toISOString().split('T')[0];
    document.getElementById("nombre").value = disp.nombre_cliente || "";
    document.getElementById("marca").value = disp.marca || "";
    document.getElementById("modelo").value = disp.modelo || "";
    document.getElementById("imei").value = disp.imei_serie || "";
    document.getElementById("accesorios").value = disp.accesorios || "";
    document.getElementById("falla").value = disp.observaciones || "";
    document.getElementById("fechaEntrega").value = disp.fecha_cita || "";
    
    if(disp.estado_reparacion) {
      document.getElementById("estadoDispositivo").value = disp.estado_reparacion;
    }
  }

  // 4. Filtrar dispositivos con la barra de búsqueda
  inputBuscar.addEventListener("input", (e) => {
    const texto = e.target.value.toLowerCase();
    const filtrados = todosLosDispositivos.filter(d => 
      (d.marca && d.marca.toLowerCase().includes(texto)) ||
      (d.modelo && d.modelo.toLowerCase().includes(texto)) ||
      (d.nombre_cliente && d.nombre_cliente.toLowerCase().includes(texto)) ||
      (d.imei_serie && d.imei_serie.toLowerCase().includes(texto))
    );
    renderizarLista(filtrados);
  });

  // 5. Enviar el formulario para registrar la orden
  formOrden.addEventListener("submit", async function (e) {
    e.preventDefault();

    if (!dispositivoSeleccionadoId) {
      alert("Por favor, selecciona un dispositivo de la lista de la izquierda.");
      return;
    }

    const datosOrden = {
      id_dispositivo: dispositivoSeleccionadoId,
      ingreso_orden: document.getElementById("fechaIngresoOrden").value,
      nombre: document.getElementById("nombre").value,
      marca: document.getElementById("marca").value,
      modelo: document.getElementById("modelo").value,
      imei: document.getElementById("imei").value,
      accesorios: document.getElementById("accesorios").value,
      estadoDispositivo: document.getElementById("estadoDispositivo").value,
      id_repuesto: selectRepuesto.value || null, 
      cantidad_repuesto: 1,                     
      costo: document.getElementById("costo").value,
      falla: document.getElementById("falla").value,
      motivo: document.getElementById("motivo").value,
      fechaEntrega: document.getElementById("fechaEntrega").value
    };

    try {
      const respuesta = await fetch('/ProyectoPPI/api/ordenes/guardar', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(datosOrden)
      });

      const resultado = await respuesta.json();

      if (respuesta.ok && resultado.status === "success") {
        alert("¡Orden de reparación registrada y stock de repuesto actualizado con éxito!");
      } else {
        alert("Error: " + (resultado.message || "No se pudo guardar la orden."));
      }
    } catch (error) {
      console.error("Error al enviar la orden:", error);
      alert("Ocurrió un error de red al intentar registrar la orden.");
    }
  });


  cargarDispositivos();
  cargarRepuestos(); 
});