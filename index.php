<?php
session_start();
require_once "conexao/conexao.php";

function hasAccessLevel($levels)
{
    global $conn;

    // Assegura que $levels é um array (É om esse vetor que a gente separa quem enxerga determinadas funções na tela)
    if (!is_array($levels)) {
        $levels = [$levels];
    }

    // Verifica se o usuário logado possui um dos níveis de acesso fornecidos
    if (isset($_SESSION["idnivel_acesso"]) && in_array($_SESSION["idnivel_acesso"], $levels)) {
        return true;
    }

    return false;
}

function logout()
{
    session_unset();
    session_destroy();
    header("Location: usuario/login.php");
    exit;
}

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: usuario/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Gestão de Propriedades</title>
    <link rel="stylesheet" href="style/style_index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <h1>Painel de Controle - Gestão de Propriedades</h1>
        <h3><?php echo "Bem Vindo, " . $_SESSION['nome_usuario'] . " ! "; ?></h3>
        <button id="notification-btn">🔔 Notificações</button>
    </header>

    <!-- Popup de notificações -->
    <div class="notification-popup" id="notification-popup">
        <span class="close-btn" id="close-btn">&times;</span>
        <h3>Notificações</h3>

        <?php
        // Marcar todas as notificações como lidas se o botão for pressionado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_lida'])) {
            $sqlMarcarLida = "UPDATE logs SET lida = 1 WHERE id_usuario = ? OR nivel_acesso <= ?";
            if ($stmtLida = $conn->prepare($sqlMarcarLida)) {
                $stmtLida->bind_param("ii", $_SESSION['idusuario'], $_SESSION['idnivel_acesso']);
                $stmtLida->execute();
                $stmtLida->close();
                echo "<p>Notificações marcadas como lidas!</p>";
            } else {
                echo "<p>Erro ao marcar notificações como lidas: " . $conn->error . "</p>";
            }
        }

        // Marcar notificação individual se o botão for pressionado
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marcar_como_lida'])) {
            $notificacaoId = $_POST['notificacao_id'];

            // Atualiza o campo `lida` para 1 apenas para a notificação selecionada
            $sqlMarcarComoLida = "UPDATE logs SET lida = 1 WHERE id = ?";

            if ($stmtMarcarComoLida = $conn->prepare($sqlMarcarComoLida)) {
                $stmtMarcarComoLida->bind_param("i", $notificacaoId);

                if ($stmtMarcarComoLida->execute()) {
                    echo "<p>Notificação marcada como lida!</p>";
                } else {
                    echo "<p>Erro ao atualizar a notificação: " . $stmtMarcarComoLida->error . "</p>";
                }

                $stmtMarcarComoLida->close();
            } else {
                echo "<p>Erro ao preparar a consulta de atualização: " . $conn->error . "</p>";
            }
        }

        $nivelDeAcesso = $_SESSION["idnivel_acesso"];

        // Consulta para obter notificações não lidas
        $sqlNotificacoes = "SELECT id, acao, descricao, data, id_usuario, nivel_acesso 
        FROM logs 
        WHERE ($nivelDeAcesso = 1 OR id_usuario = ?) AND lida = 0 
        ORDER BY data DESC 
        LIMIT 5";

        if ($stmt = $conn->prepare($sqlNotificacoes)) {
            // Bind para o id do usuário logado e nivel_acesso da sessão
            $stmt->bind_param("i", $_SESSION['idusuario']);

            if ($stmt->execute()) {
                $result1 = $stmt->get_result();

                if ($result1->num_rows > 0) {
                    // Exibir notificações
                    while ($log = $result1->fetch_assoc()) {
                        echo '<div class="notificacao-item">';
                        echo '<p><strong>Ação:</strong> ' . htmlspecialchars($log['acao']) . '</p>';
                        echo '<p><strong>Descrição:</strong> ' . htmlspecialchars($log['descricao']) . '</p>';
                        echo '<p><strong>Data:</strong> ' . date('d/m/Y H:i:s', strtotime($log['data'])) . '</p>';
                        echo '<form method="POST">';
                        echo '<input type="hidden" name="notificacao_id" value="' . $log['id'] . '">';
                        echo '<button class="teste" type="submit" name="marcar_como_lida">Marcar como lida</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>Não há notificações não lidas.</p>";
                }
            } else {
                echo "<p>Erro na consulta de notificações: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p>Erro ao preparar consulta: " . $conn->error . "</p>";
        }
        ?>

        <!-- Botão para Marcar Todas como Lida -->
        <form method="POST">
            <button type="submit" name="marcar_lida">Marcar todas como lidas</button>
        </form>
    </div>

    <nav class="menu-lateral">
        <div class="btn-expandir">
            <i class="bi bi-list"></i>
        </div>

        <ul>
            <?php if (hasAccessLevel([1])): ?>
                <li class="item-menu">
                    <a href="usuario/listar_usuarios.php">
                        <span class="icon"><i class="bi bi-person-add"></i></span>
                        <span class="txt-link">Usuários</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (hasAccessLevel([1])): ?>
                <li class="item-menu">
                    <a href="propriedade/listar_propriedades.php">
                        <span class="icon"><i class="bi bi-shop"></i></span>
                        <span class="txt-link">Propriedades</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (hasAccessLevel([1])): ?>
                <li class="item-menu">
                    <a href="cliente/listar_clientes.php">
                        <span class="icon"><i class="bi bi-person-vcard-fill"></i></span>
                        <span class="txt-link">Clientes</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (hasAccessLevel([2])): ?>
                <li class="item-menu">
                    <a href="pagamentos/pag_cliente.php">
                        <span class="icon"><i class="bi bi-wallet2"></i></span>
                        <span class="txt-link">Financeiro</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if (hasAccessLevel([1])): ?>
                <li class="item-menu">
                    <a href="pagamentos/controle_financas.php">
                        <span class="icon"><i class="bi bi-currency-dollar"></i></span>
                        <span class="txt-link">Finanças</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="item-menu">
                <a href="contrato/listar_contratos.php">
                    <span class="icon"><i class="bi bi-archive-fill"></i></span>
                    <span class="txt-link">Contratos</span>
                </a>
            </li>

            <?php if (hasAccessLevel([1])): ?>
                <li class="item-menu">
                    <a href="localidade/cadastro_cidade.php">
                        <span class="icon"><i class="bi bi-geo-alt-fill"></i></span>
                        <span class="txt-link">Localidades</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Botões de Backup -->
            <?php if (hasAccessLevel([1])): ?>
                <li class="item-menu">
                    <a href="backup/banco_de_dados/gerar_backup.php">
                        <span class="icon"><i class="bi bi-cloud-arrow-down-fill"></i></span>
                        <span class="txt-link">Fazer Backup</span>
                    </a>
                </li>
                <li class="item-menu">
                    <a href="backup/banco_de_dados/restaurar.php">
                        <span class="icon"><i class="bi bi-cloud-upload-fill"></i></span>
                        <span class="txt-link">Restaurar Backup</span>
                    </a>
                </li>
            <?php endif; ?>

            <li>
                <form action="" method="POST" class="logout-form">
                    <button type="submit" name="logout">
                        <span class="icon"><i class="bi bi-box-arrow-right"></i></span>
                        <span class="txt-link">Sair</span>
                    </button>
                    <?php
                    if (isset($_POST["logout"])) {
                        logout();
                    }
                    ?>
                </form>
            </li>
        </ul>
    </nav>

    <main>
        <section>
            <h2>Bem-vindo ao Sistema de Gestão de Propriedades</h2>
            <p>Escolha uma das opções no menu lateral para gerenciar suas propriedades e locações.</p>
        </section>

        <!-- Seção de Propriedades Disponíveis -->
        <section>
            <h2>Suas Propriedades</h2>
            <p>Escolha uma das propriedades para realizar alguma operação</p>

            <h3>Propriedades Disponíveis</h3>
            <?php if (hasAccessLevel([1])): ?>
                <div class="propriedades-container">
                    <?php
                    $limite = 6;
                    // Consulta para obter as últimas propriedades cadastradas
                    $sql = "SELECT p.*, t.nome_tipo, l.nome_cidade, s.nome_situacao, e.sigla 
                            FROM propriedade p 
                            JOIN tipo_prop t ON p.id_tipo_prop = t.id_tipo_prop
                            JOIN localizacao l ON p.id_localizacao = l.idlocalizacao
                            JOIN situacao s ON p.id_situacao = s.id_situacao
                            JOIN estados e ON l.id_estado = e.id_estado 
                            ORDER BY idpropriedade DESC 
                            LIMIT $limite";

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $detalhesUrl = 'propriedade/detalhes_propriedade.php?id=' . $row['idpropriedade'];
                            echo '<a href="' . $detalhesUrl . '" class="propriedade-link">';
                            echo '<div class="propriedade-item">';
                            echo '<h4>' . htmlspecialchars($row['nome_propriedade']) . '</h4>';
                            echo '<p>Localização: ' . htmlspecialchars($row['nome_cidade']) . '</p>';
                            echo '<p>Valor: R$ ' . number_format($row['valor_adquirido'], 2, ',', '.') . '</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo '<p>Nenhuma propriedade encontrada.</p>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <!-- Exibir propriedades para nível de acesso 2 -->
            <?php if (hasAccessLevel([2])): ?>
                <div class="propriedades-container">
                    <?php
                    $id_cliente = $_SESSION["id_cliente"];
                    $sql = "SELECT contratos.*, propriedade.nome_propriedade, contratos.vencimento 
                            FROM contratos 
                            JOIN propriedade ON contratos.id_propriedade = propriedade.idpropriedade 
                            WHERE id_cliente = $id_cliente";

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $detalhesUrl = 'propriedade/detalhes_propriedade_cliente.php?id=' . $row['id_propriedade'];
                            echo '<a href="' . $detalhesUrl . '" class="propriedade-link">';
                            echo '<div class="propriedade-item">';
                            echo '<h4>' . htmlspecialchars($row['nome_propriedade']) . '</h4>';
                            echo '</div>';
                            echo '</a>';
                        }
                    } else {
                        echo '<p>Nenhuma propriedade encontrada.</p>';
                    }
                    ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script>
        const notificationBtn = document.getElementById('notification-btn');
        const notificationPopup = document.getElementById('notification-popup');
        const closeBtn = document.getElementById('close-btn');

        notificationBtn.addEventListener('click', () => {
            notificationPopup.style.display = notificationPopup.style.display === 'block' ? 'none' : 'block';
        });

        closeBtn.addEventListener('click', () => {
            notificationPopup.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target !== notificationBtn && !notificationPopup.contains(event.target)) {
                notificationPopup.style.display = 'none';
            }
        });
    </script>
</body>

</html>
