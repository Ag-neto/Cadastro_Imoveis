@echo off
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe" --user=root --password=root --host=localhost -e "CREATE DATABASE IF NOT EXISTS controledepropriedade2;"
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqld.exe" --user=root --password=root --host=localhost controledepropriedade2 < "../../backups/backup.sql"
IF ERRORLEVEL 1 (
    echo Erro ao restaurar o backup.
    exit /b
)
echo Backup gerado e configurado com sucesso!
exit