<?php
require_once "config.php";
require_once "utils.php";

if (!isset($_SESSION["auth_user_id"])) {
	header("Location: " . SITE_URL);
}

$connection = connect();

// distinge între delete și update
// delete
if (isset($_POST['delete-object']) && $_POST['delete-object'] == "result") {
	$id = $_POST['delete-id'] ?? "";

	if (preg_match("/^\d+$/", $id)) {
		$ps = $connection->prepare("DELETE FROM participants WHERE participant_id = ?");

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
} else { // update
	$id = $_POST['result-id'] ?? "";

	$p1 = $_POST['problem-1'] ?? 0;
	$p2 = $_POST['problem-2'] ?? 0;
	$p3 = $_POST['problem-3'] ?? 0;

	if (preg_match("/^\d+$/", $id)) {
		$ps = $connection->prepare("UPDATE participants SET participant_score_1 = ?, participant_score_2 = ?, participant_score_3 = ? WHERE participant_id = ?");

		if (!$ps->bind_param("dddi", $p1, $p2, $p3, $id)) {
			echo "Eroare la bind.";
			exit();
		}

		if (!$ps->execute()) {
			echo "Eroare la update.";
			exit();
		}

		$ps->close();
	}
}

$connection->close();
header("Location: " . SITE_URL . "/dashboard");
