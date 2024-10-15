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
                    <span class="txt-link">Pagamentos</span>
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
            <p>Escolha uma das opções no menu acima para gerenciar seus imóveis e locações.</p>
        </section>
    </main>

    <main>
        <section>
            <h2>Suas Propriedades</h2>
            <p>Escolha uma das propriedades para realizar alguma operação</p>

            <h3>Propriedades Disponíveis</h3>
            <div class="propriedades-container">
                <div class="propriedade-item">
                    <h4>Apartamento Central</h4>
                    <p>Localização: Centro</p>
                    <p>Valor: R$ 500.000</p>
                </div>

                <div class="propriedade-item">
                    <h4>Casa Verde</h4>
                    <p>Localização: Bairro Verde</p>
                    <p>Valor: R$ 300.000</p>
                </div>

                <div class="propriedade-item">
                    <h4>Loja Comercial</h4>
                    <p>Localização: Av. Principal</p>
                    <p>Valor: R$ 800.000</p>
                </div>

                <div class="propriedade-item">
                    <h4>Apartamento Central</h4>
                    <p>Localização: Centro</p>
                    <p>Valor: R$ 500.000</p>
                </div>

                <div class="propriedade-item">
                    <h4>Casa Verde</h4>
                    <p>Localização: Bairro Verde</p>
                    <p>Valor: R$ 300.000</p>
                </div>

                <div class="propriedade-item">
                    <h4>Loja Comercial</h4>
                    <p>Localização: Av. Principal</p>
                    <p>Valor: R$ 800.000</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 - Sistema de Gestão de Propriedades</p>
    </footer>

    <script src="script.js"></script>
</body>

</html>
