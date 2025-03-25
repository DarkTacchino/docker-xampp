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
    anti_injection($conn, $short_link, $original_link, $user_id, 1);
     // Percorso della cartella dove salvare i file PHP
     $file_path = __DIR__ . "/$short_link";

     // Codice PHP per il file
     $php_code = "<?php\n";
     $php_code .= "require_once \$_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';\n";
     $php_code .= "require_once __DIR__ . '/function.php';\n";
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
    anti_injection($conn, $short_link, $original_link, $user_id, 0);
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
        $query_check = "SELECT * FROM links WHERE short_link = ?";
        if ($stmt = $conn->prepare($query_check)) {
            $stmt->bind_param("s", $new_short_link);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        } else {
            error_log("Errore nella preparazione della query: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            header('Location: front_dashboard.php?error=Il nome scelto è già in uso⚠️');
            exit;
        } else 
        {
            // Aggiorno il database
            $query_update = "UPDATE links SET short_link = ? WHERE short_link = ?";
            if ($stmt = $conn->prepare($query_update)) {
                $stmt->bind_param("ss", $new_short_link, $old_short_link);
                if(!$stmt->execute()){
                    error_log("Errore nell'UPDATE del link: " . $stmt->error);
                }
                $stmt->close();
            } else {
                error_log("Errore nella preparazione dell'UPDATE: " . $conn->error);
            }

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
    $query = "SELECT * FROM links WHERE short_link = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $short_link);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        error_log("Errore nella preparazione della query: " . $conn->error);
    }

    return $result->num_rows > 0;
}

//PROTEZIONE ANTI INJECTION
function anti_injection($conn, $short_link, $original_link, $user_id, $method)
{
    $query ="INSERT INTO links (short_link, original_link, id_user, method) VALUES (?,?,?,?)";
    // Preparare la query
    if($stmt = $conn->prepare($query)) {
        // Bind dei parametri: "ssii" indica (string, string, integer, integer)
        $stmt->bind_param("ssii", $short_link, $original_link, $user_id, $method);
        
        // Esegue il prepared statement
        if(!$stmt->execute()){
            // Gestione dell'errore
            error_log("Errore nell'inserimento del link: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Errore nella preparazione della query: " . $conn->error);
    }
}

// RECUPERA I LINK DAL DATABASE
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
    
    //Creazione URL
    if ($changeMethod == 0) {
        $url = "https://$host/Link_Shortener/redirect.php?c={$shortLink}";
        $linkType = "http://Link_Shortener.com/{$shortLink}";
    } else {
        $url = "https://$host/Link_Shortener/$shortLink";
        $linkType = "http://Link_Shortener.com/{$shortLink}";
    }
    
    //Creazione tasti di funzionamento
    $copy = "<button type='button' class='copy-btn' onclick='copyToClipboard(\"{$url}\", event)'><i class='bx bxs-copy'></i></button><br>";
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
    
    //Variabile con il codice html e java per costruire la card view 
    $linkCard = "
    <div class='link_card'>
        <div class='link_info'>
                <div class='sort_link'><b>Link accorciato:</b><a href='#' class='short_link' onclick='openAndReload(\"{$url}\", \"{$originalLink}\"); return false;'>{$linkType}</a>
                <div class='original_link'><b>Link originale:</b><a href='{$originalLink}'>{$originalLink}</a>
</div>
                <div class='visits'>Numero di visite: {$visits}</div>
            </div>
            <div class='actions'>
                <form action='function.php' method='POST'>
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
//Ricarica pagina 
function openAndReload(url) {
    event.preventDefault(); // Evita l'azione predefinita del link
    
    // Apri subito il link in una nuova scheda
    window.open(url, '_blank'); 

    // Dopo 1 secondo ricarica la pagina per aggiornare la dashboard
    setTimeout(function() {
        location.reload();
    }, 1000);
}

    
// Mostra una notifica sotto il mouse per 1 secondo
function showCopiedNotification(x, y) {
    const notif = document.createElement('div');
    notif.className = 'copied-notification';
    notif.textContent = 'Link copiato!';
    // Posiziona la notifica un po' più in basso rispetto al cursore
    notif.style.left = x + 'px';
    notif.style.top = (y + 20) + 'px';
    document.body.appendChild(notif);

    // Dopo 1 secondo, avvia la transizione di dissolvenza e rimuovi l'elemento
    setTimeout(() => {
        notif.style.opacity = '0';
        setTimeout(() => {
            notif.remove();
        }, 300); // attende il termine della transizione
    }, 1000);
}

// Funzione per copiare usando la Clipboard API
function copyToClipboard(text, event) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text)
            .then(() => {
                if (event) {
                    showCopiedNotification(event.clientX, event.clientY);
                }
            })
            .catch(err => {
                console.error('Errore nella copia con Clipboard API:', err);
                fallbackCopyToClipboard(text, event);
            });
    } else {
        fallbackCopyToClipboard(text, event);
    }
}

// Metodo fallback per copiare
function fallbackCopyToClipboard(text, event) {
    const textArea = document.createElement('textarea');
    textArea.value = text;
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful && event) {
            showCopiedNotification(event.clientX, event.clientY);
        } else if (!successful) {
            console.error('Fallback: Impossibile copiare il testo.');
        }
    } catch (err) {
        console.error('Fallback: Errore durante la copia', err);
    }
    
    document.body.removeChild(textArea);
}


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
