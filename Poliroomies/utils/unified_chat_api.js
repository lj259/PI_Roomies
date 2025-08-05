import * as SecureStore from 'expo-secure-store';

// Configuration
const LARAVEL_BASE_URL = 'http://localhost:8000/api/v2'; // Update with your Laravel API URL
const FASTAPI_BASE_URL = 'http://localhost:8001'; // Your FastAPI URL

/**
 * Unified Chat API Service
 * This service connects to Laravel's unified chat API for real-time synchronization
 */
class UnifiedChatService {
  constructor() {
    this.baseUrl = LARAVEL_BASE_URL;
    this.fallbackUrl = FASTAPI_BASE_URL;
  }

  async getAuthToken() {
    return await SecureStore.getItemAsync('access_token');
  }

  async makeRequest(endpoint, options = {}) {
    const token = await this.getAuthToken();
    if (!token) {
      throw new Error('No authentication token found');
    }

    const defaultOptions = {
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        ...options.headers,
      },
    };

    const requestOptions = { ...defaultOptions, ...options };

    try {
      // Try Laravel API first
      const response = await fetch(`${this.baseUrl}${endpoint}`, requestOptions);
      
      if (response.ok) {
        return await response.json();
      } else if (response.status === 401) {
        throw new Error('Authentication failed');
      } else {
        throw new Error(`Request failed with status ${response.status}`);
      }
    } catch (error) {
      console.warn('Laravel API failed, trying fallback:', error.message);
      
      // Fallback to FastAPI
      try {
        const fallbackResponse = await fetch(`${this.fallbackUrl}${endpoint}`, requestOptions);
        if (fallbackResponse.ok) {
          return await fallbackResponse.json();
        }
        throw new Error('Both APIs failed');
      } catch (fallbackError) {
        throw new Error(`All APIs failed: ${error.message}, ${fallbackError.message}`);
      }
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
      throw error;
    }
  }

  /**
   * Get conversation messages with a specific user
   */
  async getConversation(userId) {
    try {
      const response = await this.makeRequest(`/chats/${userId}/messages`);
      return response.success ? response.mensajes : [];
    } catch (error) {
      console.error('Error getting conversation:', error);
      throw error;
    }
  }

  /**
   * Send a message to a specific user
   */
  async sendMessage(userId, contenido) {
    try {
      const response = await this.makeRequest(`/chats/${userId}/messages`, {
        method: 'POST',
        body: JSON.stringify({ contenido }),
      });
      return response.success ? response.mensaje : null;
    } catch (error) {
      console.error('Error sending message:', error);
      throw error;
    }
  }

  /**
   * Get new messages since timestamp (for polling)
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
        body: JSON.stringify(body),
      });
      return response.success;
    } catch (error) {
      console.error('Error marking messages as read:', error);
      return false;
    }
  }

  /**
   * Get user information
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
}

// Legacy API functions (keeping for backward compatibility)
const BASE_URL = FASTAPI_BASE_URL;

export const obtenerChatsActivos = async () => {
  try {
    const unifiedService = new UnifiedChatService();
    return await unifiedService.getActiveChats();
  } catch (error) {
    // Fallback to legacy API
    const token = await SecureStore.getItemAsync('access_token');
    if (!token) {
      throw new Error('No hay sesión iniciada');
    }

    const response = await fetch(`${BASE_URL}/chats/activos`, {
      headers: { Authorization: `Bearer ${token}` },
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.detail || 'Error al obtener chats activos');
    }

    return response.json();
  }
};

export const obtenerMensajes = async (receptorId) => {
  try {
    const unifiedService = new UnifiedChatService();
    return await unifiedService.getConversation(receptorId);
  } catch (error) {
    // Fallback to legacy API
    const token = await SecureStore.getItemAsync('access_token');
    if (!token) {
      throw new Error('No hay sesión iniciada');
    }

    const response = await fetch(`${BASE_URL}/mensajes/${receptorId}`, {
      headers: { Authorization: `Bearer ${token}` },
    });

    if (response.status === 404) {
      return [];
    }

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.detail || 'Error al obtener mensajes');
    }

    return response.json();
  }
};

export const enviarMensaje = async (receptorId, contenido) => {
  try {
    const unifiedService = new UnifiedChatService();
    return await unifiedService.sendMessage(receptorId, contenido);
  } catch (error) {
    // Fallback to legacy API
    const token = await SecureStore.getItemAsync('access_token');
    if (!token) throw new Error('No hay sesión iniciada');

    const response = await fetch(`${BASE_URL}/mensajes/`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({
        receptor_id: receptorId,
        contenido: contenido,
      }),
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.detail || 'Error al enviar mensaje');
    }

    return response.json();
  }
};

// New unified API functions
export const unifiedChatService = new UnifiedChatService();

// Polling utility for real-time updates
export class ChatPoller {
  constructor(userId, onNewMessages) {
    this.userId = userId;
    this.onNewMessages = onNewMessages;
    this.lastTimestamp = Date.now() / 1000;
    this.interval = null;
    this.isPolling = false;
  }

  start(intervalMs = 3000) {
    if (this.isPolling) return;
    
    this.isPolling = true;
    this.interval = setInterval(async () => {
      try {
        const newMessages = await unifiedChatService.getMessagesSince(this.userId, this.lastTimestamp);
        if (newMessages.length > 0) {
          this.lastTimestamp = Math.max(...newMessages.map(msg => msg.timestamp));
          this.onNewMessages(newMessages);
        }
      } catch (error) {
        console.error('Polling error:', error);
      }
    }, intervalMs);
  }

  stop() {
    if (this.interval) {
      clearInterval(this.interval);
      this.interval = null;
    }
    this.isPolling = false;
  }

  updateTimestamp(timestamp) {
    this.lastTimestamp = Math.max(this.lastTimestamp, timestamp);
  }
}

// Export everything for compatibility
export default {
  obtenerChatsActivos,
  obtenerMensajes,
  enviarMensaje,
  unifiedChatService,
  ChatPoller,
};
