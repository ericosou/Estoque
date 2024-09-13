<?php
session_start();

// Verifica se o formulário foi enviado e se os campos estão preenchidos
if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    header('Location: index.php');
    exit();
}

include('config.php'); // Inclui o arquivo de configuração que define $conn

// Obtém os valores do formulário e faz hash da senha
$usuario = $_POST['usuario'];
$senha = md5($_POST['senha']); // Note que md5 não é recomendado para senhas; considere usar password_hash e password_verify para segurança

// Prepara a consulta SQL para prevenir SQL Injection
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha";
$stmt = $conn->prepare($sql);
$stmt->execute(['usuario' => $usuario, 'senha' => $senha]);

$row = $stmt->fetch(PDO::FETCH_OBJ);

if ($row) {
    // Se o usuário for encontrado, configura as variáveis de sessão
    $_SESSION['usuario'] = $usuario;
    $_SESSION['nome'] = $row->nome;
    $_SESSION['tipo'] = $row->tipo;

    // Redireciona para a página principal após o login bem-sucedido
    header('Location: dashboard.php');
    exit();
} else {
    // Se o login falhar, exibe uma mensagem de erro e redireciona para a página de login
    echo "<script>alert('Usuário ou senha incorreto'); window.location.href='index.php';</script>";
}
?>
