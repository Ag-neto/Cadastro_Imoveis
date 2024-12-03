@echo off
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe" --user=root --password= --host=localhost controledepropriedade > "../../backups/backup_" . date('Y-m-d_H-i-s') . ".sql"
exit