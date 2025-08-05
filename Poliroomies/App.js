import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { ScrollView, Button, View, StyleSheet, Alert } from 'react-native';
import * as Notificaciones from 'expo-notifications';
import * as Dispositivos from 'expo-device';
import {navigationRef} from './src/navigation/NavigationRef';
import { registrarTokenNotificacion } from './utils/api';
import { useEffect } from 'react';

// Importa las pantallas
import BusquedaScreen from './src/screens/BusquedaScreen';
import ChatScreen from './src/screens/ChatScreen';
import ChatsScreen from './src/screens/ChatsScreen';
import Configuracion from './src/screens/configuracion';

import ForgotPasswordScreen from './src/screens/ForgotPasswordScreen';

import LoginScreen from './src/screens/loginScreen';
import EdicionPerfilScreen from './src/screens/EdicionPerfilScreen';

import PerfilUsuarioScreen from './src/screens/PerfilUsuarioScreen';
import RegistroScreen from './src/screens/RegistroScreen';
import SplashScreen from './src/screens/SplashScreen';

import PregFrec from './src/screens/preg_frec';
import Politicas from './src/screens/PoliticasScreen';
import SoporteChat from './src/screens/SoporteScreen';

import WelcomeScreen from './src/screens/welcomeScreen';
import CambiarPasswdScreen from './src/screens/CambiarPasswdScreen';


const configurarNotificaciones = async () => {
  const { status } = await Notificaciones.requestPermissionsAsync();
  if (status !== 'granted') {
    console.log("Permiso de notificaciones denegado");
    return null;
  }

  const { data: expoPushToken } = await Notificaciones.getExpoPushTokenAsync();
  console.log("Expo Push Token:", expoPushToken);

  try {
    await registrarTokenNotificacion(expoPushToken);
    console.log("Token registrado correctamente");
  } catch (error) {
    console.error("Error al registrar token:", error.message);
  }

  return expoPushToken; 
};


const Stack = createStackNavigator();

export default function App() {
  useEffect(() => {
  const setupNotifications = async () => {
    const token = await configurarNotificaciones();
    if (token) {
      console.log('Expo Push Token:', token);
    }

    Notificaciones.setNotificationHandler({
      handleNotification: async () => ({
        shouldShowAlert: true,
        shouldPlaySound: true,
        shouldSetBadge: false,
      }),
    });

    const subscriptionReceived = Notificaciones.addNotificationReceivedListener(notification => {
      console.log('📩 Notificación recibida:', notification);
    });

    const subscriptionResponse = Notificaciones.addNotificationResponseReceivedListener(response => {
      const screen = response.notification.request.content.data?.screen;
      if (screen) {
        navigationRef.current?.navigate(screen);
      }
    });

    return () => {
      subscriptionReceived.remove();
      subscriptionResponse.remove();
    };
  };

  setupNotifications();
}, []);

  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="SplashScreen">
        <Stack.Screen name="BusquedaScreen" component={BusquedaScreen} options={{ headerShown: false }} />
        <Stack.Screen name="ChatScreen" component={ChatScreen} options={{ headerShown: false }} />
        <Stack.Screen name="ChatsScreen" component={ChatsScreen} options={{ headerShown: false }} />
        <Stack.Screen name="Configuracion" component={Configuracion} options={{ headerShown: false }} />

        <Stack.Screen name="ForgotPasswordScreen" component={ForgotPasswordScreen} options={{ headerShown: false }} />

        <Stack.Screen name="LoginScreen" component={LoginScreen} options={{ headerShown: false }} />
        <Stack.Screen name="EdicionPerfilScreen" component={EdicionPerfilScreen} options={{ headerShown: false }} />

        <Stack.Screen name="PerfilUsuarioScreen" component={PerfilUsuarioScreen} options={{ headerShown: false }} />
        <Stack.Screen name="RegistroScreen" component={RegistroScreen} options={{ headerShown: false }} />
        <Stack.Screen name="SplashScreen" component={SplashScreen} options={{ headerShown: false }} />
        
        <Stack.Screen name="PregFrec" component={PregFrec} options={{ headerShown: false }} />
        <Stack.Screen name="Politicas" component={Politicas} options={{ headerShown: false }} />
        <Stack.Screen name="SoporteChat" component={SoporteChat} options={{ headerShown: false }} />

        <Stack.Screen name="WelcomeScreen" component={WelcomeScreen} options={{ headerShown: false }} />
        <Stack.Screen name="CambiarPasswdScreen" component={CambiarPasswdScreen} options={{ headerShown: false }}/>
      </Stack.Navigator>
    </NavigationContainer>
  );
}

const styles = StyleSheet.create({
  container: {
    padding: 20,
    gap: 10,
  },
});
