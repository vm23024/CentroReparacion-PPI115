document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token") || "";
  const listaContainer = document.getElementById("lista-tecnicos-container");

  if (!listaContainer) return;

  async function cargarTecnicosYReparaciones() {
    try {
      const respuesta = await fetch('/ProyectoPPI/api/tecnicos/reparaciones-todos', {
        method: 'GET',
        headers: { 'Authorization': `Bearer ${token}` }
      });

      if (!respuesta.ok) throw new Error("Error al obtener técnicos");

      const resultado = await respuesta.json();
      
      if (resultado.status === "success" && Array.isArray(resultado.data)) {
        const tecnicosGlobal = resultado.data;
        renderizarListaTecnicos(tecnicosGlobal);

        // Carga el primero por defecto al iniciar
        if (tecnicosGlobal.length > 0) {
          mostrarDetalleTecnico(tecnicosGlobal[0]);
        }
      } else {
        listaContainer.innerHTML = `<div class="p-3 text-muted text-center">No hay técnicos registrados.</div>`;
      }
    } catch (error) {
      console.error("Error:", error);
      listaContainer.innerHTML = `<div class="p-3 text-danger text-center">Error al conectar con el servidor.</div>`;
    }
  }

  function renderizarListaTecnicos(tecnicos) {
    listaContainer.innerHTML = "";

    tecnicos.forEach((tec, index) => {
      const divCard = document.createElement("div");
      const esPrimero = index === 0;
      
      divCard.className = `p-3 rounded-3 border bg-white shadow-sm d-flex justify-content-between align-items-center mb-2`;
      divCard.style.cursor = "pointer";
      
      if (esPrimero) {
        divCard.style.borderColor = "#2d5a27";
        divCard.style.backgroundColor = "#f4f9f2";
      }

      const totalOrdenes = tec.reparaciones.length;
      const textoSub = totalOrdenes > 0 ? `${totalOrdenes} orden(es) en proceso` : 'Sin reparaciones asignadas';

      divCard.innerHTML = `
        <div class="d-flex align-items-center gap-3">
          <div class="bg-white p-2 rounded-3 border d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
            <i class="bi bi-person-fill ${esPrimero ? 'text-success' : 'text-secondary'} fs-4"></i>
          </div>
          <div>
            <h6 class="fw-bold mb-0 text-dark">${tec.nombre_tecnico}</h6>
            <span class="text-muted small" style="font-size: 0.78rem;">${textoSub}</span>
          </div>
        </div>
        <i class="bi bi-three-dots-vertical text-secondary fs-5"></i>
      `;

      
      divCard.addEventListener("click", () => {
        document.querySelectorAll("#lista-tecnicos-container > div").forEach(el => {
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

        mostrarDetalleTecnico(tec);
      });

      listaContainer.appendChild(divCard);
    });
  }

  function mostrarDetalleTecnico(tec) {
    // 1. Actualizamos el nombre del técnico en la tarjeta derecha
    const nombreElem = document.getElementById("detalle-nombre");
    if (nombreElem) nombreElem.innerText = tec.nombre_tecnico;

    // 2. Actualizamos el correo y teléfono en la tarjeta derecha
    const contactoElem = document.getElementById("detalle-contacto");
    if (contactoElem) contactoElem.innerHTML = `${tec.correo} &nbsp;•&nbsp; ${tec.telefono}`;
    
    // 3. Contenedor de las reparaciones del técnico seleccionado
    const contenedorReparaciones = document.getElementById("lista-reparaciones-container");
    if (!contenedorReparaciones) return;

    contenedorReparaciones.innerHTML = "";

    if (!tec.reparaciones || tec.reparaciones.length === 0) {
      contenedorReparaciones.innerHTML = `<p class="text-muted small">Este técnico no registra órdenes de reparación asociadas.</p>`;
      return;
    }

    // ponemos las ordenes de reparacion asociadas al tecnico
    tec.reparaciones.forEach(rep => {
      const itemRep = document.createElement("div");
      itemRep.className = "p-3 border rounded-3 bg-white d-flex align-items-center gap-3 shadow-sm mb-3";
      
      itemRep.innerHTML = `
        <div class="bg-light p-2 rounded-3 border d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; flex-shrink: 0;">
           <i class="bi bi-tools text-success fs-4"></i>
        </div>
        <div class="w-100">
          <h6 class="fw-bold mb-1 text-dark">${rep.tipo_reparacion} (${rep.dispositivo})</h6>
          <p class="text-muted small mb-2" style="font-size: 0.78rem;">Falla: ${rep.descripcion}</p>
          <span class="text-secondary small fw-semibold" style="font-size: 0.75rem;">${rep.tiempo_estimado}</span>
        </div>
      `;
      contenedorReparaciones.appendChild(itemRep);
    });
  }

  cargarTecnicosYReparaciones();
});