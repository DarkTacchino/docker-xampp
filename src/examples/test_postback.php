<?php
// Inizializza le variabili
$name = "";
$email = "";
$message = "";
$error = "";

// Verifica se il modulo è stato inviato (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera i dati dal modulo
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Validazione dei dati
    if (empty($name)) {
        $error = "Il nome è obbligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "L'email non è valida.";
    } elseif (empty($message)) {
        $error = "Il messaggio è obbligatorio.";
    } else {
        // Se i dati sono validi, puoi elaborarli (es. salvare in un database)
        // Qui mostriamo solo un messaggio di successo
        $info = "Grazie, $name! Il tuo messaggio è stato inviato.";
        // Resetta i campi del modulo
        $name = $email = $message = "";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Esempio di Postback in PHP</title>
</head>
<body>
    <h1>Modulo di Contatto</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php elseif (!empty($info)): ?>
        <p style="color: green;"><?php echo $info; ?></p>
    <?php endif; ?>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <br><br>

        <label for="message">Messaggio:</label>
        <textarea id="message" name="message"><?php echo htmlspecialchars($message); ?></textarea>
        <br><br>

        <button type="submit">Invia</button>
    </form>
</body>
</html>