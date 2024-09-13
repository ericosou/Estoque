<?php
session_start();
include 'config.php'; // Inclua a configuração do banco de dados

// Verifica se o usuário está logado
if (empty($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Função para formatar data no formato "dia, mês, ano"
function formatarData($data) {
    $meses = [
        'January' => 'Janeiro',
        'February' => 'Fevereiro',
        'March' => 'Março',
        'April' => 'Abril',
        'May' => 'Maio',
        'June' => 'Junho',
        'July' => 'Julho',
        'August' => 'Agosto',
        'September' => 'Setembro',
        'October' => 'Outubro',
        'November' => 'Novembro',
        'December' => 'Dezembro'
    ];

    $date = new DateTime($data);
    $dia = $date->format('d');
    $mes = $date->format('F');
    $ano = $date->format('Y');

    $mes_portugues = isset($meses[$mes]) ? $meses[$mes] : $mes;

    return "{$dia}, {$mes_portugues}, {$ano}";
}

// Processa a exclusão se o ID for fornecido
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    try {
        $sql = "DELETE FROM bebidas WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        header('Location: estoque.php');
        exit();
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">Erro ao excluir bebida: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estoque de Bebidas</title>
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
                <a href='dashboard.php' class='btn btn-info ms-2'>Cadastro</a>
                <a href='logout.php' class='btn btn-danger ms-2'>Sair</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1 class="mb-4">Estoque de Bebidas</h1>

        <!-- Tabela de Estoque -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Data de Validade</th>
                    <th>Ação</th> <!-- Nova coluna para ações -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Seleciona todas as bebidas do banco de dados
                $sql = "SELECT * FROM bebidas ORDER BY data_validade";
                $stmt = $conn->query($sql);
                $bebidas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Exibe as bebidas na tabela
                foreach ($bebidas as $bebida) {
                    echo "<tr>
                        <td>{$bebida['id']}</td>
                        <td>{$bebida['nome']}</td>
                        <td>{$bebida['quantidade']}</td>
                        <td>" . formatarData($bebida['data_validade']) . "</td>
                        <td>
                            <a href='estoque.php?delete={$bebida['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir?\");'>Excluir</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Notificação de Validade -->
        <?php
        $data_atual = date('Y-m-d');
        $antecedencia = 30; // Defina o valor padrão ou obtenha de configuração

        // Seleciona bebidas que estão próximas da validade
        $sql = "SELECT * FROM bebidas WHERE data_validade <= DATE_ADD(:data_atual, INTERVAL :antecedencia DAY)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['data_atual' => $data_atual, 'antecedencia' => $antecedencia]);
        $bebidas_proximas_validade = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Exibe a lista de bebidas próximas da validade
        if (count($bebidas_proximas_validade) > 0) {
            echo "<h2 class='mt-5'>Bebidas Próximas da Validade:</h2>";
            echo "<ul class='list-group'>";
            foreach ($bebidas_proximas_validade as $bebida) {
                echo "<li class='list-group-item'>
                    {$bebida['nome']} - Validade: " . formatarData($bebida['data_validade']) . "
                </li>";
            }
            echo "</ul>";
        } else {
            echo "<p class='mt-5'>Não há bebidas próximas da validade.</p>";
        }
        ?>
    </div>

    <!-- Inclusão dos scripts do Bootstrap -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
