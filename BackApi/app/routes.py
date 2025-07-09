from fastapi import APIRouter, Depends, HTTPException
from sqlalchemy.orm import Session
from datetime import datetime
import models, schemas
from database import get_db

router = APIRouter()

@router.post("/mensajes/", response_model=schemas.Mensaje)
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

@router.get("/mensajes/{mensaje_id}", response_model=schemas.Mensaje)
def leer_mensaje(mensaje_id: int, db: Session = Depends(get_db)):
    mensaje = db.query(models.Mensaje).filter(models.Mensaje.id == mensaje_id).first()
    if not mensaje:
        raise HTTPException(status_code=404, detail="Mensaje no encontrado")
    return mensaje

@router.get("/usuarios/{usuario_id}/mensajes/", response_model=list[schemas.Mensaje])
def obtener_mensajes_usuario(usuario_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        (models.Mensaje.emisor_id == usuario_id) | 
        (models.Mensaje.receptor_id == usuario_id)
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes

@router.get("/usuarios/{emisor_id}/mensajes-enviados/", response_model=list[schemas.Mensaje])
def obtener_mensajes_enviados(emisor_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        models.Mensaje.emisor_id == emisor_id
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes

@router.get("/usuarios/{receptor_id}/mensajes-recibidos/", response_model=list[schemas.Mensaje])
def obtener_mensajes_recibidos(receptor_id: int, db: Session = Depends(get_db)):
    mensajes = db.query(models.Mensaje).filter(
        models.Mensaje.receptor_id == receptor_id
    ).order_by(models.Mensaje.created_at.desc()).all()
    return mensajes