<?
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle de Seguimiento - SYS-REPAIR</title>

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="/ProyectoPPI/CSS/css.css">
</head>
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

<body>
  <div class="net-background"></div>

  <div class="container py-4">
    <!-- Tarjeta Principal del Sistema -->
    <div class="card shadow-lg mx-auto" style="max-width: 950px;">

      <!-- Encabezado Estilizado Verde Oscuro Corporativo con Logo -->
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


      <div class="card-body p-4">

        <!-- Botón de Retroceso -->
        <div class="mb-3">
          <a href="estadoDispositivo.php" class="text-success fs-4"><i class="bi bi-arrow-left"></i></a>
        </div>

        <div class="row g-4 align-items-center">
          <!-- Columna Izquierda: Imagen del Dispositivo -->
          <div class="col-md-5 text-center">
            <div class="bg-light p-3 border rounded-3 shadow-sm d-flex align-items-center justify-content-center"
              style="height: 300px;">
              <img src="Img7/Oppo.jpg" alt="Celular Oppo" class="img-fluid h-100 object-fit-contain">
            </div>
          </div>

          <!-- Columna Derecha: Detalles de la Orden -->
          <div class="col-md-7">
            <h3 class="fw-bold text-dark mb-1" id="det-dispositivo">Celular Oppo</h3>
            <span class="badge px-2 py-1 mb-2 fw-semibold"
              style="background-color: #d1e7dd; color: #0f5132; font-size: 0.8rem;">Precio de reparación</span>

            <h2 class="fw-bold text-dark display-6 mb-1" id="det-precio">$50</h2>
            <p class="text-muted small mb-3" id="det-imei">IMEI: 864209041234567</p>

            <!-- Selectores de Fechas -->
            <div class="row g-2 mb-3">
              <div class="col-6">
                <label class="form-label small text-muted mb-1">Fecha de registro</label>
                <input type="text" id="fechaRegistro" class="form-control form-control-sm border bg-light" readonly>
              </div>
              <div class="col-6">
                <label class="form-label small text-muted mb-1">Fecha de entrega</label>
                <input type="text" id="fechaEntrega" class="form-control form-control-sm border bg-light" readonly>
              </div>
            </div>

            <div class="mb-3">
              <label for="textareaDiagnosticoDetallado"
                class="form-label small text-muted fw-semibold mb-1">Diagnóstico</label>
              <textarea id="diagnostico" class="form-control form-control-sm border shadow-sm" rows="3"></textarea>
            </div>
          </div>
        </div>


        <!-- Progreso / Estado de Reparación -->
        <div class="mt-5 pt-3 border-top">
          <h4 class="h5 fw-bold text-dark mb-4">Estado de reparación</h4>
          <div class="d-flex justify-content-around text-center">


            <div class="d-flex flex-column align-items-center">
              <i class="bi bi-star fs-4 text-muted mb-1"></i>
              <span class="small text-muted" style="font-size: 0.85rem;">Recibido</span>
            </div>


            <div class="d-flex flex-column align-items-center">
              <i class="bi bi-star-fill fs-4 text-success mb-1"></i>
              <span class="small fw-bold text-success" style="font-size: 0.85rem;">En diagnóstico</span>
            </div>


            <div class="d-flex flex-column align-items-center">
              <i class="bi bi-star fs-4 text-muted mb-1"></i>
              <span class="small text-muted" style="font-size: 0.85rem;">En reparación</span>
            </div>


            <div class="d-flex flex-column align-items-center">
              <i class="bi bi-star fs-4 text-muted mb-1"></i>
              <span class="small text-muted" style="font-size: 0.85rem;">Esperando repuesto</span>
            </div>


            <div class="d-flex flex-column align-items-center">
              <i class="bi bi-star fs-4 text-muted mb-1"></i>
              <span class="small text-muted" style="font-size: 0.85rem;">Reparado</span>
            </div>


            <div class="d-flex flex-column align-items-center">
              <i class="bi bi-star fs-4 text-muted mb-1"></i>
              <span class="small text-muted" style="font-size: 0.85rem;">Entregado</span>
            </div>

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
  <script src="/ProyectoPPI/js/resultadoImei.js"></script>
  <script src="/ProyectoPPI/js/nav.js"></script>
</body>

</html>