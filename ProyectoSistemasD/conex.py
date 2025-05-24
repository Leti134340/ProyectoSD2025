import psycopg2
from dotenv import load_dotenv
import os

# Cargar variables de entorno
load_dotenv("conex.env")

# Obtener la URL de conexión
DATABASE_URL = os.getenv("DATABASE_URL")

print("📦 DATABASE_URL cargada:", DATABASE_URL)  # Diagnóstico

try:
    conn = psycopg2.connect(DATABASE_URL)
    print("✅ Conexión exitosa a Supabase!")

    cursor = conn.cursor()
    cursor.execute("SELECT NOW();")
    resultado = cursor.fetchone()
    print("🕒 Hora del servidor:", resultado)

    cursor.execute("SELECT * FROM usuarios LIMIT 1;")
    columnas = [desc[0] for desc in cursor.description]
    print(columnas)

    cursor.execute("SELECT * FROM usuarios;")
    usuarios = cursor.fetchall()

    for u in usuarios:
        print(u)

    cursor.close()
    conn.close()

except Exception as e:
    print("❌ Error al conectar:", e)
