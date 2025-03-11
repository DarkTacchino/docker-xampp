<?php
$cookie_name = 'visite';

if (isset($_COOKIE[$cookie_name]))
    $visite = $_COOKIE[$cookie_name] + 1;
else
    $visite = 1;

setcookie($cookie_name, $visite, time() + (86400 * 30));

echo "Hai visitato questa pagina " . $visite . " volte.";
?>