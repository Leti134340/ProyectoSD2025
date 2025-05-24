from flask import Flask, request, jsonify
import os
import psycopg2
import uuid
from dotenv import load_dotenv

load_dotenv("conex.env")

app = Flask(__name__)

DATABASE_URL = os.getenv("DATABASE_URL")

def get_db_connection():
    conn = psycopg2.connect(DATABASE_URL)
    return conn

@app.route("/api/puntos", methods=["POST"])
def registrar_puntos():
    data = request.json
    user_id = data.get("user_id")
    puntos_ganados = data.get("puntos_ganados", 0)
    puntos_perdidos = data.get("puntos_perdidos", 0)

    if not user_id:
        return jsonify({"error": "user_id es requerido"}), 400

    mov_id = str(uuid.uuid4())[:8]

    try:
        conn = get_db_connection()
        cur = conn.cursor()
        cur.execute(
            """
            INSERT INTO MovPuntos (userId, movid, puntos_ganados, puntos_perdidos)
            VALUES (%s, %s, %s, %s);
            """,
            (user_id, mov_id, puntos_ganados, puntos_perdidos)
        )
        conn.commit()
        cur.close()
        conn.close()
        return jsonify({"message": "Puntos registrados", "mov_id": mov_id}), 200

    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == "__main__":
    app.run(debug=True, port=5000)
