import os
import psycopg2
from dotenv import load_dotenv
import uuid

load_dotenv("conex.env")  # O ".env" si renombraste tu archivo

DATABASE_URL = os.getenv("DATABASE_URL")

try:
    conn = psycopg2.connect(DATABASE_URL)
    cur = conn.cursor()
    print("✅ Conectado a la base de datos")
except Exception as e:
    print("❌ Error al conectar:", e)
    conn = None

def registrar_mov_punto(user_id, puntos_ganados=0, puntos_perdidos=0):
    if conn is None:
        print("[!] No hay conexión a la base de datos")
        return
    
    mov_id = str(uuid.uuid4())[:8]  # ID único para el movimiento
    
    try:
        cur.execute(
            """
            INSERT INTO MovPuntos (userid, movid, puntos_ganados, puntos_perdidos)
            VALUES (%s, %s, %s, %s);
            """,
            (user_id, mov_id, puntos_ganados, puntos_perdidos)
        )
        conn.commit()
        print(f"[✔] Movimiento registrado: {mov_id} (+{puntos_ganados} pts)")
    except Exception as e:
        print("❌ Error al registrar movimiento:", e)

# Prueba la función
usuario_id = 7  # Cambia por un ID válido de usuario en tu BD
registrar_mov_punto(usuario_id, puntos_ganados=1)

# Cerrar conexión
if conn:
    cur.close()
    conn.close()
    print("🔌 Conexión cerrada")
