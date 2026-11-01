<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cambio de estado de reparación | SYS-REPAIR</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/ProyectoPPI/CSS/estilos.css">
</head>

<body>

  <!-- Fondo animado: líneas verdes que caen -->
  <div class="lluvia" aria-hidden="true">
    <span style="--x:52.3%;--h:94px;--d:12.1s;--r:-10.1s;--o:0.69;--y:24vh"></span>
    <span style="--x:17.9%;--h:211px;--d:10.3s;--r:-1.6s;--o:0.47;--y:71vh"></span>
    <span style="--x:53.0%;--h:213px;--d:11.5s;--r:-1.4s;--o:0.67;--y:36vh"></span>
    <span style="--x:19.7%;--h:100px;--d:11.4s;--r:-6.6s;--o:0.67;--y:13vh"></span>
    <span style="--x:44.4%;--h:219px;--d:10.2s;--r:-2.6s;--o:0.56;--y:70vh"></span>
    <span style="--x:53.3%;--h:212px;--d:9.6s;--r:-3.2s;--o:0.66;--y:38vh"></span>
    <span style="--x:91.4%;--h:141px;--d:11.9s;--r:-1.8s;--o:0.5;--y:61vh"></span>
    <span style="--x:32.0%;--h:151px;--d:9.0s;--r:-2.8s;--o:0.57;--y:20vh"></span>
    <span style="--x:88.9%;--h:129px;--d:12.6s;--r:-8.4s;--o:0.6;--y:37vh"></span>
    <span style="--x:87.5%;--h:209px;--d:7.5s;--r:-12.4s;--o:0.61;--y:67vh"></span>
    <span style="--x:17.0%;--h:147px;--d:7.1s;--r:-5.6s;--o:0.66;--y:48vh"></span>
    <span style="--x:42.3%;--h:181px;--d:8.2s;--r:-9.4s;--o:0.46;--y:75vh"></span>
    <span style="--x:45.9%;--h:94px;--d:8.7s;--r:-6.7s;--o:0.57;--y:13vh"></span>
    <span style="--x:12.1%;--h:148px;--d:12.8s;--r:-1.4s;--o:0.56;--y:10vh"></span>
    <span style="--x:89.8%;--h:136px;--d:7.9s;--r:-1.7s;--o:0.62;--y:38vh"></span>
    <span style="--x:40.8%;--h:216px;--d:10.9s;--r:-1.2s;--o:0.47;--y:28vh"></span>
    <span style="--x:42.7%;--h:108px;--d:7.9s;--r:-0.2s;--o:0.49;--y:38vh"></span>
    <span style="--x:9.2%;--h:146px;--d:6.5s;--r:-11.2s;--o:0.63;--y:48vh"></span>
    <span style="--x:98.4%;--h:196px;--d:12.5s;--r:-3.5s;--o:0.5;--y:72vh"></span>
    <span style="--x:70.5%;--h:118px;--d:12.8s;--r:-3.4s;--o:0.52;--y:44vh"></span>
    <span style="--x:62.6%;--h:142px;--d:8.0s;--r:-6.5s;--o:0.52;--y:49vh"></span>
    <span style="--x:79.8%;--h:154px;--d:6.3s;--r:-0.2s;--o:0.65;--y:29vh"></span>
  </div>

  <div class="pagina">
    <div class="tarjeta">

      <!-- ===== Encabezado ===== -->
      <header class="cabecera">

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
                      <a class="nav-link text-dark ps-4 py-1" href="facturacion.php"><i
                          class="bi bi-cash-coin me-2"></i> Pago y Facturación</a>
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

      </header>

      <main class="cuerpo">
        <!-- ===== Título y usuario ===== -->
        <div class="superior">
          <div>
            <h1 class="titulo-pagina">Órdenes de reparación</h1>
            <p class="subtitulo-pagina">Actualiza el diagnóstico y el estado de cada dispositivo</p>
          </div>
        </div>

        <div class="dos-columnas">
          <!-- ===== Lista de orden de reparacion ===== -->
          <aside aria-labelledby="t-ordenReparacion">
            <h2 class="seccion__titulo" id="t-ordenReparacion">Orden Reparación</h2>
            <div class="busqueda">
              <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="2" />
                <path d="m15.5 15.5 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <label for="buscar-ordenReparacion" class="solo-lectores">Buscar Orden Reparación</label>
              <input id="buscar-ordenReparacion" type="search" placeholder="Buscar Orden Reparación">
            </div>
            <ul class="lista" id="lista-ordenReparacion">


            </ul>
          </aside>

          <!-- ===== Detalle de la orden ===== -->
          <section aria-labelledby="nombre-cliente">
            <h2 class="seccion__titulo">Detalle de la orden</h2>
            <form class="panel" id="form-estado" novalidate>
              <div class="detalle__cabecera">
                <a class="boton-icono" href="17-registro-orden.html" aria-label="Regresar"><svg width="22" height="22"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 12H5m6-7-7 7 7 7" fill="none" stroke="currentColor" stroke-width="2"
                      stroke-linecap="round" stroke-linejoin="round" />
                  </svg></a>
                <h3 class="detalle__cliente" id="nombre-cliente">Nombre cliente</h3>
                <span class="estado-actual">En diagnóstico</span>
                <button class="boton-icono" type="button" aria-label="Más opciones"><svg width="20" height="20"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="5" r="2" fill="currentColor" />
                    <circle cx="12" cy="12" r="2" fill="currentColor" />
                    <circle cx="12" cy="19" r="2" fill="currentColor" />
                  </svg></button>
              </div>

              <div class="detalle__rejilla">
                <figure class="dispositivo">
                  <figcaption class="dispositivo__titulo">Dispositivo</figcaption>
                  <img src="img/telefono.png" class="dispositivo__imagen" alt="Teléfono del cliente">
                </figure>

                <div class="grupo-campos">
                  <div class="campo">
                    <label for="marca">Marca del dispositivo</label>
                    <input class="control" id="marca" name="marca" type="text" placeholder="Ej. Oppo">
                  </div>
                  <div class="campo">
                    <label for="serie">Número de serie / Identificador</label>
                    <input class="control" id="serie" name="serie" type="text" placeholder="Ej. IMEI 3567...">
                  </div>
                  <div class="campo">
                    <label for="repuestoUtilizado">Repuesto utilizado</label>
                    <input id="repuestoUtilizado" type="text" class="control" readonly value="Ninguno">
                  </div>
                </div>
              </div>


              <div class="detalle__final">
                <div class="campo">
                  <label for="diagnostico">Diagnóstico</label>
                  <textarea class="control" id="diagnostico" name="diagnostico"></textarea>
                </div>

                <div class="campo">
                  <label for="problema">Descripción del problema</label>
                  <textarea class="control" id="problema" name="problema"></textarea>
                </div>

                <div class="campo">
                  <label for="estado-reparacion">Estado de reparación</label>
                  <select class="control" id="estado-reparacion" name="estado" required>
                    <option value="">Selecciona un estado</option>
                    <option>Recibido</option>
                    <option>En diagnóstico</option>
                    <option>En reparación</option>
                    <option>Esperando repuesto</option>
                    <option>Reparado</option>
                    <option>Entregado</option>
                  </select>
                  <span class="mensaje-error">Elige el nuevo estado.</span>
                </div>

                <div class="campo">
                  <label for="tipo-servicio">Tipo de servicio</label>
                  <select class="control" id="tipo-servicio" name="tipo_servicio">
                    <option value="">Selecciona un servicio</option>
                    <option value="Reparación">Reparación</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Actualización de Software">Actualización de Software</option>
                    <option value="Cambio de Pantalla">Cambio de Pantalla</option>
                  </select>
                </div>

                <button class="boton boton--azul" type="submit">Cambiar estado de reparación</button>
              </div>
            </form>
          </section>
        </div>
      </main>

      <!-- ===== Pie de página ===== -->
      <footer class="pie">
        <div class="pie__redes">
          <a href="#" aria-label="Facebook"><svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="currentColor"
                d="M12 2a10 10 0 0 0-1.6 19.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 12 2z" />
            </svg></a>
          <a href="#" aria-label="Instagram"><svg width="26" height="26" viewBox="0 0 24 24" aria-hidden="true"
              fill="none" stroke="currentColor" stroke-width="2">
              <rect x="3" y="3" width="18" height="18" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
            </svg></a>
          <a href="#" aria-label="YouTube"><svg width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="currentColor"
                d="M21.6 7.2a2.5 2.5 0 0 0-1.8-1.8C18.2 5 12 5 12 5s-6.2 0-7.8.4A2.5 2.5 0 0 0 2.4 7.2 26 26 0 0 0 2 12a26 26 0 0 0 .4 4.8 2.5 2.5 0 0 0 1.8 1.8C5.8 19 12 19 12 19s6.2 0 7.8-.4a2.5 2.5 0 0 0 1.8-1.8A26 26 0 0 0 22 12a26 26 0 0 0-.4-4.8zM10 15V9l5.2 3z" />
            </svg></a>
        </div>
        <div>
          <h2 class="pie__titulo">Contactos</h2>
          <p>2222-2222</p>
          <p>7777-7777</p>
        </div>
        <div>
          <h2 class="pie__titulo">Dirección y Servicios</h2>
          <p>Calle 14 y Av. 25</p>
          <p>Local 25</p>
          <p class="pie__nota">Reparación y mantenimiento. Celulares, tablets y Smartwatches</p>
        </div>
      </footer>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/ProyectoPPI/js/app.js"></script>
  <script src="/ProyectoPPI/js/cambioEstadoReparacion.js"></script>
  <script src="/ProyectoPPI/js/nav.js"></script>

</body>

</html>