import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Switch,
  Alert,
  Linking,
  ImageBackground,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  ChevronRight,
  HelpCircle,
  Lock,
  LogOut,
} from 'lucide-react-native';
import BottomNavBar from '../widget/navbar';
import { logoutUser } from '../../utils/api'; // Importamos la función de API
import * as SecureStore from 'expo-secure-store';
import { useEffect } from 'react';
import * as Notifications from 'expo-notifications';

const SettingsItem = ({ icon: Icon, title, onPress, showChevron = true, children, danger = false }) => (
  <TouchableOpacity
    style={[styles.settingsItem, danger && styles.dangerItem]}
    onPress={onPress}
    disabled={!onPress}
  >
    <View style={styles.settingsItemLeft}>
      {Icon && <Icon size={24} color={danger ? '#B00020' : '#fff'} style={styles.settingsIcon} />}
      <Text style={[styles.settingsItemText, danger && styles.dangerText]}>{title}</Text>
    </View>
    <View style={styles.settingsItemRight}>
      {children}
      {showChevron && onPress && <ChevronRight size={20} color="#ccc" />}
    </View>
  </TouchableOpacity>
);

const ConfiguracionScreen = ({ navigation }) => {
  const [msgNotif, setMsgNotif] = useState(true);
  const [privacyOnline, setPrivacyOnline] = useState(true);
  const [blockedUsers, setBlockedUsers] = useState(false);

  const handleLogout = () => {
    Alert.alert('Cerrar Sesión', '¿Estás segura de que deseas cerrar sesión?', [
      { text: 'Cancelar', style: 'cancel' },
      {
        text: 'Sí',
        onPress: async () => {
          try {
            await logoutUser();

            await SecureStore.deleteItemAsync('access_token');

            navigation.reset({
              index: 0,
              routes: [{ name: 'LoginScreen' }],
            });

            Alert.alert('Sesión cerrada', 'Has salido correctamente');
          } catch (error) {
            Alert.alert('Error', error.message);
          }
        },
      },
    ]);
  };

  useEffect(() => {
    (async () => {
      const token = await SecureStore.getItemAsync('access_token');
      if (!token) {
        navigation.reset({ index: 0, routes: [{ name: 'LoginScreen' }] });
      } else {
        setLoading(false);
      }
    })();
  }, []);

  return (
    <SafeAreaView style={styles.safeArea}>
      <ImageBackground
        source={require('../../assets/logo_fondo.jpeg')}
        style={styles.background}
        imageStyle={{ opacity: 0.05 }}
      >
        <ScrollView contentContainerStyle={styles.scrollContent}>
          <Text style={styles.header}>Configuración</Text>

          {/* Notificaciones */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Notificaciones</Text>
            <SettingsItem title="Notificación por mensaje" showChevron={false}>
              <Switch value={msgNotif} onValueChange={setMsgNotif} />
            </SettingsItem>
          </View>

          {/* Privacidad */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Privacidad</Text>
            <SettingsItem title="Visibilidad en línea" showChevron={false}>
              <Switch value={privacyOnline} onValueChange={setPrivacyOnline} />
            </SettingsItem>
            <SettingsItem title="Usuarios bloqueados" showChevron={false}>
              <Switch value={blockedUsers} onValueChange={setBlockedUsers} />
            </SettingsItem>
          </View>

          {/* Soporte */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Soporte</Text>
            <SettingsItem
              title="Preguntas Frecuentes"
              icon={HelpCircle}
              onPress={() => navigation.navigate('PregFrec')}
            />
            <SettingsItem
              title="Contactar Soporte"
              icon={HelpCircle}
              onPress={() => navigation.navigate('SoporteChat')}
            />
            <SettingsItem
              title="Acerca de la Aplicación"
              icon={HelpCircle}
              onPress={() => Alert.alert('Versión 1.0.0')}
            />
            <SettingsItem
              title="Políticas"
              icon={HelpCircle}
              onPress={() => navigation.navigate('Politicas')}
            />
          </View>

          {/* Cuenta */}
          <View style={styles.section}>
            <Text style={styles.sectionTitle}>Cuenta</Text>
            <SettingsItem
              title="Cambiar Contraseña"
              icon={Lock}
              onPress={() => navigation.navigate('CambiarContra')}
            />
            <SettingsItem
              title="Cerrar Sesión"
              icon={LogOut}
              onPress={handleLogout}
              showChevron={false}
              danger
            />
          </View>
        </ScrollView>

        {/* Barra de navegación */}
        <BottomNavBar />
      </ImageBackground>
    </SafeAreaView>
  );
};

export const styles = StyleSheet.create({
  safeArea: {
    flex: 1,
    backgroundColor: '#001F54',
  },
  background: {
    flex: 1,
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 80,
  },
  header: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 20,
    textAlign: 'center',
  },
  section: {
    backgroundColor: '#003366',
    borderRadius: 12,
    padding: 16,
    marginBottom: 20,
  },
  sectionTitle: {
    fontSize: 16,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 10,
  },
  settingsItem: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    backgroundColor: '#002244',
    paddingVertical: 14,
    paddingHorizontal: 12,
    borderRadius: 10,
    marginBottom: 8,
  },
  settingsItemLeft: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  settingsIcon: {
    marginRight: 10,
  },
  settingsItemText: {
    color: '#fff',
    fontSize: 15,
  },
  settingsItemRight: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  dangerItem: {
    backgroundColor: '#FFF0F0',
  },
  dangerText: {
    color: '#B00020',
    fontWeight: 'bold',
  },
});

export default ConfiguracionScreen;