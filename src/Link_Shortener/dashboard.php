<?php
session_start();
require_once '../includes/db.php';

$changeMethod = 1;

if($_SERVER['REQUEST_METHOD']==='POST')
{
    if(isset($_POST['elimina']))
    {
        deliteLink($conn, $changeMethod);
    }
    else if(isset($_POST['rinomina']))
    {
        renameLink($conn, $changeMethod);
    }
 
}

//SECONDO METODO 
function createFilesPHP($conn, $short_link, $original_link, $user_id)
{
    //INSERISCO I DATI NEL DATABASE
    $query = "INSERT INTO links (short_link, original_link, id_user, method) VALUES ('$short_link', '$original_link', '$user_id', 1)";
    $conn->query($query);
     // Percorso della cartella dove salvare i file PHP
     $file_path = __DIR__ . "/$short_link";

     // Codice PHP per il file
     $php_code = "<?php\n";
     $php_code .= "require_once \$_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';\n";
     $php_code .= "require_once __DIR__ . '/dashboard.php';\n";
     $php_code .= "\$short_link = basename(\$_SERVER['PHP_SELF'], '.php');\n";
     $php_code .= "header('Location: $original_link');\n";
     $php_code .= "incrementVisits(\$conn, \$short_link);\n";
     $php_code .= "exit();\n";
 
     // Crea il file PHP
     file_put_contents($file_path, $php_code);
}

//PRIMO METODO 
function InsertLink_Redirect($conn, $short_link, $original_link, $user_id)
{
    $query = "INSERT INTO links (short_link, original_link, id_user, method) VALUES ('$short_link', '$original_link', '$user_id', 0)";
    $conn->query($query);
}
//METODO ELIMINA LINK
function deliteLink($conn, $changeMethod)
{
    $short_link = $_POST['short_link'];
    if($changeMethod == 1)
    {
        $file_path = __DIR__ . "/$short_link";
            if (file_exists($file_path))
            {
                unlink($file_path);
            }
    }
    $query = "DELETE FROM links WHERE short_link = '$short_link'";
    $conn->query($query);
    header('Location: front_dashboard.php');
    exit();
}

//RINOMINA LINK
function renameLink($conn, $changeMethod)
{
    if($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $old_short_link = $_POST['old_short_link'];
        $new_short_link = $_POST['new_short_link'];

        if (empty($old_short_link) || empty($new_short_link)) {
            header('Location: front_dashboard.php');
            exit; // Termina l'esecuzione
        }

        // Controllo che il nuovo nome non sia già usato
        $query_check = "SELECT * FROM links WHERE short_link = '$new_short_link'";
        $result = $conn->query($query_check);

        if ($result->num_rows > 0) {
            echo "Errore: Il nome scelto è già in uso.";
        } else {
            // Aggiorno il database
            $query_update = "UPDATE links SET short_link = '$new_short_link' WHERE short_link = '$old_short_link'";
            $conn->query($query_update);

            // Rinomina il file PHP se il metodo è 1 (file system)
            $old_file = __DIR__ . "/$old_short_link";
            $new_file = __DIR__ . "/$new_short_link";
            if (file_exists($old_file)) {
                rename($old_file, $new_file);
            }
            header('Location: front_dashboard.php');
            exit;
        }
    }
}

//INCREMENTO VISITE
function incrementVisits($conn, $short_link)
{
    $query = "UPDATE links SET visits = visits + 1 WHERE short_link = '$short_link'";
    $conn->query($query);
}

//CONTROLLO DUPLICATI
function checkDuplicateLink($conn, $short_link)
{
    $query = "SELECT * FROM links WHERE short_link = '$short_link'";
    $result = $conn->query($query);
    return $result->num_rows > 0;
}

// Recupera i link dal database
function getLinks($conn, $changeMethod)
{
    $id_user = $_SESSION['user_id'];
    $query = "SELECT * FROM links WHERE id_user = '$id_user' AND method = '$changeMethod'";
    $result = $conn->query($query);
    $links = [];
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $links[] = $row;
        }
    }
    
    return $links;
}

// Rendering della card per ogni link
function renderLinkCard($link, $changeMethod)
{
    $host = "3000-idx-docker-xampp-1738490528241.cluster-6yqpn75caneccvva7hjo4uejgk.cloudworkstations.dev";
    $shortLink = $link['short_link'];
    $originalLink = $link['original_link'];
    $visits = $link['visits'];
    
    if ($changeMethod == 0) {
        $url = "https://$host/Link_Shortener/redirect.php?c={$shortLink}";
        $linkType = "http://Link_Shortener.com/{$shortLink}";
    } else {
        $url = "https://$host/Link_Shortener/$shortLink";
        $linkType = "http://Link_Shortener.com/{$shortLink}";
    }
    
    $copy = "<button type='button' class='copy-btn' onclick='copyToClipboard(\"{$linkType}\")'><i class='bx bxs-copy'></i></button><br>";
    $deleteButton = "<button type='submit' name='elimina' class='delete-btn'><i class='bx bxs-eraser'></i></button><br>";
    $renameButton = "<button type='button' class='rename-btn' onclick='showRenameInput(\"{$shortLink}\")'><i class='bx bx-rename'></i></button>";
    
    // Variabile $renameform per il form di rinomina
    $renameform = "
    <div class='rename_form'>
        <form action='#' method='POST'>
            <input type='hidden' name='old_short_link' value='{$shortLink}'>
            <input type='text' class='rename_textbox' name='new_short_link' placeholder='Rinomina URL'>
            <button type='submit' name='rinomina'>Salva</button>
        </form>
    </div>";
    
    $linkCard = "
    <div class='link_card'>
        <div class='link_info'>
            <div class='sort_link'>
                <b>Link accorciato:</b> <a href='{$url}' class='short_link' target='_blank'>{$linkType}</a>
                <div class='original_link'><b>Link originale:</b> <a href='{$originalLink}'>{$originalLink}</a></div>
                <div class='visits'>Numero di visite: {$visits}</div>
            </div>
            <div class='actions'>
                <form action='dashboard.php' method='POST'>
                    <input type='hidden' name='short_link' value='{$shortLink}'>
                    {$copy}
                    {$deleteButton}
                </form>
                {$renameButton}
                
            </div>
            {$renameform}
        </div>
    </div>
    <script>
//Gestione copia
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
        alert('Link copiato negli appunti!');
        }).catch(err => {
        console.error('Errore nella copia:', err);
        });

    // Gestione del click per mostrare/nascondere il form di rinomina
    const container = document.querySelector('.links_listLink');
    if (container) {
        container.addEventListener('click', (event) => {
            console.log('Cliccato un elemento');
            const renameBtn = event.target.closest('.rename-btn');
            if (renameBtn) {
                const linkCard = renameBtn.closest('.link_card');
                console.log('Card selezionata:', linkCard);
                if (linkCard) {
                    linkCard.classList.toggle('expanded');
                }
            }
        });
    } else {
        console.log('Container non trovato!');
    }
    </script>
    ";
    
    return $linkCard;
}
?>
