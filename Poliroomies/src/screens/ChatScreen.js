import React, { useState, useRef, useEffect } from 'react';
import {
  View, Text, TextInput, TouchableOpacity, FlatList, Image, Modal, StyleSheet, KeyboardAvoidingView, Platform, Keyboard, TouchableWithoutFeedback
} from 'react-native';
import { Ionicons } from '@expo/vector-icons';
import { SafeAreaView } from 'react-native-safe-area-context';
import { enviarMensaje as enviarMensajeApi } from '../../utils/api';
import { obtenerMensajes } from '../../utils/api'; 



export default function ChatScreen({ route,navigation }) {
  const {receptorId, nombre, userId, userName, userImage} = route.params;
  const [mensaje, setMensaje] = useState('');
  const [mensajes, setMensajes] = useState([]);
  const [modalVisible, setModalVisible] = useState(false);
  const flatListRef = useRef();

  const chatUserId = receptorId || userId
  const chatUserName = nombre || userName;

const enviarMensaje = async () => {
  if (mensaje.trim() === '') return;

  const nuevo = {
    id: Date.now(),
    texto: mensaje,
    tipo: 'enviado',
    estado: 'enviando',
  };
  setMensajes([...mensajes, nuevo]);
  setMensaje('');

  try {
    await enviarMensajeApi(chatUserId, mensaje);
    nuevo.estado = 'enviado';
  } catch (error) {
    nuevo.estado = 'fallido';
    console.error("Error al enviar mensaje:", error);
  }

  setMensajes(prev => {
    const actualizados = [...prev];
    actualizados[actualizados.length - 1] = nuevo;
    flatListRef.current?.scrollToEnd({ animated: true });
    return actualizados;
  });
};


useEffect(() => {
  let intervalo;
  console.log("imagen del chat", userImage);
  const cargarMensajes = async () => {
    try {
      const mensajesExistentes = await obtenerMensajes(chatUserId);
      setMensajes(mensajesExistentes);
      flatListRef.current?.scrollToEnd({ animated: true });
    } catch (error) {
      console.error("Error al cargar mensajes:", error);
    }
  };
  cargarMensajes();
  intervalo = setInterval(cargarMensajes, 2000); 
  return () => clearInterval(intervalo);
}, [chatUserId]);


  return (
    <SafeAreaView style={styles.container}>
        <TouchableWithoutFeedback onPress={Keyboard.dismiss}>
      <View style={ {flex: 1}}>
        <KeyboardAvoidingView
          style={{ flex: 1 }}
          behavior={Platform.OS === 'ios' ? 'padding' : 'height'}
          keyboardVerticalOffset={Platform.OS === 'ios' ? 150 : 25}
        >
          {/* CABECERA */}
          <View style={styles.cabecera}>
            <TouchableOpacity onPress={() => navigation.goBack()}>
              <Ionicons name="arrow-back" size={24} />
          </TouchableOpacity>

          <Image
            source={userImage ? { uri: userImage } : require('../../assets/user1.png')}
            style={styles.imagen}
          />

          <Text style={styles.nombre}>{chatUserName}</Text>

          {/* <TouchableOpacity onPress={() => setModalVisible(true)}>
            <Ionicons name="settings-outline" size={24} />
          </TouchableOpacity> */}
        </View>

        {/* MENÚ DE OPCIONES */}
        {/* <Modal visible={modalVisible} transparent animationType="slide">
          <View style={styles.modal}>
            <TouchableOpacity onPress={() => {
              setModalVisible(false);
              navigation.navigate('VerPerfil');
            }}>
              <Text style={styles.opcion}>Ver perfil</Text>
            </TouchableOpacity>
            <TouchableOpacity><Text style={styles.opcion}>Silenciar</Text></TouchableOpacity>
            <TouchableOpacity><Text style={styles.opcion}>Bloquear</Text></TouchableOpacity>
            <TouchableOpacity onPress={() => setModalVisible(false)}>
              <Text style={[styles.opcion, { color: 'red' }]}>Cerrar</Text>
            </TouchableOpacity>
          </View>
        </Modal> */}

        {/* ÁREA DE MENSAJES */}
        <View style ={{ flex: 1 }}>
          <FlatList
            ref={flatListRef}
            data={mensajes}
            keyExtractor={(item) => item.id.toString()}
            renderItem={({ item }) => {
              const tipo = item.emisor_id === chatUserId ? 'recibido' : 'enviado';

              return (
                <View style={[styles.mensaje, tipo === 'enviado' ? styles.enviado : styles.recibido]}>
                  <Text style={{ color: tipo === 'enviado' ? 'white' : 'black' }}>
                    {item.contenido || item.texto}
                  </Text>
                  <Text style={styles.estado}>enviado</Text>
                </View>
              );
            }}
            contentContainerStyle={[styles.mensajesContainer, { flexGrow: 1 }]}

          />

              {/* INPUT MENSAJE */}
              <View style={styles.inputContainer}>
                <TextInput
                  style={styles.input}
                  placeholder="Escribe un mensaje"
                  value={mensaje}
                  onChangeText={setMensaje}
                />
                <TouchableOpacity style={styles.boton} onPress={enviarMensaje}>
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
  container: { flex: 1, backgroundColor: '#f0f0f0' },
  cabecera: {
    flexDirection: 'row', alignItems: 'center', padding: 10, backgroundColor: '#fff',
    justifyContent: 'space-between'
  },
  imagen: { width: 40, height: 40, borderRadius: 20 },
  nombre: { fontWeight: 'bold', marginLeft: 10, flex: 1, fontSize: 16 },
  modal: {
    position: 'absolute', top: 50, right: 10, backgroundColor: 'white',
    padding: 15, borderRadius: 10, elevation: 10, shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 }, shadowOpacity: 0.25, shadowRadius: 4,
  },
  opcion: {
    fontSize: 16, paddingVertical: 10,
  },
  mensajesContainer: { padding: 10 },
  mensaje: { padding: 10, borderRadius: 10, marginVertical: 5, maxWidth: '70%' },
  enviado: { backgroundColor: '#072f5aff', alignSelf: 'flex-end' },
  recibido: { backgroundColor: '#ccc', alignSelf: 'flex-start' },
  estado: { fontSize: 10, color: '#555', marginTop: 4 },
  inputContainer: {
    flexDirection: 'row', alignItems: 'center', padding: 10, backgroundColor: '#fff'
  },
  input: {
    flex: 1, backgroundColor: '#e0e0e0', borderRadius: 20, paddingHorizontal: 15
  },
  boton: {
    backgroundColor: '#160431ff', borderRadius: 20, padding: 10, marginLeft: 10
  }
});
