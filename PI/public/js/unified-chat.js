/**
 * Unified Chat Service for Web Application
 * This service provides real-time chat synchronization across all platforms
 */
class UnifiedWebChatService {
    constructor() {
        this.baseUrl = '/api/web/v2';
        this.pollingInterval = null;
        this.lastTimestamp = 0;
        this.isPolling = false;
        this.currentChatId = null;
        this.onNewMessagesCallback = null;
    }

    async makeRequest(endpoint, options = {}) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                ...options.headers,
            },
        };

        const requestOptions = { ...defaultOptions, ...options };
        
        try {
            const response = await fetch(`${this.baseUrl}${endpoint}`, requestOptions);
            
            if (response.ok) {
                return await response.json();
            } else {
                throw new Error(`Request failed with status ${response.status}`);
            }
        } catch (error) {
            console.error('API request failed:', error);
            throw error;
        }
    }

    /**
     * Get all active chats
     */
    async getActiveChats() {
        try {
            const response = await this.makeRequest('/chats');
            return response.success ? response.chats : [];
        } catch (error) {
            console.error('Error getting active chats:', error);
            return [];
        }
    }

    /**
     * Get conversation messages
     */
    async getConversation(userId) {
        try {
            const response = await this.makeRequest(`/chats/${userId}/messages`);
            return response.success ? response.mensajes : [];
        } catch (error) {
            console.error('Error getting conversation:', error);
            return [];
        }
    }

    /**
     * Send a message
     */
    async sendMessage(userId, contenido) {
        try {
            const response = await this.makeRequest(`/chats/${userId}/messages`, {
                method: 'POST',
                body: JSON.stringify({ contenido })
            });
            return response.success ? response.mensaje : null;
        } catch (error) {
            console.error('Error sending message:', error);
            throw error;
        }
    }

    /**
     * Get new messages since timestamp
     */
    async getMessagesSince(userId, sinceTimestamp) {
        try {
            const response = await this.makeRequest(`/chats/${userId}/messages/since?since=${sinceTimestamp}`);
            return response.success ? response.mensajes : [];
        } catch (error) {
            console.error('Error getting new messages:', error);
            return [];
        }
    }

    /**
     * Mark messages as read
     */
    async markMessagesAsRead(userId, messageIds = null) {
        try {
            const body = messageIds ? { message_ids: messageIds } : {};
            const response = await this.makeRequest(`/chats/${userId}/read`, {
                method: 'PATCH',
                body: JSON.stringify(body)
            });
            return response.success;
        } catch (error) {
            console.error('Error marking messages as read:', error);
            return false;
        }
    }

    /**
     * Get user info
     */
    async getUserInfo(userId) {
        try {
            const response = await this.makeRequest(`/users/${userId}`);
            return response.success ? response.user : null;
        } catch (error) {
            console.error('Error getting user info:', error);
            return null;
        }
    }

    /**
     * Start polling for new messages
     */
    startPolling(chatId, onNewMessages, intervalMs = 3000) {
        this.stopPolling(); // Stop any existing polling
        
        this.currentChatId = chatId;
        this.onNewMessagesCallback = onNewMessages;
        this.isPolling = true;
        this.lastTimestamp = Date.now() / 1000;

        this.pollingInterval = setInterval(async () => {
            if (!this.isPolling || !this.currentChatId) return;

            try {
                const newMessages = await this.getMessagesSince(this.currentChatId, this.lastTimestamp);
                
                if (newMessages.length > 0) {
                    this.lastTimestamp = Math.max(...newMessages.map(msg => msg.timestamp));
                    this.onNewMessagesCallback(newMessages);
                }
            } catch (error) {
                console.error('Polling error:', error);
            }
        }, intervalMs);
    }

    /**
     * Stop polling
     */
    stopPolling() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
            this.pollingInterval = null;
        }
        this.isPolling = false;
        this.currentChatId = null;
        this.onNewMessagesCallback = null;
    }

    /**
     * Update last timestamp
     */
    updateTimestamp(timestamp) {
        this.lastTimestamp = Math.max(this.lastTimestamp, timestamp);
    }
}

// Global instance
window.unifiedChatService = new UnifiedWebChatService();

