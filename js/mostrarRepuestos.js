document.addEventListener("DOMContentLoaded", () => {
    const contenedorCatalogo = document.getElementById("catalogo-repuestos-bd");
    const formRepuestos = document.getElementById("formRepuestos");
    const inputBuscar = document.getElementById("buscadorRepuesto"); 

    let listaRepuestosGlobal = []; 

    function renderizarRepuestos(datos) {
        contenedorCatalogo.innerHTML = "";

        if (!datos || datos.length === 0) {
            contenedorCatalogo.innerHTML = `
                <div class="col-12 text-center py-4">
                    <p class="text-muted">No se encontraron repuestos.</p>
                </div>`;
            return;
        }

        datos.forEach(rep => {
            const col = document.createElement("div");
            col.className = "col-md-4 mb-3";
            
            // Verificación y renderizado de la imagen 
            let contenidoImagen = '';
            if (rep.imagen && rep.imagen.trim() !== '') {
                contenidoImagen = `<img src="${rep.imagen}" alt="Imagen repuesto" class="w-100 h-100 object-fit-cover rounded">`;
            } else {
                contenidoImagen = `<i class="bi bi-image fs-4 text-muted"></i>`;
            }

            col.innerHTML = `
                <label class="card border h-100 shadow-sm position-relative w-100" style="cursor: pointer; transition: all 0.2s ease;">
                    <input type="radio" name="id_repuesto_seleccionado" value="${rep.id_repuesto}" class="position-absolute top-0 start-0 m-3 form-check-input" required>
                    <div class="card-body text-start ps-5">
                        <div class="bg-light border rounded d-flex align-items-center justify-content-center mb-3 mx-auto overflow-hidden" style="width: 70px; height: 70px;">
                            ${contenidoImagen}
                        </div>
                        <h3 class="h6 fw-bold text-dark mb-1">${rep.tipo_repuesto} ${rep.marca} ${rep.modelo}</h3>
                        <p class="small text-secondary mb-2" style="font-size: 0.8rem;">N° Serie: ${rep.numero_serie || 'N/A'}</p>
                        <p class="small fw-semibold text-dark mb-1">Precio: $${rep.precio_unitario}</p>
                        <p class="small fw-semibold text-dark mb-0">Stock: ${rep.stock_actual}</p>
                    </div>
                </label>
            `;
            contenedorCatalogo.appendChild(col);
        });
    }

    function cargarRepuestos() {
        fetch('controllers/RepuestoController.php?accion=listarJson')
            .then(response => response.json())
            .then(data => {
                listaRepuestosGlobal = data; 
                renderizarRepuestos(listaRepuestosGlobal); 
            })
            .catch(error => console.error("Error al cargar los repuestos:", error));
    }

    // Carga inicial al abrir la página
    cargarRepuestos();

    // Filtro dinámico de búsqueda en tiempo real
    if (inputBuscar) {
        inputBuscar.addEventListener("input", (e) => {
            const textoBusqueda = e.target.value.toLowerCase().trim();

            const repuestosFiltrados = listaRepuestosGlobal.filter(rep => {
                const tipo = (rep.tipo_repuesto || "").toLowerCase();
                const marca = (rep.marca || "").toLowerCase();
                const modelo = (rep.modelo || "").toLowerCase();
                const serie = (rep.numero_serie || "").toLowerCase();

                return tipo.includes(textoBusqueda) || 
                       marca.includes(textoBusqueda) || 
                       modelo.includes(textoBusqueda) || 
                       serie.includes(textoBusqueda);
            });

            renderizarRepuestos(repuestosFiltrados);
        });
    }

    // Validación del formulario al eliminar un repuesto
    if (formRepuestos) {
        formRepuestos.addEventListener("submit", (e) => {
            const seleccionado = document.querySelector('input[name="id_repuesto_seleccionado"]:checked');

            if (!seleccionado) {
                e.preventDefault();
                alert("Por favor, selecciona un repuesto haciendo clic en su tarjeta.");
                return;
            }

            if (!confirm("¿Estás seguro de eliminar el repuesto seleccionado?")) {
                e.preventDefault();
            }
        });
    }
});