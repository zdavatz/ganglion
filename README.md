# ganglion.ch

## Requirements

* Ubuntu 20.04
* Apache 2.4.41
* MySQL MariaDB 10.3.29
* PHP 8.0.7
* Cronolog

## Setup

### Credentials

Copy sample files and update `user[name]` and `pass[word]` variables as you need.

```bash
# copy .sample files into the each same location
$ cp etc/db_connection_data.txt{.sample,}
$ cp doc/php/mysql.php{.sample,}
$ cp doc/html/php/mysql_header.php{.sample,}
$ cp doc/wsadmin/php/property.php{.sample,}
$ cp doc/wsadmin/php/auth.inc{.sample,}
```

##### Modules
* sudo apt install php8.0 libapache2-mod-php8.0
* sudo a2enmod php8.0

##### Apache2
Sample apache.conf (located in: `/etc/apache2/sites-enabled/ganglion.ch.conf`)
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
  ErrorLog "|/usr/bin/cronolog -l /var/www/ganglion.ch/log/error_log /var/www/ganglion.ch/log/%Y/%m/%d/error_log"
  CustomLog "|/usr/bin/cronolog -l /var/www/ganglion.ch/log/access_log /var/www/ganglion.ch/log/%Y/%m/%d/access_log" combined
</VirtualHost>
```
## Links

Useful tools for MySQL connections:

* [DBKiss](https://github.com/cztomczak/dbkiss)
* [TinyMy](https://github.com/einars/tinymy)
