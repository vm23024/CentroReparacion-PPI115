<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro orden de reparación | SYS-REPAIR</title>

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
    <span style="--x:32.7%;--h:128px;--d:8.8s;--r:-0.6s;--o:0.78;--y:17vh"></span>
    <span style="--x:36.8%;--h:104px;--d:12.4s;--r:-2.8s;--o:0.48;--y:58vh"></span>
    <span style="--x:7.8%;--h:113px;--d:9.9s;--r:-0.8s;--o:0.68;--y:33vh"></span>
    <span style="--x:62.8%;--h:105px;--d:10.0s;--r:-5.2s;--o:0.84;--y:10vh"></span>
    <span style="--x:55.6%;--h:124px;--d:8.0s;--r:-1.9s;--o:0.5;--y:44vh"></span>
    <span style="--x:55.9%;--h:136px;--d:6.7s;--r:-7.4s;--o:0.53;--y:17vh"></span>
    <span style="--x:54.7%;--h:106px;--d:10.0s;--r:-8.0s;--o:0.65;--y:73vh"></span>
    <span style="--x:42.9%;--h:170px;--d:9.3s;--r:-12.0s;--o:0.59;--y:36vh"></span>
    <span style="--x:78.8%;--h:152px;--d:6.6s;--r:-3.9s;--o:0.65;--y:48vh"></span>
    <span style="--x:72.5%;--h:163px;--d:10.3s;--r:-1.0s;--o:0.65;--y:26vh"></span>
    <span style="--x:75.2%;--h:128px;--d:12.5s;--r:-5.5s;--o:0.83;--y:14vh"></span>
    <span style="--x:75.9%;--h:170px;--d:8.4s;--r:-4.6s;--o:0.65;--y:63vh"></span>
    <span style="--x:7.7%;--h:113px;--d:12.6s;--r:-6.2s;--o:0.72;--y:12vh"></span>
    <span style="--x:72.7%;--h:169px;--d:10.5s;--r:-12.9s;--o:0.78;--y:41vh"></span>
    <span style="--x:71.2%;--h:178px;--d:6.2s;--r:-6.0s;--o:0.52;--y:19vh"></span>
    <span style="--x:49.4%;--h:145px;--d:11.4s;--r:-1.7s;--o:0.55;--y:55vh"></span>
    <span style="--x:90.8%;--h:217px;--d:6.6s;--r:-5.8s;--o:0.67;--y:22vh"></span>
    <span style="--x:81.3%;--h:161px;--d:10.9s;--r:-12.8s;--o:0.72;--y:53vh"></span>
    <span style="--x:94.9%;--h:128px;--d:6.6s;--r:-2.0s;--o:0.71;--y:6vh"></span>
    <span style="--x:48.5%;--h:136px;--d:7.8s;--r:-0.1s;--o:0.62;--y:52vh"></span>
    <span style="--x:60.8%;--h:171px;--d:12.7s;--r:-9.0s;--o:0.66;--y:11vh"></span>
    <span style="--x:45.8%;--h:190px;--d:8.8s;--r:-5.1s;--o:0.64;--y:56vh"></span>
  </div>

  <div class="pagina">
    <div class="tarjeta">

      <!-- ===== Encabezado ===== -->
      <header class="cabecera">
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
            <h1 class="titulo-pagina">Registro orden de reparación</h1>
            <p class="subtitulo-pagina">Selecciona un cliente y completa los datos del dispositivo</p>
          </div>

        </div>

        <div class="dos-columnas">
          <!-- ===== Lista de clientes ===== -->
          <aside aria-labelledby="t-clientes">
            <h2 class="seccion__titulo" id="t-clientes">Dispositivos/Clientes</h2>
            <div class="busqueda">
              <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="10.5" cy="10.5" r="6.5" fill="none" stroke="currentColor" stroke-width="2" />
                <path d="m15.5 15.5 5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <label for="buscar-cliente" class="solo-lectores">Buscar Dispositivo/Cliente</label>
              <input id="buscar-cliente" type="search" placeholder="Buscar Dispositivo/Cliente">
            </div>
            <ul class="lista" id="lista-dispositivo">
              <li><button class="item" type="button" data-nombre="Nombre">
                  <span class="item__miniatura"><svg width="30" height="30" viewBox="0 0 24 24" aria-hidden="true">
                      <circle cx="12" cy="8" r="4" fill="currentColor" />
                      <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" fill="currentColor" />
                    </svg></span>
                  <span class="item__textos"><span class="item__titulo">Dispositivo</span><span
                      class="item__detalle">Marca</span></span>
                  <span class="item__extra">Modelo</span>
                </button></li>
              <li><button class="item" type="button" data-nombre="Nombre">
                  <span class="item__miniatura"><svg width="30" height="30" viewBox="0 0 24 24" aria-hidden="true">
                      <circle cx="12" cy="8" r="4" fill="currentColor" />
                      <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" fill="currentColor" />
                    </svg></span>
                  <span class="item__textos"><span class="item__titulo">Dispositivo</span><span
                      class="item__detalle">Marca</span></span>
                  <span class="item__extra">Modelo</span>
                </button></li>
              <li><button class="item" type="button" data-nombre="Nombre">
                  <span class="item__miniatura"><svg width="30" height="30" viewBox="0 0 24 24" aria-hidden="true">
                      <circle cx="12" cy="8" r="4" fill="currentColor" />
                      <path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7z" fill="currentColor" />
                    </svg></span>
                  <span class="item__textos"><span class="item__titulo">Dispositivo</span><span
                      class="item__detalle">Marca</span></span>
                  <span class="item__extra">Modelo</span>
                </button></li>
            </ul>
          </aside>

          <!-- ===== Formulario ===== -->
          <section aria-labelledby="t-orden">
            <h2 class="seccion__titulo" id="t-orden">Datos de la orden</h2>
            <form id="form-orden" novalidate>
              <div class="panel">
                <div class="formulario__rejilla">

                  <div class="campo">
                    <label for="ingreso">Ingreso de orden</label>
                    <input type="date" id="fechaIngresoOrden" name="fechaIngresoOrden" class="control">
                  </div>

                  <div class="campo">
                    <label for="nombre">Nombre de cliente</label>
                    <input id="nombre" name="nombre" type="text" class="control" required>
                    <span class="mensaje-error">Ingresa el nombre del cliente.</span>
                  </div>

                  <div class="campo">
                    <label for="dispositivo">Marca del dispositivo</label>
                    <input id="marca" name="marca" type="text" class="control" placeholder="Ej. Oppo Reno 13" required>
                    <span class="mensaje-error">Ingresa la marca y el modelo.</span>
                  </div>

                  <div class="campo">
                    <label for="dispositivo">Modelo del dispositivo</label>
                    <input id="modelo" name="modelo" type="text" class="control" placeholder="Ej. Oppo Reno 13"
                      required>
                    <span class="mensaje-error">Ingresa el modelo.</span>
                  </div>

                  <div class="campo">
                    <label for="nombre">Número de IMEI</label>
                    <input id="imei" name="imei" type="text" class="control" required>
                  </div>

                  <div class="campo">
                    <label for="accesorios">Accesorios</label>
                    <input id="accesorios" name="accesorios" type="text" class="control"
                      placeholder="Ej. cargador, funda">
                  </div>

                  <div class="campo">
                    <label for="estado">Estado del dispositivo</label>
                    <select id="estadoDispositivo" name="estadoDispositivo" class="control">
                      <option value="recibido">Recibido</option>
                      <option value="diagnostico" selected>En diagnostico</option>
                      <option value="reparacion">En reparación</option>
                      <option value="esperandoRepuesto">Esperando repuesto</option>
                      <option value="reparado">Reparado</option>
                      <option value="entregado">Entregado</option>
                    </select>
                  </div>


                  <div class="campo">
                    <label for="selectRepuesto">Seleccionar repuesto</label>
                    <select id="selectRepuesto" name="selectRepuesto" class="control">
                      <option value="">Sin repuesto</option>
                    </select>
                  </div>


                  <div class="campo">
                    <label for="falla">Falla según el cliente</label>
                    <textarea id="falla" name="falla" class="control" required></textarea>
                    <span class="mensaje-error">Describe la falla reportada.</span>
                  </div>

                  <div class="campo">
                    <label for="motivo">Motivo de reparación</label>
                    <textarea id="motivo" name="motivo" class="control"></textarea>
                  </div>


                  <div class="campo">
                    <label for="prometida">Reparación prometida para</label>
                    <input type="date" id="fechaEntrega" name="fechaEntrega" class="control">
                  </div>

                  <div class="campo">
                    <label for="costo">Costo de reparación</label>
                    <div class="campo-dinero">
                      <span>$</span>
                      <input id="costo" name="costo" type="number" min="0" step="0.01" class="control"
                        placeholder="0.00">
                    </div>
                  </div>



                </div>
              </div>

              <div class="acciones">
                <button class="boton boton--verde" type="submit">Registrar orden de reparación</button>
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
  <script src="/ProyectoPPI/js/RegistrarOrdenReparacion.js"></script>
  <script src="/ProyectoPPI/js/nav.js"></script>
</body>

</html>