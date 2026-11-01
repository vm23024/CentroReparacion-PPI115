<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard del administrador | SYS-REPAIR</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- CSS Personalizado -->
  <link rel="stylesheet" href="/ProyectoPPI/CSS/css.css">
  <link rel="stylesheet" href="/ProyectoPPI/CSS/estilos.css">
</head>

<body>

  <!-- Fondo animado: líneas verdes que caen -->
  <div class="lluvia" aria-hidden="true">
    <span style="--x:76.2%;--h:141px;--d:8.2s;--r:-1.1s;--o:0.64;--y:42vh"></span>
    <span style="--x:46.0%;--h:219px;--d:12.8s;--r:-5.8s;--o:0.56;--y:31vh"></span>
    <span style="--x:90.8%;--h:143px;--d:6.5s;--r:-1.2s;--o:0.75;--y:38vh"></span>
    <span style="--x:94.4%;--h:123px;--d:10.2s;--r:-8.2s;--o:0.56;--y:19vh"></span>
    <span style="--x:69.9%;--h:149px;--d:9.5s;--r:-11.4s;--o:0.61;--y:25vh"></span>
    <span style="--x:1.4%;--h:215px;--d:10.8s;--r:-5.3s;--o:0.74;--y:58vh"></span>
    <span style="--x:34.7%;--h:170px;--d:6.8s;--r:-4.3s;--o:0.58;--y:48vh"></span>
    <span style="--x:83.2%;--h:120px;--d:12.6s;--r:-2.5s;--o:0.45;--y:42vh"></span>
    <span style="--x:25.8%;--h:106px;--d:8.8s;--r:-13.0s;--o:0.69;--y:51vh"></span>
    <span style="--x:91.7%;--h:160px;--d:12.0s;--r:-3.6s;--o:0.47;--y:41vh"></span>
    <span style="--x:63.2%;--h:128px;--d:7.7s;--r:-3.5s;--o:0.65;--y:29vh"></span>
    <span style="--x:76.8%;--h:199px;--d:12.2s;--r:-10.6s;--o:0.7;--y:75vh"></span>
    <span style="--x:54.8%;--h:110px;--d:6.3s;--r:-9.5s;--o:0.63;--y:22vh"></span>
    <span style="--x:64.2%;--h:163px;--d:9.4s;--r:-11.9s;--o:0.67;--y:26vh"></span>
    <span style="--x:47.3%;--h:177px;--d:8.0s;--r:-3.3s;--o:0.75;--y:38vh"></span>
    <span style="--x:40.8%;--h:151px;--d:8.1s;--r:-7.2s;--o:0.61;--y:26vh"></span>
    <span style="--x:64.0%;--h:109px;--d:7.5s;--r:-11.8s;--o:0.65;--y:33vh"></span>
    <span style="--x:45.4%;--h:175px;--d:13.0s;--r:-5.8s;--o:0.51;--y:29vh"></span>
    <span style="--x:24.9%;--h:134px;--d:8.4s;--r:-1.2s;--o:0.55;--y:38vh"></span>
    <span style="--x:80.3%;--h:141px;--d:12.2s;--r:-9.7s;--o:0.62;--y:57vh"></span>
    <span style="--x:74.1%;--h:143px;--d:8.6s;--r:-4.4s;--o:0.47;--y:40vh"></span>
    <span style="--x:57.3%;--h:182px;--d:6.9s;--r:-6.5s;--o:0.7;--y:32vh"></span>
  </div>

  <div class="pagina">
    <div class="tarjeta">

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

      <main class="cuerpo">
        <!-- ===== Perfil del administrador y usuario ===== -->
        <div class="superior">
          <div class="perfil">
            <img src="img/administrador.png" class="perfil__foto" alt="Foto del administrador">
            <div>
              <h1 class="titulo-pagina">Nombre administrador</h1>
              <p class="subtitulo-pagina">Dashboard &nbsp;•&nbsp; admin@sysrepair.com</p>
            </div>
          </div>

        </div>

        <!-- ===== Accesos del administrador ===== -->
        <nav class="nav-admin" aria-label="Secciones del administrador">
          <a class="boton boton--contorno" href="gestionClientesDispositivos.php">Clientes y dispositivos</a>
          <a class="boton boton--contorno" href="gestionTecnicoReparacion.php">Técnicos y tipo de reparaciones</a>
          <a class="boton boton--contorno" href="respuestosDisponibles.php">Repuestos</a>
          <a class="boton boton--contorno" href="registrarOrdenReparacion.php">Ordenes de reparación</a>
        </nav>

        <div class="dashboard__rejilla">

          <!-- Sección Repuestos -->
          <section aria-labelledby="t-repuestos">
            <div class="seccion__cabecera">
              <h2 class="seccion__titulo" id="t-repuestos">Repuestos</h2>
            </div>
            <div class="repuestos" id="dashboard-repuestos-container">
              <!-- Se llenará dinámicamente vía JavaScript -->
            </div>
          </section>

          <!-- Sección Técnicos Trabajando -->
          <section aria-labelledby="t-tecnicos">
            <h2 class="seccion__titulo" id="t-tecnicos">Técnicos trabajando</h2>
            <ul class="lista" id="dashboard-tecnicos-container">
              <!-- Se llenará dinámicamente vía JavaScript con botón de eliminar -->
            </ul>
          </section>

          <!-- Sección Orden Reparación -->
          <section id="ordenReparacion" aria-labelledby="t-ordenReparacion">
            <h2 class="seccion__titulo" id="t-ordenReparacion">Orden Reparación</h2>
            <ul class="lista" id="dashboard-ordenes-container">
              <!-- Se llenará dinámicamente vía JavaScript -->
            </ul>
          </section>

          <!-- Sección Clientes -->
          <section aria-labelledby="t-clientes">
            <h2 class="seccion__titulo" id="t-clientes">Clientes</h2>
            <ul class="lista" id="dashboard-clientes-container">
              <!-- Se llenará dinámicamente vía JavaScript con botón de eliminar -->
            </ul>
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

  <script src="js/app.js"></script>
  <script>
    // ----- clientes -----
    const MESES = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
    const selMes = document.getElementById("sel-mes");
    const selAnio = document.getElementById("sel-anio");
    const contDias = document.getElementById("dias");

    // Estado inicial igual al diseño: septiembre 2025, rango del 9 al 13
    let mes = 8, anio = 2025;
    let seleccion = { inicio: new Date(2025, 8, 9), fin: new Date(2025, 8, 13) };

    MESES.forEach(function (m, i) { selMes.add(new Option(m, i)); });
    for (let a = 2024; a <= 2028; a++) selAnio.add(new Option(a, a));

    function mismoDia(a, b) { return a.toDateString() === b.toDateString(); }

    function dibujar() {
      selMes.value = mes;
      selAnio.value = anio;
      contDias.innerHTML = "";

      const primero = new Date(anio, mes, 1);
      const inicio = new Date(anio, mes, 1 - primero.getDay());

      for (let i = 0; i < 42; i++) {
        const fecha = new Date(inicio.getFullYear(), inicio.getMonth(), inicio.getDate() + i);
        if (i >= 35 && fecha.getMonth() !== mes) break;

        // Los días del mes anterior quedan vacíos, como en el diseño
        if (fecha < primero) {
          contDias.appendChild(document.createElement("span"));
          continue;
        }

        const dia = document.createElement("button");
        dia.type = "button";
        dia.className = "clientes__dia";
        dia.textContent = fecha.getDate();

        if (fecha.getMonth() !== mes) dia.classList.add("is-fuera");
        if (mismoDia(fecha, seleccion.fin)) {
          dia.classList.add("is-seleccionado");
          dia.setAttribute("aria-pressed", "true");
        } else if (fecha >= seleccion.inicio && fecha < seleccion.fin) {
          dia.classList.add("is-rango");
        }

        dia.addEventListener("click", function () {
          seleccion = { inicio: fecha, fin: fecha };
          mes = fecha.getMonth();
          anio = fecha.getFullYear();
          dibujar();
        });
        contDias.appendChild(dia);
      }
    }

    function moverMes(paso) {
      mes += paso;
      if (mes < 0) { mes = 11; anio--; }
      if (mes > 11) { mes = 0; anio++; }
      if (anio < 2024) { anio = 2024; mes = 0; }
      if (anio > 2028) { anio = 2028; mes = 11; }
      dibujar();
    }

    document.getElementById("mes-anterior").addEventListener("click", function () { moverMes(-1); });
    document.getElementById("mes-siguiente").addEventListener("click", function () { moverMes(1); });
    selMes.addEventListener("change", function () { mes = +selMes.value; dibujar(); });
    selAnio.addEventListener("change", function () { anio = +selAnio.value; dibujar(); });

    dibujar();
  </script>

  <!-- Bootstrap JS Bundle CDN -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/ProyectoPPI/js/app.js"></script>
  <script src="/ProyectoPPI/js/dashboardAdmin.js"></script>
  <script src="/ProyectoPPI/js/nav.js"></script>
</body>

</html>