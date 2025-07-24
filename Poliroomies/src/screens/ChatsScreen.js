import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  FlatList,
  Image,
  TouchableOpacity,
  ImageBackground
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  Home,
  User,
  Search,
  Settings,
} from 'lucide-react-native';
import BottomNavBar from '../widget/navbar';
const chats = [
  {
    id: '1',
    nombre: 'Luis Ramírez',
    mensaje: '¡Hola! ¿Cómo estás?',
    hora: '10:45 a.m.',
    avatar: require('../../assets/avatar1.png'),
  },
  {
    id: '2',
    nombre: 'Grupo Polirromies',
    mensaje: 'Nueva tarea publicada, revisa el grupo.',
    hora: '9:30 a.m.',
    avatar: require('../../assets/group.png'),
  },
  {
    id: '3',
    nombre: 'Ana Torres',
    mensaje: '¿Ya enviaste el reporte de hoy?',
    hora: 'Ayer',
    avatar: require('../../assets/avatar2.png'),
  },
  {
    id: '4',
    nombre: 'Carlos Mendoza',
    mensaje: 'Nos vemos en la reunión a las 5, ¡no faltes!',
    hora: 'Lunes',
    avatar: require('../../assets/avatar1.png'),
  },
  {
    id: '5',
    nombre: 'Equipo Roomies',
    mensaje: 'Recordatorio: pago de renta este viernes.',
    hora: 'Domingo',
    avatar: require('../../assets/group.png'),
  },
];

const ChatsScreen = ({ navigation }) => {
  return (
    <SafeAreaView style={styles.safeArea}>
      <ImageBackground
        source={require('../../assets/logo_fondo.jpeg')}
        style={styles.background}
        imageStyle={{ opacity: 0.07 }}
      >
        <View style={styles.container}>
          <Text style={styles.title}>📨 Chats</Text>
          <FlatList
            data={chats}
            keyExtractor={(item) => item.id}
            renderItem={({ item }) => (
              // Falta colocar id para cada chat
              <TouchableOpacity style={styles.chatItem} onPress={() => navigation.navigate('ChatScreen')}> 
                <Image source={item.avatar} style={styles.avatar} />
                <View style={styles.chatInfo}>
                  <View style={styles.chatHeader}>
                    <Text style={styles.name}>{item.nombre}</Text>
                    <Text style={styles.time}>{item.hora}</Text>
                  </View>
                  <Text style={styles.message} numberOfLines={1}>
                    {item.mensaje}
                  </Text>
                </View>
              </TouchableOpacity>
            )}
          />
        </View>
        <BottomNavBar />
      </ImageBackground>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#001F54',
  },
  background: {
    flex: 1,
  },
  container: {
    flex: 1,
    padding: 16,
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 16,
    textAlign: 'center',
  },
  chatItem: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#002244',
    borderRadius: 12,
    padding: 12,
    marginBottom: 10,
    shadowColor: '#000',
    shadowOpacity: 0.1,
    shadowRadius: 2,
    elevation: 1,
  },
  avatar: {
    width: 54,
    height: 54,
    borderRadius: 27,
    marginRight: 12,
  },
  chatInfo: {
    flex: 1,
    justifyContent: 'center',
  },
  chatHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 4,
  },
  name: {
    fontSize: 16,
    fontWeight: '600',
    color: '#fff',
    flex: 1,
  },
  time: {
    fontSize: 12,
    color: '#aaa',
    marginLeft: 10,
  },
  message: {
    fontSize: 14,
    color: '#ccc',
  },
  navBar: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    backgroundColor: '#ccc',
    paddingVertical: 10,
    borderTopWidth: 1,
    borderTopColor: '#999',
  },
  navItem: {
    alignItems: 'center',
  },
  navText: {
    fontSize: 12,
    color: '#555',
    marginTop: 2,
  },
  navItemActive: {
    borderTopWidth: 3,
    borderTopColor: '#B00020',
    paddingTop: 6,
  },
  navTextActive: {
    color: '#B00020',
    fontWeight: 'bold',
  },
});

export default ChatsScreen;
