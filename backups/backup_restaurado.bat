@echo off

REM Configurações do MySQL
SET user=root
SET password=gui13579
SET host=localhost
SET database=controledepropriedade2

REM Caminho do MySQL bin
SET mysql_bin="C:\xampp\mysql\bin"

REM Caminho para o arquivo de backup
SET backup_path="C:\xampp\htdocs\Cadastro_Imoveis\backup\banco_de_dados\uploads\backup.sql"

REM Criar o banco de dados caso não exista
%mysql_bin%\mysql.exe --user=%user% --password=%password% --host=%host% -e "CREATE DATABASE IF NOT EXISTS %database%;"
IF ERRORLEVEL 1 (
    echo Erro ao criar o banco de dados.
    exit /b
)

REM Restaurar o banco com estrutura e dados
%mysql_bin%\mysql.exe --user=%user% --password=%password% --host=%host% %database% < %backup_path%
IF ERRORLEVEL 1 (
    echo Erro ao restaurar o backup.
    exit /b
)

REM Mensagem de sucesso
echo Backup restaurado com sucesso!
exit
