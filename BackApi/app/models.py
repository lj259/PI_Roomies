from sqlalchemy import Column, Integer, String, Text, DateTime, ForeignKey
from sqlalchemy.orm import relationship
from database import Base
from datetime import datetime

class Usuario(Base):
    __tablename__ = 'usuarios'
    
    id = Column(Integer, primary_key=True, index=True)
    nombre = Column(String(100))
    apellido_paterno = Column(String(100))
    apellido_materno = Column(String(100))
    correo = Column(String(100), unique=True, index=True)
    contraseña = Column(String(255))
    telefono = Column(String(20))
    foto_perfil = Column(String(255))
    genero = Column(String(20))
    rol = Column(String(50))
    preferencias_roomie = Column(String(255)) 
    status = Column(String(50))
    
    mensajes_enviados = relationship("Mensaje", back_populates="emisor", foreign_keys="Mensaje.emisor_id")
    mensajes_recibidos = relationship("Mensaje", back_populates="receptor", foreign_keys="Mensaje.receptor_id")

class Mensaje(Base):
    __tablename__ = 'mensajes'
    
    id = Column(Integer, primary_key=True, index=True)
    emisor_id = Column(Integer, ForeignKey('usuarios.id'))  
    receptor_id = Column(Integer, ForeignKey('usuarios.id'))  
    contenido = Column(Text)
    created_at = Column(DateTime, default=datetime.utcnow)
    updated_at = Column(DateTime, default=datetime.utcnow, onupdate=datetime.utcnow)
    
    emisor = relationship("Usuario", back_populates="mensajes_enviados", foreign_keys=[emisor_id])
    receptor = relationship("Usuario", back_populates="mensajes_recibidos", foreign_keys=[receptor_id])