<?php
require 'conexao.php';
header('Content-Type: application/json');

$dados = json_decode(file_get_contents('php://input'), true);
$acao = $dados['acao'] ?? '';

if ($acao === 'registrar') {
    $nome = $dados['nome'];
    $email = $dados['email'];
    $senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
        $stmt->execute([$nome, $email, $senha]);
        echo json_encode(['sucesso' => true, 'msg' => 'Conta criada com sucesso! Faça login.']);
    } catch (Exception $e) {
        echo json_encode(['sucesso' => false, 'msg' => 'E-mail já cadastrado.']);
    }
} elseif ($acao === 'login') {
    $email = $dados['email'];
    $senha = $dados['senha'];
    
    $stmt = $pdo->prepare("SELECT id, senha FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'msg' => 'Usuário ou senha incorretos.']);
    }
} elseif ($acao === 'logout') {
    session_destroy();
    echo json_encode(['sucesso' => true]);
}
?>