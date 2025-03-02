<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'laylist';

try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Conexión fallida: " . $e->getMessage();
}
?>
