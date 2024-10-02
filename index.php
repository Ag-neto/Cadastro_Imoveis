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

    <nav class="menu-lateral">
        <div class="btn-expandir">
            <i class="bi bi-list"></i>
        </div>

        <ul>
            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-person-add"></i></span>
                    <span class="txt-link">Add.Usuário</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="propriedade/cadastro_propriedade.php">
                    <span class="icon"><i class="bi bi-shop"></i></span>
                    <span class="txt-link">Add.Propriedade</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="inquilino/cadastro_inquilo.php">
                    <span class="icon"><i class="bi bi-person-vcard-fill"></i></span>
                    <span class="txt-link">Add.Inquilino</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-wallet2"></i></span>
                    <span class="txt-link">Pagamentos</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="aluguel/criar_contrato.php">
                    <span class="icon"><i class="bi bi-file-earmark-break-fill"></i></span>
                    <span class="txt-link">Gerar.Contrato</span>
                </a>
            </li>

            <li class="item-menu">
                <a href="#">
                    <span class="icon"><i class="bi bi-archive-fill"></i></span>
                    <span class="txt-link">Contratos</span>
                </a>
            </li>

        </ul>
    </nav>

    <main>
        <section>
            <h2>Bem-vindo ao Sistema de Gestão de Imóveis</h2>
            <p>Escolha uma das opções no menu acima para gerenciar seus imóveis e locações.</p>
        </section>
    </main>
    <main>
        <section>
            <h2>Suas Propriedades</h2>
            <p>Escolha uma das propriedades para realizar alguma operação</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Imóveis</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>