<!-- criar usuário -->

<form>
<form action="caminho_criar_usuario.php" method="post">
    <h2>Adicionar Novo Usuário</h2>

    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario"><br><br>

    <label for="senha">Senha:</label>
    <input type="passowrd" id="senha" name="senha"><br><br>

    <label for="confirmar_senha">Confirme sua Senha:</label>
    <input type="password" id="confirmar_senha" name="confirmar_senha"><br><br>

    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome"><br><br>

    <label for="cargo">Cargo:</label>
    <select id="cargo" name="cargo">
        <option value="administrador">Administrador</option>
        <option value="agente">Agente</option>
        <option value="inquilinio">Inquilino</option>
    </select><br><br>

    <input type="submit" value="Adicionar Usuario">
</form>