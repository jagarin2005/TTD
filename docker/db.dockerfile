FROM mariadb:latest
ADD /db_files/db.sql /docker-entrypoint-initdb.d/db.sql
CMD ["mysql", "--user=root", "--password=12345678", "<", "docker-entrypoint-initdb.d/db.sql"]