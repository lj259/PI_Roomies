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
import BottomNavBar from '../widget/navbar';
import * as SecureStore from 'expo-secure-store';
import { useEffect, useState } from 'react';
import { obtenerChatsActivos } from '../../utils/api';



const ChatsScreen = ({ navigation }) => {
  const [chats, setChats] = useState([]);
  const [loading, setLoading] = useState(true);
  
useEffect(() => {
  (async () => {
    const token = await SecureStore.getItemAsync('access_token');
    if (!token) {
      navigation.reset({ index: 0, routes: [{ name: 'LoginScreen' }] });
      return;
    }

    try {
      const chats = await obtenerChatsActivos();
      setChats(chats);
    } catch (error) {
      console.error("Error al obtener chats activos:", error);
    } finally {
      setLoading(false);
    }
  })();
}, []);

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
            keyExtractor={(item) => `${item.id}-${item.ultimo_mensaje_fecha}`}
            renderItem={({ item }) => (
              <TouchableOpacity
                style={styles.chatItem}
                onPress={() =>
                  navigation.navigate('ChatScreen', {
                    receptorId: item.id,
                    nombre: `${item.nombre} ${item.apellido_paterno}`
                  })
                }
              >
                <Image
                  source={ item.profile_image_url
                    ? { uri: item.profile_image_url }
                    : require('../../assets/avatar1.png')
                  }
                  style={styles.avatar}
                />
                <View style={styles.chatInfo}>
                  <View style={styles.chatHeader}>
                    <Text style={styles.name}>
                      {item.nombre} {item.apellido_paterno}
                    </Text>
                    <Text style={styles.time}>—</Text>
                  </View>
                  <Text style={styles.message} numberOfLines={1}>
                    Inicia conversación
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
