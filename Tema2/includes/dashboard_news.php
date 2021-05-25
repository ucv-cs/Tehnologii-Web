<?php
require_once "config.php";
require_once "utils.php";

if (!isset($_SESSION["auth_user_id"])) {
	header("Location: " . SITE_URL);
}

$connection = connect();

// distinge intre delete, update si insert
// delete
if (isset($_POST['delete-object']) && $_POST['delete-object'] == "news") {
	$id = $_POST['delete-id'] ?? "";

	if (preg_match("/^\d+$/", $id)) {
		$ps = $connection->prepare("DELETE FROM news WHERE news_id = ?");

		if (!$ps->bind_param("i", $id)) {
			echo "Eroare la bind.";
			exit();
		}

		if (!$ps->execute()) {
			echo "Eroare la delete.";
			exit();
		}

		$ps->close();
	}
} else if (isset($_POST['news-action']) && $_POST['news-action'] == "edit") { // update
	$id = $_POST['news-id'] ?? "";

	$content = $_POST['news-content'] ?? "";
	$content = htmlspecialchars(prepare_content($content));

	if (preg_match("/^\d+$/", $id)) {
		$ps = $connection->prepare("UPDATE news SET news_content = ?, news_date = NOW(), user_id = {$_SESSION["auth_user_id"]} WHERE news_id = ?");

		if (!$ps->bind_param("si", $content, $id)) {
			echo "Eroare la bind.";
			exit();
		}

		if (!$ps->execute()) {
			echo "Eroare la update.";
			exit();
		}

		$ps->close();
	}
} else if (isset($_POST['news-action']) && $_POST['news-action'] == "add") { // insert
	$content = $_POST['news-content'] ?? "";
	$content = prepare_content($content);

	$ps = $connection->prepare("INSERT INTO news (news_content, news_date, user_id) VALUES (?, NOW(), {$_SESSION["auth_user_id"]})");

	if (!$ps->bind_param("s", $content)) {
		echo "Eroare la bind.";
		exit();
	}

	if (!$ps->execute()) {
		echo "Eroare la create.";
		exit();
	}

	$ps->close();
}

$connection->close();
header("Location: " . SITE_URL . "/dashboard");
