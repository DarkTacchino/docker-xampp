<?php
require_once '../includes/db.php';
require_once '../Style/index.php';

require_once __DIR__ . '/dashboard.php';
// Controlla se l'utente è loggato
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"])) 
{
    die("Devi essere loggato per accedere a questa pagina.");
}

//CONTROLLO SE IL METODO UTILIZZATO è POST
if($_SERVER['REQUEST_METHOD']==='POST')
{
    $user_id = $_SESSION['user_id'];
    $original_link = $_POST['original_link'];
    $short_link = substr(md5($original_link), 0, 6);
    //CONTROLLO PRIMA SE ESISTE GIà
    if (checkDuplicateLink($conn, $short_link)) {
        echo "<script>showToast('Questo link è già stato abbreviato.')</script>";
    } else 
    {
         //CONDIZIONE PER CAPIRE CHE METODO UTILIZZARE
        if($changeMethod == 0)
        {
            InsertLink_Redirect($conn, $short_link, $original_link, $user_id);
        }
        else
        {
            createFilesPHP($conn, $short_link, $original_link, $user_id);
        }
    }
   
}
?>
<!-- CREAZIONE CODE HTML TASTO E PULSANTI -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link_Shortener</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="styles.css">
   
</head>
<body>
   
    <div class="container">
        <h1>Link Shortener</h1>

        <!-- Form per inserire un nuovo URL -->
        <form method="post" action="front_dashboard.php">
        <div class="form_crea">
            <label for="original_link"></label>
            <input type="text" id="original_link" name="original_link" placeholder="Inserire URL" required><br>
            <input type="submit" value="Crea">
        </div>
        </form>

        <!-- Lista dei link abbreviati -->
        <div class="links_listLink">
            <?php
                // Ottieni i dati dei link dal database
                $links = getLinks($conn, $changeMethod);

                // Ciclo per stampare ogni link in formato card
                if (!empty($links)) {
                    foreach ($links as $link) {
                        echo renderLinkCard($link, $changeMethod);
                    }
                } else {
                    echo "<p>Nessun link creato da te: " . $_SESSION["username"] . "</p>";
                }
            ?>
        </div>
    </div>
</body>
<script>
function showToast(message) {
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            toast.remove();
        }, 300); // attende la fine della transizione
    }, 10000); // la notifica rimane visibile per 1 secondo
}
</script>

</html>

