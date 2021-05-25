<?php

/**
 * Creează o conexiune la baza de date.
 */
function connect()
{
	$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if ($connection === false) {
		die("Eroare la conexiune: " . $connection->connect_error);
	}

	$connection->set_charset("utf8");
	$connection->query("SET NAMES utf8;");
	return $connection;
}

/**
 * Modifică textul prin înlăturarea spațiilor de la extremități, înlăturarea tagurilor <*> etc.
 */
function prepare_content($input)
{
	return strip_tags(trim($input));
}
