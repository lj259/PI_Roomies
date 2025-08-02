import * as SecureStore from 'expo-secure-store';

const BASE_URL = "http://192.168.1.138:8000/api";

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
  try {
    const token = await SecureStore.getItemAsync('access_token');
    if (!token) {
      throw new Error('No hay sesión iniciada');
    }
    
    const response = await fetch(`${BASE_URL}/logout`, {
      method: 'POST',
      headers: { Authorization: `Bearer ${token}` },
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.detail || 'Error al cerrar sesión');
    }
    await SecureStore.deleteItemAsync('access_token');
  }
  catch (error) {
    throw new Error(error.message || 'Error al cerrar sesión');
  }
};

export const obtenerUsuarios = async () => {
  const token = await SecureStore.getItemAsync('access_token');
  if (!token) {
    throw new Error('No hay sesión iniciada');
  }

  const response = await fetch(`${BASE_URL}/usuarios`, {
    headers: { Authorization: `Bearer ${token}` },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al obtener usuarios');
  }

  return response.json();
}


// export const prueba = async () => {
//   const url = `${BASE_URL}/prueba`;
//   console.log("🔗 Probando conexión a:", url);      // <— aquí
//   const response = await fetch(url, {
//     method: 'GET',
//     headers: { 'Content-Type': 'application/json' },
//   });

//   if (!response.ok) {
//     const text = await response.text();
//     console.log("❌ respuesta cruda:", text);      // <— y aquí
//     const errorData = await response.json().catch(() => ({}));
//     throw new Error(errorData.detail || 'Error en la prueba');
//   }

//   const data = await response.json();
//   console.log("✅ prueba ok:", data);               // <— y respuesta
//   return data;
// }

// Buscar usuarios por nombre
export const buscarUsuarios = async (nombre) => {
  const response = await fetch(`${BASE_URL}/usuarios/buscar/?nombre=${nombre}`, {
    method: "GET",
    headers: { "Content-Type": "application/json" },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || "Error al buscar usuarios");
  }

  return response.json();
};