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
  Image,
  PermissionsAndroid,
  Platform
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Picker } from '@react-native-picker/picker';
import { registerUser } from '../../utils/api';
import * as ImagePicker from 'expo-image-picker';



const RegistroScreen = ({ navigation }) => {
  const [contrasena, setContrasena] = useState('');
  const [confirmarContrasena, setConfirmarContrasena] = useState('');



  const seleccionarImagen = async () => {
    const permiso = await ImagePicker.requestMediaLibraryPermissionsAsync();
    if (!permiso.granted) {
      Alert.alert('Permiso denegado', 'No se puede acceder a la galería sin permisos.');
      return;
    }

    try {
      const resultado = await ImagePicker.launchImageLibraryAsync({
        mediaTypes: ImagePicker.MediaTypeOptions.Images,
        quality: 0.7,
        allowsEditing: true,
        selectionLimit: 1, 
      });

      console.log('Resultado:', resultado);

      if (!resultado.canceled && resultado.assets?.length > 0) {
        setImagenPerfil({ uri: resultado.assets[0].uri });
      }
    } catch (error) {
      console.warn('Error al seleccionar imagen:', error);
      Alert.alert('Error', 'No se pudo abrir la galería.');
    }
  };



  const handleRegistro = async () => {
    // Validaciones
    if (!nombre || !apellidoPaterno || !apellidoMaterno || !email || !contrasena || !confirmarContrasena) {
      Alert.alert('Error', 'Todos los campos son obligatorios');
      return;
    }

    if (contrasena !== confirmarContrasena) {
      Alert.alert('Error', 'Las contraseñas no coinciden');
      return;
    }

    try {
      const data = {
        nombre: nombre,
        apellido_paterno: apellidoPaterno,
        apellido_materno: apellidoMaterno,
        correo: email,
        contraseña: contrasena,
        telefono: telefono,
        genero: genero,
        rol: 'usuario',
      };

      await registerUser(data, imagenPerfil);

      Alert.alert('Registro exitoso', 'Ahora puedes iniciar sesión');
      navigation.navigate('LoginScreen');
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

          {imagenPerfil && (
            // <Text style={{ color: 'white', textAlign: 'center' }}>
            //     URI: {imagenPerfil?.uri || 'No seleccionada'}
            //   </Text>

            <Image
              source={{ uri: imagenPerfil.uri }}
              style={{ width: 100, height: 100, borderRadius: 50, alignSelf: 'center', marginVertical: 10 }}
            />
          )}

          <TouchableOpacity style={styles.imagePicker} onPress={() => {
            // console.log('Botón presionado');
            seleccionarImagen();
          }}>
            <Text style={styles.imagePickerText}>
              {imagenPerfil ? 'Cambiar imagen' : 'Seleccionar imagen de perfil'}
            </Text>
          </TouchableOpacity>

          
          <TextInput
            placeholder="Nombre"
            placeholderTextColor="#ccc"
            style={styles.input}
            value={nombre}
            onChangeText={setNombre}
          />

          <TextInput
            placeholder="Apellido Paterno"
            placeholderTextColor="#ccc"
            style={styles.input}
            value={apellidoPaterno}
            onChangeText={setApellidoPaterno}
          />

          <TextInput
            placeholder="Apellido Materno"
            placeholderTextColor="#ccc"
            style={styles.input}
            value={apellidoMaterno}
            onChangeText={setApellidoMaterno}
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

          <TextInput
            placeholder="Teléfono (opcional)"
            placeholderTextColor="#ccc"
            style={styles.input}
            value={telefono}
            onChangeText={setTelefono}
            keyboardType="phone-pad"
          />

          <Picker
            selectedValue={genero}
            style={styles.input}
            onValueChange={(itemValue) => setGenero(itemValue)}
          >
            <Picker.Item label="Selecciona género" value="" />
            <Picker.Item label="Masculino" value="masculino" />
            <Picker.Item label="Femenino" value="femenino" />
            <Picker.Item label="Otro" value="otro" />
          </Picker>

          <TouchableOpacity style={styles.button} onPress={handleRegistro}>
            <Text style={styles.buttonText}>Registrarme</Text>
          </TouchableOpacity>

          {/* <TouchableOpacity style={styles.button} onPress={handlePrueba}>
            <Text style={styles.buttonText}>Probar API</Text>
          </TouchableOpacity> */}

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
  imagePicker: {
  backgroundColor: '#003366',
  padding: 12,
  borderRadius: 10,
  alignItems: 'center',
  marginBottom: 15,
},
imagePickerText: {
  color: '#fff',
  fontWeight: 'bold',
},

});

export default RegistroScreen;
