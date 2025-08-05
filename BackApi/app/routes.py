from fastapi import APIRouter, Depends, HTTPException, UploadFile, File, Form, Request
from sqlalchemy.orm import Session
from sqlalchemy import func, and_, or_
from typing import List
from datetime import datetime, timedelta
import models, schemas
from database import get_db
from models import Usuario
from schemas import UsuarioCreate, UsuarioOut, UsuarioLogin, TokenOut, RespuestaToken
from utils import get_password_hash, verify_password

import jwt
from jwt import PyJWTError
from jwt import decode as jwt_decode
from fastapi.security import OAuth2PasswordBearer
import requests
import os

SECRET_KEY = "Nq4j8ZsXwV1p3K0aYbR6mT7uD5hL9oQc2fG4eJxPzSt8yRnUvWiCfBqEaHdMkOg"
ALGORITHM = "HS256"
ACCESS_TOKEN_EXPIRE_MINUTES = 720

router = APIRouter()
oauth2_scheme = OAuth2PasswordBearer(tokenUrl="login")

# Decodificar token
def get_current_user(token: str = Depends(oauth2_scheme), db: Session = Depends(get_db)):
    try:
        payload = jwt_decode(token, SECRET_KEY, algorithms=[ALGORITHM])
        user_id = payload.get("user_id")
        if user_id is None:
            raise HTTPException(status_code=401, detail="Token inválido")
        user = db.query(Usuario).filter(Usuario.id == user_id).first()
        if user is None:
            raise HTTPException(status_code=404, detail="Usuario no encontrado")
        return user
    except PyJWTError:
        raise HTTPException(status_code=403, detail="Token inválido")
    
# Registro
@router.post("/register", response_model=UsuarioOut, tags=["Usuarios"])
def register(
    nombre: str = Form(...),
    apellido_paterno: str = Form(...),
    apellido_materno: str = Form(...),
    correo: str = Form(...),
    contraseña: str = Form(...),
    telefono: str = Form(""),
    genero: str = Form(""),
    rol: str = Form("usuario"),
    imagen: UploadFile = File(None),
    db: Session = Depends(get_db)
):
    print("Recibida solicitud de registro")

    existing_user = db.query(Usuario).filter(Usuario.correo == correo).first()
    if existing_user:
        raise HTTPException(status_code=400, detail="El correo ya está registrado.")

    hashed_password = get_password_hash(contraseña)

    ruta_imagen = "perfil/default.jpg"

    if imagen:
        try:
            carpeta = "perfil"
            os.makedirs(carpeta, exist_ok=True)
            
            nombre_archivo = correo.replace("@", "_at_").replace(".", "_dot_")
            ruta_imagen = os.path.join(carpeta, f"{nombre_archivo}_perfil.jpg")
            
            with open(ruta_imagen, "wb") as buffer:
                buffer.write(imagen.file.read())
        except Exception as e:
            raise HTTPException(status_code=500, detail=f"Error al guardar la imagen: {str(e)}")
    
    nuevo_usuario = Usuario(
        nombre=nombre,
        apellido_paterno=apellido_paterno,
        apellido_materno=apellido_materno,
        correo=correo,
        contraseña=hashed_password,
        telefono=telefono,
        genero=genero,
        rol=rol,
        status=1,
        foto_perfil=ruta_imagen
    )
    
    try:
        db.add(nuevo_usuario)
        db.commit()
        db.refresh(nuevo_usuario)
        return nuevo_usuario
    except Exception as e:
        db.rollback()
        raise HTTPException(status_code=500, detail="Error al registrar el usuario: " + str(e))

# Login
@router.post("/login", response_model=TokenOut, tags=["Entrada/Salida"])
def login(user: UsuarioLogin, db: Session = Depends(get_db)):
    db_user = db.query(Usuario).filter(Usuario.correo == user.correo).first()
    if not db_user or not verify_password(user.contraseña, db_user.contraseña):
        raise HTTPException(status_code=401, detail="Correo o contraseña incorrectos.")
    expire = datetime.utcnow() + timedelta(minutes=ACCESS_TOKEN_EXPIRE_MINUTES)
    payload = {
        "sub": db_user.correo,
        "user_id": db_user.id,
        "exp": expire,
        }
    token = jwt.encode(payload, SECRET_KEY, algorithm=ALGORITHM)

    return {
        "access_token": token,
        "token_type": "bearer",
        "nombre": db_user.nombre,
        "correo": db_user.correo
    }

