FROM mariadb:10.9.4

ADD conf/default_authentication.cnf /etc/mysql/conf.d/default_authentication.cnf
ADD conf/default_charset.cnf /etc/mysql/conf.d/default_charset.cnf
ADD conf/default_timezone.cnf /etc/mysql/conf.d/default_timezone.cnf

ADD initdb/init.sql /docker-entrypoint-initdb.d/init.sql