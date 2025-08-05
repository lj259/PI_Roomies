from fastapi import FastAPI
from database import engine
from models import Base
from routes import router
from fastapi.middleware.cors import CORSMiddleware
from fastapi.staticfiles import StaticFiles


# Crear tablas si no existen
Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="API de Mensajería",
    description="API para sistema de mensajería",
    version="1.0.0",
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

app.include_router(router, prefix="/api")

app.mount("/perfil", StaticFiles(directory="perfil"), name="perfil")

@app.get("/")
def root():
    return {"message": "API Polie Roomies - Mensajería"}