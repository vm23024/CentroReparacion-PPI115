document.addEventListener("DOMContentLoaded", async () => {
  const token = localStorage.getItem("token") || sessionStorage.getItem("token");
  
 
  const params = new URLSearchParams(window.location.search);
  const idOrden = params.get("id");

  if (!idOrden || !token) {
    alert("No se especificó la orden o no hay sesión activa.");
    window.location.href = "estadoDispositivo.php";
    return;
  }

  try {
    const respuesta = await fetch(`/ProyectoPPI/api/ordenes/detalle?id=${idOrden}`, {
      method: 'GET',
      headers: { 
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json'
      }
    });

    const resultado = await respuesta.json();

    if (respuesta.ok && resultado.status === "success") {
      rellenarDetalleOrden(resultado.data);
    } else {
      alert(resultado.message || "No se pudo cargar la información.");
    }
  } catch (error) {
    console.error("Error al conectar con el servidor:", error);
  }

  function rellenarDetalleOrden(orden) {
    // 1. Título (Marca y Modelo)
    const tituloH3 = document.querySelector(".col-md-7 h3");
    if (tituloH3) {
      tituloH3.innerText = `${orden.marca_dispositivo || orden.marca || 'Dispositivo'} ${orden.modelo_dispositivo || orden.modelo || ''}`;
    }
    
    // 2. Costo de reparación usando costo_reparacion
    const costoH2 = document.querySelector(".col-md-7 h2.display-6");
    if (costoH2) {
      const costo = orden.costo_reparacion ? parseFloat(orden.costo_reparacion).toFixed(2) : '0.00';
      costoH2.innerText = `$${costo}`;
    }
    
    // 3. Número de serie / IMEI
    const imeiP = document.querySelector(".col-md-7 .text-muted.small");
    if (imeiP) {
      imeiP.innerText = `IMEI: ${orden.numero_imei || orden.imei_serie || 'N/D'}`;
    }

    // 4. Fechas exactas en los inputs de solo lectura
    const inputRegistro = document.getElementById("fechaRegistro");
    if (inputRegistro) {
      inputRegistro.value = orden.fecha_registro || 'N/D';
    }

    const inputEntrega = document.getElementById("fechaEntrega");
    if (inputEntrega) {
      inputEntrega.value = orden.reparacion_prometida_para || 'Por definir';
    }

    // 5. Imagen del dispositivo
    const imgTag = document.querySelector(".col-md-5 img");
    if (imgTag) {
      imgTag.src = orden.imagen ? `/ProyectoPPI/${orden.imagen}` : 'Img7/Oppo.jpg';
    }

    // 6. Diagnóstico o falla reportada
    const textareaDiag = document.getElementById("diagnostico");
    if (textareaDiag) {
      textareaDiag.value = orden.diagnostico || orden.falla_cliente || orden.observaciones || "Sin diagnóstico registrado.";
    }

    // 7. Actualizar pasos del estado de reparación (Estrellas)
    actualizarProgresoEstado(orden.estado_dispositivo);
  }

  function actualizarProgresoEstado(estadoActual) {
    if (!estadoActual) return;
    
    // Recorre los 6 pasos definidos en tu HTML (Recibido, En diagnóstico, En reparación, etc.)
    const pasos = document.querySelectorAll(".mt-5.pt-3.border-top .d-flex.flex-column.align-items-center");
    
    pasos.forEach(paso => {
      const spanTexto = paso.querySelector("span");
      const icono = paso.querySelector("i");
      
      if (spanTexto && icono) {
        const nombrePaso = spanTexto.innerText.trim().toLowerCase();
        const estadoLower = estadoActual.trim().toLowerCase();

        // Si el estado de la base de datos coincide con el texto del paso, se ilumina de verde
        if (nombrePaso.includes(estadoLower) || estadoLower.includes(nombrePaso)) {
          icono.className = "bi bi-star-fill fs-4 text-success mb-1";
          spanTexto.className = "small fw-bold text-success";
          spanTexto.style.fontSize = "0.85rem";
        } else {
          // De lo contrario se mantiene en gris
          icono.className = "bi bi-star fs-4 text-muted mb-1";
          spanTexto.className = "small text-muted";
          spanTexto.style.fontSize = "0.85rem";
        }
      }
    });
  }
});