<?php
require_once '../includes/db.php';
require_once __DIR__ . '/dashboard.php';
if($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $code_short =$_GET['c'];
    $query = "SELECT original_link FROM links WHERE short_link = '$code_short'";
    $result = $conn->query($query);
    if ($result && $row = $result->fetch_assoc()) {
        header("Location: " . $row['original_link']);
        incrementVisits($conn, $code_short);
        exit;
    } else {
        echo "Link non trovato.";
    }
} else {
    echo "URL non fornito.";
}
?>