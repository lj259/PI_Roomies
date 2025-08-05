from pydantic import BaseModel, EmailStr, Field
from datetime import datetime
from typing import Optional

class UsuarioBase(BaseModel):
    nombre: str
    apellido_paterno: str
    apellido_materno: str
    correo: EmailStr
    telefono: str
    genero: str
    rol: str

class UsuarioCreate(UsuarioBase):
    contraseña: str

class Usuario(UsuarioBase):
    id: int
    foto_perfil: Optional[str] = None
    
    class Config:
        from_attributes = True

class UsuarioLogin(BaseModel):
    correo: EmailStr
    contraseña: str

class UsuarioOut(BaseModel):
    id: int 
    nombre: str 
    apellido_paterno: str
    apellido_materno: str
    telefono: Optional[str] = None
    genero: Optional[str] = None
    foto_perfil: Optional[str] = None
    correo: EmailStr 

    class Config:
        from_attributes = True


# --- Schemas de Mensajes ---
class MensajeBase(BaseModel):
    receptor_id: int
    contenido: str

class MensajeCreate(MensajeBase):
    pass

class Mensaje(MensajeBase):
    id: int
    emisor_id: int
    created_at: datetime
    updated_at: Optional[datetime] = None
    
    class Config:
        from_attributes = True
        
class ChatResumen(BaseModel):
    id: int
    nombre: str
    apellido_paterno: str
    profile_image_url: Optional[str] = None
    ultimo_mensaje_contenido: str
    ultimo_mensaje_fecha: datetime

    class Config:
        from_attributes = True
        

class TokenOut(BaseModel):
    access_token: str
    token_type: str
    nombre: str
    correo: str
    
class TokenRegistro(BaseModel):
    token: str
        
class RespuestaToken(BaseModel):
    detail: str
    
class TokenRegistrado(BaseModel):
    token: str

#--- Métodos de Amigos ---

class AmigoBase(BaseModel):
    id_usuario1: int
    id_usuario2: int
    status: str = "pendiente"

class AmigoCreate(AmigoBase):
    pass

class AmigoOut(BaseModel):
    id: int
    status: str
    created_at: datetime
    updated_at: datetime
    usuario_amigo: UsuarioOut  

    class Config:
        from_attributes = True

#--- actulizar contraseña

class ActualizarContrasena(BaseModel):
    contrasena_actual: str
    contrasena_nueva: str
    confirmar_contrasena: str