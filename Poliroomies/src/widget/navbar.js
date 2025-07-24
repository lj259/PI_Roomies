// BottomNavBar.js
import React from 'react';
import { View, Text, TouchableOpacity, StyleSheet } from 'react-native';
import { Home, User, Search, Settings } from 'lucide-react-native';
import { useNavigation, useRoute } from '@react-navigation/native';

const BottomNavBar = () => {
  const navigation = useNavigation();
  const route = useRoute();

  const isActive = (name) => route.name === name;

  return (
    <View style={styles.navBar}>
      <NavItem
        icon={Home}
        label="Inicio"
        active={isActive('ChatsScreen')}
        onPress={() => navigation.navigate('ChatsScreen')}
      />
      <NavItem
        icon={User}
        label="Perfil"
        active={isActive('PerfilUsuarioScreen')}
        onPress={() => navigation.navigate('PerfilUsuarioScreen')}
      />
      <NavItem
        icon={Search}
        label="Buscar"
        active={isActive('BusquedaScreen')}
        onPress={() => navigation.navigate('BusquedaScreen')}
      />
      <NavItem
        icon={Settings}
        label="Config"
        active={isActive('Configuracion')}
        onPress={() => navigation.navigate('Configuracion')}
      />
    </View>
  );
};

const NavItem = ({ icon: Icon, label, active, onPress }) => (
  <TouchableOpacity style={[styles.navItem, active && styles.navItemActive]} onPress={onPress}>
    <Icon color={active ? '#B00020' : '#888'} size={22} />
    <Text style={[styles.navText, active && styles.navTextActive]}>{label}</Text>
  </TouchableOpacity>
);

const styles = StyleSheet.create({
  navBar: {
    flexDirection: 'row',
    justifyContent: 'space-around',
    paddingVertical: 10,
    backgroundColor: '#ccc',
  },
  navItem: {
    alignItems: 'center',
  },
  navText: {
    fontSize: 12,
    color: '#888',
  },
  navItemActive: {},
  navTextActive: {
    color: '#B00020',
    fontWeight: 'bold',
  },
});

export default BottomNavBar;
