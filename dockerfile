# Imagen base ligera de Python
FROM python:3.12-alpine

# Crea directorio de trabajo
WORKDIR /app

# Copia dependencias
COPY ./src/requirements.txt .

# Instala dependencias sin caché
RUN pip install --no-cache-dir -r requirements.txt

# Copia el resto del código
COPY . .

# Expone el puerto Flask
EXPOSE 5000

# Comando de ejecución
CMD ["python", "app.py"]