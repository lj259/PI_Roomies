@extends('layouts.Plantilla1')
@section('titulo', 'Búsqueda')
@section('Contenido')

    <style>
        .search-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        
        .search-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: none;
        }
        
        .search-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2.2rem;
            margin: 0;
            text-align: center;
        }
        
        .option-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 25px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            border: 3px solid transparent;
            position: relative;
            overflow: hidden;
        }
        
        .option-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%);
            z-index: 1;
        }
        
        .option-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }
        
        .option-card.female {
            /* Removed border-image for cleaner look */
        }
        
        .option-card.female:hover {
            /* Removed border-image for cleaner look */
        }
        
        .option-card.male {
            /* Removed border-image for cleaner look */
        }
        
        .option-card.male:hover {
            /* Removed border-image for cleaner look */
        }
        
        .option-card.mixed {
            /* Removed border-image for cleaner look */
        }
        
        .option-card.mixed:hover {
            /* Removed border-image for cleaner look */
        }
        
        .avatar-container {
            position: relative;
            margin-bottom: 1.5rem;
            z-index: 2;
        }
        
        .avatar-circle {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .avatar-circle.female {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
        }
        
        .avatar-circle.male {
            background: linear-gradient(135deg, #4ecdc4, #2196f3);
        }
        
        .avatar-circle.mixed {
            background: linear-gradient(135deg, #4caf50, #8bc34a);
        }
        
        .avatar-circle:hover {
            transform: rotate(5deg) scale(1.1);
        }
        
        .avatar-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: contain;
            transition: all 0.3s ease;
        }
        
        .option-description {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            z-index: 2;
            position: relative;
        }
        
        .search-btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 3px solid;
            position: relative;
            z-index: 2;
            text-decoration: none;
            display: inline-block;
        }
        
        .search-btn.female {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border-color: #ff6b6b;
            color: white;
        }
        
        .search-btn.female:hover {
            background: linear-gradient(135deg, #ff5252, #c62828);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .search-btn.male {
            background: linear-gradient(135deg, #4ecdc4, #2196f3);
            border-color: #4ecdc4;
            color: white;
        }
        
        .search-btn.male:hover {
            background: linear-gradient(135deg, #2196f3, #1976d2);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(33, 150, 243, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .search-btn.mixed {
            background: linear-gradient(135deg, #4caf50, #8bc34a);
            border-color: #4caf50;
            color: white;
        }
        
        .search-btn.mixed:hover {
            background: linear-gradient(135deg, #388e3c, #689f38);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(76, 175, 80, 0.4);
            color: white;
            text-decoration: none;
        }
        
        .gender-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            opacity: 0.8;
        }
        
        .row-enhanced {
            margin-bottom: 3rem;
        }
        
        @media (max-width: 768px) {
            .search-title {
                font-size: 1.8rem;
            }
            
            .avatar-circle {
                width: 150px;
                height: 150px;
            }
            
            .avatar-img {
                width: 90px;
                height: 90px;
            }
            
            .option-card {
                margin-bottom: 2rem;
            }
        }
    </style>

    <div class="search-container">
        <div class="container">
            <!-- Header Section -->
            <div class="search-header">
                <h2 class="search-title">
                    <i class="fas fa-home mr-3"></i>
                    ¿Con quién buscas compartir tu espacio?
                </h2>
                <p class="text-center mt-3 mb-0 text-muted" style="font-size: 1.1rem;">
                    Encuentra el compañero ideal para tu 
                </p>
            </div>

            <!-- Search Options -->
            <div class="row justify-content-center">
                
                <!-- Female Option -->
                @if (Auth::user()->genero === "femenino" || Auth::user()->genero === "masculino")
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="option-card female text-center">
                        <div class="avatar-container">
                            <div class="gender-icon text-center">
                                <i class="fas fa-venus" style="color: #ff6b6b;"></i>
                            </div>
                            <div class="avatar-circle female">
                                <img src="{{ asset('images/Poli1.png') }}" alt="Mujeres" class="avatar-img">
                            </div>
                        </div>
                        <h4 class="font-weight-bold mb-3" style="color: #ff6b6b;">
                            <i class="fas fa-female mr-2"></i>Solo Mujeres
                        </h4>
                        <p class="option-description">
                            Encuentra compañeras de cuarto ideales. Comparte experiencias únicas y crea lazos duraderos en un ambiente seguro y cómodo.
                        </p>
                        <a href="{{route('RutaResultados',['publico' => 'femenino'])}}" class="search-btn female">
                            <i class="fas fa-search mr-2"></i>Buscar Compañeras
                        </a>
                    </div>
                </div>
                @endif

                <!-- Male Option -->
                @if (Auth::user()->genero === "masculino" || Auth::user()->genero === "femenino")
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="option-card male text-center">
                        <div class="avatar-container">
                            <div class="gender-icon text-center">
                                <i class="fas fa-mars" style="color: #2196f3;"></i>
                            </div>
                            <div class="avatar-circle male">
                                <img src="{{ asset('images/Polo1.png') }}" alt="Hombres" class="avatar-img">
                            </div>
                        </div>
                        <h4 class="font-weight-bold mb-3" style="color: #2196f3;">
                            <i class="fas fa-male mr-2"></i>Solo Hombres
                        </h4>
                        <p class="option-description">
                            Busca compañeros con quienes compartir tu espacio. Encuentra personas con intereses similares y vive una experiencia increíble.
                        </p>
                        <a href="{{ route('RutaResultados',['publico' => 'masculino']) }}" class="search-btn male">
                            <i class="fas fa-search mr-2"></i>Buscar Compañeros
                        </a>
                    </div>
                </div>
                @endif

                <!-- Mixed Option -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="option-card mixed text-center">
                        <div class="avatar-container">
                            <div class="gender-icon text-center">
                                <i class="fas fa-users" style="color: #4caf50;"></i>
                            </div>
                            <div class="avatar-circle mixed">
                                <img src="{{ asset('images/Polo-Poli.png') }}" alt="Mixto" class="avatar-img">
                            </div>
                        </div>
                        <h4 class="font-weight-bold mb-3" style="color: #4caf50;">
                            <i class="fas fa-users mr-2"></i>Grupo Mixto
                        </h4>
                        <p class="option-description">
                            Abierto a todas las posibilidades. Conoce personas diversas y enriquece tu experiencia con diferentes perspectivas y culturas.
                        </p>
                        <a href="{{route('RutaResultados',['publico' => 'otro'])}}" class="search-btn mixed">
                            <i class="fas fa-search mr-2"></i>Buscar Mixto
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Additional Info Section -->
            <div class="row justify-content-center mt-5">
                <div class="col-md-10">
                    <div class="text-center p-4" style="background: rgba(255,255,255,0.9); border-radius: 20px;">
                        <h5 class="mb-3" style="color: #667eea;">
                            <i class="fas fa-lightbulb mr-2"></i>¿Por qué elegir PI Roomies?
                        </h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-shield-alt fa-2x mb-2" style="color: #4caf50;"></i>
                                <p class="mb-0"><strong>Seguridad</strong><br>Perfiles verificados</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-heart fa-2x mb-2" style="color: #ff6b6b;"></i>
                                <p class="mb-0"><strong>Compatibilidad</strong><br>Encuentra tu match perfecto</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="fas fa-home fa-2x mb-2" style="color: #2196f3;"></i>
                                <p class="mb-0"><strong>Comodidad</strong><br>Tu hogar ideal te espera</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection