<?php
    function ConectarBD(){
        $user='postgres.rmyewvtglmknnrvankvj';
        $password='Basurin2025';
        $host='aws-0-us-east-2.pooler.supabase.com';
        $port='5432';
        $dbname='postgres';

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";

        try{
            $pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            return $pdo;
        }catch (PDOException $e){
            echo "Error en la conexión: ". $e->getMessage();
        }
    }
?>