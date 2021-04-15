# ganglion.ch

## Requirements

* Apache 2.4.46
* MySQL 5.1.66 (using readline 5.1)
* PHP 5.6.24


## Setup

### Credentials

Copy sample files and update `user[name]` and `pass[word]` variables as you need.

```bash
# copy .sample files into the each same location
$ cp etc/db_connection_data.txt{.sample,}
$ cp doc/html/php/mysql_header.php{.sample,}
$ cp doc/wsadmin/php/auth.inc{.sample,}
```

### Middlewares

e.g. Gentoo Linux

#### Apache2

##### Modules

For the Ebuild:

```bash
$ cat /etc/portage/package.env
...
www-servers/apache www-servers/apache.conf

$ cat /etc/portage/env/www-servers/apache.conf
# Apache2 Modules (Note: they are taken from the current server, it includes not used ones too)
APACHE2_MODULES="access auth auth_dbm auth_anon auth_digest alias filter file-cache echo charset-lite cache disk-cache mem-cache ext-filter case_filter case-filter-in deflate mime-magic cern-meta expires headers usertrack unique-id proxy proxy_connect proxy_ftp proxy_http info include proxy_fcgi cgi cgid dav dav-fs vhost-alias speling rewrite log_config logio env setenvif mime status autoindex asis negotiation dir imap actions userdir so unique_id auth_basic authn_alias authn_anon authn_dbm authn_default authn_file authz_dbm authz_default authz_groupfile authz_host authz_owner authz_user disk_cache ext_filter file_cache mem_cache mime_magic vhost_alias proxy_html xml2enc socache_shmcb authn_core authz_core unixd access_compat session session_cookie session_crypto session_dbd dbd dbd_mysql request auth_form form"

# Multi-Processing Modules (MPMs)
APACHE2_MPMS="prefork"
```

##### Options

Runtime options:

```bash
# Add `-D PHP`
% cat /etc/conf.d/apache
APACHE2_OPTS="-D DEFAULT_VHOST -D INFO -D SSL -D SSL_DEFAULT_VHOST -D LANGUAGE -D PHP"
```

Sample apache.conf (located in: `/etc/apache2/vhosts.d/ganglion.ch.conf`)

```txt
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
```

#### PHP

##### USE flags

* Omit `threads` USE flag (We enable "prefork" for Apache2)
* Add `mysql`, `apache2` USE flag

```bash
$ equery l -po dev-lang/php
 * Searching for php in dev-lang ...
[I-O] [  ] dev-lang/php-5.6.40-r7:5.6
[IP-] [  ] dev-lang/php-7.3.27:7.3
[-P-] [  ] dev-lang/php-7.3.27-r1:7.3
[-P-] [  ] dev-lang/php-7.4.15:7.4
[-P-] [  ] dev-lang/php-7.4.16:7.4
[-P-] [  ] dev-lang/php-8.0.3:8.0

$ sudo su
# echo 'dev-lang/php -threads' >> /etc/portage/package.use/php
# exit
$ sudo emerge -av dev-lang/php
```

##### Select version

Swich PHP for Apache 2 with `eselect`.

```bash
$ sudo eselect php list apache2
  [1]   php5.6 *
  [2]   php7.3
$ sudo eselect php set apache2 2
```

#### MySQL

Nothing special.

```bash
$ sudo emerge -av dev-db/mysql
```


## Links

Useful tools for MySQL connections:

* [DBKiss](https://github.com/cztomczak/dbkiss)
* [TinyMy](https://github.com/einars/tinymy)
