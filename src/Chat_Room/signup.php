<?php
session_start();
require_once '../includes/db.php'; //connessione al database
$conn = dataClassRoom();
$username = $_POST['username']; //Prendo i dati dal form
$email = $_POST['email'];
$password = $_POST['password'];

//Inserisco i nuovi dati nel datbase 
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($username) && !empty($password))
{
    // Controlla se l'utente esiste già nel database
    $query = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $conn->query($query);
    
    if (mysqli_num_rows($result) > 0) 
    {
        // L'utente esiste già
        echo "Username o email già esistenti!";
        echo "<p>Errore nei campi  <a href=\"signup.html\">torna nella pagina registrazione</a></p>";
    } 
    else 
    {
        // Prepara la query per inserire il nuovo utente
        $insert_query = "INSERT INTO utenti (username, email, password) VALUES ('$username', '$email', '$password')";

        // Esegui la query di inserimento
        if ($conn->query($insert_query)) 
        {
        // Esegui la query per recuperare l'utente appena registrato
        $query = "SELECT id, username FROM utenti WHERE email = '$email'";
        $result = $conn->query($query);  
        // Login riuscito, prendi l'ID dell'utente e imposta la sessione
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id']; // Salva l'ID dell'utente nella sessione
        $_SESSION['username'] = $user['username'];
            // Registrazione riuscita
            header("Location: room.html"); // Reindirizza l'utente alla pagina di login
            exit();
        }
        else
        {
            // Se c'è un errore nell'inserimento
            echo "Errore nella registrazione: " . mysqli_error($conn);
            echo "<p>Errore nei campi  <a href=\"signup.html\">torna nella pagina registrazione</a></p>";
        }
    }
    
            
    
}
?>
