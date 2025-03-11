<?php
require_once '../includes/db.php';

xdebug_info();

$table = $_GET["table"];
$query = "SELECT * FROM $table";
$result = $conn->query($query);

//stampo il contenuto della tabella se ci sono delle righe
if ($result->num_rows > 0)
{
    echo "<table border='1'>";

    //stampo le colonne
    while ($column = $result->fetch_field())
    {
        echo "<th> $column->name </th>";
    }

    // stampa i dati delle righe
    // usa l'oggetto $result ritornato dalla query per iterare le righe
    // il metodo fetch_assoc ritorna un associative array con i dati della riga corrente
    // poi passa alla riga successiva 
    while ($row = $result->fetch_assoc())
    {
        echo "<tr>";

        foreach ($row as $key => $value)
        {
            echo "<td> $value </td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}


