import React, { useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  Image,
  ActivityIndicator,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

const SplashScreen = ({ navigation }) => {
  useEffect(() => {
    const timer = setTimeout(() => {
      navigation.replace('WelcomeScreen');
    }, 2500);
    return () => clearTimeout(timer);
  }, [navigation]);

  return (
    <SafeAreaView style={styles.container}>
      <Image
        source={require('../../assets/logo_fondo.jpeg')}
        style={styles.logo}
        resizeMode="contain"
      />
      <Text style={styles.title}>PoliRoomies</Text>
      <ActivityIndicator size="large" color="#fff" style={{ marginTop: 20 }} />
    </SafeAreaView>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#001F54',
    alignItems: 'center',
    justifyContent: 'center',
  },
  logo: {
    width: 200,
    height: 200,
    opacity: 0.6,
  },
  title: {
    color: '#fff',
    fontSize: 30,
    fontWeight: 'bold',
    marginTop: 20,
  },
});

export default SplashScreen;
