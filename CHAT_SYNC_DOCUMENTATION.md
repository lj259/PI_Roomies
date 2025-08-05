# Chat Synchronization System - PI Roomies

## Overview

This document describes the unified chat synchronization system that enables real-time messaging across three platforms:
- **Laravel Web Application (PI)** - Main web interface
- **FastAPI Backend (BackApi)** - Mobile app API
- **React Native Mobile App (Poliroomies)** - Mobile application

## Architecture

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Web App (PI)  │    │  Mobile Backend │    │   Mobile App    │
│    (Laravel)    │    │   (FastAPI)     │    │ (React Native)  │
└─────────┬───────┘    └─────────┬───────┘    └─────────┬───────┘
          │                      │                      │
          │ HTTP API Calls       │ HTTP API Calls       │ HTTP API Calls
          │                      │                      │
          └──────────────────────┼──────────────────────┘
                                 │
                    ┌─────────────▼───────────┐
                    │   Unified Chat API     │
                    │     (Laravel)          │
                    │                        │
                    │ - Real-time polling    │
                    │ - Message sync         │
                    │ - Read status          │
                    │ - User management      │
                    └─────────────┬──────────┘
                                  │
                         ┌────────▼────────┐
                         │  MySQL Database │
                         │   (Shared)      │
                         └─────────────────┘
```

## Components

### 1. Laravel Unified Chat API (`UnifiedChatController.php`)

**Endpoints:**
- `GET /api/v2/chats` - Get all active chats
- `GET /api/v2/chats/{userId}/messages` - Get conversation messages
- `POST /api/v2/chats/{userId}/messages` - Send message
- `GET /api/v2/chats/{userId}/messages/since` - Get messages since timestamp (polling)
- `PATCH /api/v2/chats/{userId}/read` - Mark messages as read
- `GET /api/v2/users/{userId}` - Get user info

**Features:**
- Real-time message synchronization
- Read status tracking
- Friend verification
- Error handling and fallbacks
- Cross-platform compatibility

### 2. FastAPI Sync Service (`chat_sync.py`)

**Purpose:** Bridges FastAPI backend with Laravel API for synchronization

**Features:**
- Automatic fallback to local storage if Laravel API fails
- HTTP client for Laravel API communication
- Message forwarding and synchronization
- Error handling and retry logic

### 3. Mobile App Unified Service (`unified_chat_api.js`)

**Features:**
- Unified API interface for mobile app
- Real-time polling for new messages
- Optimistic UI updates
- Automatic fallback to legacy API
- Connection status monitoring

### 4. Web App Integration (`unified-chat.js`)

**Features:**
- Real-time polling for web interface
- DOM manipulation for message display
- Connection status monitoring
- Enhanced UX with typing indicators

## Database Schema

### Messages Table (`mensajes`)
```sql
- id: Primary key
- emisor_id: Sender user ID
- receptor_id: Receiver user ID
- contenido: Message content
- created_at: Creation timestamp
- updated_at: Update timestamp
- read_at: Read timestamp (NEW)
```

## Setup Instructions

### 1. Laravel Setup

```bash
# Navigate to Laravel project
cd PI/

# Run the migration
php artisan migrate

# Clear caches
php artisan config:cache
php artisan route:cache
```

### 2. FastAPI Setup

```bash
# Navigate to FastAPI project
cd BackApi/app/

# Install dependencies
pip install -r requirements_updated.txt

# Set environment variables
export LARAVEL_API_URL="http://localhost:8000/api/v2"

# Run the server
uvicorn main:app --reload --port 8001
```

### 3. Mobile App Setup

```bash
# Navigate to mobile app
cd Poliroomies/

# Install dependencies
npm install

