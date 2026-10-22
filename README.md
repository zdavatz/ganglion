# ganglion.ch

## Requirements

* Ubuntu 22.04
* Apache 2.4.52
* MariaDB 10.6
* PHP 8.4 (switched from the end-of-life PHP 8.0 in October 2026)
* Cronolog

### Optional (for scripts)

* PEAR `Mail` + `Net_SMTP` and an MTA — required by the contact form, see [Mail](#mail)
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
* sudo apt install php8.4 libapache2-mod-php8.4 php8.4-mysql php8.4-curl
* sudo a2dismod php8.0 && sudo a2enmod php8.4
* sudo phpenmod mysqli

Install the `php8.4-*` extensions **before** switching the Apache module —
without `php8.4-mysql` no page can reach the database.

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

## YouTube Integration

The page `doc/html/youtube_ursula_davatz.php` lists all videos from the Ursula Davatz YouTube channel, sorted by views (descending) by default. Columns (Titel, Aufrufe, Likes, Kommentare, Veröffentlicht) are clickable to sort ascending/descending. It uses the YouTube Data API v3 and caches results for 1 hour.

**Setup:** Place your YouTube API key in `.yt-keys` in the project root (one line, key only). This file is gitignored.

## Kurse (Courses)

The courses page (`doc/html/kurse.php`) lists entries from the `kurse` table in three
sections, selected by the `kurs_art` column: `regkurse` (Regelmässige Kurse),
`spezkurse` (Spezielle Kurse) and `gruppe` (Gruppen). Clicking a title opens the
detail/registration popup `doc/html/popup_kurse.php`.

A course can carry a flyer PDF in the `pdf_kurse` column. When it is set, an Adobe
icon linking to the file appears next to the course title in the list and as a
"Flyer:" row in the popup. The files live in `doc/html/pdf/` and are served from
`/html/pdf/`.

Flyers are managed from the admin panel (Kurse → "pdf - Datei:"); uploads are
validated against the extension allowlist and stored under `doc/html/pdf/`. The
"Pdf löschen" button clears the column and removes the file.

Schema changes and content inserts are kept as SQL files under `mysql/`, e.g.
`mysql/kurse_spezkurs_educational_engineering.sql`, applied with:

```bash
$ mysql -u<user> -p <database> < mysql/kurse_spezkurs_educational_engineering.sql
```

## Mail

The contact form (`doc/html/kontakt.php` → `doc/html/mail_gesendet.php` →
`doc/html/php/feedback_mail.php`) sends with PEAR `Mail` through
`/usr/sbin/sendmail`. That binary is provided by **msmtp**, which relays every
message through the **Google Workspace SMTP relay** of ganglion.ch:

```bash
$ sudo apt install php-mail php-net-smtp msmtp-mta
```

`/etc/msmtprc`:

```
defaults
tls            on
tls_starttls   on
tls_trust_file /etc/ssl/certs/ca-certificates.crt
syslog         LOG_MAIL

account        google_relay
host           smtp-relay.gmail.com
port           587
domain         ganglion.ch
from           kontakt@ganglion.ch
auth           off

account default : google_relay
```

No password is involved: the relay is authorised by IP in the Workspace admin
console (Apps → Gmail → Routing → SMTP relay service, "only addresses in my
domains", TLS required). Allow **both** server addresses, `49.12.40.36` and
`2a01:4f8:c17:6dc6::1` — msmtp connects over IPv6 when it can.

Test from the shell with
`printf "Subject: test\n\nhi\n" | /usr/sbin/sendmail -f kontakt@ganglion.ch you@example.com`.
A failed send is written to the Apache error log and the visitor is told to
write to sekretariat@ganglion.ch directly. Until October 2026 the form lost
every message silently (no PEAR Mail, no MTA) — check the error log after any
mail-related change.

## Homepage notices

`doc/index.php` carries a highlighted notice box (CSS class `praxis-hinweis` in
`doc/html/css/browser5.css`) directly under the navigation. It currently announces
the closure of the practice per end of 2026 and links to the two letters from the
secretariat, `doc/html/pdf/Praxisschliessung_Patienten_2026.pdf` (patients) and
`doc/html/pdf/Praxisschliessung_2026.pdf` (professionals). Edit or remove the block
in `index.php` when the notice is no longer current.

## Secretariat mails

The secretariat (`sekretariat@ganglion.ch`) sends course flyers, group notices and
announcements as PDF attachments to `zdavatz@ywesee.com`. They are read and answered
via the Gmail REST API with a service account (domain-wide delegation, scopes
`gmail.readonly` + `gmail.send`). The scripts and credentials live outside this
repository in `~/software/gmail-ywesee/` and `~/.config/gmail-ywesee/`.

## Full-Text Search & AI Q&A

The lectures page (`doc/html/vortraege.php`) integrates with the [gang2fts5](https://github.com/zdavatz/gang2fts5) full-text search server for two features:

- **Volltextsuche** — FTS5-based keyword search across all lecture transcripts (supports phrases, wildcards, boolean operators)
- **Fragen (KI)** — Natural language Q&A powered by Grok AI with streamed answers and source references

**Requirements:** The `gang2fts5` server must be running on the same host:

```bash
cd /path/to/gang2fts5
XAI_API_KEY=your-key ./gang2fts5 serve  # starts on port 3000
```

The PHP proxy scripts (`doc/html/php/search_proxy.php` and `doc/html/php/ask_proxy.php`) forward requests to `http://127.0.0.1:3000`. The search works without the API key; the KI Q&A requires `XAI_API_KEY`.

## Links

Useful tools for MySQL connections:

* [DBKiss](https://github.com/cztomczak/dbkiss)
* [TinyMy](https://github.com/einars/tinymy)
