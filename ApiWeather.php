<?php require 'vendor/autoload.php'; // Charger les dépendances

use GuzzleHttp\Client;

// Créer un client HTTP

function getWeather($ville) {
try {
    $client = new Client();
    // Envoyer une requête GET vers l'API météo
    $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather', [
        'query' => [
            'q'     => "$ville", // Ville
            'appid' => '9dfe85f2e1010cfb7786171873f03285', // Clé API
            'units' => 'metric', // Unités en Celsius
            'lang'  => 'fr' // Langue en français
        ],
        'verify' => 'C:/laragon/bin/php/php-8.3.16-Win32-vs16-x64/extras/ssl/cacert.pem' // Chemin vers le fichier cacert.pem
    ]);

    // Décoder la réponse JSON
    $data = json_decode($response->getBody(), true);

    // Afficher les informations météo
    echo "Météo à " . $data['name'] . " : " . $data['weather'][0]['description'] . "<br>";
    echo "Température : " . $data['main']['temp'] . "°C<br>";
    echo "Humidité : " . $data['main']['humidity'] . "%<br>";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
} 
getWeather('Kyoto'); 

?>