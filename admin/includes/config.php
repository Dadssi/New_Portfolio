<?php
$host = "localhost";
$dbname = "portfolio_db";
$username = "root";
$password = "root";

// Connexion MySQL
$conn = new mysqli($host, $username, $password, $dbname);

// Vérification
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}
?>
