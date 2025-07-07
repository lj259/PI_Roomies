from pydantic import BaseModel, EmailStr
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
        orm_mode = True

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
        orm_mode = True