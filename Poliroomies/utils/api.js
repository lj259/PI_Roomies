import * as SecureStore from 'expo-secure-store';

const BASE_URL = "http://10.0.2.2:8000/api";

// Registro
export const registerUser = async (data) => {
  const response = await fetch(`${BASE_URL}/register`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al registrar');
  }

  return response.json();
};

// Login
export const loginUser = async (correo, contraseña) => {
  const response = await fetch(`${BASE_URL}/login`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ correo, contraseña }),
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || "Error al iniciar sesión");
  }

  // Tu backend no devuelve token, así que solo retorna el usuario
  const data = await response.json();
  // Si en el futuro agregas token, aquí lo puedes guardar
  // await SecureStore.setItemAsync('token', data.access_token);
  return data;
};

// Obtener usuario por ID
export const getUser = async (usuario_id) => {
  const response = await fetch(`${BASE_URL}/usuarios/${usuario_id}`, {
    method: 'GET',
    headers: { 'Content-Type': 'application/json' },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al obtener usuario');
  }

  return response.json();
};

// Actualizar usuario por ID
export const updateUser = async (usuario_id, data) => {
  const response = await fetch(`${BASE_URL}/usuarios/${usuario_id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data),
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al actualizar usuario');
  }

  return response.json();
};

// Cerrar sesión (solo borra token si lo usas en el futuro)
export const logoutUser = async () => {
  await SecureStore.deleteItemAsync('token');
};