import React, { useState, useRef, useEffect } from 'react';
import {
  View, Text, TextInput, TouchableOpacity, FlatList, Image, Modal, StyleSheet, 
  KeyboardAvoidingView, Platform, Keyboard, TouchableWithoutFeedback, Alert
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { SafeAreaView } from 'react-native-safe-area-context';
import { unifiedChatService, ChatPoller } from '../../utils/unified_chat_api';
import * as SecureStore from 'expo-secure-store';

export default function UnifiedChatScreen({ route, navigation }) {
  const { receptorId, nombre, userId, userName } = route.params;
  const [mensaje, setMensaje] = useState('');
  const [mensajes, setMensajes] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const [loading, setLoading] = useState(false);
  const [userInfo, setUserInfo] = useState(null);
  const [currentUserId, setCurrentUserId] = useState(null);
  const flatListRef = useRef();
  const pollerRef = useRef(null);

  const chatUserId = receptorId || userId;
  const chatUserName = nombre || userName;

  // Get current user ID
  useEffect(() => {
    const getCurrentUser = async () => {
      try {
        const userId = await SecureStore.getItemAsync('user_id');
        setCurrentUserId(parseInt(userId));
      } catch (error) {
        console.error('Error getting current user:', error);
      }
    };
    getCurrentUser();
  }, []);

  // Initialize chat poller for real-time updates
  useEffect(() => {
    if (!chatUserId) return;

    const handleNewMessages = (newMessages) => {
      if (newMessages.length > 0) {
        setMensajes(prev => {
          const existingIds = new Set(prev.map(m => m.id));
          const uniqueNewMessages = newMessages.filter(m => !existingIds.has(m.id));
          return [...prev, ...uniqueNewMessages];
        });
        
        // Auto-scroll to bottom when new messages arrive
        setTimeout(() => {
          flatListRef.current?.scrollToEnd({ animated: true });
        }, 100);
      }
    };

    pollerRef.current = new ChatPoller(chatUserId, handleNewMessages);
    pollerRef.current.start(2000); // Poll every 2 seconds

    return () => {
      if (pollerRef.current) {
        pollerRef.current.stop();
      }
    };
  }, [chatUserId]);

  // Load initial messages and user info
  useEffect(() => {
    const loadInitialData = async () => {
      if (!chatUserId) return;
      
      setLoading(true);
      try {
        // Load messages
        const mensajesExistentes = await unifiedChatService.getConversation(chatUserId);
        setMensajes(mensajesExistentes);
        
        // Load user info
        const info = await unifiedChatService.getUserInfo(chatUserId);
        setUserInfo(info);
        
        // Update poller timestamp
        if (mensajesExistentes.length > 0 && pollerRef.current) {
          const lastTimestamp = Math.max(...mensajesExistentes.map(m => m.timestamp || 0));
          pollerRef.current.updateTimestamp(lastTimestamp);
        }
        
        // Scroll to bottom
        setTimeout(() => {
          flatListRef.current?.scrollToEnd({ animated: true });
        }, 100);
        
      } catch (error) {
        console.error("Error loading initial data:", error);
        Alert.alert('Error', 'No se pudieron cargar los mensajes');
      } finally {
        setLoading(false);
      }
    };

    loadInitialData();
  }, [chatUserId]);

  const enviarMensaje = async () => {
    if (mensaje.trim() === '' || loading) return;

    const mensajeTexto = mensaje.trim();
    setMensaje('');
    setLoading(true);

    // Optimistic update - add message immediately to UI
    const tempMessage = {
      id: `temp_${Date.now()}`,
      contenido: mensajeTexto,
      emisor_id: currentUserId,
      receptor_id: chatUserId,
      created_at: new Date().toISOString(),
      timestamp: Date.now() / 1000,
      es_mio: true,
      estado: 'enviando'
    };

    setMensajes(prev => [...prev, tempMessage]);
    
    // Scroll to bottom
    setTimeout(() => {
      flatListRef.current?.scrollToEnd({ animated: true });
    }, 100);

    try {
      const response = await unifiedChatService.sendMessage(chatUserId, mensajeTexto);
      
      if (response) {
        // Replace temp message with real message
        setMensajes(prev => prev.map(m => 
          m.id === tempMessage.id ? { ...response, estado: 'enviado' } : m
        ));
        
        // Update poller timestamp
        if (pollerRef.current) {
          pollerRef.current.updateTimestamp(response.timestamp || Date.now() / 1000);
        }
      } else {
        throw new Error('No response received');
      }
    } catch (error) {
      console.error("Error sending message:", error);
      
      // Mark message as failed
      setMensajes(prev => prev.map(m => 
        m.id === tempMessage.id ? { ...m, estado: 'fallido' } : m
      ));
      
      Alert.alert('Error', 'No se pudo enviar el mensaje');
    } finally {
      setLoading(false);
    }
  };

  const retryMessage = async (message) => {
    if (message.estado !== 'fallido') return;
    
    setLoading(true);
    try {
      const response = await unifiedChatService.sendMessage(chatUserId, message.contenido);
      
      if (response) {
        setMensajes(prev => prev.map(m => 
          m.id === message.id ? { ...response, estado: 'enviado' } : m
        ));
      }
    } catch (error) {
      console.error("Error retrying message:", error);
      Alert.alert('Error', 'No se pudo reenviar el mensaje');
    } finally {
      setLoading(false);
    }
  };

  const markMessagesAsRead = async () => {
    try {
      await unifiedChatService.markMessagesAsRead(chatUserId);
    } catch (error) {
      console.error("Error marking messages as read:", error);
    }
  };

  // Mark messages as read when screen comes into focus
  useEffect(() => {
    const unsubscribe = navigation.addListener('focus', () => {
      markMessagesAsRead();
    });

    return unsubscribe;
  }, [navigation, chatUserId]);

  const renderMessage = ({ item }) => {
    const isMyMessage = item.es_mio || item.emisor_id === currentUserId;
    const messageStyle = [
      styles.mensaje,
      isMyMessage ? styles.enviado : styles.recibido
    ];

    return (
      <TouchableOpacity
        style={messageStyle}
        onPress={() => {
          if (item.estado === 'fallido') {
            Alert.alert(
              'Reenviar mensaje',
              '¿Quieres intentar enviar este mensaje de nuevo?',
              [
                { text: 'Cancelar', style: 'cancel' },
                { text: 'Reenviar', onPress: () => retryMessage(item) }
              ]
            );
          }
        }}
      >
        <Text style={{ 
          color: isMyMessage ? 'white' : 'black',
          fontSize: 16
        }}>
          {item.contenido}
        </Text>
        <View style={styles.messageFooter}>
          <Text style={[styles.tiempo, { 
            color: isMyMessage ? 'rgba(255,255,255,0.7)' : 'rgba(0,0,0,0.5)' 
          }]}>
            {new Date(item.created_at).toLocaleTimeString('es-ES', {
              hour: '2-digit',
              minute: '2-digit'
            })}
          </Text>
          {isMyMessage && (
            <Text style={[styles.estado, {
              color: item.estado === 'fallido' ? '#ff6b6b' : 
                     item.estado === 'enviando' ? '#ffa500' : 'rgba(255,255,255,0.7)'
            }]}>
              {item.estado === 'enviando' ? '⏳' : 
               item.estado === 'fallido' ? '❌' : '✓'}
            </Text>
          )}
        </View>
      </TouchableOpacity>
    );
  };

  return (
    <SafeAreaView style={styles.container}>
      <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
        <View style={{ flex: 1 }}>
          <KeyboardAvoidingView
            style={{ flex: 1 }}
            behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
            keyboardVerticalOffset={Platform.OS === 'ios' ? 150 : 25}
          >
            {/* Header */}
            <View style={styles.cabecera}>
              <TouchableOpacity onPress={() => navigation.goBack()}>
                <Ionicons name="arrow-back" size={24} color="#fff" />
              </TouchableOpacity>

              <Image 
                source={
                  userInfo?.foto_perfil 
                    ? { uri: userInfo.foto_perfil }
                    : require('../../assets/user1.png')
                } 
                style={styles.imagen} 
              />
              
              <View style={styles.headerInfo}>
                <Text style={styles.nombre}>
                  {userInfo ? `${userInfo.nombre} ${userInfo.apellido_paterno}` : chatUserName}
                </Text>
                {loading && <Text style={styles.status}>Escribiendo...</Text>}
              </View>

              <TouchableOpacity onPress={() => setModalVisible(true)}>
                <Ionicons name="settings-outline" size={24} color="#fff" />
              </TouchableOpacity>
            </View>

            {/* Options Modal */}
            <Modal visible={modalVisible} transparent animationType="slide">
              <TouchableWithoutFeedback onPress={() => setModalVisible(false)}>
                <View style={styles.modalOverlay}>
                  <View style={styles.modal}>
                    <TouchableOpacity onPress={() => {
                      setModalVisible(false);
                      navigation.navigate('VerPerfil', { userId: chatUserId });
                    }}>
                      <Text style={styles.opcion}>Ver perfil</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => markMessagesAsRead()}>
                      <Text style={styles.opcion}>Marcar como leído</Text>
                    </TouchableOpacity>
                    <TouchableOpacity onPress={() => setModalVisible(false)}>
                      <Text style={[styles.opcion, { color: 'red' }]}>Cerrar</Text>
                    </TouchableOpacity>
                  </View>
                </View>
              </TouchableWithoutFeedback>
            </Modal>

            {/* Messages Area */}
            <View style={{ flex: 1 }}>
              <FlatList
                ref={flatListRef}
                data={mensajes}
                keyExtractor={(item) => item.id?.toString() || Math.random().toString()}
                renderItem={renderMessage}
                contentContainerStyle={[styles.mensajesContainer, { flexGrow: 1 }]}
                onContentSizeChange={() => flatListRef.current?.scrollToEnd({ animated: true })}
              />

              {/* Input Area */}
              <View style={styles.inputContainer}>
                <TextInput
                  style={styles.input}
                  placeholder="Escribe un mensaje"
                  placeholderTextColor="#999"
                  value={mensaje}
                  onChangeText={setMensaje}
                  multiline
                  maxLength={1000}
                />
                <TouchableOpacity 
                  style={[styles.boton, { opacity: loading || !mensaje.trim() ? 0.5 : 1 }]} 
                  onPress={enviarMensaje}
                  disabled={loading || !mensaje.trim()}
                >
                  <Ionicons name="send" size={20} color="#fff" />
                </TouchableOpacity>
              </View>
            </View>
          </KeyboardAvoidingView>
        </View>
      </TouchableWithoutFeedback>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { 
    flex: 1, 
    backgroundColor: '#f0f0f0' 
  },
  cabecera: {
    flexDirection: 'row', 
    alignItems: 'center', 
    padding: 15, 
    backgroundColor: '#160431ff',
    justifyContent: 'space-between'
  },
  imagen: { 
    width: 40, 
    height: 40, 
    borderRadius: 20,
    marginLeft: 10
  },
  headerInfo: {
    flex: 1,
    marginLeft: 10
  },
  nombre: { 
    fontWeight: 'bold', 
    fontSize: 16,
    color: '#fff'
  },
  status: {
    fontSize: 12,
    color: '#ccc',
    fontStyle: 'italic'
  },
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0,0,0,0.5)',
    justifyContent: 'flex-start',
    alignItems: 'flex-end',
    paddingTop: 60,
    paddingRight: 15
  },
  modal: {
    backgroundColor: 'white',
    padding: 15, 
    borderRadius: 10, 
    elevation: 10, 
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 }, 
    shadowOpacity: 0.25, 
    shadowRadius: 4,
    minWidth: 150
  },
  opcion: { 
    fontSize: 16, 
    paddingVertical: 10,
    textAlign: 'center'
  },
  mensajesContainer: { 
    padding: 10 
  },
  mensaje: { 
    padding: 12, 
    borderRadius: 15, 
    marginVertical: 5, 
    maxWidth: '75%',
    minWidth: '20%'
  },
  enviado: { 
    backgroundColor: '#072f5aff', 
    alignSelf: 'flex-end',
    borderBottomRightRadius: 5
  },
  recibido: { 
    backgroundColor: '#fff', 
    alignSelf: 'flex-start',
    borderBottomLeftRadius: 5,
    borderWidth: 1,
    borderColor: '#e0e0e0'
  },
  messageFooter: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginTop: 4
  },
  tiempo: { 
    fontSize: 10, 
    marginTop: 4 
  },
  estado: { 
    fontSize: 10, 
    marginTop: 4,
    marginLeft: 5
  },
  inputContainer: {
    flexDirection: 'row', 
    alignItems: 'flex-end', 
    padding: 10, 
    backgroundColor: '#fff',
    borderTopWidth: 1,
    borderTopColor: '#e0e0e0'
  },
  input: {
    flex: 1, 
    backgroundColor: '#f5f5f5', 
    borderRadius: 20, 
    paddingHorizontal: 15,
    paddingVertical: 10,
    maxHeight: 100,
    fontSize: 16
  },
  boton: {
    backgroundColor: '#160431ff', 
    borderRadius: 20, 
    padding: 10, 
    marginLeft: 10,
    justifyContent: 'center',
    alignItems: 'center'
  }
});
