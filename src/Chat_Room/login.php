<?php
session_start();
require_once '../includes/db.php'; //connessione al database
//Controllo presenza parametri login
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $email = $_POST['email']; //Prendo i dati dal form
    $password = $_POST['password'];
    $query = "SELECT * FROM utenti WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($query);
    if (mysqli_num_rows($result) > 0) 
    {
        // Login riuscito, prendi l'ID dell'utente e imposta la sessione
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id']; // Salva l'ID dell'utente nella sessione
        $_SESSION['username'] = $user['username'];

        // Login riuscito, fai il login dell'utente
        header("Location: room.html");
        echo "ciao";
    } 
    else 
    {
        // Login fallito
        echo "Login fallito!";
        echo "<p>Errore nei campi  <a href=\"login.html\">torna nella pagina login</a></p>";
    }
            
    
}
?>
