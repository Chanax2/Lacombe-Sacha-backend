<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Harry Potter API</h1>
    <h2>Essayez ces noms:<br/>
    harry-potter

    ron-weasley

    draco-malfoy

    hermione-granger</h2>
    <?php

    require 'vendor/autoload.php'; // Charger les dépendances

    use GuzzleHttp\Client;
    $client = new Client([
        'verify' => false // Disable SSL verification
    ]);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $HPNAME = htmlspecialchars($_POST['HP_Name']);
        echo "Vous avez recherché : " . $HPNAME . "<br>";
        get_HP_Character($HPNAME); // Fetch and display character info
    } else {
        echo '<form method="POST" action="">
            <label for="HP_Name">Entrez le nom d\'un Personnage d\'Harry Potter :</label>
            <input type="text" id="HP_Name" name="HP_Name" required>
            <button type="submit">Rechercher</button>
        </form>';
    }

    function get_HP_Character($name) {
        global $client; 
        try {
            $response = $client->request('GET', "https://hp-api.lainocs.fr/characters/$name");
            $body = $response->getBody();
            $data = json_decode($body, true); 

            // echo les infos
            echo "<h3>Character Information:</h3>";
            echo "Name: " . $data['name'] . "<br>";
            echo "House: " . $data['house'] . "<br>";
            echo "Actor: " . $data['actor'] . "<br>";
            echo "Wand: " . $data['wand'] . "<br>";
            echo "Patronus: " . $data['patronus'] . "<br>";
            echo "<img src='" . $data['image'] . "' alt='Character Image' style='width:200px;'><br>";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }

    ?>
</body>
</html>