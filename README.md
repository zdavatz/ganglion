# ganglion.ch

## Requirements

* Ubuntu 20.04
* Apache 2.4.41
* MySQL MariaDB 10.3.29
* PHP 8.0.7
* Cronolog

### Optional (for scripts)

* Ruby with `mysql` gem — for RSS feed generation (`create_xml_from_db.rb`)
* `qrencode` — for QR code PDF generation
* ImageMagick (`convert`) — for QR code PDF generation
* `cpdf` — for QR code PDF generation

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
* sudo apt-get install php8.0-mysql
* sudo phpenmod mysqli

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
## Security

The codebase has been hardened against common web vulnerabilities:

* **SQL Injection**: All database queries use prepared statements with parameter binding (`mysqli_prepare` / `mysqli_stmt_bind_param`)
* **XSS**: All variable output in HTML context is wrapped in `htmlspecialchars(ENT_QUOTES, 'UTF-8')`
* **Register Globals**: The dangerous `extract()` emulation of `register_globals` has been removed; all request parameters are read explicitly from `$_GET` / `$_POST`
* **Directory Traversal**: File paths from user input are sanitized with `basename()`
* **File Uploads**: Extension allowlist validation before accepting uploads (pdf, doc, docx, txt, jpg, jpeg, png, gif)
* **Email Header Injection**: Newlines stripped from email headers; email addresses validated with `filter_var`
* **Session Handling**: Deprecated `session_register()` replaced with explicit `$_SESSION[]` read/write
* **Server Info**: Removed `phpinfo.php` to prevent server configuration exposure

## Links

Useful tools for MySQL connections:

* [DBKiss](https://github.com/cztomczak/dbkiss)
* [TinyMy](https://github.com/einars/tinymy)
