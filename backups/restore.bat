@echo off
"C:\xampp\mysql\bin\mysql.exe" --user=root --password=gui13579 --host=localhost -e "CREATE DATABASE IF NOT EXISTS controledepropriedade2;"
"C:\xampp\mysql\bin\mysql.exe" --user=root --password=gui13579 --host=localhost controledepropriedade2 < "../../backups/backup.sql"
IF ERRORLEVEL 0 (
    echo Backup restaurado com sucesso!
) ELSE (
    echo Ocorreu um erro ao restaurar o backup.
)
exit