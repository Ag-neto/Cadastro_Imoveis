<?php
require_once "conexao/conexao.php";

// Número de propriedades a serem exibidas
$limite = 6;

// Consulta para obter as últimas propriedades cadastradas
$sql = "SELECT p.*, t.nome_tipo, l.nome_cidade, s.nome_situacao, e.sigla 
    FROM propriedade p 
    JOIN tipo_prop t ON p.id_tipo_prop = t.id_tipo_prop
    JOIN localizacao l ON p.id_localizacao = l.idlocalizacao
    JOIN situacao s ON p.id_situacao = s.id_situacao
    JOIN estados e ON l.id_estado = e.id_estado ORDER BY idpropriedade DESC LIMIT $limite";

$result = $conn->query($sql);
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
        <button id="notification-btn">🔔 Notificações</button>
    </header>

    <!-- Popup de notificações -->
    <div class="notification-popup" id="notification-popup">
        <span class="close-btn" id="close-btn">&times;</span>
        <h3>Notificações</h3>
        <p>Você tem 3 novas notificações.</p>
        <p>Propriedade "Casa no Centro" foi atualizada.</p>
        <p>Pagamento pendente para "Apartamento Vista Mar".</p>
        <p>Contrato de "Sala Comercial" expirando em breve.</p>
    </div>

    <nav class="menu-lateral">
        <div class="btn-expandir">
            <i class="bi bi-list"></i>
        </div>

        <ul>
            <!-- Link para a listagem de usuários -->
            <li class="item-menu">
                <a href="usuario/listar_usuarios.php">
                    <span class="icon"><i class="bi bi-person-add"></i></span>
                    <span class="txt-link">Usuários</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="propriedade/listar_propriedades.php">
                    <span class="icon"><i class="bi bi-shop"></i></span>
                    <span class="txt-link">Propriedades</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="inquilino/listar_inquilinos.php">
                    <span class="icon"><i class="bi bi-person-vcard-fill"></i></span>
                    <span class="txt-link">Inquilinos</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="pagamentos/pag_cliente.php">
                    <span class="icon"><i class="bi bi-wallet2"></i></span>
                    <span class="txt-link">Financeiro</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="contrato/listar_contratos.php">
                    <span class="icon"><i class="bi bi-archive-fill"></i></span>
                    <span class="txt-link">Contratos</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="localidade/cadastro_cidade.php">
                    <span class="icon"><i class="bi bi-geo-alt-fill"></i></span>
                    <span class="txt-link">Localidades</span>
                </a>
            </li>
        </ul>
    </nav>

    <main>
        <section>
            <h2>Bem-vindo ao Sistema de Gestão de Imóveis</h2>
            <p>Escolha uma das opções no menu lateral para gerenciar suas propriedades e locações.</p>
        </section>
    </main>

    <main>
        <section>
            <h2>Suas Propriedades</h2>
            <p>Escolha uma das propriedades para realizar alguma operação</p>

            <h3>Propriedades Disponíveis</h3>
            <div class="propriedades-container">
                <?php
                // Verifica se há resultados
                if ($result && $result->num_rows > 0) {
                    // Loop para exibir cada propriedade
                    while ($row = $result->fetch_assoc()) {
                        // Gera o link para a página de detalhes da propriedade
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
        </section>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script>
        // JavaScript para abrir e fechar o popup de notificações
        const notificationBtn = document.getElementById('notification-btn');
        const notificationPopup = document.getElementById('notification-popup');
        const closeBtn = document.getElementById('close-btn');

        notificationBtn.addEventListener('click', () => {
            // Alterna a exibição do popup
            notificationPopup.style.display = notificationPopup.style.display === 'block' ? 'none' : 'block';
        });

        closeBtn.addEventListener('click', () => {
            // Oculta o popup
            notificationPopup.style.display = 'none';
        });

        // Fechar o popup ao clicar fora dele
        window.addEventListener('click', (event) => {
            if (event.target !== notificationBtn && !notificationPopup.contains(event.target)) {
                notificationPopup.style.display = 'none';
            }
        });
    </script>
</body>

</html>