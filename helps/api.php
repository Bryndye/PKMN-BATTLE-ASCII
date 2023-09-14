<?php
$url = 'https://pokeapi.co/api/v2/generation/1';

$options = [
    'http' => [
        'method' => 'GET',
        'header' => 'Content-Type: application/json',
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response !== false) {
    // Traitement de la réponse
    echo $response;
} else {
    // Gestion de l'erreur
    echo 'Erreur lors de la requête GET';
}

?>