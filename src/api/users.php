<?php
session_start();
require_once '../includes/db.php'; // Connessione al database

header('Content-Type: application/json'); // Importante per il corretto parsing del JSON

$query = "SELECT nome, cognome, email FROM user";
$result = $conn->query($query);
$utenti = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $utenti[] = $row;
    }
}
echo $utenti[1];
echo json_encode($utenti);
?>
