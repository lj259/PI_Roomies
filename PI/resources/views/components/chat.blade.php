<head>
    <title>Chat en Vivo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
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
<div class="modal fade" id="{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $id }}Label">{{ $title ?? 'Chat' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div id="user-list" style="height: 400px; overflow-y: auto;">
                            </div>
                    </div>
                    <div class="col-md-8">
                        <div id="chat-messages" style="height: 300px; overflow-y: auto;">
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
    </div>
</div>

<script>
    $(document).ready(function() {
        let chatMessages = $('#chat-messages');
        let chatInput = $('#chat-input');
        let chatSend = $('#chat-send');
        let userList = $('#user-list');
        let selectedUserId = null;

        function loadMessages() {
            if (!selectedUserId) return; // No carga mensajes si no hay usuario seleccionado

            $.ajax({
                url: '/api/chat/messages/' + selectedUserId, // Modifica la ruta
                success: function(response) {
                    if (response.success) {
                        chatMessages.empty();
                        response.messages.forEach(function(message) {
                            chatMessages.append('<p><strong>' + message.user.name + ':</strong> ' + message.message + '</p>');
                        });
                        chatMessages.scrollTop(chatMessages[0].scrollHeight);
                    } else {
                        console.error('Error loading messages');
                    }
                }
            });
        }

        function loadUsers() {
            $.ajax({
                url: '/api/users', // Nueva ruta para obtener usuarios
                success: function(users) {
                    userList.empty();
                    users.forEach(function(user) {
                        userList.append(`<p class="user-item" data-id="${user.id}">${user.name}</p>`);
                    });

                    $('.user-item').click(function() {
                        selectedUserId = $(this).data('id');
                        loadMessages();
                        $('.user-item').removeClass('active');
                        $(this).addClass('active');
                    });
                }
            });
        }

        loadUsers();
        setInterval(loadMessages, 5000);

        chatSend.click(function() {
            if (!selectedUserId) return; // No envía mensajes si no hay usuario seleccionado

            $.ajax({
                url: '/api/chat/messages/' + selectedUserId, // Modifica la ruta
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: JSON.stringify({ message: chatInput.val() }),
                success: function(response) {
                    if (response.success) {
                        chatInput.val('');
                        loadMessages();
                    } else {
                        console.error('Error sending message');
                    }
                }
            });
        });
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