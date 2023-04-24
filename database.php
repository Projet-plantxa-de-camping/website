{% block php %}
<?php

require_once __DIR__ . '/vendor/autoload.php';

session_start();
// Vérifiez que l'utilisateur est connecté
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];

    // Charger les variables d'environnement depuis le fichier .env
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

// Utiliser les variables d'environnement pour se connecter à la base de données
    $servername = $_ENV['DB_HOST'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    $dbname = $_ENV['DB_DATABASE'];

// Connexion à la base de données MySQL
    $conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifiez si la connexion à la base de données a réussi
    if (!$conn) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

// Requête SQL pour récupérer la valeur de "remaining_time" pour l'utilisateur connecté
    $query = "SELECT remaining_time FROM users WHERE id = $user_id";

// Exécutez la requête SQL et récupérez le résultat
    $result = mysqli_query($conn, $query);

// Vérifiez si la requête a réussi
    if (!$result) {
        die("La requête SQL a échoué : " . mysqli_error($conn));
    }

// Récupérez la valeur de "remaining_time" à partir du résultat de la requête SQL
    $row = mysqli_fetch_assoc($result);
    $remainingTimeFromDB = $row['remaining_time'];

// Fermez la connexion à la base de données
    mysqli_close($conn);
}