# Logout (simulado, sin tokens)
@router.post("/logout" , tags=["Entrada/Salida"])
def logout():
    return {"message": "Sesión cerrada correctamente (solo simulado, no hay tokens aún)"}

# Notificaciones
def enviar_notificacion_push(token, titulo, cuerpo):
    print(f"Enviando notificación a {token} con título: {titulo} y cuerpo: {cuerpo}")
    if not token:
        print("No se proporcionó un token de notificación.")
        return
    mensaje = {
        "to": token,
        "title": titulo,
        "body": cuerpo
    }
    headers = {
        "Content-Type": "application/json"
    }
    requests.post("https://exp.host/--/api/v2/push/send", json=mensaje, headers=headers)
# Mensajes
@router.post("/mensajes/", response_model=schemas.Mensaje)
def crear_mensaje(
    mensaje: schemas.MensajeCreate, 
    db: Session = Depends(get_db),
    usuario: Usuario = Depends(get_current_user)
):
    now = datetime.utcnow()
    print(f"Usuario actual: {usuario.id}, Receptor: {mensaje.receptor_id}, Contenido: {mensaje.contenido}")
    db_mensaje = models.Mensaje(
        emisor_id=usuario.id,
        receptor_id=mensaje.receptor_id,
        contenido=mensaje.contenido,
        created_at=now,
        updated_at=now
    )
    db.add(db_mensaje)
    db.commit()
    db.refresh(db_mensaje)
    
    tokens = db.query(models.NotificacionToken).filter_by(usuario_id=mensaje.receptor_id).all()
    print(f"Tokens encontrados: {[t.token for t in tokens]}")
    if not tokens:
        print("No se encontraron tokens de notificación para el receptor.")
        return db_mensaje
    for t in tokens:
        enviar_notificacion_push(t.token, f"{usuario.nombre} te ha enviado un mensaje", mensaje.contenido)
    return db_mensaje

@router.get("/mensajes/{receptor_id}", response_model=list[schemas.Mensaje])
def obtener_conversacion(receptor_id: int, db: Session = Depends(get_db), current_user: Usuario = Depends(get_current_user)):
    mensajes = db.query(models.Mensaje).filter(
        ((models.Mensaje.emisor_id == current_user.id) & (models.Mensaje.receptor_id == receptor_id)) |
        ((models.Mensaje.emisor_id == receptor_id) & (models.Mensaje.receptor_id == current_user.id))
    ).order_by(models.Mensaje.created_at.asc()).all()
    return mensajes

@router.get("/chats/activos", response_model=List[schemas.ChatResumen], tags=["Chats"])
def obtener_chats_activos(
    request: Request,
    db: Session = Depends(get_db),
    usuario_actual: Usuario = Depends(get_current_user)
):
    mensajes = (
        db.query(models.Mensaje)
        .filter(
            or_(
                models.Mensaje.emisor_id == usuario_actual.id,
                models.Mensaje.receptor_id == usuario_actual.id
            )
        )
        .order_by(models.Mensaje.created_at.desc())
        .all()
    )

    chats_dict = {}
    for mensaje in mensajes:
        otro_id = (
            mensaje.receptor_id if mensaje.emisor_id == usuario_actual.id
            else mensaje.emisor_id
        )
        if otro_id not in chats_dict:
            chats_dict[otro_id] = mensaje

    resultado = []
    for otro_id, mensaje in chats_dict.items():
        usuario = db.query(models.Usuario).filter_by(id=otro_id).first()
        imagen_url = None
        if usuario.foto_perfil:
            base_url = str(request.base_url).rstrip('/')
            imagen_url = f"{base_url}/{usuario.foto_perfil}"

        if usuario:
            resultado.append(schemas.ChatResumen(
                id=usuario.id,
                nombre=usuario.nombre,
                apellido_paterno=usuario.apellido_paterno,
                profile_image_url=imagen_url,
                ultimo_mensaje_contenido=mensaje.contenido,
                ultimo_mensaje_fecha=mensaje.created_at
            ))

    return resultado

