<?php
session_start();

// Na Vercel, pegamos as credenciais pelas Variáveis de Ambiente por segurança
$host = getenv('DB_HOST'); 
$port = getenv('DB_PORT') ?: '5432'; // 5432 ou 6543 (pooler)
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    // A string de conexão muda para 'pgsql' (PostgreSQL)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
    $pdo = new PDO($dsn, $user, $password);
    
    // Configura o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Garante que os dados sejam retornados como arrays associativos
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Retorna erro em formato JSON caso a conexão falhe
    die(json_encode(['erro' => 'Falha na conexão com o banco de dados.']));
}
?>