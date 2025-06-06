<?php
session_start();
require_once '../includes/db.php';
$conn = dataLinkShort();

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $query = "SELECT * FROM utenti WHERE email = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            echo "Utente già esistente";
        } else {  // <--- Sposta else qui
            $hash_pw = md5($password);
            $insert_query = "INSERT INTO utenti (username, email, password) VALUES (?, ?, ?)";
            
            if ($stmt = $conn->prepare($insert_query)) {
                $stmt->bind_param("sss", $username, $email, $hash_pw);
                
                if (!$stmt->execute()) {
                    error_log("Errore nell'inserimento dell'utente: " . $stmt->error);
                }
                
                $stmt->close();
                header("Location: login.html");
                exit();  // Importante per evitare esecuzioni indesiderate
            } else {
                error_log("Errore nella preparazione della query: " . $conn->error);
            }
        }
        $stmt->close();
    } else {
        error_log("Errore nella preparazione della query: " . $conn->error);
    }
} else {
    echo "Errore";
}
?>
