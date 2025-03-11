<?php
session_start();
require_once '../includes/db.php';
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
if($_SERVER['REQUEST_METHOD'] === "POST")
{
    $query = "SELECT * FROM utenti WHERE email = '$email'";
    $result = $conn->query($query);
    if(mysqli_num_rows($result) > 0)
    {
        echo "Utente gia esistente";
    }
    else
    {
        $hash_pw = md5($password);
        $insert_query = "INSERT INTO utenti (username, email, password) VALUES ('$username', '$email', '$hash_pw')";
        $result = $conn->query($insert_query);
        header("Location: login.html");
    }

}
else
{
echo "errore";
}
?>