@echo off
mysql --user=root --password= --host=localhost -e "CREATE DATABASE IF NOT EXISTS controledepropriedade;"
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe" --user=root --password= --host=localhost controledepropriedade > "../../backups/backup.sql"
exit