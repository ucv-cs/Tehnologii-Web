<?php
require_once "config.php";
require_once "utils.php";

$connection = connect();

$first_name = $_POST["first-name"] ?? "";
$family_name = $_POST["family-name"] ?? "";
$email = $_POST["participant-email"] ?? "";

$first_name = prepare_content($first_name);
$family_name = prepare_content($family_name);
$email = prepare_content($email);

$error_first_name = "";
$error_family_name = "";
$error_email = "";

$regex_name = "/^[-\s\p{L}]+$/iu";
if (empty($first_name)) {
	$error_first_name = "Scrie prenumele!";
} elseif (!filter_var($first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $regex_name)))) {
	$error_first_name = "Scrie corect prenumele!";
}

if (empty($family_name)) {
	$error_family_name = "Scrie numele!";
} elseif (!filter_var($family_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $regex_name)))) {
	$error_family_name = "Scrie corect numele!";
}

if (empty($email)) {
	$error_email = "Scrie adresa de email!";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$error_email = "Scrie corect adresa de email!";
}

if (empty($error_first_name) && empty($error_family_name) && empty($error_email)) {

	$sql = "INSERT INTO participants (participant_first_name, participant_family_name, participant_email) VALUES (?, ?, ?)";

	if ($ps = $connection->prepare($sql)) {
		$ps->bind_param("sss", $first_name, $family_name, $email);
		$ps->execute();
		$ps->close();
	}
}

$connection->close();

$errors = array(
	'first-name' => $error_first_name,
	'family-name' => $error_family_name,
	'participant-email' => $error_email
);
echo json_encode($errors);
