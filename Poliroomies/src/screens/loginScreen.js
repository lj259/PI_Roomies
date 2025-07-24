import React, { useState } from 'react';
import {
  View,
  Text,
  TextInput,
  TouchableOpacity,
  StyleSheet,
  ImageBackground,
  Alert,
  ScrollView,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { loginUser } from '../../utils/api'; // Asegúrate de que la ruta sea correcta

const LoginScreen = ({ navigation }) => {
  const [email, setEmail] = useState('');
  const [contrasena, setContrasena] = useState('');

  const handleLogin = async () => {
    if (!email || !contrasena) {
      Alert.alert('Error', 'Rellena todos los campos');
      return;
    }

    try {
      const user = await loginUser(email, contrasena);
      Alert.alert('Bienvenido', `Hola ${user.nombre}`);
      // Aquí podrías guardar el usuario en AsyncStorage o contexto global si deseas persistir sesión
      navigation.navigate('ChatsScreen'); // Cambia si necesitas otra pantalla
    } catch (error) {
      Alert.alert('Error', error.message);
    }
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <ImageBackground
        source={require('../../assets/logo_fondo.jpeg')}
        style={styles.background}
        imageStyle={{ opacity: 0.07 }}
      >
        <ScrollView contentContainerStyle={styles.container}>
          <Text style={styles.title}>Iniciar Sesión</Text>

          <TextInput
            placeholder="Correo"
            placeholderTextColor="#ccc"
            style={styles.input}
            value={email}
            onChangeText={setEmail}
            keyboardType="email-address"
            autoCapitalize="none"
          />
          <TextInput
            placeholder="Contraseña"
            placeholderTextColor="#ccc"
            style={styles.input}
            secureTextEntry
            value={contrasena}
            onChangeText={setContrasena}
          />

          <TouchableOpacity onPress={() => navigation.navigate('ForgotPasswordScreen')}>
            <Text style={styles.link}>¿Olvidaste tu contraseña?</Text>
          </TouchableOpacity>

          <TouchableOpacity style={styles.button} onPress={handleLogin}>
            <Text style={styles.buttonText}>Entrar</Text>
          </TouchableOpacity>

          <TouchableOpacity onPress={() => navigation.navigate('RegistroScreen')}>
            <Text style={styles.link}>
              ¿No tienes cuenta? <Text style={styles.linkBold}>Regístrate</Text>
            </Text>
          </TouchableOpacity>
        </ScrollView>
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
    padding: 20,
    justifyContent: 'center',
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 30,
    textAlign: 'center',
  },
  input: {
    backgroundColor: '#002244',
    color: '#fff',
    borderRadius: 10,
    padding: 14,
    marginBottom: 15,
    borderWidth: 1,
    borderColor: '#ccc',
  },
  button: {
    backgroundColor: '#B00020',
    padding: 14,
    borderRadius: 10,
    alignItems: 'center',
    marginTop: 10,
    marginBottom: 20,
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
  link: {
    color: '#ccc',
    textAlign: 'center',
    marginTop: 10,
  },
  linkBold: {
    color: '#fff',
    fontWeight: 'bold',
  },
});

export default LoginScreen;