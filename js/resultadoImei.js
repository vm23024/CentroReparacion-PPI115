document.addEventListener("DOMContentLoaded", async () => {
  const params = new URLSearchParams(window.location.search);
  const imeiOrden = params.get("imei");

  if (!imeiOrden) {
    alert("No se especificó el número de IMEI.");
    window.location.href = "index.php";
    return;
  }

  try {
   
    const respuesta = await fetch(`/ProyectoPPI/getOrdenImei.php?imei=${encodeURIComponent(imeiOrden)}`, {
      method: 'GET',
      headers: { 'Content-Type': 'application/json' }
    });

    const resultado = await respuesta.json();

    if (respuesta.ok && resultado.status === "success") {
      const orden = resultado.data;

      // 1. Título
      const tituloH3 = document.querySelector(".col-md-7 h3");
      if (tituloH3) tituloH3.innerText = `${orden.marca_dispositivo || 'Dispositivo'} ${orden.modelo_dispositivo || ''}`;
      
      // 2. Costo
      const costoH2 = document.querySelector(".col-md-7 h2.display-6");
      if (costoH2) costoH2.innerText = `$${parseFloat(orden.costo_reparacion || 0).toFixed(2)}`;
      
      // 3. IMEI
      const imeiP = document.querySelector(".col-md-7 .text-muted.small");
      if (imeiP) imeiP.innerText = `IMEI: ${orden.numero_imei || imeiOrden}`;

      // 4. Fechas
      const inputRegistro = document.getElementById("fechaRegistro");
      if (inputRegistro) inputRegistro.value = orden.fecha_ingreso || 'N/D';

      const inputEntrega = document.getElementById("fechaEntrega");
      if (inputEntrega) inputEntrega.value = orden.reparacion_prometida_para || 'Por definir';

      // 5. Diagnóstico
      const textareaDiag = document.getElementById("diagnostico");
      if (textareaDiag) textareaDiag.value = orden.diagnostico || orden.falla_cliente || "Sin diagnóstico registrado.";

    } else {
      alert(resultado.message || "No se encontró ninguna orden con este IMEI.");
      window.location.href = "index.php";
    }
  } catch (error) {
    console.error("Error al conectar con el servidor:", error);
  }
});