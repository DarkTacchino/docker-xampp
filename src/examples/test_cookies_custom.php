<?php
// Verifica se il form è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera il nome e il valore del cookie dal form
    $cookie_name = $_POST['cookie_name'];
    $cookie_value = $_POST['cookie_value'];

    // Imposta il cookie con il nome e il valore forniti
    if (!empty($cookie_name) && !empty($cookie_value)) {
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // Scadenza: 30 giorni
        // Aggiorna manualmente $_COOKIE per visualizzare il nuovo cookie immediatamente
        $_COOKIE[$cookie_name] = $cookie_value;
        echo "<p>Cookie <strong>$cookie_name</strong> creato con successo!</p>";
    } else {
        echo "<p>Errore: il nome e il valore del cookie non possono essere vuoti.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Cookie</title>
</head>
<body>
    <h1>Crea un nuovo cookie</h1>
    <form method="POST" action="">
        <label for="cookie_name">Nome del cookie:</label>
        <input type="text" id="cookie_name" name="cookie_name" required>
        <br><br>
        <label for="cookie_value">Valore del cookie:</label>
        <input type="text" id="cookie_value" name="cookie_value" required>
        <br><br>
        <button type="submit">Crea Cookie</button>
    </form>

    <h2>Cookie attualmente in uso</h2>
    <?php
    if (!empty($_COOKIE)) {
        echo "<ul>";
        foreach ($_COOKIE as $name => $value) {
            echo "<li><strong>$name</strong>: $value</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nessun cookie attualmente in uso.</p>";
    }
    ?>
</body>
</html>