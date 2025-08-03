import React, { useState } from "react";
import {
  View,
  TextInput,
  FlatList,
  Text,
  TouchableOpacity,
  StyleSheet,
  ActivityIndicator,
  Image,
} from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";
import BottomNavBar from "../widget/navbar";
import { buscarUsuarios } from "../../utils/api";

export default function BusquedaScreen({ navigation }) {
  const [search, setSearch] = useState("");
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);

  const handleSearch = async () => {
    if (!search.trim()) return;

    try {
      setLoading(true);
      const data = await buscarUsuarios(search); // Se usa solo la función buscarUsuarios
      setResults(data);
    } catch (error) {
      console.error("Error al buscar usuarios:", error);
    } finally {
      setLoading(false);
    }
  };

  const renderItem = ({ item }) => (
    <TouchableOpacity
      style={styles.card}
      onPress={() =>
        navigation.navigate("ChatScreen", {
          receptorId: item.id,
          nombre: `${item.nombre} ${item.apellido_paterno}`,
        })
      }
    >
      <View style={styles.avatarContainer}>
        <Image
          source={require("../../assets/user1.png")}
          style={styles.avatar}
        />
      </View>
      <View style={styles.info}>
        <Text style={styles.nombre}>
          {item.nombre} {item.apellido_paterno}
        </Text>
        <Text style={styles.subtexto}>{item.correo}</Text>
      </View>
    </TouchableOpacity>
  );

  return (
    <SafeAreaView style={styles.container}>
      {/* Input de búsqueda */}
      <TextInput
        style={styles.input}
        placeholder="Buscar usuario por nombre..."
        placeholderTextColor="#ccc"
        value={search}
        onChangeText={setSearch}
        onSubmitEditing={handleSearch}
      />

      {/* Lista de resultados */}
      {loading ? (
        <ActivityIndicator size="large" color="#B00020" />
      ) : (
        <FlatList
          data={results}
          keyExtractor={(item) => item.id.toString()}
          renderItem={renderItem}
          ListEmptyComponent={
            <Text style={styles.empty}>No se encontraron usuarios</Text>
          }
        />
      )}

      {/* Barra de navegación */}
      <BottomNavBar />
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#001F54",
    paddingTop: 20,
  },
  input: {
    backgroundColor: "#002244",
    color: "#fff",
    borderRadius: 10,
    padding: 14,
    borderWidth: 1,
    borderColor: "#ccc",
    marginBottom: 20,
  },
  card: {
    flexDirection: "row",
    alignItems: "center",
    backgroundColor: "#003366",
    padding: 15,
    borderRadius: 12,
    marginBottom: 12,
    borderWidth: 1,
    borderColor: "#004080",
    shadowColor: "#000",
    shadowOpacity: 0.1,
    shadowOffset: { width: 0, height: 2 },
    shadowRadius: 4,
    elevation: 3,
  },
  avatarContainer: {
    width: 50,
    height: 50,
    borderRadius: 25,
    backgroundColor: "#004080",
    justifyContent: "center",
    alignItems: "center",
    marginRight: 15,
  },
  avatar: {
    width: 30,
    height: 30,
    tintColor: "#fff",
  },
  info: {
    flex: 1,
  },
  nombre: {
    color: "#fff",
    fontSize: 16,
    fontWeight: "bold",
  },
  subtexto: {
    color: "#ccc",
    fontSize: 14,
    marginTop: 2,
  },
  empty: {
    textAlign: "center",
    color: "#ccc",
    marginTop: 20,
  },
});