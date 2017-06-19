---------------------LOGIN INFORMATION---------------------------
location= mcsdb.utm.utoronto.ca
dbname= abbass13_309
user=abbass13
password=90444
-----------------------------------------------------------------

sed -i 's/$UTORID/'$utorid'/g' ./model/model.php
sed -i 's/$DBPASSWORD/'$password'/g' ./model/model.php
sed -i 's/$LOCATION/'$location'/g' ./model/model.php
sed -i 's/$DBNAME/'$dbname'/g' ./model/model.php

PGPASSWORD=$password psql -h $location -d $dbname -U $user -f setup.sql
