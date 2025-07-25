from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from datetime import datetime
import models, schemas
from database import get_db
from models import Usuario
from schemas import UsuarioCreate, UsuarioOut, UsuarioLogin
from utils import get_password_hash, verify_password

router = APIRouter()


# Login
@router.post("/login", response_model=UsuarioOut, tags=["Entrada/Salida"])
def login(user: UsuarioLogin, db: Session = Depends(get_db)):
    db_user = db.query(Usuario).filter(Usuario.correo == user.correo).first()
    if not db_user or not verify_password(user.contraseña, db_user.contraseña):
        raise HTTPException(status_code=401, detail="Correo o contraseña incorrectos.")
    return db_user

# Logout (simulado, sin tokens)
@router.post("/logout" , tags=["Entrada/Salida"])
def logout():
    return {"message": "Sesión cerrada correctamente (solo simulado, no hay tokens aún)"}

@router.post("/mensajes/", response_model=schemas.Mensaje, tags=["Mensajes"])
def crear_mensaje(
    mensaje: schemas.MensajeCreate, 
    db: Session = Depends(get_db),
    emisor_id: int = 1  #Usuario 1 Predeterminado
):
    now = datetime.utcnow()
    db_mensaje = models.Mensaje(
        emisor_id=emisor_id,
        receptor_id=mensaje.receptor_id,
        contenido=mensaje.contenido,
        created_at=now,
        updated_at=now
    )
    db.add(db_mensaje)
    db.commit()
    db.refresh(db_mensaje)
    return db_mensaje

@router.get("/mensajes/{mensaje_id}", response_model=schemas.Mensaje, tags=["Mensajes"])
def leer_mensaje(mensaje_id: int, db: Session = Depends(get_db)):
    mensaje = db.query(models.Mensaje).filter(models.Mensaje.id == mensaje_id).first()
    if not mensaje:
        raise HTTPException(status_code=404, detail="Mensaje no encontrado")
    return mensaje

@router.get("/usuarios/{usuario_id}/mensajes/", response_model=list[schemas.Mensaje], tags=["Mensajes"])
def obtener_mensajes_usuario(usuario_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        (models.Mensaje.emisor_id == usuario_id) | 
        (models.Mensaje.receptor_id == usuario_id)
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes

@router.get("/usuarios/{emisor_id}/mensajes-enviados/", response_model=list[schemas.Mensaje], tags=["Mensajes"])
def obtener_mensajes_enviados(emisor_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        models.Mensaje.emisor_id == emisor_id
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes

@router.get("/usuarios/{receptor_id}/mensajes-recibidos/", response_model=list[schemas.Mensaje], tags=["Mensajes"])
def obtener_mensajes_recibidos(receptor_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        models.Mensaje.receptor_id == receptor_id
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes 

# Obtener todos los usuarios
@router.get("/usuarios/", response_model=list[UsuarioOut], tags=["Usuarios"])
def obtener_usuarios(db: Session = Depends(get_db)):
    usuarios = db.query(Usuario).all()
    return usuarios

#Obtener datos de usuario
@router.get("/usuarios/{usuario_id}", response_model=UsuarioOut, tags=["Usuarios"])
def obtener_usuario(usuario_id: int, db: Session = Depends(get_db)):
    db_usuario = db.query(Usuario).filter(Usuario.id == usuario_id).first()
    if not db_usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    return db_usuario

# Registro
@router.post("/register", response_model=UsuarioOut, tags=["Usuarios"])
def register(user: UsuarioCreate, db: Session = Depends(get_db)):
    print("Recibida solicitud de registro")
    print("Entra al metodo registro: ", user.dict())
    existing_user = db.query(Usuario).filter(Usuario.correo == user.correo).first()
    if existing_user:
        raise HTTPException(status_code=400, detail="El correo ya está registrado.")
    
    hashed_password = get_password_hash(user.contraseña)
    nuevo_usuario = Usuario(
        nombre=user.nombre,
        apellido_paterno=user.apellido_paterno,
        apellido_materno=user.apellido_materno,
        correo=user.correo,
        contraseña=hashed_password,
        telefono=user.telefono,
        genero=user.genero,
        rol=user.rol,
        status=1,  # Predeterminado activo,
    )
    try:
        db.add(nuevo_usuario)
        db.commit()
        db.refresh(nuevo_usuario)
        return nuevo_usuario
    except Exception as e:
        db.rollback()
        raise HTTPException(status_code=500, detail="Error al registrar el usuario: " + str(e))

# Actualizar usuario
@router.put("/usuarios/{usuario_id}", response_model=UsuarioOut, tags=["Usuarios"])
def actualizar_usuario(usuario_id: int, usuario: UsuarioCreate, db: Session = Depends(get_db)):
    db_usuario = db.query(Usuario).filter(Usuario.id == usuario_id).first()
    if not db_usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    
    db_usuario.nombre = usuario.nombre
    db_usuario.apellido_paterno = usuario.apellido_paterno
    db_usuario.apellido_materno = usuario.apellido_materno
    db_usuario.telefono = usuario.telefono
    db_usuario.genero = usuario.genero
    db_usuario.rol = usuario.rol
    if usuario.contraseña:
        db_usuario.contraseña = get_password_hash(usuario.contraseña)
    
    db.commit()
    db.refresh(db_usuario)
    return db_usuario