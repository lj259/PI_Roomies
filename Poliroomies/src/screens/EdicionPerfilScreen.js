import React, { useState, useEffect } from 'react';
import {
  View, Text, TextInput, TouchableOpacity, Image, ScrollView, Alert, StyleSheet
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import * as ImagePicker from 'expo-image-picker';
import { getUser, updateUser } from '../../utils/api';
import * as SecureStore from 'expo-secure-store';
import { jwtDecode } from 'jwt-decode';
import { Picker } from '@react-native-picker/picker';

const EdicionPerfilScreen = ({ navigation }) => {
  const [imagenPerfil, setImagenPerfil] = useState(null);
  const [usuarioId, setUsuarioId] = useState(null);
  const [nombre, setNombre] = useState('');
  const [apellidoPaterno, setApellidoPaterno] = useState('');
  const [apellidoMaterno, setApellidoMaterno] = useState('');
  const [telefono, setTelefono] = useState('');
  const [genero, setGenero] = useState('');

  useEffect(() => {
    const cargarDatos = async () => {
      const token = await SecureStore.getItemAsync('access_token');
      const decoded = jwtDecode(token);
      const id = decoded.user_id || decoded.id || decoded.sub;
      setUsuarioId(id);

      const data = await getUser(id);
      // console.log("Datos del usuario:", data);
      setNombre(data.nombre);
      setApellidoPaterno(data.apellido_paterno);
      setApellidoMaterno(data.apellido_materno);
      setTelefono(data.telefono || '');
      setGenero(data.genero || '');
      if (data.foto_perfil) {
        setImagenPerfil({ uri: `http://192.168.1.138:8000/${data.foto_perfil}` });
      }
    };

    cargarDatos();
  }, []);

  const seleccionarImagen = async () => {
    const permiso = await ImagePicker.requestMediaLibraryPermissionsAsync();
    if (!permiso.granted) {
      Alert.alert('Permiso denegado', 'No se puede acceder a la galería sin permisos.');
      return;
    }

    const resultado = await ImagePicker.launchImageLibraryAsync({
      mediaTypes: ImagePicker.MediaTypeOptions.Images,
      quality: 0.7,
      allowsEditing: true,
    });

    if (!resultado.canceled && resultado.assets?.length > 0) {
      setImagenPerfil({ uri: resultado.assets[0].uri });
    }
  };

  const handleGuardarCambios = async () => {
    try {
      const data = {
        nombre,
        apellido_paterno: apellidoPaterno,
        apellido_materno: apellidoMaterno,
        telefono,
        genero,
      };

      await updateUser(usuarioId, data, imagenPerfil);
      Alert.alert('Perfil actualizado', 'Tus datos han sido guardados');
      navigation.goBack();
    } catch (error) {
      Alert.alert('Error', error.message);
    }
  };

  return (
    <SafeAreaView style={styles.safeArea}>
      <ScrollView contentContainerStyle={styles.container}>
        <Text style={styles.title}>Editar Perfil</Text>

        {imagenPerfil && (
          <Image source={{ uri: imagenPerfil.uri }} style={styles.profileImage} />
        )}

        <TouchableOpacity style={styles.imagePicker} onPress={seleccionarImagen}>
          <Text style={styles.imagePickerText}>
            {imagenPerfil ? 'Cambiar imagen' : 'Seleccionar imagen de perfil'}
          </Text>
        </TouchableOpacity>

        <TextInput style={styles.input} value={nombre} onChangeText={setNombre} placeholder="Nombre" />
        <TextInput style={styles.input} value={apellidoPaterno} onChangeText={setApellidoPaterno} placeholder="Apellido Paterno" />
        <TextInput style={styles.input} value={apellidoMaterno} onChangeText={setApellidoMaterno} placeholder="Apellido Materno" />
        <TextInput style={styles.input} value={telefono} onChangeText={setTelefono} placeholder="Teléfono" />
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

        <TouchableOpacity style={styles.button} onPress={handleGuardarCambios}>
          <Text style={styles.buttonText}>Guardar Cambios</Text>
        </TouchableOpacity>
      </ScrollView>
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  safeArea: { flex: 1, backgroundColor: '#001F54' },
  container: { padding: 20 },
  title: { fontSize: 24, fontWeight: 'bold', color: '#fff', marginBottom: 20, textAlign: 'center' },
  input: { backgroundColor: '#002244', color: '#fff', borderRadius: 10, padding: 14, marginBottom: 15 },
  button: { backgroundColor: '#B00020', padding: 14, borderRadius: 10, alignItems: 'center' },
  buttonText: { color: '#fff', fontWeight: 'bold' },
  imagePicker: { backgroundColor: '#003366', padding: 12, borderRadius: 10, alignItems: 'center', marginBottom: 15 },
  imagePickerText: { color: '#fff', fontWeight: 'bold' },
  profileImage: { width: 100, height: 100, borderRadius: 50, alignSelf: 'center', marginBottom: 10 },
});

export default EdicionPerfilScreen;
