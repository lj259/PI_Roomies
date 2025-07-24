import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { ScrollView, Button, View, StyleSheet } from 'react-native';

// Importa las pantallas
import BusquedaScreen from './src/screens/BusquedaScreen';
import ChatScreen from './src/screens/ChatScreen';
import ChatsScreen from './src/screens/ChatsScreen';
import Configuracion from './src/screens/configuracion';

import ForgotPasswordScreen from './src/screens/ForgotPasswordScreen';

import LoginScreen from './src/screens/LoginScreen';
import PerfilUsuarioScreen from './src/screens/PerfilUsuarioScreen';
import PregFrec from './src/screens/preg_frec';
import RegistroScreen from './src/screens/RegistroScreen';
import SplashScreen from './src/screens/SplashScreen';

import WelcomeScreen from './src/screens/WelcomeScreen';

const Stack = createStackNavigator();

export default function App() {
  return (
    <NavigationContainer>
      <Stack.Navigator initialRouteName="SplashScreen">
        <Stack.Screen name="BusquedaScreen" component={BusquedaScreen} />
        <Stack.Screen name="ChatScreen" component={ChatScreen} />
        <Stack.Screen name="ChatsScreen" component={ChatsScreen} />
        <Stack.Screen name="Configuracion" component={Configuracion} />
        
        <Stack.Screen name="ForgotPasswordScreen" component={ForgotPasswordScreen} />
        
        <Stack.Screen name="LoginScreen" component={LoginScreen} />
        <Stack.Screen name="PerfilUsuarioScreen" component={PerfilUsuarioScreen} />
        <Stack.Screen name="PregFrec" component={PregFrec} />
        <Stack.Screen name="RegistroScreen" component={RegistroScreen} />
        <Stack.Screen name="SplashScreen" component={SplashScreen} />
        
        <Stack.Screen name="WelcomeScreen" component={WelcomeScreen} />
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
