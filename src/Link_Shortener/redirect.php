<?php
require_once '../includes/db.php';
$conn = dataLinkShort();
require_once __DIR__ . '/function.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $code_short = $_GET['c'];

    $query = "SELECT original_link FROM links WHERE short_link = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $code_short);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $row = $result->fetch_assoc()) {
            header("Location: " . $row['original_link']);
            incrementVisits($conn, $code_short);
            exit;
        } else {
            echo "Link non trovato.";
        }
        $stmt->close();
    } else {
        error_log("Errore nella preparazione della query: " . $conn->error);
    }
} else {
    echo "URL non fornito.";
}
?>
