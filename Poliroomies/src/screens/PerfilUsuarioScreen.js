import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  Image,
  TouchableOpacity,
  ScrollView,
  Modal,
  TextInput,
  FlatList,
  Alert,
  Dimensions,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import Icon from 'react-native-vector-icons/Ionicons';
import BottomNavBar from '../widget/navbar';
const { width, height } = Dimensions.get('window');

export default function PerfilUsuarioScreen({ route }) {
  const isOwnProfile = !route?.params?.isExternalProfile; // true si es perfil propio
  
  const [userData, setUserData] = useState({
    name: 'María González',
    status: 'Estudiante de Ingeniería 📚',
    profileImage: 'https://via.placeholder.com/120x120.png?text=MG',
    friendsCount: 24,
  });

  const [friends] = useState([
    { id: 1, name: 'Ana Martínez', image: 'https://via.placeholder.com/50x50.png?text=AM', online: true },
    { id: 2, name: 'Carlos López', image: 'https://via.placeholder.com/50x50.png?text=CL', online: false },
    { id: 3, name: 'Sofia Rivera', image: 'https://via.placeholder.com/50x50.png?text=SR', online: true },
    { id: 4, name: 'Diego Morales', image: 'https://via.placeholder.com/50x50.png?text=DM', online: false },
    { id: 5, name: 'Isabella Cruz', image: 'https://via.placeholder.com/50x50.png?text=IC', online: true },
  ]);

  const [rentals] = useState([
    { id: 1, title: 'Habitación en Col. Centro', price: '$2,500/mes', image: 'https://via.placeholder.com/100x80.png?text=R1' },
    { id: 2, title: 'Estudio Amueblado', price: '$3,200/mes', image: 'https://via.placeholder.com/100x80.png?text=R2' },
  ]);

  const [statusModalVisible, setStatusModalVisible] = useState(false);
  const [newStatus, setNewStatus] = useState(userData.status);
  const [friendsExpanded, setFriendsExpanded] = useState(false);

  const handleUpdateStatus = () => {
    setUserData(prev => ({ ...prev, status: newStatus }));
    setStatusModalVisible(false);
  };

  const handleAddFriend = () => {
    Alert.alert('Agregar Amigo', 'Solicitud de amistad enviada');
  };

  const handleBlockUser = () => {
    Alert.alert(
      'Bloquear Usuario',
      '¿Estás seguro que deseas bloquear a este usuario?',
      [
        { text: 'Cancelar', style: 'cancel' },
        { text: 'Bloquear', style: 'destructive' },
      ]
    );
  };

  const renderFriendItem = ({ item }) => (
    <View style={styles.friendItem}>
      <View style={styles.friendImageContainer}>
        <Image source={{ uri: item.image }} style={styles.friendImage} />
        {item.online && <View style={styles.onlineIndicator} />}
      </View>
      <Text style={styles.friendName}>{item.name}</Text>
    </View>
  );

  const renderRentalItem = ({ item }) => (
    <View style={styles.rentalItem}>
      <Image source={{ uri: item.image }} style={styles.rentalImage} />
      <View style={styles.rentalInfo}>
        <Text style={styles.rentalTitle}>{item.title}</Text>
        <Text style={styles.rentalPrice}>{item.price}</Text>
      </View>
    </View>
  );

  return (
    <SafeAreaView style={styles.container}>
      {/* Logo de fondo */}
      <Image
        source={require('../../assets/polo.png')}
        style={styles.backgroundLogo}
        resizeMode="contain"
      />

      <ScrollView style={styles.scrollContainer} showsVerticalScrollIndicator={false}>
        {/* Perfil Principal */}
        <View style={styles.profileSection}>
          <View style={styles.profileImageContainer}>
            <Image source={{ uri: userData.profileImage }} style={styles.profileImage} />
            {isOwnProfile && (
              <TouchableOpacity style={styles.editImageButton}>
                <Icon name="camera" size={20} color="white" />
              </TouchableOpacity>
            )}
          </View>

          <Text style={styles.userName}>{userData.name}</Text>

          <View style={styles.statusContainer}>
            <Text style={styles.userStatus}>{userData.status}</Text>
            {isOwnProfile && (
              <TouchableOpacity
                style={styles.editStatusButton}
                onPress={() => setStatusModalVisible(true)}
              >
                <Icon name="pencil" size={16} color="#667eea" />
              </TouchableOpacity>
            )}
          </View>

          {/* Botones de acción para perfil externo */}
          {!isOwnProfile && (
            <View style={styles.externalProfileActions}>
              <TouchableOpacity style={styles.addFriendButton} onPress={handleAddFriend}>
                <Icon name="person-add" size={18} color="white" />
                <Text style={styles.addFriendText}>+ Agregar</Text>
              </TouchableOpacity>
              <TouchableOpacity style={styles.blockButton} onPress={handleBlockUser}>
                <Icon name="ban" size={18} color="white" />
                <Text style={styles.blockText}>Bloquear</Text>
              </TouchableOpacity>
            </View>
          )}
        </View>

        {/* Arrendamientos (Solo perfil propio) */}
        {isOwnProfile && (
          <View style={styles.section}>
            <View style={styles.sectionHeader}>
              <Icon name="home" size={20} color="#667eea" />
              <Text style={styles.sectionTitle}>Mis Arrendamientos</Text>
            </View>
            <FlatList
              data={rentals}
              renderItem={renderRentalItem}
              keyExtractor={(item) => item.id.toString()}
              horizontal
              showsHorizontalScrollIndicator={false}
              contentContainerStyle={styles.rentalsList}
            />
          </View>
        )}

        {/* Amigos */}
        <View style={styles.section}>
          <TouchableOpacity
            style={styles.sectionHeader}
            onPress={() => setFriendsExpanded(!friendsExpanded)}
          >
            <Icon name="people" size={20} color="#667eea" />
            <Text style={styles.sectionTitle}>Amigos ({userData.friendsCount})</Text>
            <Icon
              name={friendsExpanded ? "chevron-up" : "chevron-down"}
              size={20}
              color="#667eea"
            />
          </TouchableOpacity>

          {friendsExpanded && (
            <View style={styles.friendsContainer}>
              <FlatList
                data={friends}
                renderItem={renderFriendItem}
                keyExtractor={(item) => item.id.toString()}
                numColumns={2}
                columnWrapperStyle={styles.friendsRow}
              />
              
              {isOwnProfile && (
                <TouchableOpacity style={styles.addFriendButtonLarge} onPress={handleAddFriend}>
                  <Icon name="person-add" size={20} color="#667eea" />
                  <Text style={styles.addFriendTextLarge}>+ Agregar amigo</Text>
                </TouchableOpacity>
              )}
            </View>
          )}
        </View>

        {/* Edición de datos (Solo perfil propio) */}
        {isOwnProfile && (
          <View style={styles.section}>
            <View style={styles.sectionHeader}>
              <Icon name="settings" size={20} color="#667eea" />
              <Text style={styles.sectionTitle}>Edición de Datos</Text>
            </View>
            <TouchableOpacity style={styles.editOption}>
              <Icon name="person" size={18} color="#666" />
              <Text style={styles.editOptionText}>Editar información personal</Text>
              <Icon name="chevron-forward" size={18} color="#666" />
            </TouchableOpacity>
            <TouchableOpacity style={styles.editOption}>
              <Icon name="lock-closed" size={18} color="#666" />
              <Text style={styles.editOptionText}>Cambiar contraseña</Text>
              <Icon name="chevron-forward" size={18} color="#666" />
            </TouchableOpacity>
            <TouchableOpacity style={styles.editOption}>
              <Icon name="notifications" size={18} color="#666" />
              <Text style={styles.editOptionText}>Configurar notificaciones</Text>
              <Icon name="chevron-forward" size={18} color="#666" />
            </TouchableOpacity>
          </View>
        )}
      </ScrollView>

      {/* Modal para editar estado */}
      <Modal
        animationType="slide"
        transparent={true}
        visible={statusModalVisible}
        onRequestClose={() => setStatusModalVisible(false)}
      >
        <View style={styles.modalOverlay}>
          <View style={styles.modalContainer}>
            <View style={styles.modalHeader}>
              <Text style={styles.modalTitle}>Editar Estado</Text>
              <TouchableOpacity onPress={() => setStatusModalVisible(false)}>
                <Icon name="close" size={24} color="#333" />
              </TouchableOpacity>
            </View>

            <TextInput
              style={styles.statusInput}
              value={newStatus}
              onChangeText={setNewStatus}
              placeholder="Escribe tu estado..."
              multiline
              maxLength={100}
            />

            <View style={styles.modalActions}>
              <TouchableOpacity
                style={styles.cancelButton}
                onPress={() => setStatusModalVisible(false)}
              >
                <Text style={styles.cancelButtonText}>Cancelar</Text>
              </TouchableOpacity>
              <TouchableOpacity style={styles.saveButton} onPress={handleUpdateStatus}>
                <Text style={styles.saveButtonText}>Guardar</Text>
              </TouchableOpacity>
            </View>
          </View>
        </View>
      </Modal>
      {/* Barra de navegación */}
      <BottomNavBar />
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f8f9fa',
  },
  backgroundLogo: {
    position: 'absolute',
    width: width * 0.6,
    height: width * 0.6,
    top: height * 0.1,
    right: -width * 0.2,
    opacity: 0.05,
    zIndex: 0,
  },
  scrollContainer: {
    flex: 1,
    zIndex: 1,
  },

  // Perfil Principal
  profileSection: {
    alignItems: 'center',
    paddingTop: 30,
    paddingBottom: 30,
    paddingHorizontal: 20,
  },
  profileImageContainer: {
    position: 'relative',
    marginBottom: 15,
  },
  profileImage: {
    width: 120,
    height: 120,
    borderRadius: 60,
    borderWidth: 4,
    borderColor: 'white',
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 8,
  },
  editImageButton: {
    position: 'absolute',
    bottom: 0,
    right: 0,
    backgroundColor: '#667eea',
    borderRadius: 18,
    width: 36,
    height: 36,
    justifyContent: 'center',
    alignItems: 'center',
    borderWidth: 3,
    borderColor: 'white',
  },
  userName: {
    fontSize: 24,
    fontWeight: 'bold',
    color: '#333',
    textAlign: 'center',
    marginBottom: 8,
  },
  statusContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 20,
  },
  userStatus: {
    fontSize: 16,
    color: '#666',
    textAlign: 'center',
    marginRight: 8,
  },
  editStatusButton: {
    padding: 5,
  },

  // Botones de perfil externo
  externalProfileActions: {
    flexDirection: 'row',
    gap: 15,
  },
  addFriendButton: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#667eea',
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 25,
    gap: 8,
  },
  addFriendText: {
    color: 'white',
    fontWeight: '600',
    fontSize: 16,
  },
  blockButton: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#dc3545',
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 25,
    gap: 8,
  },
  blockText: {
    color: 'white',
    fontWeight: '600',
    fontSize: 16,
  },

  // Secciones
  section: {
    marginHorizontal: 20,
    marginBottom: 25,
    backgroundColor: 'white',
    borderRadius: 12,
    padding: 20,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 4,
    elevation: 3,
  },
  sectionHeader: {
    flexDirection: 'row',
    alignItems: 'center',
    marginBottom: 15,
    gap: 10,
  },
  sectionTitle: {
    fontSize: 18,
    fontWeight: '600',
    color: '#333',
    flex: 1,
  },

  // Arrendamientos
  rentalsList: {
    paddingRight: 20,
  },
  rentalItem: {
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
    padding: 10,
    marginRight: 15,
    width: 140,
  },
  rentalImage: {
    width: '100%',
    height: 80,
    borderRadius: 8,
    marginBottom: 8,
  },
  rentalInfo: {
    alignItems: 'flex-start',
  },
  rentalTitle: {
    fontSize: 12,
    fontWeight: '600',
    color: '#333',
    marginBottom: 4,
  },
  rentalPrice: {
    fontSize: 14,
    fontWeight: 'bold',
    color: '#667eea',
  },

  // Amigos
  friendsContainer: {
    marginTop: 10,
  },
  friendsRow: {
    justifyContent: 'space-between',
    marginBottom: 15,
  },
  friendItem: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
    padding: 10,
    width: '48%',
  },
  friendImageContainer: {
    position: 'relative',
    marginRight: 10,
  },
  friendImage: {
    width: 40,
    height: 40,
    borderRadius: 20,
  },
  onlineIndicator: {
    position: 'absolute',
    bottom: 0,
    right: 0,
    width: 12,
    height: 12,
    backgroundColor: '#28a745',
    borderRadius: 6,
    borderWidth: 2,
    borderColor: 'white',
  },
  friendName: {
    fontSize: 14,
    fontWeight: '500',
    color: '#333',
    flex: 1,
  },
  addFriendButtonLarge: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#f8f9fa',
    borderRadius: 8,
    padding: 15,
    borderWidth: 2,
    borderColor: '#667eea',
    borderStyle: 'dashed',
    marginTop: 10,
    gap: 8,
  },
  addFriendTextLarge: {
    fontSize: 16,
    fontWeight: '600',
    color: '#667eea',
  },

  // Edición de datos
  editOption: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 15,
    borderBottomWidth: 1,
    borderBottomColor: '#f0f0f0',
    gap: 12,
  },
  editOptionText: {
    fontSize: 16,
    color: '#333',
    flex: 1,
  },

  // Modal
  modalOverlay: {
    flex: 1,
    backgroundColor: 'rgba(0, 0, 0, 0.5)',
    justifyContent: 'center',
    alignItems: 'center',
  },
  modalContainer: {
    backgroundColor: 'white',
    borderRadius: 12,
    padding: 20,
    width: width * 0.85,
    maxWidth: 400,
  },
  modalHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 20,
  },
  modalTitle: {
    fontSize: 18,
    fontWeight: '600',
    color: '#333',
  },
  statusInput: {
    borderWidth: 1,
    borderColor: '#ddd',
    borderRadius: 8,
    padding: 12,
    fontSize: 16,
    minHeight: 80,
    textAlignVertical: 'top',
    marginBottom: 20,
  },
  modalActions: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    gap: 15,
  },
  cancelButton: {
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
  },
  cancelButtonText: {
    fontSize: 16,
    color: '#666',
  },
  saveButton: {
    backgroundColor: '#667eea',
    paddingHorizontal: 20,
    paddingVertical: 10,
    borderRadius: 8,
  },
  saveButtonText: {
    fontSize: 16,
    color: 'white',
    fontWeight: '600',
  },
});