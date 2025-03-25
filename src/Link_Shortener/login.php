<?php
session_start();
require_once '../includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $hash_pw = md5($password);
    $query = "SELECT * FROM utenti WHERE email='$email' AND password = '$hash_pw'";   
    $result = $conn->query($query);
    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
        $_SESSION["user_id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        header("Location: front_dashboard.php");
    }
    else
    {
        echo "errore! <br>";
    }
    print_r ($_POST);
}
else
{
    echo "errore";
}

?>