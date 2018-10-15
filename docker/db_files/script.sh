#!/bin/bash
service mysql start
mysql --user=root --password=12345678 --database=p_db < db.sql
service mysql stop