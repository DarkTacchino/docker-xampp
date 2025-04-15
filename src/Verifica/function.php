<?php
// Collegamento al database 
$host = 'db'; 
$dbname = 'kartodromo'; 
$user = 'user';
$password = 'user';
$port = 3306;

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Errore di connessione: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Salvo solo l'email nella sessione
    if (isset($_POST["email"])) {
        $_SESSION["email"] = $_POST["email"];
    } else {
        die("Email mancante.");
    }

    // Controllo se è login o registrazione
    if (isset($_POST["nome"]) && isset($_POST["cognome"])) {
        $query = "INSERT INTO utenti (nome, cognome, email, password) VALUES (?,?,?,?)";
        $stmt = $conn-> prepare($query);
        $stmt -> bind_param("ssss", $_POST["nome"], $_POST["cognome"], $_POST["email"], $_POST["password"]);
        $stmt -> execute();
        $stmt -> close();
        header("Location: storico.html");
    }
    else if (isset($_POST["ruolòo"]))
    {
        caricaDati();
        header("Location: gestore.html");
    }
    else
    {
        $query = "SELECT * FROM utenti WHERE email = ? AND password = ?";
        $stmt = $conn-> prepare($query);
        $stmt -> bind_param("ss", $_POST["email"], $_POST["password"]);
        $stmt -> execute();
        $result = $stmt->get_result();
        if($result && mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            if($row["ruolo"] == "admin")
            {
                header("Location: gestore.html");
            }
            else
            {
                header("Location: storico.html");
            }
        }
    }
    
}

function caricaDati() 
{
    
}
    

?>
