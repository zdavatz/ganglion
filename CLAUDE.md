# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

ganglion.ch is a PHP/MySQL website for Dr. med. Ursula Davatz (psychiatrist). It manages lectures (Vorträge), articles (Artikel), courses (Kurse), and a podcast feed. Deployed on Apache with HTTP Basic Auth for the admin panel.

## Tech Stack

- PHP 8.0.7 (procedural, no framework), Apache 2.4.41, MySQL/MariaDB 10.3.29
- Ruby scripts for RSS feed generation (`create_xml_from_db.rb`)
- Bash scripts for QR code PDF generation (`generate_qr_pdf`, `gen_link_1`, `gen_qr_only_2`)

## Architecture

The document root is `doc/`. All public-facing pages are under `doc/html/`, admin pages under `doc/wsadmin/`.

### Key paths

- `doc/index.php` — main entry point
- `doc/html/php/navbar.php` — shared navigation
- `doc/html/php/mysql_header.php` — database connection (from `.sample` template)
- `doc/php/function.php` — shared helpers (MIME mail, Swiss date formatting, user agent detection)
- `doc/wsadmin/php/admin.php` — admin entry point
- `doc/wsadmin/php/save.php` — admin data persistence
- `etc/db_connection_data.txt` — MySQL credentials (from `.sample` template)

### Database tables

- `vortrag` — lectures (title, summary, date, PDF, audio, location, audience, download count)
- `artikel` — articles (title, journal, PDF, topic, publication date, download count)
- `kurse` — courses (title, start dates)
- `thema` — topic categories (Arbeit, Erziehung, Gesundheit, Familie)
- `links` — external links
- `forum_inhalt` / `forum_thread` — forum content

### Content flow

Pages include shared components via `require_once`. Admin CRUD operations go through `doc/wsadmin/php/save.php`. The MySQL dump is in `mysql/ganglion_7.6.2021.txt`.

## Setup

Copy all `.sample` config files before running:
```bash
cp etc/db_connection_data.txt{.sample,}
cp doc/php/mysql.php{.sample,}
cp doc/html/php/mysql_header.php{.sample,}
cp doc/wsadmin/php/property.php{.sample,}
cp doc/wsadmin/php/auth.inc{.sample,}
```
Then update credentials in each file.

## Security Conventions

- **SQL queries**: Always use prepared statements with `mysqli_prepare` / `mysqli_stmt_bind_param`. Never interpolate variables into SQL strings.
- **HTML output**: Always wrap variables in `htmlspecialchars($val, ENT_QUOTES, 'UTF-8')` before echoing into HTML.
- **Request parameters**: Read from `$_GET` / `$_POST` explicitly. Never use `extract()` on superglobals.
- **File paths**: Use `basename()` on any user-supplied filename before using it in file operations (`unlink`, `move_uploaded_file`, path construction).
- **File uploads**: Validate extensions with `validate_upload()` in `save.php` (allowlist: pdf, doc, docx, txt, jpg, jpeg, png, gif).
- **Email headers**: Strip `\r\n` from Subject/header values to prevent header injection. Validate email addresses with `filter_var($email, FILTER_VALIDATE_EMAIL)`.
- **Sessions**: Use explicit `$_SESSION[]` reads at start and write-back at end of included files. Never use deprecated `session_register()`.

## Conventions

- The site is in **German** (Swiss German context). Content fields, UI text, and page names are in German.
- Date format is Swiss: `d.m.Y` (handled by `datum_ch()` in `function.php`).
- PDFs are stored in `doc/html/pdf/`, audio files tracked via database URL fields.
- Download counts are tracked in the `vortrag` and `artikel` tables.
- The `.gitignore` excludes credential files, audio directories, and generated configs.
- `doc/html/youtube_ursula_davatz.php` — YouTube video listing page using the YouTube Data API v3. Clickable column headers for sorting (Titel, Aufrufe, Likes, Kommentare, Veröffentlicht). API key stored in `.yt-keys` (gitignored). Results cached in `/tmp` for 1 hour.
- `doc/html/vortraege.php` includes full-text search and KI Q&A via the `gang2fts5` server (must be running on `127.0.0.1:3000`). PHP proxies: `doc/html/php/search_proxy.php` (GET, forwards to `/api/search`) and `doc/html/php/ask_proxy.php` (POST, SSE streaming proxy for `/api/ask` using Grok AI).
