with phpmyadmin import main database .
then import masking-script-crowdfunding.sql


with mysql cli : 
mysql -u root -p{pass} {databasename} < maindatabase.sql
mysql -u root -p{pass} {databasename} < masking-script-crowdfunding.sql


In docker root user need to be used . and in container rootpassword need to be set .