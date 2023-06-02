<?php

$curl = curl_init();

$url = "https://eu-central-1.aws.data.mongodb-api.com/app/data-xkcms/endpoint/data/v1/action/findOne";
$headers = array(
    "Content-Type: application/json",
    "Access-Control-Request-Headers: *",
    "api-key: <API_KEY>"
);
$data = array(
    "collection" => "<COLLECTION_NAME>",
    "database" => "<DATABASE_NAME>",
    "dataSource" => "Scores",
    "projection" => array("_id" => 1)
);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($curl);

if ($response === false) {
    $error = curl_error($curl);
    // Gérer l'erreur de la requête
} else {
    // Traiter la réponse
    echo $response;
}

curl_close($curl);

?>