@router.post("/notificaciones/token", response_model=RespuestaToken, tags=["Notificaciones"])
def registrar_token(
    data: schemas.TokenRegistro,
    db: Session = Depends(get_db),
    usuario: Usuario = Depends(get_current_user)
):
    existente = db.query(models.NotificacionToken).filter_by(token=data.token).first()
    if existente:
        return {"detail": "Token ya registrado"}

    nuevo = models.NotificacionToken(usuario_id=usuario.id, token=data.token)
    db.add(nuevo)
    db.commit()
    db.refresh(nuevo)
    return {"detail": "Token registrado correctamente"}

# Usuarios
@router.get("/usuarios/{usuario_id}/mensajes/", response_model=list[schemas.Mensaje], tags=["Mensajes"])
def obtener_mensajes_usuario(usuario_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        (models.Mensaje.emisor_id == usuario_id) | 
        (models.Mensaje.receptor_id == usuario_id)
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes
# Actualizar usuario
@router.put("/usuarios/{usuario_id}", tags=["Usuarios"])
async def actualizar_usuario(
    usuario_id: int,
    nombre: str = Form(...),
    apellido_paterno: str = Form(...),
    apellido_materno: str = Form(...),
    telefono: str = Form(""),
    genero: str = Form(""),
    imagen: UploadFile = File(None),
    db: Session = Depends(get_db)
):
    usuario = db.query(Usuario).filter(Usuario.id == usuario_id).first()
    if not usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")

    # Actualizar campos
    usuario.nombre = nombre
    usuario.apellido_paterno = apellido_paterno
    usuario.apellido_materno = apellido_materno
    usuario.telefono = telefono
    usuario.genero = genero

    # Si se envía nueva imagen
    if imagen:
        try:
            carpeta = "perfil"
            os.makedirs(carpeta, exist_ok=True)

            nombre_archivo = usuario.correo.replace("@", "_at_").replace(".", "_dot_")
            ruta_imagen = os.path.join(carpeta, f"{nombre_archivo}_perfil.jpg")

            with open(ruta_imagen, "wb") as buffer:
                buffer.write(await imagen.read())

            usuario.foto_perfil = ruta_imagen
        except Exception as e:
            raise HTTPException(status_code=500, detail=f"Error al guardar la imagen: {str(e)}")

    try:
        db.commit()
        db.refresh(usuario)
        return usuario
    except Exception as e:
        db.rollback()
        raise HTTPException(status_code=500, detail=f"Error al actualizar usuario: {str(e)}")

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
@router.get("/usuario/{usuario_id}", response_model=UsuarioOut, tags=["Usuarios"])
def obtener_usuario(request: Request, usuario_id: int, db: Session = Depends(get_db)):
    db_usuario = db.query(Usuario).filter(Usuario.id == usuario_id).first()
    if not db_usuario:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")

    imagen_url = None
    if db_usuario.foto_perfil:
        base_url = str(request.base_url).rstrip('/')
        imagen_url = f"{base_url}/media/{db_usuario.foto_perfil}"

    usuario_dict = db_usuario.__dict__.copy()
    usuario_dict["profile_image_url"] = imagen_url
    print(f"Usuario encontrado: {usuario_dict}")
    return usuario_dict


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

#--- Métodos de Amistad ---

# Enviar solicitud de amistad
@router.post("/amigos", response_model=schemas.AmigoOut)
def enviar_solicitud(amigo: schemas.AmigoCreate, db: Session = Depends(get_db)):
    nueva_solicitud = models.Amigo(**amigo.dict())
    db.add(nueva_solicitud)
    db.commit()
    db.refresh(nueva_solicitud)
    return nueva_solicitud 

# Aceptar/Rechazar solicitud
@router.put("/amigos/{amigo_id}", response_model=schemas.AmigoOut)
def actualizar_solicitud(amigo_id: int, status: str, db: Session = Depends(get_db)):
    solicitud = db.query(models.Amigo).filter(models.Amigo.id == amigo_id).first()
    if not solicitud:
        raise HTTPException(status_code=404, detail="Solicitud no encontrada")
    if status not in ["aceptado", "rechazado"]:
        raise HTTPException(status_code=400, detail="Estado inválido.")
    solicitud.status = status  # "aceptado" o "rechazado"
    db.commit()
    db.refresh(solicitud)
    return solicitud

# Listar amigos de un usuario
@router.get("/amigos/{usuario_id}", response_model=list[schemas.AmigoOut])
def listar_amigos(usuario_id: int, db: Session = Depends(get_db)):
    amigos = db.query(models.Amigo).filter(
        ((models.Amigo.id_usuario1 == usuario_id) | (models.Amigo.id_usuario2 == usuario_id)) &
        (models.Amigo.status == "Aceptado")
    ).all()

    resultado = []
    for amigo in amigos:
        otro_id = amigo.id_usuario2 if amigo.id_usuario1 == usuario_id else amigo.id_usuario1
        usuario_amigo = db.query(models.Usuario).filter_by(id=otro_id).first()

        resultado.append(schemas.AmigoOut(
            id=amigo.id,
            status=amigo.status,
            created_at=amigo.created_at,
            updated_at=amigo.updated_at,
            usuario_amigo=usuario_amigo
        ))
    print(f"Amigos encontrados: {len(resultado)}")
    return resultado

# Eliminar amistad
@router.delete("/amigos/{amigo_id}")
def eliminar_amigo(amigo_id: int, db: Session = Depends(get_db)):
    amigo = db.query(models.Amigo).filter(models.Amigo.id == amigo_id).first()
    if not amigo:
        raise HTTPException(status_code=404, detail="Amigo no encontrado")
    db.delete(amigo)
    db.commit()
    return {"message": "Amistad eliminada correctamente"} 

@router.get("/usuarios/buscar/", response_model=list[UsuarioOut])
def buscar_usuarios(nombre: str, db: Session = Depends(get_db)):
    usuarios = db.query(Usuario).filter(
        Usuario.nombre.ilike(f"%{nombre}%") |
        Usuario.apellido_paterno.ilike(f"%{nombre}%") |
        Usuario.apellido_materno.ilike(f"%{nombre}%")
    ).limit(20).all()
    return usuarios

# Actualizar contraseña
@router.put("/usuarios/{usuario_id}/actualizar-contrasena", response_model=dict, tags=["Usuarios"])
def actualizar_contrasena(
    usuario_id: int,
    datos: schemas.ActualizarContrasena,
    db: Session = Depends(get_db),
    usuario_actual: Usuario = Depends(get_current_user)
):
    # Verificar que el usuario existe
    usuario_a_actualizar = db.query(Usuario).filter(Usuario.id == usuario_id).first()
    if not usuario_a_actualizar:
        raise HTTPException(status_code=404, detail="Usuario no encontrado")
    
    # Verificar que el usuario autenticado puede actualizar esta contraseña
    # (solo puede actualizar su propia contraseña)
    if usuario_actual.id != usuario_id:
        raise HTTPException(status_code=403, detail="No tienes permisos para actualizar la contraseña de este usuario")
    
    # Verificar que la contraseña actual sea correcta
    if not verify_password(datos.contrasena_actual, usuario_a_actualizar.contraseña):
        raise HTTPException(status_code=400, detail="La contraseña actual es incorrecta")
    
    # Verificar que las contraseñas nuevas coincidan
    if datos.contrasena_nueva != datos.confirmar_contrasena:
        raise HTTPException(status_code=400, detail="Las contraseñas nuevas no coinciden")
    
    # Verificar que la nueva contraseña no sea igual a la actual
    if verify_password(datos.contrasena_nueva, usuario_a_actualizar.contraseña):
        raise HTTPException(status_code=400, detail="La nueva contraseña debe ser diferente a la actual")
    
    # Validar longitud mínima de la nueva contraseña
    if len(datos.contrasena_nueva) < 6:
        raise HTTPException(status_code=400, detail="La nueva contraseña debe tener al menos 6 caracteres")
    
    try:
        # Hashear la nueva contraseña
        nueva_contrasena_hash = get_password_hash(datos.contrasena_nueva)
        
        # Actualizar en la base de datos
        usuario_a_actualizar.contraseña = nueva_contrasena_hash
        db.commit()
        db.refresh(usuario_a_actualizar)
        
        return {"message": "Contraseña actualizada correctamente"}
    
    except Exception as e:
        db.rollback()
        raise HTTPException(status_code=500, detail="Error al actualizar la contraseña: " + str(e))

# @router.get("/prueba", tags=["Pruebas"])
# def prueba():
#     print("Prueba exitosa")
#     return {"message": "¡Prueba exitosa!"}
