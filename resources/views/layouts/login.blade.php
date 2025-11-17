<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | CYA Bordados</title>
    <link rel="shortcut icon" href="{{ asset('cyabordados.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* === Fondo y fuente general === */
        body {
            background: linear-gradient(135deg, #0D3B66, #22223B);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            margin: 0;
        }

        /* === Tarjeta === */
        .card {
            border-radius: 1rem;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.4);
            background-color: #ffffff;
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === Logo circular === */
        .logo-circle {
            width: 85px;
            height: 85px;
            background: #0D3B66;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            box-shadow: 0px 4px 12px rgba(13, 59, 102, 0.5);
        }

        .logo-circle img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
        }

        /* === Botones === */
        .btn-primary {
            background-color: #FAA916;
            border: none;
            color: #0D3B66;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ffc23d;
            transform: scale(1.03);
        }

        /* === Textos === */
        .text-dark {
            color: #0D3B66 !important;
        }

        .text-muted {
            color: #555 !important;
        }

        a {
            text-decoration: none;
            color: #0D3B66;
            font-weight: 500;
        }

        a:hover {
            color: #FAA916;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10">
                <div class="card border-0 shadow-lg p-4">
                    <div class="card-body p-4">

                        <!-- Logo -->
                        <div class="logo-circle">
                            <img src="{{ asset('faviconEdunotas.ico') }}" alt="Logo">
                        </div>

                        <!-- Título -->
                        <div class="text-center mb-4">
                            <h1 class="h4 text-dark fw-bold">CYA Bordados</h1>
                            <p class="text-muted">Accede con tus credenciales</p>
                        </div>

                        <!-- Errores -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulario -->
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="ejemplo@correo.com" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="********" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-sign-in-alt"></i> Ingresar
                            </button>

                            <div class="text-center mt-3">
                                <a href="{{ route('landing') }}"><i class="fas fa-arrow-left"></i> Regresar al
                                    inicio</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
