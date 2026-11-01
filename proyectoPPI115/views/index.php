<?php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYS-REPAIR</title>

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
        <div class="card shadow-lg mx-auto" style="max-width: 1050px;">

            <!-- Encabezado Estilizado Verde Oscuro Corporativo con Logo -->
            <div class="card-header text-white d-flex justify-content-between align-items-center py-3"
                style="background-color: #2d5a27; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <div class="d-flex align-items-center gap-3">

                    <!-- Botón del Menú -->
                    <button class="btn text-white" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#menuLateral" aria-controls="menuLateral">
                        <i class="bi bi-list fs-4"></i>
                    </button>

                    <!-- Offcanvas Actualizado -->
                    <div class="offcanvas offcanvas-start text-dark" tabindex="-1" id="menuLateral"
                        aria-labelledby="menuLateralLabel">
                        <div class="offcanvas-header bg-success text-white">
                            <h5 class="offcanvas-title" id="menuLateralLabel"><i
                                    class="bi bi-cpu-fill me-2"></i>SYS-REPAIR - Menú</h5>
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
                                        <a class="nav-link text-dark ps-4 py-1"
                                            href="gestionClientesDispositivos.php"><i
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
                                        <a class="nav-link text-danger fw-semibold ps-4 py-1" href="#"
                                            id="btn-cerrar-sesion-general">
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
            <div class="card-body p-4">

                <main class="hero">
                    <div id="carouselCaptions" class="carousel slide" data-bs-ride="carousel">

                        <!-- Indicadores -->
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>

                            <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>

                            <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>

                            <button type="button" data-bs-target="#carouselCaptions" data-bs-slide-to="3"
                                aria-label="Slide 4"></button>
                        </div>

                        <!-- Imágenes -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/ProyectoPPI/img/FotosCarrusel/images.jpg" class="d-block w-100"
                                    alt="Servicio técnico">
                            </div>

                            <div class="carousel-item">
                                <img src="/ProyectoPPI/img/FotosCarrusel/reparacion-pantallas.jpg" class="d-block w-100"
                                    alt="Reparación de pantallas">
                            </div>

                            <div class="carousel-item">
                                <img src="/ProyectoPPI/img/FotosCarrusel/tablet_reparar_600.jpg" class="d-block w-100"
                                    alt="Reparación de tablets">
                            </div>
                            <div class="carousel-item">
                                <img src="/ProyectoPPI/img/FotosCarrusel/tecnico.jpg" class="d-block w-100"
                                    alt="Reparación de tablets">
                            </div>
                        </div>

                        <!-- Botón anterior -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>

                        <!-- Botón siguiente -->
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>

                    <section class="hero-content" aria-labelledby="hero-title">
                        <h2 id="hero-title">Reparación y mantenimiento</h2>
                        <p class="intro">Establecimiento especializado en reparación y mantenimiento de teléfonos
                            celulares y otros dispositivos móviles como tablets o smartwatch.</p>
                        <p class="intro">Nuestros técnicos expertos utilizan las mejores herramientas disponibles y
                            repuestos originales para restaurar su dispositivo a su máximo rendimiento.</p>
                        <ul class="benefits">
                            <li></span> Diagnóstico rápido y preciso</li>
                            <li></span> Repuestos con garantía de taller</li>
                            <li></span> Técnicos especializados</li>
                        </ul>
                        <!-- Ingreso de n° de orden-->
                        <form class="lookup-form" id="lookup-form">
                            <label class="visually-hidden" for="order-number">Número de IMEI</label>
                            <input id="order-number" name="order-number" type="text"
                                placeholder="Ingresa tu Nº de IMEI..." required>
                            <div class="button-container">
                                <button type="submit" class="button button-blue border-0"
                                    style="cursor: pointer;">Consultar</button>
                            </div>
                        </form>
                        <p class="form-message" id="form-message" role="status" aria-live="polite"></p>
                    </section>

                </main>
                <!--Seccion pasos de reparación-->
                <section class="repair-section">

                    <!-- Imagen del técnico -->
                    <div class="repair-image">
                        <img src="/ProyectoPPI/IMG/tecnico.jpg"
                            alt="Técnico profesional reparando un dispositivo electrónico">
                    </div>

                    <!-- Contenido del proceso -->
                    <div class="repair-content">

                        <h1>Proceso De Reparación, Sin Complicaciones</h1>

                        <div class="repair-steps">
                            <div class="step">
                                <div class="step-number">1</div>
                                <div class="step-text">
                                    <h2>Registra y reserva en línea</h2>
                                    <p>Reserve su reparación en línea o visítenos en la tienda</p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">2</div>
                                <div class="step-text">
                                    <h2>Dejar</h2>
                                    <p>Deje su dispositivo o programe una recogida</p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">3</div>
                                <div class="step-text">
                                    <h2>Reparaciones Rápidas</h2>
                                    <p>Reparaciones rápidas: la mayoría de las reparaciones se completan el mismo día.
                                    </p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">4</div>
                                <div class="step-text">
                                    <h2>Listo para su uso</h2>
                                    <p>Recupere su dispositivo en óptimas condiciones y listo para usar en poco tiempo!
                                    </p>
                                </div>
                            </div>

                            <div class="step">
                                <div class="step-number">5</div>
                                <div class="step-text">
                                    <h2>Expertos profesionales</h2>
                                    <p>Nuestros profesionales certificados manejan una amplia gama de problemas
                                        telefónicos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Pie de Página Corporativo -->
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
                        <p class="mb-0 text-secondary small">Reparación y mantenimiento. Celulares, tablets y
                            Smartwatches</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/ProyectoPPI/js/index.js"></script>
    <script src="/ProyectoPPI/js/nav.js"></script>
</body>

</html>