# Update API configuration in unified_chat_api.js
# Set LARAVEL_BASE_URL to your Laravel API URL
# Set FASTAPI_BASE_URL to your FastAPI URL
```

### 4. Web App Configuration

1. Add the unified chat script to your blade templates:
```html
<script src="{{ asset('js/unified-chat.js') }}"></script>
```

2. Update your chat view to use the new unified template:
```php
// In your controller
return view('chat.simple', compact('amigos'));
```

## API Authentication

### Laravel
- Uses Laravel's built-in authentication
- Session-based for web routes
- Token-based for API routes

### FastAPI
- JWT token authentication
- Tokens should be synchronized with Laravel for unified auth

### Mobile App
- Stores JWT tokens securely using Expo SecureStore
- Automatic token refresh and validation

## Real-time Features

### Polling System
- **Web App:** 3-second intervals for active chats
- **Mobile App:** 2-second intervals with background support
- **Smart Polling:** Only polls when user is active and chat is open

### Message Status
- **Sending:** Message being sent (optimistic update)
- **Sent:** Message successfully delivered
- **Failed:** Message failed to send (retry option)
- **Read:** Message marked as read by recipient

## Error Handling

### Fallback Strategy
1. **Primary:** Laravel Unified API
2. **Secondary:** Direct FastAPI calls
3. **Tertiary:** Local storage/cache

### Connection Monitoring
- Automatic detection of network status
- Visual indicators for connection state
- Graceful degradation when offline

## Security Considerations

### Authentication
- All API endpoints require authentication
- Friend verification before allowing chat access
- CSRF protection for web forms

### Data Validation
- Message content validation (max 1000 characters)
- SQL injection protection
- XSS prevention in message display

### Rate Limiting
- API rate limiting to prevent spam
- Message frequency limits
- Polling rate limits

## Performance Optimizations

### Database
- Indexed queries on user IDs and timestamps
- Efficient pagination for message history
- Proper relationship loading

### Caching
- Message caching for frequently accessed conversations
- User info caching
- Connection pooling for database

### Mobile Optimization
- Lazy loading for message history
- Efficient list rendering with FlatList
- Background state management

## Monitoring and Logging

### Laravel
```php
Log::info('Message sent', [
    'sender_id' => $senderId,
    'receiver_id' => $receiverId,
    'message_length' => strlen($content)
]);
```

### FastAPI
```python
logger.info(f"Sync operation completed for user {user_id}")
```

### Mobile App
```javascript
console.log('Message sync completed', { messageCount: messages.length });
```

## Testing

### Unit Tests
- Message sending/receiving
- Authentication flows
- Error handling scenarios

### Integration Tests
- Cross-platform message synchronization
- Real-time polling functionality
- Fallback mechanisms

### End-to-End Tests
- Complete user workflows
- Multi-device scenarios
- Network failure recovery

## Deployment

### Production Environment
1. Configure proper API URLs for each environment
2. Set up SSL certificates for secure communication
3. Configure database connections and connection pooling
4. Set up monitoring and alerting
5. Configure rate limiting and security headers

### Environment Variables
```bash
# Laravel
LARAVEL_API_URL=https://your-laravel-api.com/api/v2

# FastAPI
LARAVEL_API_URL=https://your-laravel-api.com/api/v2
DATABASE_URL=mysql://user:pass@host/database

# Mobile App
LARAVEL_BASE_URL=https://your-laravel-api.com/api/v2
FASTAPI_BASE_URL=https://your-fastapi.com
```

## Troubleshooting

### Common Issues

1. **Messages not syncing:**
   - Check network connectivity
   - Verify API authentication
   - Check server logs for errors

2. **Polling not working:**
   - Verify JavaScript console for errors
   - Check if user is authenticated
   - Confirm API endpoint accessibility

3. **Database connection issues:**
   - Verify database credentials
   - Check connection pooling settings
   - Monitor database performance

### Debug Commands

```bash
# Laravel logs
tail -f storage/logs/laravel.log

# FastAPI logs
uvicorn main:app --log-level debug

# Mobile app debugging
npx react-native log-android  # Android
npx react-native log-ios      # iOS
```

## Future Enhancements

### WebSocket Support
- Real-time bidirectional communication
- Reduced server load from polling
- Instant message delivery

### Push Notifications
- Native mobile notifications
- Web push notifications
- Smart notification grouping

### Message Features
- File attachments
- Message reactions
- Message editing/deletion
- Message search functionality

### Performance Improvements
- Message pagination
- Infinite scroll
- Message caching strategies
- Background sync optimization

## Support

For technical support or questions about the synchronization system:

1. Check the application logs for error details
2. Verify all API endpoints are accessible
3. Confirm database connectivity
4. Test with minimal data to isolate issues

## Version History

- **v1.0.0** - Initial unified chat synchronization system
- **v1.1.0** - Added read status tracking
- **v1.2.0** - Enhanced error handling and fallbacks
- **v1.3.0** - Mobile app optimization and polling improvements
