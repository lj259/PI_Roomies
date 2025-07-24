from fastapi import FastAPI
from database import engine
from models import Base
from routes import router

# Crear tablas si no existen
Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="API de Mensajería",
    description="API para sistema de mensajería",
    version="1.0.0",
)

app.include_router(router, prefix="/api")

@app.get("/")
def root():
    return {"message": "API Polie Roomies - Mensajería"}