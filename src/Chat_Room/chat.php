<?php
session_start();
require_once '../includes/db.php'; // Connessione al database
$conn = dataClassRoom();

// Controlla se l'azione è 'getmessaggi' o 'invia'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'invia') {
        // Controllo che i dati siano presenti
        if (!isset($_POST['messaggio'], $_POST['roomId'], $_SESSION['user_id'])) {
            die("Errore: Dati mancanti.");
        }

        // Pulizia e preparazione dei dati
        $messaggio = htmlspecialchars($_POST['messaggio'], ENT_QUOTES, 'UTF-8');
        $stanza = intval($_POST['roomId']);
        $utente_id = intval($_SESSION['user_id']);

        // Inserimento messaggio nel database con Prepared Statement
        $stmt = $conn->prepare("INSERT INTO messaggi (id_utente, id_stanze, testo) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $utente_id, $stanza, $messaggio);
        $stmt->execute();
        $stmt->close();
        echo json_encode(["status" => "success", "message" => "Messaggio inviato"]);
    }

    // Gestione GET per recuperare i messaggi
    if ($_POST['action'] === 'getmessaggi' && isset($_POST['roomId'])) {
        $stanza = intval($_POST['roomId']);

        $stmt = $conn->prepare("SELECT m.testo, m.data, u.username 
                                FROM messaggi m 
                                JOIN utenti u ON m.id_utente = u.id 
                                WHERE m.id_stanze = ? 
                                ORDER BY m.data ASC");
        $stmt->bind_param("i", $stanza);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Output dei messaggi in JSON
        $messaggi = [];
        while ($row = $result->fetch_assoc()) {
            $data_formattata = date('d M Y, H:i', strtotime($row['data'])); // Formatta la data
            $messaggi[] = [
                'username' => $row['username'],
                'testo' => $row['testo'],
                'data' => $data_formattata
            ];
        }
        $stmt->close();
        header('Content-Type: application/json');
        echo json_encode($messaggi);
    }
}
?>
