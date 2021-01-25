# ganglion
## /etc/apache2/vhosts.d/ganglion.ch.conf 
```
<Directory /var/www/ganglion.ch/doc>
  Options ExecCGI FollowSymlinks
  Require all granted
</Directory>
<Directory /var/www/ganglion.ch/doc/wsadmin>
  AuthName "Backend"
  AuthType Basic
  AuthUserFile /var/www/ganglion.ch/etc/htpasswd
  Require valid-user
</Directory>

<VirtualHost *:80>
#  DBDriver mysql
#  DBDParams host=localhost,dbname=ganglion,user=gangli,pass=gg6438
  ServerName www.ganglion.ch
  ServerAlias ganglion.ch 
  ServerAlias www.ursuladavatz-institut.ch ursuladavatz-institut.ch
  DocumentRoot /var/www/ganglion.ch/doc
  DirectoryIndex index.php index.html
  LogLevel debug
  ErrorLog "|/usr/sbin/cronolog -l /var/www/ganglion.ch/log/error_log /var/www/ganglion.ch/log/%Y/%m/%d/error_log"
  CustomLog "|/usr/sbin/cronolog -l /var/www/ganglion.ch/log/access_log /var/www/ganglion.ch/log/%Y/%m/%d/access_log" combined
  <IfModule mod_php5.c>
    php_value error_reporting 0
    # php <= 5.3
    php_admin_flag register_globals on
    php_admin_value post_max_size 100M
    php_admin_value upload_max_filesize 100M
  </IfModule>
</VirtualHost>

## webalizer
<Directory "/var/www/ganglion.ch/webalizer">
  Options None
  AllowOverride None
  Require all granted
</Directory>

<VirtualHost *:80>
  DocumentRoot /var/www/ganglion.ch/webalizer
  ServerName webalizer.ganglion.ch
  DirectoryIndex index.html
  AddDefaultCharset UTF-8
</VirtualHost>

#AddDefaultCharset ISO-8859-1
```
