from transformers import AutoImageProcessor, AutoModelForImageClassification
from PIL import Image
import torch
import cv2
import serial
import time
import qrcode
from datetime import datetime
import uuid
import os
import json
import psycopg2
from dotenv import load_dotenv

load_dotenv("conex.env")
DATABASE_URL = os.getenv("DATABASE_URL")
import numpy as np

# ==========================
# Conectar con Arduino
# ==========================
arduino = serial.Serial('COM3', 9600)  # Cambia COM3 si usas otro puerto
time.sleep(2)

# ==========================
# Cargar modelo
# ==========================
model_name = "SilentHillFan/trash-clasiffier-biodegradable"
model = AutoModelForImageClassification.from_pretrained(model_name)
processor = AutoImageProcessor.from_pretrained(model_name)

# ==========================
# Clases → categorías
# ==========================
categoria_general = {
    "banana_peel": "Organico",
    "apple_core": "Organico",
    "paper": "Reciclable",
    "plastic_bottle": "Reciclable",
    "can": "Reciclable",
    "food_scraps": "Organico",
    "cardboard": "Reciclable",
    "glass_bottle": "Reciclable",
    "tea_bag": "Organico",
    "egg_shell": "Organico",
    "plastic": "Inorganico",
    "biodegradable": "Organico"
}

# ==========================
# Registrar ID generado
# ==========================
def registrar_id(id_usado):
    archivo = "ids_usados.json"
    if os.path.exists(archivo):
        with open(archivo, "r") as f:
            ids = json.load(f)
    else:
        ids = []
    ids.append(id_usado)
    with open(archivo, "w") as f:
        json.dump(ids, f)

def registrar_mov_punto(user_id, puntos_ganados=0, puntos_perdidos=0):
    if conn is None:
        print("[!] No hay conexión a la base de datos")
        return
    
    mov_id = str(uuid.uuid4())[:8]  # ID único para el movimiento

def registrar_mov_punto(user_id, puntos_ganados=0, puntos_perdidos=0):
    if conn is None:
        print("[!] No hay conexión a la base de datos")
        return
    
    mov_id = str(uuid.uuid4())[:8]  # ID único para el movimiento
    
    try:
        cur.execute(
            """
            INSERT INTO MovPuntos (userId, movid, puntos_ganados, puntos_perdidos)
            VALUES (%s, %s, %s, %s);
            """,
            (user_id, mov_id, puntos_ganados, puntos_perdidos)
        )
        conn.commit()
        print(f"[✔] Movimiento registrado: {mov_id} (+{puntos_ganados} pts)")
    except Exception as e:
        print("❌ Error al registrar movimiento:", e)



# ==========================
# Mostrar QR (retorna imagen)
# ==========================
def generar_imagen_qr():
    id_unico = str(uuid.uuid4())[:8]
    texto_qr = f"ID {id_unico}  Puntos 5  Fecha {datetime.now().strftime('%Y-%m-%d %H:%M:%S')}"
    
    qr = qrcode.make(texto_qr)
    img_qr = qr.convert("RGB")
    qr_np = np.array(img_qr)
    qr_np = cv2.cvtColor(qr_np, cv2.COLOR_RGB2BGR)

    print(f"[✔] Codigo QR generado: {texto_qr}")
    registrar_id(id_unico)
    return qr_np

# ==========================
# Inicializar cámara
# ==========================
cap = cv2.VideoCapture(0)
if not cap.isOpened():
    print("Error: No se pudo acceder a la camara")
    exit()

cv2.namedWindow("Codigo QR")
imagen_blanca = np.ones((300, 300, 3), dtype=np.uint8) * 255
qr_actual = imagen_blanca.copy()

try:
    conn = psycopg2.connect(DATABASE_URL)
    cur = conn.cursor()
    print("Conectado a Supabase ^_^")
except Exception as e:
    print("Error al conectar a Supabase:", e)
    conn = None

qr_mostrar_hasta = 0

print("Presiona Espacio para clasificar y Esc para salir")

while True:
    ret, frame = cap.read()
    if not ret:
        print("Error al capturar la imagen")
        break

    cv2.imshow("Clasificador de Basura", frame)

    if time.time() < qr_mostrar_hasta:
        cv2.imshow("Codigo QR", qr_actual)
    else:
        cv2.imshow("Codigo QR", imagen_blanca)

    key = cv2.waitKey(1) & 0xFF

    if key == 32:  # Espacio
        image_rgb = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        image_pil = Image.fromarray(image_rgb)

        inputs = processor(image_pil, return_tensors="pt")
        outputs = model(**inputs)
        predictions = torch.argmax(outputs.logits, dim=-1)
        predicted_label = model.config.id2label[predictions.item()]
        categoria = categoria_general.get(predicted_label, "Desconocido")

        print(f"Clase detectada: {predicted_label}")
        print(f"Categoria: {categoria}")

        # Enviar comando Arduino según categoría
        if categoria == "Organico":
            arduino.write(b"ORG\n")
        elif categoria == "Reciclable":
            arduino.write(b"REC\n")
        elif categoria == "Inorganico":
            arduino.write(b"INO\n")
        else:
            print("[!] Categoria desconocida, no se envía comando")

        qr_actual = generar_imagen_qr()
        qr_mostrar_hasta = time.time() + 5  # Mostrar QR por 5 segundos

        # Mostrar texto en ventana de cámara
        texto = f"{predicted_label} ({categoria})"
        temp_frame = frame.copy()
        cv2.putText(temp_frame, texto, (10, 30), cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 2)
        cv2.imshow("Clasificador de Basura", temp_frame)
        usuario_id = 1  # Cambia esto según el usuario actual
        if categoria in ["Organico", "Reciclable", "Inorganico"]:
            registrar_mov_punto(usuario_id, puntos_ganados=1)
        cv2.waitKey(1000)

    elif key == 27:  # Esc
        break

cap.release()
cv2.destroyAllWindows()
arduino.close()
if conn:
    cur.close()
    conn.close()