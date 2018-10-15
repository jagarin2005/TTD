FROM mariadb:latest
COPY /db_files/db.sql /docker-entrypoint-initdb.d/db.sql
CMD ["mysql", "--user=root", "--password=12345678", "--database=p_db", "<", "/docker-entrypoint-initdb.d/db.sql"]