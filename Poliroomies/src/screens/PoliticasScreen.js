import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  ImageBackground,
  TouchableOpacity
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { ArrowLeft } from 'lucide-react-native';
import { useNavigation } from '@react-navigation/native';

const PoliticasScreen = () => {
  const navigation = useNavigation();
  return (
    <SafeAreaView style={styles.safeArea}>
      <ImageBackground
        source={require('../../assets/logo_fondo.jpeg')}
        style={styles.background}
        imageStyle={{ opacity: 0.05 }}
      >
                {/* Barra superior */}
        <View style={styles.topBar}>
          <TouchableOpacity style={styles.backButton} onPress={() => navigation.goBack()}>
            <ArrowLeft color="#fff" size={24} />
          </TouchableOpacity>
          <Text style={styles.screenTitle}>Políticas de Privacidad</Text>
        </View>
        <ScrollView contentContainerStyle={styles.scrollContent}>

          <View style={styles.section}>
            <Text style={styles.text}>
              En nuestra aplicación, tu privacidad es una prioridad. A continuación te explicamos cómo recopilamos,
              usamos y protegemos tu información personal.
            </Text>

            <Text style={styles.subTitle}>1. Información que recopilamos</Text>
            <Text style={styles.text}>
              Recopilamos información que tú mismo proporcionas, como tu nombre, correo electrónico, y preferencias de uso.
              También recopilamos información automática como tipo de dispositivo, sistema operativo y datos de uso.
            </Text>

            <Text style={styles.subTitle}>2. Uso de la información</Text>
            <Text style={styles.text}>
              Utilizamos tus datos para ofrecer una mejor experiencia, personalizar el contenido, y mejorar continuamente nuestros servicios.
            </Text>

            <Text style={styles.subTitle}>3. Compartición de datos</Text>
            <Text style={styles.text}>
              No compartimos tu información con terceros sin tu consentimiento, salvo que sea requerido por ley o para cumplir con nuestros servicios.
            </Text>

            <Text style={styles.subTitle}>4. Seguridad</Text>
            <Text style={styles.text}>
              Implementamos medidas de seguridad técnicas y organizativas para proteger tu información contra accesos no autorizados.
            </Text>

            <Text style={styles.subTitle}>5. Tus derechos</Text>
            <Text style={styles.text}>
              Puedes acceder, modificar o eliminar tus datos en cualquier momento desde la configuración de tu cuenta o contactándonos directamente.
            </Text>

            <Text style={styles.subTitle}>6. Cambios a esta política</Text>
            <Text style={styles.text}>
              Nos reservamos el derecho de modificar esta política. Cualquier cambio será notificado a través de la aplicación.
            </Text>

            <Text style={styles.text}>
              Si tienes preguntas sobre nuestras políticas, por favor contáctanos a soporte_polirommies@tuapp.com.
            </Text>
          </View>
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
  scrollContent: {
    padding: 16,
    paddingBottom: 80,
  },
  header: {
    fontSize: 26,
    fontWeight: 'bold',
    color: '#fff',
    marginBottom: 20,
    textAlign: 'center',
  },
  section: {
    backgroundColor: '#f8f8f8ff',
    borderRadius: 12,
    padding: 16,
  },
  subTitle: {
    color: 'red',
    fontSize: 16,
    fontWeight: 'bold',
    marginTop: 15,
    marginBottom: 5,
  },
  text: {
    color: 'black',
    fontSize: 14,
    lineHeight: 20,
    textAlign: 'justify',
  },
  topBar: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#B00020', // Rojo dominante
    paddingHorizontal: 16,
    paddingVertical: 12,
  },
  backButton: {
    marginRight: 12,
  },
  screenTitle: {
    fontSize: 20,
    color: '#fff',
    fontWeight: 'bold',
  },
});

export default PoliticasScreen;
