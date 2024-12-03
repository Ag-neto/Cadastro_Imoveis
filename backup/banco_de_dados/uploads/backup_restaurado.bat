@echo off
"C:\xampp\mysql\bin\mysql.exe" --user=root --password=gui13579 --host=localhost -e "CREATE DATABASE IF NOT EXISTS controledepropriedade2;"
"C:\xampp\mysql\bin\mysqldump.exe" --user=root --password=gui13579 --host=localhost controledepropriedade2 > "../../backups/backup.sql"