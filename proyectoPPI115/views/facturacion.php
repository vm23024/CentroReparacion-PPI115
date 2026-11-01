<?
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Facturación y Pago - SYS-REPAIR</title>

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="/ProyectoPPI/CSS/css.css">
</head>

<body>
  <!-- Fondo dinámico con lluvia en tonos verde oscuro -->
  <div class="net-background">
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
    <div class="data-rain"></div>
  </div>

  <div class="container py-4">
    <!-- Tarjeta Principal del Sistema -->
    <div class="card shadow-lg mx-auto" style="max-width: 1050px;">

      <!-- Encabezado Estilizado Verde Oscuro Corporativo con Logo -->
      <div class="card-header text-white d-flex justify-content-between align-items-center py-3"
        style="background-color: #2d5a27; border-top-left-radius: 12px; border-top-right-radius: 12px;">
        <div class="d-flex align-items-center gap-3">

          <!-- Botón del Menú -->
          <button class="btn text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral"
            aria-controls="menuLateral">
            <i class="bi bi-list fs-4"></i>
          </button>

          <!-- Offcanvas Actualizado -->
          <div class="offcanvas offcanvas-start text-dark" tabindex="-1" id="menuLateral"
            aria-labelledby="menuLateralLabel">
            <div class="offcanvas-header bg-success text-white">
              <h5 class="offcanvas-title" id="menuLateralLabel"><i class="bi bi-cpu-fill me-2"></i>SYS-REPAIR - Menú
              </h5>
              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
              <p class="text-muted small mb-3">Navegación del sistema:</p>
              <ul class="nav flex-column gap-1">
                <li class="nav-item">
                  <a class="nav-link text-dark fw-semibold" href="index.php">
                    <i class="bi bi-house-door me-2 text-success"></i> Inicio
                  </a>
                </li>

                <div id="menu-publico">
                  <li class="nav-item mt-3 mb-1">
                    <span class="text-uppercase text-muted fw-bold px-3"
                      style="font-size: 0.75rem; letter-spacing: 0.5px;">Cliente</span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="login.php"><i
                        class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión Cliente</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="registrarse.php"><i
                        class="bi bi-person-plus me-2"></i> Registrar Cliente</a>
                  </li>
                  <li class="nav-item mt-3 mb-1">
                    <span class="text-uppercase text-muted fw-bold px-3"
                      style="font-size: 0.75rem; letter-spacing: 0.5px;">EMPLEADO</span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="accesoEmpleado.php"><i
                        class="bi bi-shield-lock me-2"></i> Inicio sesión empleado</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="registrarseEmpleado.php"><i
                        class="bi bi-shield-lock me-2"></i>
                      Registrar Empleado</a>
                  </li>
                </div>

                <div id="seccion-cliente" style="display: none;">
                  <li class="nav-item mt-3 mb-1">
                    <span class="text-uppercase text-muted fw-bold px-3"
                      style="font-size: 0.75rem; letter-spacing: 0.5px;">Mi Cuenta
                      (Cliente)</span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="perfilCliente.php"><i
                        class="bi bi-person-badge me-2"></i> Información Cliente</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="registrarDispositivo.php"><i
                        class="bi bi-phone me-2"></i> Registro Dispositivo</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="estadoDispositivo.php"><i
                        class="bi bi-search me-2"></i> Consultar Estado Dispositivo</a>
                  </li>
                </div>

                <div id="seccion-empleado" style="display: none;">
                  <li class="nav-item mt-3 mb-1">
                    <span class="text-uppercase text-muted fw-bold px-3"
                      style="font-size: 0.75rem; letter-spacing: 0.5px;">Panel Empleado</span>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="menuEmpleado.php"><i
                        class="bi bi-speedometer2 me-2"></i> Menú Principal Empleado</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="diagnosticoDispositivo.php"><i
                        class="bi bi-clipboard-pulse me-2"></i> Consulta y Diagnóstico de
                      Clientes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="respuestosDisponibles.php"><i
                        class="bi bi-box-seam me-2"></i> Consultar Repuesto</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="registrarRepuesto.php"><i
                        class="bi bi-plus-circle me-2"></i> Registrar Repuesto</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="registrarOrdenReparacion.php"><i
                        class="bi bi-file-earmark-text me-2"></i> Registrar Orden de
                      Reparación</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="cambioEstadoReparacion.php"><i
                        class="bi bi-arrow-repeat me-2"></i> Cambiar Estado Reparación</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="facturacion.php"><i class="bi bi-cash-coin me-2"></i>
                      Pago y Facturación</a>
                  </li>
                  <li class="nav-item mt-1">
                    <a class="nav-link text-dark ps-4 py-1" href="gestionClientesDispositivos.php"><i
                        class="bi bi-people-fill me-2"></i> Gestión Clientes y Dispositivos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-dark ps-4 py-1" href="gestionTecnicoReparacion.php"><i
                        class="bi bi-gear-fill me-2"></i> Gestión Técnicos</a>
                  </li>
                  <li class="nav-item mt-3">
                    <a class="nav-link text-dark fw-bold bg-light rounded px-3 py-2 shadow-sm border"
                      href="administrador.php">
                      <i class="bi bi-shield-lock-fill me-2 text-success"></i> Administrador
                    </a>
                  </li>
                </div>
                <div id="seccion-cerrar" style="display: none;" class="mt-4">
                  <li class="nav-item border-top pt-2">
                    <a class="nav-link text-danger fw-semibold ps-4 py-1" href="#" id="btn-cerrar-sesion-general">
                      <i class="bi bi-box-arrow-left me-2"></i> Cerrar Sesión
                    </a>
                  </li>
                </div>

              </ul>
            </div>
          </div>
          <!-- Fin Offcanvas -->

          <div class="bg-white text-success d-flex align-items-center justify-content-center rounded-2 shadow-sm"
            style="width: 40px; height: 40px;">
            <i class="bi bi-cpu-fill fs-4"></i>
          </div>
          <div>
            <h2 class="h6 m-0 fw-bold text-white">SYS-REPAIR</h2>
            <small class="text-light" style="font-size: 0.75rem; opacity: 0.85;">Centro de Reparación de
              Dispositivos Móviles</small>
          </div>
        </div>
        <span class="fs-4 text-light"><i class="bi bi-tools"></i></span>
      </div>

      <!-- Contenido Principal -->
      <div class="card-body p-4 p-md-5">

        <!-- Título y Botones Superiores -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom">
          <div class="d-flex align-items-center gap-2">
            <h1 class="h3 fw-bold text-dark m-0">Estado de Pago y Factura</h1>
          </div>
        </div>

        <!-- Fila Principal con Búsqueda y Secciones -->
        <div class="row g-4">

          <!-- Columna Izquierda: Lista de Clientes -->
          <div class="col-lg-4 border-end-lg">
            <label class="form-label fw-bold text-dark mb-2">Buscar cliente</label>
            <div class="input-group mb-3">
              <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
              <input type="text" class="form-control bg-light" placeholder="Nombre o teléfono...">
            </div>

            <h2 class="h6 fw-bold text-secondary mb-3">Clientes en espera</h2>

            <div class="list-group gap-2">
              <a href="#" class="list-group-item list-group-item-action border rounded-3 p-3 active"
                style="background-color: #e8f0e3; color: #1b3318; border-color: #2d5a27 !important;">
                <div class="d-flex w-100 justify-content-between align-items-center">
                  <h3 class="h6 mb-1 fw-bold">Carlos Martínez</h3>
                  <small class="text-muted fw-bold">10 min</small>
                </div>
                <p class="mb-1 small">Celular Samsung S22</p>
                <small class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i>
                  Seleccionado</small>
              </a>

              <a href="#" class="list-group-item list-group-item-action border rounded-3 p-3">
                <div class="d-flex w-100 justify-content-between align-items-center">
                  <h3 class="h6 mb-1 fw-bold">Ana López</h3>
                  <small class="text-muted">25 min</small>
                </div>
                <p class="mb-1 small text-muted">Tablet Xiaomi Pad 5</p>
              </a>

              <a href="#" class="list-group-item list-group-item-action border rounded-3 p-3">
                <div class="d-flex w-100 justify-content-between align-items-center">
                  <h3 class="h6 mb-1 fw-bold">Roberto Gómez</h3>
                  <small class="text-muted">40 min</small>
                </div>
                <p class="mb-1 small text-muted">Smartwatch Huawei GT3</p>
              </a>
            </div>
          </div>

          <!-- Columna Derecha: Detalle de Relación Cliente - Dispositivo - Diagnóstico -->
          <div class="col-lg-8">

            <!-- Tarjeta 1: Relación Cliente y Dispositivo -->
            <div class="card border shadow-sm mb-3">
              <div class="card-header bg-light fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-person-vcard text-success fs-5"></i> Información del Cliente y Dispositivo
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-sm-6">
                    <p class="mb-1 small text-muted">Nombre del Cliente</p>
                    <p class="fw-bold mb-0 text-dark">Carlos Martínez</p>
                  </div>
                  <div class="col-sm-6">
                    <p class="mb-1 small text-muted">Teléfono de Contacto</p>
                    <p class="fw-bold mb-0 text-dark">7788-9900</p>
                  </div>
                  <div class="col-sm-6">
                    <p class="mb-1 small text-muted">Marca</p>
                    <p class="fw-bold mb-0 text-dark">Samsung</p>
                  </div>
                  <div class="col-sm-6">
                    <p class="mb-1 small text-muted">Modelo</p>
                    <p class="fw-bold mb-0 text-dark">Samsung Galaxy S22</p>
                  </div>
                  <div class="col-sm-6">
                    <p class="mb-1 small text-muted">Número de Serie / IMEI</p>
                    <p class="fw-bold mb-0 text-dark">SN-8823910293</p>
                  </div>
                  <div class="col-sm-6">
                    <p class="mb-1 small text-muted">Estado</p>
                    <p class="fw-bold mb-0 text-dark">reparado</p>
                  </div>
                </div>
              </div>
            </div>


            <!-- Tarjeta de Desglose de Factura -->
            <div class="card border shadow-sm mb-4" id="seccion-factura-imprimir">
              <div
                class="card-header bg-light fw-bold text-dark d-flex justify-content-between align-items-center flex-wrap gap-2">
                <span><i class="bi bi-receipt me-2 text-success"></i> Comprobante N°: <span
                    class="text-secondary">FAC-2026-0892</span></span>
                <span class="small text-muted">Fecha: 14/09/2026</span>
              </div>
              <div class="card-body p-4">


                <!-- Tabla de Detalles de Cobro -->
                <div class="table-responsive mb-2">
                  <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light small text-secondary">
                      <tr>
                        <th class="py-3 px-3">Descripción del Concepto</th>
                        <th class="py-3 px-3 text-center" style="width: 100px;">Cant.</th>
                        <th class="py-3 px-3 text-end" style="width: 120px;">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody id="tabla-cuerpo-factura">

                    </tbody>
                    <tfoot class="table-light">
                      <tr>
                        <td colspan="2" class="py-3 px-3 text-end fw-bold text-dark">Total a Pagar:</td>
                        <td id="txt-total-pagar" class="py-3 px-3 text-end fw-bold text-success fs-5">$0.00</td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
            </div>

            <!-- Tarjeta 3: Sección de Selección de Método de Pago -->
            <div class="card border shadow-sm mb-4">
              <div class="card-header bg-light fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-credit-card-2-front text-success fs-5"></i> Método de Pago
              </div>
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label small fw-bold text-secondary">Seleccione la forma de pago:</label>
                    <select class="form-select bg-light fw-semibold text-dark">
                      <option value="tarjeta" selected>Tarjeta de Crédito / Débito</option>
                      <option value="efectivo">Efectivo</option>
                      <option value="transferencia">Transferencia Bancaria</option>
                      <option value="chivo">Billetera Electrónica</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label small fw-bold text-secondary">Referencia / No. de Autorización:</label>
                    <input type="text" class="form-control bg-light" placeholder="Ingrese número de referencia...">
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

        <!-- Botones de Acción e Interacción de Pago al Final -->
        <div class="d-flex justify-content-end align-items-center flex-wrap gap-3">
          <div class="d-flex gap-2 flex-wrap">
            <!-- Botón de Pagar / Procesar que enviará la orden a la tabla de factura -->
            <button type="button"
              class="btn btn-success fw-bold py-2 px-4 rounded-3 shadow-sm d-flex align-items-center gap-2"
              style="background-color: #198754;">
              <i class="bi bi-check-circle-fill"></i> Pagar y Procesar
            </button>
            <button type="button"
              class="btn btn-outline-success fw-bold py-2 px-4 rounded-3 shadow-sm d-flex align-items-center gap-2">
              <i class="bi bi-download"></i> Descargar Factura (PDF)
            </button>
          </div>
        </div>

      </div>

      <!-- Pie de página corporativo -->
      <div class="card-footer bg-white border-top p-4">
        <div class="row text-muted small">
          <div class="col-md-4 mb-3 mb-md-0">
            <div class="d-flex gap-3 fs-5 text-dark mb-2">
              <a href="#" class="text-dark"><i class="bi bi-twitter-x"></i></a>
              <a href="#" class="text-dark"><i class="bi bi-facebook"></i></a>
              <a href="#" class="text-dark"><i class="bi bi-instagram"></i></a>
              <a href="#" class="text-dark"><i class="bi bi-youtube"></i></a>
            </div>
          </div>
          <div class="col-md-4 mb-3 mb-md-0">
            <h6 class="fw-bold text-dark">Contactos</h6>
            <p class="mb-1">2222-2222</p>
            <p class="mb-0">7777-7777</p>
          </div>
          <div class="col-md-4">
            <h6 class="fw-bold text-dark">Dirección y Servicios</h6>
            <p class="mb-1">Calle 14 y Av. 25</p>
            <p class="mb-1">Local 25</p>
            <p class="mb-0 text-secondary small">Reparación y mantenimiento. Celulares, tablets y Smartwatches</p>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap JS Bundle CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/ProyectoPPI/js/facturacion.js"></script>
  <script src="/ProyectoPPI/js/nav.js"></script>
</body>

</html>