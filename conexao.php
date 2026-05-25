<?php
session_start();

$host = 'localhost';
$dbname = 'agenda_db';
$user = 'root';
$pass = ''; // Senha padrão do XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['erro' => 'Falha na conexão com o banco de dados.']));
}
?>