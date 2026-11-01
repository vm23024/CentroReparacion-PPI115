document.addEventListener("DOMContentLoaded", () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token") || "";

  async function cargarDashboardAdmin() {
    try {
      // 1. Cargar Repuestos
      const resRep = await fetch('/ProyectoPPI/api/repuestos/todos', {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const dataRep = await resRep.json();
      renderizarRepuestos(dataRep.data || []);

      // 2. Cargar Órdenes de Reparación
      const resOrd = await fetch('/ProyectoPPI/api/ordenes/todas', {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const dataOrd = await resOrd.json();
      renderizarOrdenes(dataOrd.data || []);

      // 3. Cargar Técnicos / Empleados
      const resTec = await fetch('/ProyectoPPI/api/tecnicos/reparaciones-todos', {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const dataTec = await resTec.json();
      renderizarTecnicos(dataTec.data || []);

      // 4. Cargar Clientes
      const resCli = await fetch('/ProyectoPPI/api/clientes/dispositivos-todos', {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const dataCli = await resCli.json();
      renderizarClientes(dataCli.data || []);

    } catch (error) {
      console.error("Error al sincronizar el dashboard del administrador:", error);
    }
  }

  function renderizarRepuestos(repuestos) {
    const contenedor = document.getElementById("dashboard-repuestos-container");
    if (!contenedor) return;
    contenedor.innerHTML = "";
    
    repuestos.slice(0, 4).forEach(rep => {
      contenedor.innerHTML += `
        <div class="repuesto">
          <span class="repuesto__icono">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="6" y="2" width="12" height="20" rx="2.5"/><path d="M10 5h4" stroke-linecap="round"/></svg>
          </span>
          <span>
            <span class="repuesto__nombre">${rep.nombre}</span>
            <span class="repuesto__stock ${rep.stock <= 3 ? 'repuesto__stock--bajo' : ''}">Stock: ${rep.stock} unidades</span>
          </span>
        </div>`;
    });
  }

  function renderizarOrdenes(ordenes) {
    const contenedor = document.getElementById("dashboard-ordenes-container");
    if (!contenedor) return;
    contenedor.innerHTML = "";

    ordenes.slice(0, 3).forEach(ord => {
      contenedor.innerHTML += `
        <li class="item">
          <span class="item__miniatura"><img src="img/telefono.png" alt="" style="width:30px; height:30px; object-fit:contain;"></span>
          <span class="item__textos">
            <span class="item__titulo">${ord.marca_dispositivo || 'Dispositivo'} ${ord.modelo_dispositivo || ''}</span>
            <span class="item__detalle">Fecha : ${ord.ingreso_orden || 'Reciente'}</span>
          </span>
          <span class="badge bg-success-subtle text-success">${ord.estado_dispositivo || 'En proceso'}</span>
        </li>`;
    });
  }

  function renderizarTecnicos(tecnicos) {
    const contenedor = document.getElementById("dashboard-tecnicos-container");
    if (!contenedor) return;
    contenedor.innerHTML = "";

    tecnicos.forEach(tec => {
      const li = document.createElement("li");
      li.className = "item";
      li.innerHTML = `
        <span class="item__miniatura">
          <svg width="30" height="30" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="currentColor"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" fill="currentColor"/></svg>
        </span>
        <span class="item__textos">
          <span class="item__titulo">${tec.nombre_tecnico}</span>
          <span class="item__detalle">${tec.correo}</span>
        </span>
        <div class="d-flex align-items-center gap-2">
          <span class="punto-estado">Activo</span>
          <button class="btn btn-sm btn-outline-danger eliminar-tecnico" title="Eliminar empleado" data-id="${tec.id_tecnico}">
            <i class="bi bi-trash"></i>
          </button>
        </div>`;

      li.querySelector(".eliminar-tecnico").addEventListener("click", () => {
        eliminarRegistro('/ProyectoPPI/api/empleados/eliminar/', tec.id_tecnico);
      });
      contenedor.appendChild(li);
    });
  }

  function renderizarClientes(clientes) {
    const contenedor = document.getElementById("dashboard-clientes-container");
    if (!contenedor) return;
    contenedor.innerHTML = "";

    clientes.forEach(cli => {
      const li = document.createElement("li");
      li.className = "item";
      li.innerHTML = `
        <span class="item__miniatura">
          <svg width="30" height="30" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" fill="currentColor"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" fill="currentColor"/></svg>
        </span>
        <span class="item__textos">
          <span class="item__titulo">${cli.nombre_cliente}</span>
          <span class="item__detalle">${cli.correo || 'Sin correo'}</span>
        </span>
        <div class="d-flex align-items-center gap-2">
          <span class="punto-estado">Activo</span>
          <button class="btn btn-sm btn-outline-danger eliminar-cliente" title="Eliminar cliente" data-id="${cli.id_cliente}">
            <i class="bi bi-trash"></i>
          </button>
        </div>`;

      li.querySelector(".eliminar-cliente").addEventListener("click", () => {
        eliminarRegistro('/ProyectoPPI/api/clientes/eliminar/', cli.id_cliente);
      });
      contenedor.appendChild(li);
    });
  }

  async function eliminarRegistro(urlBase, id) {
    if (!confirm("¿Estás seguro de que deseas eliminar este registro del sistema?")) return;
    try {
      const respuesta = await fetch(urlBase + id, {
        method: 'DELETE',
        headers: { 'Authorization': `Bearer ${token}` }
      });
      const resultado = await respuesta.json();
      if (resultado.status === "success") {
        alert("Registro eliminado exitosamente.");
        cargarDashboardAdmin();
      } else {
        alert("No se pudo eliminar: " + (resultado.message || 'Error desconocido'));
      }
    } catch (error) {
      console.error("Error al procesar la eliminación:", error);
    }
  }

  cargarDashboardAdmin();
});