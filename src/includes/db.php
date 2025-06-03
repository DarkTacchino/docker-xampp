<?php
function dataClassRoom()
{
    $host = 'db';  
    $dbname = 'chat_room'; 
    
    $user = 'user';
    $password = 'user';
    $port = 3306;
    $conn = new mysqli($host, $user, $password, $dbname, $port);

    if ($conn->connect_error) 
    {
        die("Errore di connessione: " . $conn->connect_error);  
    }  
    return $conn; 
}

function dataLinkShort()
{
    $host = 'db';  
    $dbname = 'link_shortener'; 
    
    $user = 'user';
    $password = 'user';
    $port = 3306;
    $conn = new mysqli($host, $user, $password, $dbname, $port);

    if ($conn->connect_error) 
    {
        die("Errore di connessione: " . $conn->connect_error);  
    }  
    return $conn; 
}
