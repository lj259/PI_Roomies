@extends('layouts.plantilla_propietarios')
@section('titulo', 'Solicitudes')
@section('Contenido')

    <link rel="stylesheet" href="{{asset('css/perfil.css')}}">
    <main class="d-flex flex-column min-vh-100">
        <div class="container mt-4">
            <div class="row">
                <!-- Lista de Usuarios con Solicitudes -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="fas fa-users"></i> Solicitudes Pendientes</h5>
                        </div>
                        <div class="card-body p-0">
                            @if($usuarios && $usuarios->count() > 0)
                                <div class="usuarios-lista">
                                    @foreach($usuarios as $usuario)
                                        <div class="usuario-item p-3 border-bottom" data-usuario-id="{{ $usuario->id }}"
                                            style="cursor: pointer;">
                                            <div class="d-flex align-items-center">
                                                @if($usuario->foto_perfil && $usuario->foto_perfil !== 'perfil/default.jpg')
                                                    <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Foto de perfil"
                                                        class="rounded-circle me-3" width="45" height="45">
                                                @else
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3"
                                                        style="width: 45px; height: 45px;">
                                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }}</h6>
                                                    <small class="text-muted">
                                                        @if($solicitudes->where('usuario_id', $usuario->id)->first())
                                                            Apartamento:
                                                            {{ $solicitudes->where('usuario_id', $usuario->id)->first()->apartamento->titulo }}
                                                        @endif
                                                    </small>
                                                </div>
                                                <i class="fas fa-chevron-right text-muted"></i> <!-- Added this line -->
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-4 text-center">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay solicitudes pendientes.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Área de Chat -->
                <div class="col-md-8">
                    <div class="card chat-area">
                        <div id="chat-placeholder" class="card-body text-center py-5">
                            <i class="fas fa-comments fa-4x text-muted mb-3"></i>
                            <h4 class="text-muted">Chat de Solicitudes</h4>
                            <p class="text-muted">Selecciona una solicitud para comenzar a chatear</p>
                        </div>

                        <div id="chat-content" style="display: none;">
                            <div class="card-header d-flex align-items-center">
                                <div id="chat-usuario-info" class="d-flex align-items-center flex-grow-1">
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

        <!-- Agregar los scripts necesarios -->
        <script>
            let chatActivo = null;
            let intervaloMensajes = null;
            let ultimoMensajeId = null;

            document.addEventListener('DOMContentLoaded', function () {
                const usuarioItems = document.querySelectorAll('.usuario-item');

                usuarioItems.forEach(item => {
                    item.addEventListener('click', function () {
                        usuarioItems.forEach(i => i.classList.remove('activo'));
                        this.classList.add('activo');

                        const usuarioId = this.getAttribute('data-usuario-id');
                        abrirChat(usuarioId);
                    });
                });

                const formEnviarMensaje = document.getElementById('form-enviar-mensaje');
                if (formEnviarMensaje) {
                    formEnviarMensaje.addEventListener('submit', function (e) {
                        e.preventDefault();
                        enviarMensaje();
                    });
                }
            });

            function mostrarChat(usuario) {
                document.getElementById('chat-placeholder').style.display = 'none';
                document.getElementById('chat-content').style.display = 'block';
                document.getElementById('receptor-id').value = usuario.id;

                const usuarioInfo = document.getElementById('chat-usuario-info');
                let fotoHtml = '';

                if (usuario.foto_perfil && usuario.foto_perfil !== 'perfil/default.jpg') {
                    fotoHtml = `<img src="/storage/${usuario.foto_perfil}" alt="Foto de perfil" class="rounded-circle me-2" width="35" height="35">`;
                } else {
                    fotoHtml = `<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">${usuario.nombre.charAt(0).toUpperCase()}</div>`;
                }

                usuarioInfo.innerHTML = `
                ${fotoHtml}
                <div>
                    <h6 class="mb-0">${usuario.nombre} ${usuario.apellido_paterno}</h6>
                    <small class="text-muted">${usuario.correo}</small>
                </div>
            `;
            }

            function abrirChat(usuarioId) {
                if (chatActivo === usuarioId) return;

                chatActivo = usuarioId;
                ultimoMensajeId = null;

                if (intervaloMensajes) {
                    clearInterval(intervaloMensajes);
                }

                fetch(`/chat/usuario/${usuarioId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mostrarChat(data.usuario);
                            cargarMensajes(usuarioId);

                            intervaloMensajes = setInterval(() => {
                                if (!window.estaEscribiendo()) {
                                    cargarMensajesSinInterruption(usuarioId);
                                }
                            }, 8000);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function mostrarMensajes(mensajes, permitirScroll = true) {
                const container = document.getElementById('mensajes-container');
                const estabaAlFinal = container.scrollTop + container.clientHeight >= container.scrollHeight - 10;
                const scrollAnterior = container.scrollTop;

                container.innerHTML = '';

                mensajes.forEach(mensaje => {
                    const esMio = mensaje.es_propietario; // Changed this line to check es_propietario flag
                    const messageDiv = document.createElement('div');
                    messageDiv.className = `mb-3 d-flex ${esMio ? 'justify-content-end' : 'justify-content-start'}`;

                    messageDiv.innerHTML = `
                        <div class="mensaje ${esMio ? 'mensaje-propio' : 'mensaje-usuario'}" style="max-width: 70%;">
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

                if (permitirScroll && estabaAlFinal) {
                    container.scrollTop = container.scrollHeight;
                } else if (!permitirScroll && !estabaAlFinal) {
                    container.scrollTop = scrollAnterior;
                }
            }

            function cargarMensajes(usuarioId) {
                fetch(`/chat/usuario/mensajes/${usuarioId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            mostrarMensajes(data.mensajes, true);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function cargarMensajesSinInterruption(usuarioId) {
                fetch(`/chat/usuario/mensajes/${usuarioId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.mensajes.length > 0) {
                            const ultimoMensaje = data.mensajes[data.mensajes.length - 1];
                            if (ultimoMensajeId !== ultimoMensaje.id) {
                                mostrarMensajes(data.mensajes, false);
                                ultimoMensajeId = ultimoMensaje.id;
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function cerrarChat() {
                chatActivo = null;
                if (intervaloMensajes) {
                    clearInterval(intervaloMensajes);
                }
                document.getElementById('chat-content').style.display = 'none';
                document.getElementById('chat-placeholder').style.display = 'block';
            }

            function enviarMensaje() {
                const form = document.getElementById('form-enviar-mensaje');
                const formData = new FormData(form);

                fetch('/chat/usuario/enviar', {  // Changed to correct endpoint
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

            window.estaEscribiendo = () => {
                const input = document.getElementById('mensaje-input');
                return input && input.value.length > 0;
            };
        </script>

    </main>

    <style>
        .usuario-item:hover {
            background-color: #f8f9fa;
        }

        .usuario-item.activo {
            background-color: #e3f2fd;
            border-left: 4px solid #2196f3;
        }

        .mensaje-propio .mensaje-contenido {
            background-color: #007bff;
            color: white;
        }

        .mensaje-usuario .mensaje-contenido {
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