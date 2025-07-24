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

  const data = await response.json();
  await SecureStore.setItemAsync('token', data.access_token);
  return data;
};

// Obtener usuario
export const getUser = async () => {
  const token = await SecureStore.getItemAsync('token');
  if (!token) {
    throw new Error('No hay sesión iniciada');
  }

  const response = await fetch(`${BASE_URL}/user`, {
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al obtener usuario');
  }

  return response.json();
};

// Actualizar usuario
export const updateUser = async (data) => {
  const token = await SecureStore.getItemAsync('token');
  if (!token) {
    throw new Error('No hay sesión iniciada');
  }

  const response = await fetch(`${BASE_URL}/user`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify(data),
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al actualizar usuario');
  }

  return response.json();
};

// Cerrar sesión
export const logoutUser = async () => {
  await SecureStore.deleteItemAsync('token');
};
