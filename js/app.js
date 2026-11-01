/*  Lista de clientes: selección y búsqueda  */
const botonesCliente = document.querySelectorAll("button.item[data-nombre]");

botonesCliente.forEach(function (boton) {
  boton.addEventListener("click", function () {
    botonesCliente.forEach(function (b) { b.classList.remove("is-activo"); });
    boton.classList.add("is-activo");
    // Cada pantalla decide qué hacer con el cliente elegido
    document.dispatchEvent(new CustomEvent("cliente-seleccionado", {
      detail: { nombre: boton.dataset.nombre }
    }));
  });
});

const buscador = document.getElementById("buscar-cliente");
if (buscador) {
  buscador.addEventListener("input", function () {
    const texto = buscador.value.toLowerCase();
    document.querySelectorAll("#lista-clientes li").forEach(function (li) {
      li.hidden = !li.textContent.toLowerCase().includes(texto);
    });
  });
}

/*  Validación de campos obligatorios  */
function validarRequeridos(formulario) {
  let valido = true;
  formulario.querySelectorAll("[required]").forEach(function (campo) {
    const vacio = campo.value.trim() === "";
    campo.closest(".campo").classList.toggle("has-error", vacio);
    if (vacio && valido) campo.focus();
    if (vacio) valido = false;
  });
  return valido;
}

/*  Ventana de confirmación  */
const modal = document.getElementById("modal");
if (modal) {
  const aceptar = modal.querySelector(".boton");
  if (modal.classList.contains("is-visible")) aceptar.focus();
  aceptar.addEventListener("click", function () {
    window.location.href = aceptar.dataset.destino;
  });
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") aceptar.click();
  });
}
