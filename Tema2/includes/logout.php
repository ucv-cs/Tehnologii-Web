<?php
require_once "config.php";

if (isset($_POST["logout"])) {
	session_destroy();
	header("Location: " . SITE_URL);
}
