<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de usuario</title>
</head>

<body>

</body>

</html>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil de Usuario y Menú - SYS-REPAIR</title>

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="CSS/css.css">
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
    <div class="card shadow-lg mx-auto position-relative" style="max-width: 2950px;">


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

      <div class="card-body p-4 position-relative">

        <!-- Información del Cliente (Encabezado de Perfil) -->
        <div class="d-flex align-items-center gap-3 mb-4 pb-2">
          <div
            class="rounded-circle overflow-hidden shadow-sm border border-2 border-success d-flex align-items-center justify-content-center"
            style="width: 90px; height: 90px; flex-shrink: 0;">
            <img src="IMG/icons8-user-avatar-50.png" alt="Foto de Perfil del Cliente"
              class="w-100 h-100 object-fit-cover">
          </div>
          <div>
            <h1 id="lblNombreCompleto" class="h2 fw-bold text-dark m-0">Nombre cliente</h1>
            <p class="text-muted mb-0 fw-normal"><span id="lblCorreo">juan.perez@email.com</span>&nbsp;•&nbsp;<span
                id="lblTelefono">503 7777-8888</span>
            </p>
          </div>
        </div>

        <div class="row g-4 mt-1">
          <!-- Columna Izquierda: Dispositivos Registrados -->
          <div class="col-md-7">
            <h3 class="h5 fw-bold text-dark mb-3">Dispositivos registrados</h3>

            <div id="contenedorDispositivos" class="d-flex flex-column gap-2">
              <!--se cargaran mediante js y bd -->

            </div>
          </div>

          <!-- Columna Derecha: Botones de Acción -->
          <div class="col-md-5 d-flex flex-column justify-content-center gap-3 pt-md-4">
            <a href="estadoDispositivo.php" class="btn btn-primary fw-bold py-2 px-3 rounded-3 shadow-sm text-center">
              Consultar estado de reparación
            </a>
            <a href="registrarDispositivo.php"
              class="btn btn-success fw-bold py-2 px-3 rounded-3 shadow-sm text-center">
              Registrar dispositivo nuevo
            </a>
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
  <script src="/ProyectoPPI/js/perfilCliente.js"></script>
  <script src="/ProyectoPPI/js/nav.js"></script>
</body>

</html>