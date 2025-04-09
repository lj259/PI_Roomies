<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title ?? 'Chat' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="chat-messages" style="height: 300px; overflow-y: auto;">
                    <!-- Aquí se mostrarán los mensajes -->
                </div>
                <div class="input-group mt-3">
                    <input type="text" id="chat-input" class="form-control" placeholder="Escribe un mensaje...">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="chat-send">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Incluir jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
    let chatMessages = $('#chat-messages');
    let chatInput = $('#chat-input');
    let chatSend = $('#chat-send');
    let userList = $('#user-list');
    let selectedUserId = null;

    // Cargar mensajes del chat
    function loadMessages() {
        if (!selectedUserId) return;  // No carga si no hay usuario seleccionado

        $.ajax({
            url: '/api/chat/mensajes/' + selectedUserId,  // Ruta de la API
            method: 'GET',  // Usamos GET para obtener los mensajes
            success: function(response) {
                if (response.success) {
                    chatMessages.empty();  // Limpiar los mensajes anteriores
                    // Mostrar los nuevos mensajes
                    response.mensajes.forEach(function(message) {
                        chatMessages.append('<p><strong>' + message.emisor.name + ':</strong> ' + message.contenido + '</p>');
                    });
                    chatMessages.scrollTop(chatMessages[0].scrollHeight);  // Hacer scroll al final del chat
                } else {
                    console.error('Error al cargar los mensajes');
                }
            }
        });
    }

    // Cargar la lista de usuarios para el chat
    function loadUsers() {
        $.ajax({
            url: '/api/usuarios',  // Ruta de la API para obtener los usuarios
            success: function(users) {
                userList.empty();  // Limpiar la lista de usuarios
                users.forEach(function(user) {
                    userList.append(`<p class="user-item" data-id="${user.id}">${user.name}</p>`);
                });

                // Cuando el usuario hace click en otro usuario
                $('.user-item').click(function() {
                    selectedUserId = $(this).data('id');
                    loadMessages();  // Cargar los mensajes con el usuario seleccionado
                    $('.user-item').removeClass('active');
                    $(this).addClass('active');
                });
            }
        });
    }

    // Enviar mensaje
    chatSend.click(function() {
        if (!selectedUserId) return;  // No enviar si no hay usuario seleccionado

        $.ajax({
            url: '/api/chat/mensajes/' + selectedUserId,  // Ruta para enviar el mensaje
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Token CSRF de Laravel
            },
            data: JSON.stringify({ contenido: chatInput.val() }),  // Enviar el mensaje
            success: function(response) {
                if (response.success) {
                    chatInput.val('');  // Limpiar el campo de texto
                    loadMessages();  // Recargar los mensajes
                } else {
                    console.error('Error al enviar el mensaje');
                }
            }
        });
    });

    loadUsers();  // Cargar los usuarios al inicio
    setInterval(loadMessages, 5000);  // Recargar mensajes cada 5 segundos
});

</script>

<style>
    .user-item {
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid #eee;
    }

    .user-item.active {
        background-color: #f0f0f0;
    }
</style>
