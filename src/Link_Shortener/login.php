<?php
session_start();
require_once '../includes/db.php';
$conn = dataLinkShort();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica che i campi email e password siano presenti
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        // Nota: Considera di usare password_hash() e password_verify() per una maggiore sicurezza.
        $hash_pw = md5($password);
        
        $query = "SELECT * FROM utenti WHERE email = ? AND password = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $email, $hash_pw);
            $stmt->execute();
            
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION["user_id"] = $row['id'];
                $_SESSION["username"] = $row['username'];
                header("Location: front_dashboard.php");
                exit();
            } else {
                // Nessun utente trovato, credenziali errate
                header("Location: login.html?error=Errore%20credenziali");
                exit();
            }
            $stmt->close();
        } else {
            error_log("Errore nella preparazione della query: " . $conn->error);
            echo "Errore interno.";
        }
    } else {
        header("Location: login.html?error=Campi%20mancanti");
        exit();
    }
} else {
    echo "Errore: metodo non valido";
}
?>
