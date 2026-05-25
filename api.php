<?php
require 'conexao.php';
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['erro' => 'Não autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY concluida ASC, data_tarefa ASC");
    $stmt->execute([$usuario_id]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} elseif ($metodo === 'POST') {
    $dados = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO tarefas (usuario_id, titulo, data_tarefa) VALUES (?, ?, ?)");
    $stmt->execute([$usuario_id, $dados['titulo'], $dados['data']]);
    echo json_encode(['sucesso' => true]);

} elseif ($metodo === 'PUT') {
    $dados = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE tarefas SET concluida = NOT concluida WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$dados['id'], $usuario_id]);
    echo json_encode(['sucesso' => true]);

} elseif ($metodo === 'DELETE') {
    $dados = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$dados['id'], $usuario_id]);
    echo json_encode(['sucesso' => true]);
}
?>