document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("lookup-form");
  
  if (form) {
    form.addEventListener("submit", (e) => {
      e.preventDefault(); 
      
      const inputImei = document.getElementById("order-number");
      const imei = inputImei ? inputImei.value.trim() : "";

      if (imei) {
        window.location.href = `resultadoImei.php?imei=${encodeURIComponent(imei)}`;
      } else {
        alert("Por favor, ingresa un número de IMEI válido.");
      }
    });
  }
});