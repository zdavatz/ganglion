# ganglion.ch
## Apache on Gentoo modules loading
```
APACHE2_MODULES="access auth auth_dbm auth_anon auth_digest alias filter file-cache echo charset-lite cache disk-cache mem-cache ext-filter case_filter case-filter-in deflate mime-magic cern-meta expires headers usertrack unique-id proxy proxy_connect proxy_ftp proxy_http info include proxy_fcgi cgi cgid dav dav-fs vhost-alias speling rewrite log_config logio env setenvif mime status autoindex asis negotiation dir imap actions userdir so unique_id auth_basic authn_alias authn_anon authn_dbm authn_default authn_file authz_dbm authz_default authz_groupfile authz_host authz_owner authz_user disk_cache ext_filter file_cache mem_cache mime_magic vhost_alias proxy_html xml2enc socache_shmcb authn_core authz_core unixd access_compat session session_cookie session_crypto session_dbd dbd dbd_mysql request auth_form form"
APACHE2_MPMS="prefork"
```
## php configure options
`./configure --with-mysql --with-apxs2=/usr/bin/apxs --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --enable-phpdbg`
for PHP 5.6.24
## /etc/apache2/vhosts.d/ganglion.ch.conf 
for Apache 2.4.46
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
