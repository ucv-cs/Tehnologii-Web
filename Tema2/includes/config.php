<?php
define('SITE_URL', "http://" . $_SERVER["SERVER_NAME"]);
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'competition');

// https://www.php.net/manual/en/session.security.ini.php
// https://www.php.net/manual/en/features.session.security.management.php
ini_set("session.use_strict_mode", "true");

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}