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

class UsuarioLogin(BaseModel):
    correo: EmailStr
    contraseña: str

class UsuarioOut(BaseModel):
    id: int 
    nombre: str 
    correo: EmailStr 

    class Config:
        from_attributes = True

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
        
class TokenOut(BaseModel):
    access_token: str
    token_type: str
    nombre: str
    correo: str
    
class AmigoBase(BaseModel):
    usuario_id: int
    amigo_id: int

class AmigoCreate(AmigoBase):
    pass

class Amigo(AmigoBase):
    id: int
    created_at: datetime
    updated_at: Optional[datetime] = None

    class Config:
        orm_mode = True
        
#--- Métodos de Amigos ---

class AmigoBase(BaseModel):
    id_usuario1: int
    id_usuario2: int
    status: str = "pendiente"

class AmigoCreate(AmigoBase):
    pass

class AmigoOut(AmigoBase):
    id: int

    class Config:
        from_attributes = True