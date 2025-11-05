<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CYA Bordados - Bordamos tus ideas con arte</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&family=Playfair+Display:wght@600&display=swap"
        rel="stylesheet">

    <!-- AOS Animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <style>
        :root {
            --azul: #0D3B66;
            --mostaza: #FAA916;
            --fondo: #FAF9F6;
            --gris: #F3F3F3;
            --texto: #22223B;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--texto);
            background-color: var(--fondo);
            scroll-behavior: smooth;
        }

        /* NAVBAR */
        .navbar {
            background-color: var(--azul);
            transition: background 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--mostaza) !important;
            font-family: 'Playfair Display', serif;
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: var(--mostaza) !important;
        }

        /* HERO */
        .hero {
            background: linear-gradient(to bottom right, rgba(13, 59, 102, 0.7), rgba(13, 59, 102, 0.8)),
                url("https://images.unsplash.com/photo-1574286630801-cb5f7a59b34b?auto=format&fit=crop&w=1920&q=80") center/cover no-repeat;
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 0 20px;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .hero p {
            max-width: 700px;
            margin: 0 auto 2rem;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .btn-mostaza {
            background-color: var(--mostaza);
            color: var(--azul);
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-mostaza:hover {
            background-color: #f7b529;
            transform: scale(1.05);
        }

        section {
            padding: 100px 0;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: var(--azul);
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        /* TARJETAS */
        .service-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .service-card i {
            color: var(--mostaza);
            margin-bottom: 15px;
        }

        /* CONTACTO */
        .btn-outline-mostaza {
            border: 2px solid var(--mostaza);
            color: var(--mostaza);
            border-radius: 50px;
            padding: 10px 25px;
            transition: all 0.3s;
        }

        .btn-outline-mostaza:hover {
            background-color: var(--mostaza);
            color: var(--azul);
        }

        /* FOOTER */
        footer {
            background-color: var(--azul);
            color: #fff;
            text-align: center;
            padding: 40px 0 20px;
        }

        footer a {
            color: var(--mostaza);
            margin: 0 10px;
            font-size: 1.4rem;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #fff;
        }

        footer p {
            margin-top: 15px;
            font-size: 0.9rem;
            color: #ddd;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">CYA Bordados</a>
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                            Administración
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <header class="hero" data-aos="fade-up">
        <h1>Bordamos tus ideas con arte</h1>
        <p>Transformamos tu diseño en un bordado de alta calidad. Uniformes, gorras, logotipos y más, con el toque
            artesanal que distingue a CYA Bordados.</p>
        <a href="#contacto" class="btn btn-mostaza mt-3">Solicita tu diseño</a>
    </header>

    <!-- NOSOTROS -->
    <section id="nosotros" data-aos="fade-up">
        <div class="container text-center">
            <h2>¿Quiénes Somos?</h2>
            <p class="text-muted mx-auto" style="max-width:700px;">
                En <b>CYA Bordados</b> somos un taller especializado en <b>bordados personalizados</b> para prendas,
                gorras y textiles.
                Creamos arte digital para máquinas <b>Tajima</b> y usamos hilos de primera calidad.
                Cada puntada refleja dedicación, precisión y creatividad.
            </p>
        </div>
    </section>

    <!-- SERVICIOS -->
    <section id="servicios" class="bg-light" data-aos="fade-up">
        <div class="container text-center">
            <h2>Nuestros Servicios</h2>
            <div class="row mt-5 g-4">
                <div class="col-md-4" data-aos="zoom-in">
                    <div class="service-card">
                        <i class="fa-solid fa-shirt fa-3x mb-3"></i>
                        <h5>Bordado en Prendas</h5>
                        <p>Playeras, camisas, uniformes o chaquetas. Tu logo o diseño con acabado profesional.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="service-card">
                        <i class="fa-solid fa-hat-cowboy fa-3x mb-3"></i>
                        <h5>Bordado en Gorras</h5>
                        <p>Personalización de gorras con bordados detallados, ideales para marcas y eventos.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="service-card">
                        <i class="fa-solid fa-pen-ruler fa-3x mb-3"></i>
                        <h5>Digitalización de Arte</h5>
                        <p>Convertimos tu idea o logo en arte bordable optimizado para máquinas Tajima.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACTO -->
    <section id="contacto" data-aos="fade-up">
        <div class="container text-center">
            <h2>Contáctanos</h2>
            <p class="text-muted">¿Tienes una idea o diseño en mente? Escríbenos y te ayudamos a hacerla realidad.</p>
            <div class="mt-4">
                <a href="https://wa.me/50377777777" target="_blank" class="btn btn-mostaza me-2"><i
                        class="fab fa-whatsapp"></i> WhatsApp</a>
                <a href="mailto:bordados@cyabordados.com" class="btn btn-outline-mostaza"><i
                        class="fa-solid fa-envelope"></i> Correo</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="https://wa.me/50377777777"><i class="fab fa-whatsapp"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
            <p>© 2025 CYA Bordados | Hecho con dedicación en El Salvador</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>

</html>
