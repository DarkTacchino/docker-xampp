<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/db.php';
require_once __DIR__ . '/dashboard.php';
$short_link = basename($_SERVER['PHP_SELF'], '.php');
header('Location: ssc');
incrementVisits($conn, $short_link);
exit();
