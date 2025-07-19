@extends('layouts.Plantilla1')
@section('titulo', 'Resultados de Búsqueda')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/resultados.css')}}">
    <main class="min-vh-100" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
        <!-- Título de la Página -->
        <div class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1 class="hero-title">
                        <i class="fas fa-search me-3"></i>
                        RESULTADOS DE BÚSQUEDA
                    </h1>
                    <p class="hero-subtitle">Descubre tu hogar ideal entre estos increíbles departamentos</p>
                    <div class="hero-stats">
                        <span class="stat-item">
                            <i class="fas fa-home"></i>
                            <span id="results-count">{{ count($apartamentos) }}</span> Departamentos Encontrados
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <!-- Error Display -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <!-- Sidebar de Filtros -->
                <div class="col-lg-3 col-md-4 mb-4">
                    <div class="filter-sidebar">
                        <div class="filter-header">
                            <h4><i class="fas fa-filter me-2"></i>Filtros</h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('RutaResultados') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-list"></i> Ver Todos
                                </a>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="clear-filters">
                                    <i class="fas fa-times"></i> Limpiar
                                </button>
                            </div>
                        </div>

                        <!-- Current Filters Display -->
                        @if(request()->hasAny(['publico', 'precio_min', 'precio_max', 'habitaciones', 'servicios', 'ubicacion']))
                        <div class="current-filters mb-3">
                            <h6 class="text-muted mb-2"><i class="fas fa-tags me-1"></i>Filtros Activos:</h6>
                            <div class="filter-tags">
                                @if(request('publico'))
                                    <span class="filter-tag">
                                        Género: {{ ucfirst(request('publico')) }}
                                        <a href="{{ route('RutaResultados', array_merge(request()->except('publico'))) }}" class="remove-filter">×</a>
                                    </span>
                                @endif
                                @if(request('precio_min') || request('precio_max'))
                                    <span class="filter-tag">
                                        Precio: ${{ request('precio_min', '0') }} - ${{ request('precio_max', '∞') }}
                                        <a href="{{ route('RutaResultados', array_merge(request()->except(['precio_min', 'precio_max']))) }}" class="remove-filter">×</a>
                                    </span>
                                @endif
                                @if(request('habitaciones'))
                                    <span class="filter-tag">
                                        Habitaciones: {{ request('habitaciones') }}+
                                        <a href="{{ route('RutaResultados', array_merge(request()->except('habitaciones'))) }}" class="remove-filter">×</a>
                                    </span>
                                @endif
                                @if(request('ubicacion'))
                                    <span class="filter-tag">
                                        Ubicación: {{ request('ubicacion') }}
                                        <a href="{{ route('RutaResultados', array_merge(request()->except('ubicacion'))) }}" class="remove-filter">×</a>
                                    </span>
                                @endif
                                @if(request('servicios'))
                                    <span class="filter-tag">
                                        Servicios: {{ count(request('servicios')) }} seleccionados
                                        <a href="{{ route('RutaResultados', array_merge(request()->except('servicios'))) }}" class="remove-filter">×</a>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <form id="filter-form" method="GET" action="{{ route('RutaResultados') }}">
                            <!-- Filtro de Género -->
                            <div class="filter-group">
                                <h6 class="filter-title">
                                    <i class="fas fa-users me-2"></i>Disponible Para
                                </h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publico" value="" id="publico_all"
                                           {{ request('publico') == '' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publico_all">Todos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publico" value="masculino" id="publico_masculino"
                                           {{ request('publico') == 'masculino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publico_masculino">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publico" value="femenino" id="publico_femenino"
                                           {{ request('publico') == 'femenino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publico_femenino">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publico" value="otro" id="publico_otro"
                                           {{ request('publico') == 'otro' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="publico_otro">Mixto</label>
                                </div>
                            </div>

                            <!-- Filtro de Precio -->
                            <div class="filter-group">
                                <h6 class="filter-title">
                                    <i class="fas fa-dollar-sign me-2"></i>Rango de Precio
                                    </h6>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" 
                                               name="precio_min" placeholder="Mín" 
                                               value="{{ request('precio_min') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control form-control-sm" 
                                               name="precio_max" placeholder="Máx" 
                                               value="{{ request('precio_max') }}">
                                    </div>
                                </div>
                                <small class="text-muted">Precio en MXN por mes</small>
                            </div>

                            <!-- Filtro de Habitaciones -->
                            <div class="filter-group">
                                <h6 class="filter-title">
                                    <i class="fas fa-bed me-2"></i>Habitaciones Mínimas
                                </h6>
                                <select class="form-select form-select-sm" name="habitaciones">
                                    <option value="">Cualquier cantidad</option>
                                    <option value="1" {{ request('habitaciones') == '1' ? 'selected' : '' }}>1+</option>
                                    <option value="2" {{ request('habitaciones') == '2' ? 'selected' : '' }}>2+</option>
                                    <option value="3" {{ request('habitaciones') == '3' ? 'selected' : '' }}>3+</option>
                                    <option value="4" {{ request('habitaciones') == '4' ? 'selected' : '' }}>4+</option>
                                </select>
                            </div>

                            <!-- Filtro de Servicios -->
                            <div class="filter-group">
                                <h6 class="filter-title">
                                    <i class="fas fa-check-circle me-2"></i>Servicios
                                </h6>
                                @if(isset($serviciosDisponibles) && $serviciosDisponibles->count() > 0)
                                    @foreach($serviciosDisponibles as $servicio)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               name="servicios[]" value="{{ $servicio }}" 
                                               id="servicio_{{ $loop->index }}"
                                               {{ in_array($servicio, request('servicios', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="servicio_{{ $loop->index }}">
                                            {{ $servicio }}
                                        </label>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="text-muted">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            No hay servicios disponibles para filtrar
                                        </small>
                                    </div>
                                @endif
                            </div>

                            <!-- Filtro de Ubicación -->
                            <div class="filter-group">
                                <h6 class="filter-title">
                                    <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                                </h6>
                                <div class="location-input-wrapper">
                                    <input type="text" class="form-control form-control-sm" 
                                           name="ubicacion" placeholder="Buscar por dirección..." 
                                           value="{{ request('ubicacion') }}">
                                    <span class="keyboard-hint">Ctrl+K</span>
                                </div>
                            </div>

                            <!-- Ordenamiento -->
                            <div class="filter-group">
                                <h6 class="filter-title">
                                    <i class="fas fa-sort me-2"></i>Ordenar Por
                                </h6>
                                <select class="form-select form-select-sm" name="ordenar">
                                    <option value="precio_asc" {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}>
                                        Precio: Menor a Mayor
                                    </option>
                                    <option value="precio_desc" {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}>
                                        Precio: Mayor a Menor
                                    </option>
                                    <option value="habitaciones_asc" {{ request('ordenar') == 'habitaciones_asc' ? 'selected' : '' }}>
                                        Habitaciones: Menos a Más
                                    </option>
                                    <option value="habitaciones_desc" {{ request('ordenar') == 'habitaciones_desc' ? 'selected' : '' }}>
                                        Habitaciones: Más a Menos
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">
                                <i class="fas fa-search me-2"></i>Aplicar Filtros
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Resultados -->
                <div class="col-lg-9 col-md-8">
                    <div class="row justify-content-center" id="results-container">
                        @foreach($apartamentos as $depa)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="apartment-card">
                                <div class="card-image-container">
                                    <img src="{{ asset('images/departamento2.jpeg') }}" alt="Departamento" class="card-image">
                                    <div class="card-overlay">
                                        <div class="price-badge">
                                            ${{ number_format($depa->precio) }} MXN/mes
                                        </div>
                                    </div>
                                </div>

                                <div class="card-content">
                                    @php
                                        // Buscar el nombre del propietario usando el ID del propietario
                                        $propietario = $propietarios->where('id', $depa->propietario_id)->first();
                                    @endphp

                                    <div class="card-header">
                                        <h5 class="card-title">
                                            <i class="fas fa-building me-2"></i>
                                            {{ $depa->titulo }}
                                        </h5>
                                        <div class="owner-info">
                                            <i class="fas fa-user-circle me-2"></i>
                                            <span>{{ $propietario ? $propietario->nombre : 'Desconocido' }}</span>
                                        </div>
                                    </div>

                                    <div class="card-details">
                                        <div class="detail-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $depa->direccion }}</span>
                                        </div>
                                        
                                        <div class="detail-item">
                                            <i class="fas fa-bed"></i>
                                            <span>{{ $depa->habitaciones_disponibles }} Habitaciones</span>
                                        </div>

                                        <div class="detail-item">
                                            <i class="fas fa-users"></i>
                                            <span>Disponible para: 
                                                @switch($depa->disponible_para)
                                                    @case('masculino')
                                                        <span class="badge bg-primary">Masculino</span>
                                                        @break
                                                    @case('femenino')
                                                        <span class="badge bg-danger">Femenino</span>
                                                        @break
                                                    @case('otro')
                                                        <span class="badge bg-success">Mixto</span>
                                                        @break
                                                @endswitch
                                            </span>
                                        </div>
                                    </div>

                                    <div class="services-section">
                                        <h6 class="services-title">
                                            <i class="fas fa-star me-2"></i>
                                            Servicios Incluidos y Cercanias
                                        </h6>
                                        @php
                                            // Verificar si servicios es un string JSON y decodificarlo si es necesario
                                            $servicios = is_string($depa->servicios) ? json_decode($depa->servicios, true) : $depa->servicios;
                                        @endphp

                                        @if(is_array($servicios) && count($servicios) > 0) 
                                            <div class="services-grid">
                                                @foreach ($servicios as $servicio)
                                                    <div class="service-item">
                                                        <i class="fas fa-check-circle me-2"></i>
                                                        <span>{{ $servicio }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="no-services">
                                                <i class="fas fa-info-circle me-2"></i>
                                                <span>No hay servicios especificados</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="card-footer">
                                        <a href="{{ route('RutaDetalles', ['id' => $depa->id, 'propietario_id' => $depa->propietario_id]) }}"
                                            class="contact-btn">
                                            <i class="fas fa-phone me-2"></i>
                                            Mas Información
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>                 
                        @endforeach

                        @if(count($apartamentos) === 0)
                            <div class="col-12">
                                <div class="no-results">
                                    <i class="fas fa-home fa-3x mb-3"></i>
                                    <h4>No se encontraron departamentos</h4>
                                    <p>Intenta ajustar tus criterios de búsqueda para encontrar más opciones.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- JavaScript para funcionalidad de filtros -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filter-form');
            const clearFiltersBtn = document.getElementById('clear-filters');
            const resultsCount = document.getElementById('results-count');

            // Auto-submit form when filters change
            filterForm.addEventListener('change', function(e) {
                // Add a small delay to prevent too many rapid submissions
                clearTimeout(this.submitTimeout);
                this.submitTimeout = setTimeout(() => {
                    this.submit();
                }, 300);
            });

            // Handle input fields with debounce
            const textInputs = filterForm.querySelectorAll('input[type="text"], input[type="number"]');
            textInputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(this.debounceTimeout);
                    this.debounceTimeout = setTimeout(() => {
                        filterForm.submit();
                    }, 800);
                });
            });

            // Clear all filters
            clearFiltersBtn.addEventListener('click', function() {
                // Reset form
                filterForm.reset();
                
                // Uncheck all radio buttons
                const radios = filterForm.querySelectorAll('input[type="radio"]');
                radios.forEach(radio => radio.checked = false);
                
                // Check the "all" option for publico
                const publicoAll = document.getElementById('publico_all');
                if (publicoAll) {
                    publicoAll.checked = true;
                }
                
                // Submit form
                filterForm.submit();
            });

            // Input validation for price fields
            const priceInputs = filterForm.querySelectorAll('input[type="number"]');
            priceInputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.value < 0) {
                        this.value = 0;
                    }
                    
                    // Validate price range
                    if (this.name === 'precio_min') {
                        const maxInput = filterForm.querySelector('input[name="precio_max"]');
                        if (maxInput.value && parseInt(this.value) > parseInt(maxInput.value)) {
                            this.style.borderColor = '#dc3545';
                            this.title = 'El precio mínimo no puede ser mayor al máximo';
                        } else {
                            this.style.borderColor = '';
                            this.title = '';
                        }
                    }
                    
                    if (this.name === 'precio_max') {
                        const minInput = filterForm.querySelector('input[name="precio_min"]');
                        if (minInput.value && parseInt(this.value) < parseInt(minInput.value)) {
                            this.style.borderColor = '#dc3545';
                            this.title = 'El precio máximo no puede ser menor al mínimo';
                        } else {
                            this.style.borderColor = '';
                            this.title = '';
                        }
                    }
                });
            });

            // Add loading state
            filterForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Aplicando Filtros...';
                    submitBtn.disabled = true;
                }
            });

            // Add animation to filter cards
            function animateResults() {
                const cards = document.querySelectorAll('.apartment-card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = `${index * 0.1}s`;
                    card.classList.add('fade-in-up');
                });
            }

            // Call animation on page load
            animateResults();

            // Smooth scroll to results when filters change
            function scrollToResults() {
                const resultsContainer = document.getElementById('results-container');
                if (resultsContainer && window.innerWidth > 768) {
                    resultsContainer.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }
            }

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + K to focus on location search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    const locationInput = document.querySelector('input[name="ubicacion"]');
                    if (locationInput) {
                        locationInput.focus();
                    }
                }
                
                // Escape to clear filters
                if (e.key === 'Escape') {
                    clearFiltersBtn.click();
                }
            });
        });
    </script>

    <style>
        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        /* Loading state */
        .filter-loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Enhanced hover effects */
        .filter-sidebar .form-check-label:hover {
            color: #667eea;
        }

        .filter-sidebar .form-control:hover,
        .filter-sidebar .form-select:hover {
            border-color: #667eea;
        }

        /* Keyboard shortcut hint */
        .location-input-wrapper {
            position: relative;
        }

        .keyboard-hint {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            color: #6c757d;
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #e9ecef;
        }
    </style>

@endsection
