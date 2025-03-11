<?php
// Dichiarazione di un array associativo
$persona = [
    "nome" => "Marco",
    "cognome" => "Rossi",
    "età" => 25,
    "professione" => "Ingegnere"
];

// Stampa le informazioni relative alla variabile
echo "Visualizzazione con metodo var_dump():<br>";
var_dump($persona);
echo "<br><br>";

// Accesso ai valori
echo "Accesso ai valori dell'array tramite la rispettiva chiave:<br>";
echo "Nome: " . $persona["nome"] . "<br>";
echo "Cognome: " . $persona["cognome"] . "<br>";
echo "Età: " . $persona["età"] . "<br>";
echo "Professione: " . $persona["professione"] . "<br>";

echo "<br><br>";

// Modifica di un valore
echo "Aggiornamento del campo età <br>";
$persona["età"] = 26;
echo "Età aggiornata: " . $persona["età"] . "<br>";

echo "<br><br>";

// Aggiunta di una nuova chiave-valore
echo "Aggiunta di una nuova entry (chiave-valore):<br>";
$persona["città"] = "Roma";
echo "Città: " . $persona["città"] . "<br>";

echo "<br><br>";

// Utilizzo di array_keys per ottenere le chiavi
echo "Utilizzo della funzione array_keys per prendere le chiavi:<br>";
$chiavi = array_keys($persona);
echo "\nChiavi dell'array:<br>";
print_r($chiavi);

echo "<br><br>";

// Iterazione su un array associativo
echo "Iterazione con foreach:<br>";
foreach ($persona as $chiave => $valore) {
    echo ucfirst($chiave) . ": " . $valore . "<br>";
}

echo "<br><br>";

// Controllo di esistenza di una chiave
echo "Controllo dell'esistenza di una chiave:<br>";
if (array_key_exists("email", $persona)) {
    echo "Email: " . $persona["email"] . "<br>";
} else {
    echo "Email non trovata.<br>";
}

echo "<br><br>";

// Rimozione di un elemento
echo "Rimozione di un elemento tramite funzione unset<br>";
unset($persona["professione"]);
echo "\nDopo aver rimosso 'professione':<br>";
foreach ($persona as $chiave => $valore) {
    echo ucfirst($chiave) . ": " . $valore . "<br>";
}
?>