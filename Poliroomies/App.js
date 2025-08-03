import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { ScrollView, Button, View, StyleSheet, Alert } from 'react-native';
import * as Notificaciones from 'expo-notifications';
import * as Dispositivos from 'expo-device';
import {navigationRef} from './src/navigation/NavigationRef';
import { useEffect } from 'react';

// Importa las pantallas
import BusquedaScreen from './src/screens/BusquedaScreen';
import ChatScreen from './src/screens/ChatScreen';
import ChatsScreen from './src/screens/ChatsScreen';
import Configuracion from './src/screens/configuracion';

import ForgotPasswordScreen from './src/screens/ForgotPasswordScreen';

import LoginScreen from './src/screens/loginScreen';
import RecuperacionScreen from './src/screens/RecuperacionScreen';

import PerfilUsuarioScreen from './src/screens/PerfilUsuarioScreen';
import RegistroScreen from './src/screens/RegistroScreen';
import SplashScreen from './src/screens/SplashScreen';

import PregFrec from './src/screens/preg_frec';
import Politicas from './src/screens/PoliticasScreen';
import SoporteChat from './src/screens/SoporteScreen';

import WelcomeScreen from './src/screens/welcomeScreen';


Notificaciones.setNotificationHandler({
  handleNotification: async () => ({
    shouldShowAlert: true,
    shouldPlaySound: true,
    shouldSetBadge: false,
  }),
});

const registerForPushNotificationsAsync = async () => {
  const { status: existingStatus } = await Notificaciones.getPermissionsAsync();
  let finalStatus = existingStatus;

  if (existingStatus !== 'granted') {
    const { status } = await Notificaciones.requestPermissionsAsync();
    finalStatus = status;
  }

  if (finalStatus !== 'granted') {
    Alert.alert('Permiso denegado');
    return;
  }

  const tokenData = await Notificaciones.getExpoPushTokenAsync();
  return tokenData.data;
};
const Stack = createStackNavigator();

export default function App() {
  useEffect(() => {
  const setupNotifications = async () => {
    const token = await registerForPushNotificationsAsync();
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
        {/* <Stack.Screen name="RecuperacionScreen" component={RecuperacionScreen} options={{ headerShown: false }} /> */}

        <Stack.Screen name="PerfilUsuarioScreen" component={PerfilUsuarioScreen} options={{ headerShown: false }} />
        <Stack.Screen name="RegistroScreen" component={RegistroScreen} options={{ headerShown: false }} />
        <Stack.Screen name="SplashScreen" component={SplashScreen} options={{ headerShown: false }} />
        
        <Stack.Screen name="PregFrec" component={PregFrec} options={{ headerShown: false }} />
        <Stack.Screen name="Politicas" component={Politicas} options={{ headerShown: false }} />
        <Stack.Screen name="SoporteChat" component={SoporteChat} options={{ headerShown: false }} />

        <Stack.Screen name="WelcomeScreen" component={WelcomeScreen} options={{ headerShown: false }} />
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