// Enhanced chat functions for existing web app
window.UnifiedChatFunctions = {
    currentChatId: null,
    chatService: window.unifiedChatService,

    async openChat(amigoId) {
        try {
            this.chatService.stopPolling();
            this.currentChatId = amigoId;

            // Show chat interface
            document.getElementById('chat-placeholder').style.display = 'none';
            document.getElementById('chat-content').style.display = 'block';

            // Load user info
            const userInfo = await this.chatService.getUserInfo(amigoId);
            if (userInfo) {
                this.displayUserInfo(userInfo);
            }

            // Load messages
            await this.loadMessages(amigoId);

            // Start polling for new messages
            this.chatService.startPolling(amigoId, (newMessages) => {
                this.displayNewMessages(newMessages);
            });

            // Mark all chat items as inactive and current as active
            document.querySelectorAll('.amigo-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`[data-amigo-id="${amigoId}"]`)?.classList.add('active');

        } catch (error) {
            console.error('Error opening chat:', error);
            this.showError('Error al abrir el chat');
        }
    },

    async loadMessages(amigoId) {
        try {
            const mensajes = await this.chatService.getConversation(amigoId);
            this.displayMessages(mensajes);
            
            // Update timestamp for polling
            if (mensajes.length > 0) {
                const lastTimestamp = Math.max(...mensajes.map(m => m.timestamp || 0));
                this.chatService.updateTimestamp(lastTimestamp);
            }
        } catch (error) {
            console.error('Error loading messages:', error);
            this.showError('Error al cargar mensajes');
        }
    },

    displayUserInfo(userInfo) {
        const chatAmigoInfo = document.getElementById('chat-amigo-info');
        if (chatAmigoInfo) {
            let fotoHtml = '';
            if (userInfo.foto_perfil && userInfo.foto_perfil !== 'perfil/default.jpg') {
                fotoHtml = `<img src="/storage/${userInfo.foto_perfil}" alt="Foto de perfil" class="rounded-circle me-2" width="35" height="35">`;
            } else {
                fotoHtml = `<div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px; font-size: 0.9rem;">${userInfo.nombre.charAt(0).toUpperCase()}</div>`;
            }
            
            chatAmigoInfo.innerHTML = `
                ${fotoHtml}
                <div>
                    <h6 class="mb-0">${userInfo.nombre} ${userInfo.apellido_paterno}</h6>
                    <small class="text-muted">${userInfo.correo}</small>
                </div>
            `;
        }
    },

    displayMessages(mensajes) {
        const container = document.getElementById('mensajes-container');
        if (!container) return;

        container.innerHTML = '';
        
        mensajes.forEach(mensaje => {
            this.appendMessage(mensaje);
        });

        // Scroll to bottom
        container.scrollTop = container.scrollHeight;
    },

    displayNewMessages(newMessages) {
        newMessages.forEach(mensaje => {
            this.appendMessage(mensaje);
        });

        const container = document.getElementById('mensajes-container');
        if (container) {
            // Auto-scroll if user is near bottom
            const isNearBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - 100;
            if (isNearBottom) {
                container.scrollTop = container.scrollHeight;
            }
        }
    },

    appendMessage(mensaje) {
        const container = document.getElementById('mensajes-container');
        if (!container) return;

        const messageDiv = document.createElement('div');
        messageDiv.className = `mensaje ${mensaje.es_mio ? 'mensaje-propio' : 'mensaje-amigo'}`;
        
        const fecha = new Date(mensaje.created_at);
        const tiempo = fecha.toLocaleTimeString('es-ES', {
            hour: '2-digit',
            minute: '2-digit'
        });

        messageDiv.innerHTML = `
            <div class="mensaje-contenido">
                ${this.escapeHtml(mensaje.contenido)}
            </div>
            <div class="mensaje-tiempo">
                ${tiempo}
            </div>
        `;

        container.appendChild(messageDiv);
    },

    async sendMessage() {
        const input = document.getElementById('mensaje-input');
        const contenido = input?.value?.trim();
        
        if (!contenido || !this.currentChatId) return;

        try {
            input.value = '';
            
            // Optimistic update
            const tempMessage = {
                id: `temp_${Date.now()}`,
                contenido: contenido,
                es_mio: true,
                created_at: new Date().toISOString(),
                timestamp: Date.now() / 1000
            };
            
            this.appendMessage(tempMessage);
            
            // Send message
            const response = await this.chatService.sendMessage(this.currentChatId, contenido);
            
            if (response) {
                // Update timestamp for polling
                this.chatService.updateTimestamp(response.timestamp || Date.now() / 1000);
                
                // Replace temp message with real message
                const tempElement = document.querySelector(`[data-message-id="temp_${tempMessage.id}"]`);
                if (tempElement) {
                    tempElement.remove();
                    this.appendMessage(response);
                }
            }
            
            // Mark as read
            await this.chatService.markMessagesAsRead(this.currentChatId);
            
        } catch (error) {
            console.error('Error sending message:', error);
            this.showError('Error al enviar mensaje');
        }
    },

    closeChat() {
        this.chatService.stopPolling();
        this.currentChatId = null;
        
        document.getElementById('chat-content').style.display = 'none';
        document.getElementById('chat-placeholder').style.display = 'block';
        
        // Clear input
        const input = document.getElementById('mensaje-input');
        if (input) input.value = '';
        
        // Remove active state from all items
        document.querySelectorAll('.amigo-item').forEach(item => {
            item.classList.remove('active');
        });
    },

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    },

    showError(message) {
        // You can implement your error display logic here
        console.error(message);
        if (window.Swal) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error'
            });
        } else {
            alert(message);
        }
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Set up event listeners
    document.querySelectorAll('.amigo-item').forEach(item => {
        item.addEventListener('click', function() {
            const amigoId = this.dataset.amigoId;
            if (amigoId) {
                window.UnifiedChatFunctions.openChat(parseInt(amigoId));
            }
        });
    });

    // Set up send message form
    const sendForm = document.getElementById('form-enviar-mensaje');
    if (sendForm) {
        sendForm.addEventListener('submit', function(e) {
            e.preventDefault();
            window.UnifiedChatFunctions.sendMessage();
        });
    }

    // Set up close chat button
    const closeButtons = document.querySelectorAll('[onclick*="cerrarChat"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.UnifiedChatFunctions.closeChat();
        });
    });

    console.log('Unified Chat Service initialized for web');
});
