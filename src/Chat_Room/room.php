<?php
// Abilita la visualizzazione degli errori per il debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once '../includes/db.php'; // Connessione al databasephp 

// Verifica se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    echo "Devi essere loggato per accedere a questa pagina.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'crea_stanza') 
{
    // Ottieni i dati inviati dal modulo
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];

    $query = "INSERT INTO stanze (nome, descrizione) VALUES ('$nome', '$descrizione')";
    if (mysqli_query($conn, $query)) 
    {
        $id_stanza = mysqli_insert_id($conn); // Recupera l'ID della stanza appena creata
        // Inserisce l'associazione nella tabella "scrive"
        $user_id = $_SESSION['user_id'];
        $query_associazione = "INSERT INTO scrive (id_utente, id_stanza) VALUES ('$user_id', '$id_stanza')";
        if (mysqli_query($conn, $query_associazione)) 
        {
            echo "Stanza creata e associazione aggiunta con successo!";
        } 
        else 
        {
            echo "Errore nell'associare l'utente alla stanza: " . mysqli_error($conn);
        }
    } 
    else 
    {
        echo "Errore nella creazione della stanza: " . mysqli_error($conn);
    }

}

if ($_GET['action'] === 'get_stanze') {
    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT s.id, s.nome, s.descrizione
              FROM stanze s
              JOIN scrive sc ON s.id = sc.id_stanza
              WHERE sc.id_utente = '$user_id'";
    $result = mysqli_query($conn, $query);
    
    header('Content-Type: application/json');

    if ($result) {
        $stanze = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($stanze);
    } else {
        echo json_encode(["error" => mysqli_error($conn)]);
    }
    exit();
}
?>