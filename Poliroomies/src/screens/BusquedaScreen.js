import React, { useState } from "react";
import {
  View,
  TextInput,
  FlatList,
  Text,
  TouchableOpacity,
  StyleSheet,
  ActivityIndicator,
} from "react-native";
import { SafeAreaView } from "react-native-safe-area-context";
import BottomNavBar from "../widget/navbar";

export default function BusquedaScreen({ navigation }) {
  const [search, setSearch] = useState("");
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);

  const handleSearch = async () => {
    if (!search.trim()) return;

    try {
      setLoading(true);
      const response = await fetch(
        `http://192.168.100.44:8000/usuarios/buscar/?nombre=${search}`
      );
      const data = await response.json();
      setResults(data);
    } catch (error) {
      console.error("Error al buscar usuarios:", error);
    } finally {
      setLoading(false);
    }
  };

  const renderItem = ({ item }) => (
    <TouchableOpacity
      style={styles.item}
      onPress={() => navigation.navigate("ChatScreen", { usuarioId: item.id })}
    >
      <Text style={styles.nombre}>{item.nombre} {item.apellido_paterno}</Text>
      <Text style={styles.correo}>{item.correo}</Text>
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
    padding: 20,
  },
  input: {
    backgroundColor: "#002244",
    color: "#fff",
    borderRadius: 10,
    padding: 14,
    borderWidth: 1,
    borderColor: "#ccc",
    marginBottom: 10,
  },
  item: {
    backgroundColor: "#003366",
    padding: 15,
    borderRadius: 8,
    marginBottom: 10,
  },
  nombre: { fontSize: 16, color: "#fff", fontWeight: "bold" },
  correo: { fontSize: 14, color: "#ccc" },
  empty: { textAlign: "center", color: "#ccc", marginTop: 20 },
});
