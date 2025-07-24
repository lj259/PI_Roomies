import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TextInput,
  TouchableOpacity,
  ImageBackground,
  Alert,
  ScrollView,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { registerUser } from '../../utils/api'; // Asegúrate de que la ruta sea correcta

const RegistroScreen = ({ navigation }) => {
  const [nombre, setNombre] = useState('');
  const [email, setEmail] = useState('');
  const [contrasena, setContrasena] = useState('');
  const [confirmarContrasena, setConfirmarContrasena] = useState('');

  const handleRegistro = async () => {
    if (!nombre || !email || !contrasena || !confirmarContrasena) {
      Alert.alert('Error', 'Todos los campos son obligatorios');
      return;
    }

    if (contrasena !== confirmarContrasena) {
      Alert.alert('Error', 'Las contraseñas no coinciden');
      return;
    }

    try {
      const data = {
        nombre,
        apellido_paterno: '', // Podrías añadir más campos si tu API los requiere
        apellido_materno: '',
        correo: email,
        contraseña: contrasena,
        telefono: '',
        genero: '',
        rol: 'usuario',
      };

      await registerUser(data);
      Alert.alert('Registro exitoso', 'Ahora puedes iniciar sesión');
      navigation.navigate('LoginScreen'); // Vuelve a la pantalla de login
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
          <Text style={styles.title}>Crear Cuenta</Text>

          <TextInput
            placeholder="Nombre completo"
            placeholderTextColor="#ccc"
            style={styles.input}
            value={nombre}
            onChangeText={setNombre}
          />
          <TextInput
            placeholder="Correo electrónico"
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
          <TextInput
            placeholder="Confirmar contraseña"
            placeholderTextColor="#ccc"
            style={styles.input}
            secureTextEntry
            value={confirmarContrasena}
            onChangeText={setConfirmarContrasena}
          />

          <TouchableOpacity style={styles.button} onPress={handleRegistro}>
            <Text style={styles.buttonText}>Registrarme</Text>
          </TouchableOpacity>

          <TouchableOpacity onPress={() => navigation.navigate('LoginScreen')}>
            <Text style={styles.link}>
              ¿Ya tienes una cuenta?{' '}
              <Text style={styles.linkBold}>Inicia sesión aquí</Text>
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
  },
  linkBold: {
    color: '#fff',
    fontWeight: 'bold',
  },
});

export default RegistroScreen;
