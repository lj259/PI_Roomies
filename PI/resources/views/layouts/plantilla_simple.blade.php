<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PI Roomies Application">
    <title>@yield('titulo') | PI Roomies</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Styles -->
    @vite(['resources\js\app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/css/themes/default.min.css" />
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #1a56db;
            --light-blue: #e1effe;
            --primary-red: #dc2626;
            --light-red: #fee2e2;
            --white: #ffffff;
            --light-gray: #f8fafc;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--light-gray);
        }
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-blue) !important;
        }
        .navbar {
            background-color: var(--white) !important;
            border-bottom: 3px solid var(--primary-blue);
        }
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        .btn-danger {
            background-color: var(--primary-red);
            border-color: var(--primary-red);
        }
        a {
            color: var(--primary-blue);
        }
        a:hover {
            color: var(--primary-red);
        }
        .card {
            border-top: 3px solid var(--primary-blue);
        }
        .footer {
            background-color: var(--primary-blue);
            color: var(--white);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('RutaInicio') }}">PI Roomies</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>   
            <div class="collapse navbar-collapse" id="navbarNav">
                @yield('navbar-content')
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content container">
        @yield('Contenido')
    </div>
    
    <!-- Footer -->
    <x-footer />

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
    
    <!-- Flash Messages -->
    @session('Exito')
        <script>
            Swal.fire({
                title: "Success",
                text: "{{$value}}",
                icon: "success",
                confirmButtonColor: '#4CAF50'
            });
        </script>
    @endsession
    
    @session('Fallo')
        <script>
            Swal.fire({
                title: "Error",
                text: "{{$value}}",
                icon: "error",
                confirmButtonColor: '#F44336'
            });
        </script>
    @endsession
</body>

</html>