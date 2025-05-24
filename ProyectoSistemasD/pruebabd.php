    <?php
// Parámetros de conexión (usa los tuyos)
$host = 'db.rmyewvtglmknnrvankvj.supabase.co';
$dbname = 'postgres';
$user = 'postgres';
$password = 'Basurin2025'; // reemplaza esto con tu clave real
$port = '5432';

try {
    // Crear conexión PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // echo "Conexión exitosa a Supabase PostgreSQL<br>";
    $stmt = $pdo->query("SELECT * FROM usuarios"); // Cambia 'usuarios' por tu tabla
    $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
<DOCTYPE HTML>
<html>
<meta charset="UTF-8">
    <title>Listado de Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
    <body>
        <h2> Listado de usuarios </h2>
        <br/>
    <table>
    <tr>
        <?php
        // Mostrar encabezados dinámicamente
        if (!empty($filas)) {
            foreach (array_keys($filas[0]) as $columna) {
                echo "<th>" . htmlspecialchars($columna) . "</th>";
            }
        }
        ?>
    </tr>
    <?php
    // Mostrar datos
    foreach ($filas as $fila) {
        echo "<tr>";
        foreach ($fila as $valor) {
            echo "<td>" . htmlspecialchars($valor) . "</td>";
        }
        echo "</tr>";
    }
    ?>
    </table>
    </body>
</html>
