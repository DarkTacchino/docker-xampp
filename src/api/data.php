<?php
    header('Content-Type: application/json');

    $data = [
        ['nome' => 'Mario', 'cognome' => 'Rossi', 'email' => 'mario.rossi@example.it'],
        ['nome' => 'Nicola', 'cognome' => 'Damico', 'email' => 'nicola.damico@example.it'],
        ['nome' => 'Riccardo', 'cognome' => 'Ilari', 'email' => 'riccardo.ilari@example.it']
    ];

    echo json_encode($data);
?>
