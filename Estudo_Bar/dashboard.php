<?php
session_start();

// Verifica se a sessão está ativa, se não estiver, redireciona para o login
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .navbar-nav {
            flex: 1;
            justify-content: center;
        }
        .navbar-nav .nav-item {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Exibe o nome do usuário no lugar do texto "Sistema X" -->
            <span class="navbar-brand">Olá, <?php echo $_SESSION["nome"]; ?></span>
            <div class="d-flex">
                <a href='estoque.php' class='btn btn-info ms-2'>Estoque</a>
                <a href='logout.php' class='btn btn-danger ms-2'>Sair</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="mb-4">Cadastro de Bebidas</h1>
        
        <?php
        include 'config.php'; // Inclui o arquivo de configuração que define $conn

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Coleta dados do formulário
            $nome = $_POST['nome'];
            $quantidade = $_POST['quantidade'];
            $data_validade = $_POST['data_validade'];

            try {
                // Insere dados no banco de dados
                $sql = "INSERT INTO bebidas (nome, quantidade, data_validade) VALUES (:nome, :quantidade, :data_validade)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'nome' => $nome,
                    'quantidade' => $quantidade,
                    'data_validade' => $data_validade
                ]);

                echo '<div class="alert alert-success" role="alert">Bebida cadastrada com sucesso!</div>';
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger" role="alert">Erro ao cadastrar bebida: ' . $e->getMessage() . '</div>';
            }
        }
        ?>
        <!-- Formulário de cadastro -->
        <form method="post" action="">
            <div class="form-group">
                <label for="nome">Nome da Bebida</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="quantidade">Quantidade</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>
            <div class="form-group">
                <label for="data_validade">Data de Validade</label>
                <input type="date" class="form-control" id="data_validade" name="data_validade" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar Bebida</button>
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
