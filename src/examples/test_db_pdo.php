<?php

//presi dal docker-compose.yml
$host = 'db'; 
$dbname = 'root_db';
$user = 'user';
$password = 'user';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connessione al database riuscita con PDO!";
} catch (PDOException $e) {
    echo "Errore di connessione: " . $e->getMessage();
}
