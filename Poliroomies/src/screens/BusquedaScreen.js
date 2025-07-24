import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import BottomNavBar from '../widget/navbar';

export default function BusquedaScreen() {
  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.container}>
      <Text style={styles.text}>Aquí va la búsqueda de usuarios o contenido 🔍</Text>
        </View>

      {/* Barra de navegación */}
      <BottomNavBar />
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: { flex:1, justifyContent:'center', alignItems:'center' },
  text: { fontSize: 18, color: '#555' }
});
