# Gjimnazi Ulpiana – Versioni PHP + MySQL

Ky projekt tani është i përgatitur për prezantim me backend real në **PHP + MySQL**, pa ndryshuar dizajnin ekzistues (HTML/CSS/JS).

## Çfarë është implementuar

- Login / Signup me session PHP
- Dashboard për profesor/admin
- Rezervime terminesh me ruajtje në DB
- Prano/Refuzo termin (me njoftim email)
- Cilësime të profesorit
- Menaxhim vlerësimesh (ruaj/publiko)
- Anti-double-booking me `UNIQUE (teacher_id, slot_time)`
- Validime server-side (email, fusha obligative, format ore)

---

## 1) Krijimi i databazës

1. Hape phpMyAdmin (ose MySQL CLI).
2. Importo skedarin `schema.sql`.

Kjo krijon:
- `users`
- `bookings`
- `teacher_settings`
- `grades`

Admin default:
- **Email:** `admin@ulpiana.edu`
- **Password:** `12345`

---

## 2) Konfigurimi i backend-it

Ndrysho `config.php` sipas serverit tënd:

```php
<?php
return [
    'db_host' => '127.0.0.1',
    'db_name' => 'ulpiana_db',
    'db_user' => 'root',
    'db_pass' => '',
    'base_url' => '',
    'mail_from' => 'no-reply@ulpiana.local',
    'mail_from_name' => 'Gjimnazi Ulpiana'
];
```

---

## 3) Nisja lokale

Nga folderi i projektit:

```bash
php -S localhost:8000
```

Hape në browser:

`http://localhost:8000/index.html`

---

## 4) Rrjedha e testimit për prezantim

1. Regjistrohu si prind/nxënës.
2. Rezervo një termin.
3. Kyçu si profesor (`@ulpiana.edu`, pass `12345`) ose admin.
4. Hape dashboard dhe prano/refuzo terminin.
5. Shto një vlerësim dhe publikoje.

---

## 5) Shënime për email

Aktualisht përdoret `mail()` i PHP.

- Në hosting real: zakonisht funksionon me konfigurim standard.
- Në localhost: mund të duhet SMTP/sendmail i konfiguruar.

Nëse don, mund të shtohet PHPMailer + SMTP (Gmail/Outlook/cPanel SMTP) për dërgesë 100% të besueshme edhe lokalisht.

---

## 6) Skedarët kryesorë

- `api.php` – endpoint-et backend
- `db.php` – PDO + session + helpers
- `config.php` – konfigurimi
- `schema.sql` – databaza
- `script.js` – frontend publik i lidhur me API
- `dashboard.js` – dashboard i lidhur me API
- `private-dashboard.html` – dashboard privat për scheduling me komandë
- `private-dashboard.js` – logjika e dashboard-it privat
- `cron_publish_scheduled.php` – publikim automatik i postimeve të planifikuara

---

## 7) Hardening i sigurisë (Production-ready)

Janë shtuar këto përmirësime:

- Session cookie më e sigurt (`httponly`, `samesite=lax`, `secure` kur HTTPS është aktiv)
- CSRF token për të gjitha kërkesat `POST`
- Rigjenerim i session-id pas login/signup (`session_regenerate_id(true)`)
- Logout i fortë (pastrim session + fshirje cookie)

### Çka duhet të verifikosh para deploy-it final

1. Aktivizo HTTPS në server dhe komento-rreshtat për redirect te `.htaccess`.
2. Vendos kredenciale reale SMTP në `.env`.
3. Ndrysho fjalëkalimet default dhe hiq login-in fallback testues nëse s’të duhet.
4. Sigurohu që `display_errors=Off` në production.
5. Testo rrjedhat kryesore: login/signup, rezervim, prano/refuzo, ruaj/publiko nota.

---

## 8) Private Chatbot Scheduler (vetëm për ty)

### 8.1 Konfigurimi në `.env`

Shto këtë variabël:

```env
PRIVATE_DASHBOARD_KEY=vendos_nje_celes_shume_te_forte
```

Gjithashtu sigurohu që ke edhe:

```env
GOOGLE_CLIENT_ID=...
GOOGLE_CLIENT_SECRET=...
```

### 8.2 Update databaza (nëse DB ekziston)

Ekzekuto `db_alter_latest.sql` që të krijohet tabela `scheduled_posts`.

### 8.3 Hyrja në dashboard privat

Hape:

`private-dashboard.html`

Kyçu me `PRIVATE_DASHBOARD_KEY`.

### 8.4 Formati i komandës

Shkruaj komandën në këtë format:

```text
Postoje 2026-05-20 10:30 | Titulli i Njoftimit | Përmbajtja e njoftimit
```

Ose më thjeshtë:

```text
Postoje sot ora 10:30 | Titulli | Përmbajtja
Postoje nesër ora 09:00 | Titulli | Përmbajtja
```

Kjo e ruan postimin si `scheduled`.

### 8.5 Publikimi automatik

Skript:

`cron_publish_scheduled.php`

#### Opsion A (rekomanduar): Cron nga CLI

```bash
php c:/xampp2/htdocs/ulpiana/cron_publish_scheduled.php
```

Vendose në Task Scheduler (Windows) çdo 5 minuta.

#### Opsion B: HTTP me key

```text
https://domaini-yt/cron_publish_scheduled.php?key=PRIVATE_DASHBOARD_KEY
```

> Ky endpoint është i mbrojtur me të njëjtin çelës privat.

### 8.6 Postim me foto (super thjeshtë)

Në `private-dashboard.html` ke edhe formën manuale:
- Titulli
- Përmbajtja
- Data/Ora (`YYYY-MM-DD HH:MM`)
- Audience
- Foto (JPG/PNG/WEBP)

Klikon **Ruaj postimin** dhe sistemi e planifikon automatikisht.



