const BASE_URL = "http://10.0.2.2:8000"; // Cambia por tu IP local si pruebas en físico

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

  return response.json();
};
