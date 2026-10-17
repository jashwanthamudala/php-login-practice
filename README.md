# PHP Login Practice

I made this small project while learning PHP and MySQL. It helped me understand how a registration form sends data to PHP, how PHP stores a password hash in a database, and how a login session can be used to protect a page.

This is a practice project, not a finished authentication system for a real website.

## What it can do

- Register a user with a name, email, and password
- Store a password hash instead of the original password
- Look up an account using its email address
- Check a submitted password with PHP's `password_verify()`
- Start a session after a successful login
- Restrict the dashboard to logged-in users
- Log out and end the session

## Tools used

- PHP
- MySQL
- PDO for database access
- HTML forms
- XAMPP for local development

## Project files

| File | What it does |
| --- | --- |
| `register.php` | Shows the registration form and creates an account |
| `login.php` | Checks the email and password, then starts the logged-in session |
| `dashboard.php` | Shows a page only when a user session exists |
| `logout.php` | Clears the session and sends the user back to login |
| `config.example.php` | Example database configuration to copy for local use |
| `.gitignore` | Keeps local config and database dumps out of Git |

## Run it locally with XAMPP

### 1. Put the project in `htdocs`

Copy this folder into your XAMPP web directory. On a typical Windows installation, that is:

```text
C:\\xampp\\htdocs\\php-login-practice
```

Start Apache and MySQL from the XAMPP Control Panel.

### 2. Create the database and table

Open phpMyAdmin (often `http://localhost/phpmyadmin`) and run this SQL:

```sql
CREATE DATABASE IF NOT EXISTS practice_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE practice_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

The `email` column is unique so the same email cannot be registered more than once. The `password_hash` column holds the hash created by PHP.

If your MySQL server uses a different port, update the port in your local `config.php`.

### 3. Set up the local config

Make a copy of `config.example.php` and name the copy `config.php`.

Open `config.php` and adjust the database name, username, password, and port to match your XAMPP/MySQL setup. The actual `config.php` is ignored by Git, so it should remain local.

### 4. Open the app

Visit:

```text
http://localhost/php-login-practice/register.php
```

Register a test account, then log in. After a successful login, the app redirects to the dashboard. Use the **Log out** link to end the session.

## How the password handling works

During registration, PHP uses `password_hash()` to create a hash before inserting it into the database. The original password is not stored.

During login, the app finds the account by email and uses `password_verify()` to check the password typed into the form against the stored hash. It does not need to decrypt the hash.

## Things I learned

While building this, I practiced:

- Handling form submissions with `POST`
- Connecting PHP to MySQL with PDO
- Using prepared statements and placeholders
- Reading a database row with `fetch()`
- Hashing and verifying passwords
- Starting, checking, and ending PHP sessions
- Redirecting between pages

## Security notes and next improvements

This is a beginner project for local learning. It has some basic safeguards, but it is **not ready to protect real users or sensitive information**.

Possible next improvements:

- Add CSRF protection to forms
- Configure session cookies securely (HTTPS, `HttpOnly`, and `Secure` where applicable)
- Add rate limiting or login-attempt throttling
- Add password-reset functionality
- Improve validation and error handling
- Use a properly secured database account instead of a local development account
- Add automated tests and deploy only after a security review

Please don't use real personal information or a password you use on other websites while testing.
