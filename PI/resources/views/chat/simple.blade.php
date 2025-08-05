@extends('layouts.Plantilla1')

@section('titulo', 'Chat')

@section('Contenido')

    <link rel="stylesheet" href="{{ asset('css/amigos-chat.css') }}">

    <main class="d-flex flex-column min-vh-100">
        <div class="container mt-4">
            <h2><i class="fas fa-comments"></i> Chat</h2>

        <!-- Pestañas de navegación -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('chat.index') ? 'active' : '' }}" href="{{ route('chat.index') }}">
                    <i class="fas fa-user-friends"></i> Amigos
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('chat.propietarios') ? 'active' : '' }}" href="{{ route('chat.propietarios') }}">
                    <i class="fas fa-user-tie"></i> Propietarios
                </a>
            </li>
        </ul>
        <!-- Fin pestañas de navegación -->

        <div class="row"></div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-users"></i> Amigos</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($amigos && $amigos->count() > 0)
                                <div class="amigos-lista">
                                    @foreach($amigos as $amigo)
                                        <div class="amigo-item p-3 border-bottom" data-amigo-id="{{ $amigo->id }}"
                                            style="cursor: pointer;">
                                            <div class="d-flex align-items-center">
                                                @if($amigo->foto_perfil && $amigo->foto_perfil !== 'perfil/default.jpg')
                                                    <img src="{{ asset('storage/' . $amigo->foto_perfil) }}" alt="Foto de perfil"
                                                        class="rounded-circle me-3" width="45" height="45">
                                                @else
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                        style="width: 45px; height: 45px;">
                                                        {{ strtoupper(substr($amigo->nombre, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $amigo->nombre }} {{ $amigo->apellido_paterno }}</h6>
                                                    <small class="text-muted">{{ $amigo->correo }}</small>
                                                </div>
                                                <i class="fas fa-chevron-right text-muted"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-4 text-center">
                                    <i class="fas fa-user-friends fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-3">No tienes amigos para chatear aún.</p>
                                    <a href="{{ route('amigos.index') }}" class="btn btn-primary">
                                        <i class="fas fa-user-plus"></i> Agregar Amigos
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card chat-area">
                        <div id="chat-placeholder" class="card-body text-center py-5">
                            <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Bienvenido al Chat</h4>
                            <p class="text-muted">Selecciona un amigo para comenzar a chatear</p>
                        </div>

                        <div id="chat-content" style="display: none;">
                            <div class="card-header d-flex align-items-center">
                                <div id="chat-amigo-info" class="d-flex align-items-center flex-grow-1">
                                    <!-- Se llenará dinámicamente -->
                                </div>
                                <button class="btn btn-sm btn-outline-secondary" onclick="cerrarChat()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="card-body p-0">
                                <div id="mensajes-container" style="height: 400px; overflow-y: auto; padding: 15px;">
                                    <!-- Los mensajes se cargarán aquí -->
                                </div>
                            </div>

                            <div class="card-footer">
                                <form id="form-enviar-mensaje" class="d-flex">
                                    @csrf
                                    <input type="hidden" id="receptor-id" name="receptor_id">
                                    <input type="text" id="mensaje-input" name="mensaje" class="form-control me-2"
                                        placeholder="Escribe tu mensaje..." required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        let chatActivo = null;
        let intervaloMensajes = null;
        let ultimoMensajeId = null;

        document.addEventListener('DOMContentLoaded', function () {
            // Manejar clicks en amigos
            document.querySelectorAll('.amigo-item').forEach(item => {
                item.addEventListener('click', function () {
                    const amigoId = this.dataset.amigoId;
                    abrirChat(amigoId);
                });
            });

            // Manejar envío de mensajes
            document.getElementById('form-enviar-mensaje').addEventListener('submit', function (e) {
                e.preventDefault();
                enviarMensaje();
            });

            // Verificar si hay un amigo específico en la URL
            const urlParams = new URLSearchParams(window.location.search);
            const amigoId = urlParams.get('amigo');
            if (amigoId) {
                abrirChat(amigoId);
                // Limpiar la URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // Detectar cuando el usuario está escribiendo para pausar las actualizaciones
            const mensajeInput = document.getElementById('mensaje-input');
            let escribiendo = false;
            let tiempoEscribiendo = null;

            mensajeInput.addEventListener('input', function () {
                escribiendo = true;
                clearTimeout(tiempoEscribiendo);
                tiempoEscribiendo = setTimeout(() => {
                    escribiendo = false;
                }, 2000); // Considerar que dejó de escribir después de 2 segundos de inactividad
            });

            // Función para verificar si el usuario está escribiendo
            window.estaEscribiendo = () => escribiendo;
        });

        function abrirChat(amigoId) {
            if (chatActivo === amigoId) return;

            chatActivo = amigoId;
            ultimoMensajeId = null; // Reset al cambiar de chat

            // Limpiar intervalo anterior
            if (intervaloMensajes) {
                clearInterval(intervaloMensajes);
            }

            // Obtener información del amigo
            fetch(`/chat/amigo/${amigoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarChat(data.amigo);
                        cargarMensajes(amigoId);

                        // Actualizar mensajes cada 8 segundos, pero solo si no está escribiendo
                        intervaloMensajes = setInterval(() => {
                            if (!window.estaEscribiendo()) {
                                cargarMensajesSinInterruption(amigoId);
                            }
                        }, 8000);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function mostrarChat(amigo) {
            document.getElementById('chat-placeholder').style.display = 'none';
            document.getElementById('chat-content').style.display = 'block';
            document.getElementById('receptor-id').value = amigo.id;

            // Mostrar información del amigo en el header
            const amigoInfo = document.getElementById('chat-amigo-info');
            let fotoHtml = '';

            if (amigo.foto_perfil && amigo.foto_perfil !== 'perfil/default.jpg') {
                fotoHtml = `<img src="/storage/${amigo.foto_perfil}" alt="Foto de perfil" class="rounded-circle me-2" width="35" height="35">`;
            } else {
                fotoHtml = `<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">${amigo.nombre.charAt(0).toUpperCase()}</div>`;
            }

            amigoInfo.innerHTML = `
            ${fotoHtml}
            <div>
                <h6 class="mb-0">${amigo.nombre} ${amigo.apellido_paterno}</h6>
                <small class="text-muted">${amigo.correo}</small>
            </div>
        `;
        }

        function cargarMensajes(amigoId) {
            fetch(`/chat/mensajes/${amigoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarMensajes(data.mensajes, true); // true = permite scroll automático
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Nueva función para cargar mensajes sin interrumpir la experiencia del usuario
        function cargarMensajesSinInterruption(amigoId) {
            fetch(`/chat/mensajes/${amigoId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Solo actualizar si hay mensajes nuevos
                        if (data.mensajes.length > 0) {
                            const ultimoMensaje = data.mensajes[data.mensajes.length - 1];
                            if (ultimoMensajeId !== ultimoMensaje.id) {
                                mostrarMensajes(data.mensajes, false); // false = no forzar scroll
                                ultimoMensajeId = ultimoMensaje.id;
                            }
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function mostrarMensajes(mensajes, permitirScroll = true) {
            const container = document.getElementById('mensajes-container');
            const estabaAlFinal = container.scrollTop + container.clientHeight >= container.scrollHeight - 10;

            // Guardar la posición actual del scroll si el usuario no está al final
            const scrollAnterior = container.scrollTop;

            container.innerHTML = '';

            mensajes.forEach(mensaje => {
                const esMio = mensaje.es_mio;
                const messageDiv = document.createElement('div');
                messageDiv.className = `mb-3 d-flex ${esMio ? 'justify-content-end' : 'justify-content-start'}`;

                messageDiv.innerHTML = `
                <div class="mensaje ${esMio ? 'mensaje-propio' : 'mensaje-amigo'}" style="max-width: 70%;">
                    <div class="mensaje-contenido p-2 rounded">
                        ${mensaje.contenido}
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                        ${new Date(mensaje.created_at).toLocaleString()}
                    </small>
                </div>
            `;

                container.appendChild(messageDiv);
            });

            // Solo hacer scroll automático si:
            // 1. Se permite el scroll (primera carga o envío de mensaje)
            // 2. El usuario estaba al final antes de la actualización
            if (permitirScroll && estabaAlFinal) {
                container.scrollTop = container.scrollHeight;
            } else if (!permitirScroll && !estabaAlFinal) {
                // Mantener la posición anterior si no estaba al final
                container.scrollTop = scrollAnterior;
            }

            // Actualizar el ID del último mensaje
            if (mensajes.length > 0) {
                ultimoMensajeId = mensajes[mensajes.length - 1].id;
            }
        }

        function enviarMensaje() {
            const form = document.getElementById('form-enviar-mensaje');
            const formData = new FormData(form);

            fetch('/chat/enviar', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('mensaje-input').value = '';
                        // Cargar mensajes inmediatamente después de enviar
                        cargarMensajes(chatActivo);
                    } else {
                        alert('Error al enviar mensaje: ' + (data.error || 'Error desconocido'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error de conexión al enviar mensaje');
                });
        }

        function cerrarChat() {
            chatActivo = null;

            if (intervaloMensajes) {
                clearInterval(intervaloMensajes);
                intervaloMensajes = null;
            }

            document.getElementById('chat-content').style.display = 'none';
            document.getElementById('chat-placeholder').style.display = 'block';
            document.getElementById('mensaje-input').value = '';
        }
    </script>

    <style>
        .amigo-item:hover {
            background-color: #f8f9fa;
        }

        .amigo-item.activo {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }

        .mensaje-propio .mensaje-contenido {
            background-color: #007bff;
            color: white;
        }

        .mensaje-amigo .mensaje-contenido {
            background-color: #f1f3f4;
            color: #333;
        }

        .chat-area {
            height: 600px;
        }

        #mensajes-container::-webkit-scrollbar {
            width: 6px;
        }

        #mensajes-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #mensajes-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        #mensajes-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>

@endsection