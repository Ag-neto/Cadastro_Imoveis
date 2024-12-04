@echo off
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe" --user=root --password=gui13579 --host=localhost controledepropriedade2 > "../../backups/backup_%date%_%time:~0,2%-%time:~3,2%-%time:~6,2%.sql"
exit