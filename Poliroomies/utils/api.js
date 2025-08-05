import * as SecureStore from 'expo-secure-store';

const BASE_URL = "http://192.168.1.138:8000/api";

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

// Registro

export const registerUser = async (data, imagenPerfil) => {
  const formData = new FormData();
  Object.entries(data).forEach(([key, value]) => {
    formData.append(key, value);
  });
    if (imagenPerfil?.uri) {
    formData.append('imagen', {
      uri: imagenPerfil.uri,
      name: 'perfil.jpg',
      type: 'image/jpeg',
    });
  }
  const response = await fetch(`${BASE_URL}/register`, {
    method: 'POST',
    body: formData,
  });

  const rawText = await response.text(); 

  let dataResponse;
  try {
    dataResponse = JSON.parse(rawText);
  } catch (err) {
    throw new Error(`Respuesta inesperada del servidor: ${rawText}`);
  }

  if (!response.ok) {
    throw new Error(dataResponse.detail || 'Error al registrar');
  }

  return dataResponse;
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
  await SecureStore.setItemAsync('access_token', data.access_token);
  return data;
};

export const registrarTokenNotificacion = async (expoPushToken) => {
  const token = await SecureStore.getItemAsync('access_token');
  if (!token) throw new Error('No hay sesión iniciada');
  console.log("🔗 Registrando token de notificación:", expoPushToken);
  const response = await fetch(`${BASE_URL}/notificaciones/token`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ token: expoPushToken }),
  });

  const contentType = response.headers.get('content-type');

  if (!response.ok) {
    if (contentType && contentType.includes('application/json')) {
      const errorData = await response.json();
      throw new Error(errorData.detail || 'Error al registrar token de notificación');
    } else {
      const errorText = await response.text();
      throw new Error(errorText || 'Error desconocido al registrar token');
    }
  }

  if (contentType && contentType.includes('application/json')) {
    return await response.json();
  } else {
    return await response.text();
  }
};

// Obtener usuario por ID
export const getUser = async (usuario_id) => {
    const token = await SecureStore.getItemAsync('access_token');
  if (!token) {
    throw new Error('No hay sesión iniciada');
  }
  const response = await fetch(`${BASE_URL}/usuario/${usuario_id}`, {
    method: 'GET',
    headers: { 'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`
     },
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al obtener usuario');
  }

  return response.json();
};

// Actualizar usuario por ID
export const updateUser = async (id, data, imagen) => {
  const token = await SecureStore.getItemAsync('access_token');
  const formData = new FormData();

  for (const key in data) {
    formData.append(key, data[key]);
  }

  if (imagen?.uri) {
    const filename = imagen.uri.split('/').pop();
    const type = 'image/jpeg';
    formData.append('imagen', { uri: imagen.uri, name: filename, type });
  }

  const response = await fetch(`${BASE_URL}/usuarios/${id}`, {
    method: 'PUT',
    headers: {
      Authorization: `Bearer ${token}`,
    },
    body: formData,
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al actualizar usuario');
  }

  return response.json();
};


// Cerrar sesión 
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

export const obtenerChatsActivos = async () => {
  const token = await SecureStore.getItemAsync('access_token');
  const response = await fetch(`${BASE_URL}/chats/activos`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });

  if (!response.ok) {
    throw new Error('Error al obtener chats activos');
  }

  return await response.json();
};

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

//Mensajes
export const obtenerMensajes = async (receptorId) => {
  const token = await SecureStore.getItemAsync('access_token');
  if (!token) {
    throw new Error('No hay sesión iniciada');
  }

  const response = await fetch(`${BASE_URL}/mensajes/${receptorId}`, {
    headers: { Authorization: `Bearer ${token}` },
  });

  if (response.status === 404) {
    return [];
  }

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al obtener mensajes');
  }

  return response.json();
};

export const enviarMensaje = async (receptorId, contenido) => {
  const token = await SecureStore.getItemAsync('access_token');
  if (!token) throw new Error('No hay sesión iniciada');

  const response = await fetch(`${BASE_URL}/mensajes/`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${token}`,
    },
    body: JSON.stringify({ receptor_id: receptorId, contenido }),
  });

  if (!response.ok) {
    const errorData = await response.json();
    throw new Error(errorData.detail || 'Error al enviar mensaje');
  }

  return response.json();
};

//Amigos
export const obtenerAmigos = async (usuarioId) => {
  const token = await SecureStore.getItemAsync('access_token');
  const response = await fetch(`${BASE_URL}/amigos/${usuarioId}`, {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  });

  if (!response.ok) {
    throw new Error('Error al obtener amigos');
  }

  return await response.json();
};
