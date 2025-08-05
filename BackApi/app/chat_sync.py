import httpx
import asyncio
import os
from typing import List, Dict, Optional
from datetime import datetime
import logging

logger = logging.getLogger(__name__)

class ChatSyncService:
    """
    Service to synchronize chat messages with Laravel API
    This service bridges the FastAPI backend with the Laravel unified chat system
    """
    
    def __init__(self):
        self.laravel_base_url = os.getenv("LARAVEL_API_URL", "http://localhost:8000/api/v2")
        self.timeout = httpx.Timeout(10.0)
        
    async def get_active_chats(self, user_token: str) -> List[Dict]:
        """Get active chats from Laravel API"""
        try:
            async with httpx.AsyncClient(timeout=self.timeout) as client:
                response = await client.get(
                    f"{self.laravel_base_url}/chats",
                    headers={"Authorization": f"Bearer {user_token}"}
                )
                
                if response.status_code == 200:
                    data = response.json()
                    return data.get('chats', [])
                else:
                    logger.error(f"Error getting chats: {response.status_code} - {response.text}")
                    return []
                    
        except Exception as e:
            logger.error(f"Error syncing chats: {str(e)}")
            return []
    
    async def get_conversation(self, user_token: str, user_id: int) -> List[Dict]:
        """Get conversation messages from Laravel API"""
        try:
            async with httpx.AsyncClient(timeout=self.timeout) as client:
                response = await client.get(
                    f"{self.laravel_base_url}/chats/{user_id}/messages",
                    headers={"Authorization": f"Bearer {user_token}"}
                )
                
                if response.status_code == 200:
                    data = response.json()
                    return data.get('mensajes', [])
                else:
                    logger.error(f"Error getting conversation: {response.status_code} - {response.text}")
                    return []
                    
        except Exception as e:
            logger.error(f"Error getting conversation: {str(e)}")
            return []
    
    async def send_message_to_laravel(self, user_token: str, receptor_id: int, contenido: str) -> Optional[Dict]:
        """Send message through Laravel API for synchronization"""
        try:
            async with httpx.AsyncClient(timeout=self.timeout) as client:
                response = await client.post(
                    f"{self.laravel_base_url}/messages",
                    headers={
                        "Authorization": f"Bearer {user_token}",
                        "Content-Type": "application/json"
                    },
                    json={
                        "receptor_id": receptor_id,
                        "contenido": contenido
                    }
                )
                
                if response.status_code == 200:
                    data = response.json()
                    return data.get('mensaje')
                else:
                    logger.error(f"Error sending message: {response.status_code} - {response.text}")
                    return None
                    
        except Exception as e:
            logger.error(f"Error sending message to Laravel: {str(e)}")
            return None
    
    async def get_messages_since(self, user_token: str, user_id: int, since_timestamp: int) -> List[Dict]:
        """Get new messages since timestamp"""
        try:
            async with httpx.AsyncClient(timeout=self.timeout) as client:
                response = await client.get(
                    f"{self.laravel_base_url}/chats/{user_id}/messages/since",
                    headers={"Authorization": f"Bearer {user_token}"},
                    params={"since": since_timestamp}
                )
                
                if response.status_code == 200:
                    data = response.json()
                    return data.get('mensajes', [])
                else:
                    logger.error(f"Error getting new messages: {response.status_code} - {response.text}")
                    return []
                    
        except Exception as e:
            logger.error(f"Error getting new messages: {str(e)}")
            return []
    
    async def mark_messages_as_read(self, user_token: str, user_id: int, message_ids: List[int] = None) -> bool:
        """Mark messages as read in Laravel"""
        try:
            async with httpx.AsyncClient(timeout=self.timeout) as client:
                payload = {}
                if message_ids:
                    payload["message_ids"] = message_ids
                
                response = await client.patch(
                    f"{self.laravel_base_url}/chats/{user_id}/read",
                    headers={
                        "Authorization": f"Bearer {user_token}",
                        "Content-Type": "application/json"
                    },
                    json=payload
                )
                
                return response.status_code == 200
                    
        except Exception as e:
            logger.error(f"Error marking messages as read: {str(e)}")
            return False
    
    async def get_user_info(self, user_token: str, user_id: int) -> Optional[Dict]:
        """Get user info from Laravel API"""
        try:
            async with httpx.AsyncClient(timeout=self.timeout) as client:
                response = await client.get(
                    f"{self.laravel_base_url}/users/{user_id}",
                    headers={"Authorization": f"Bearer {user_token}"}
                )
                
                if response.status_code == 200:
                    data = response.json()
                    return data.get('user')
                else:
                    logger.error(f"Error getting user info: {response.status_code} - {response.text}")
                    return None
                    
        except Exception as e:
            logger.error(f"Error getting user info: {str(e)}")
            return None

# Global instance
chat_sync_service = ChatSyncService()
