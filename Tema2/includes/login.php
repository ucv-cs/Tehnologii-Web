<?php
require_once "config.php";
require_once "utils.php";

$connection = connect();

$email = $_POST["email"] ?? "";
$password = $_POST["password"] ?? "";

$email = prepare_content($email);
// $password = trim($password);

$error_email = "";
$error_password = "";

$regex_password = "/^[a-zA-Z+\-0-9_.?#$\s]+$/i";

if (empty($email)) {
	$error_email = "Scrie adresa de email.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$error_email = "Scrie corect adresa de email.";
}

if (empty($password)) {
	$error_password = "Scrie parola.";
} elseif (!filter_var($password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => $regex_password)))) {
	$error_password = "Scrie corect parola.";
}

if (empty($error_email) && empty($error_password)) {
	$sql = "SELECT * FROM users WHERE user_email = ? AND user_password = ?";

	if ($ps = $connection->prepare($sql)) {
		$password_hash = sha1($email . $password);
		$ps->bind_param("ss", $email, $password_hash);

		if ($ps->execute()) {
			$result = $ps->get_result();

			if ($result->num_rows == 1) {
				$row = $result->fetch_array();
				$_SESSION["auth_user_id"] = $row["user_id"];
				$_SESSION["auth_user_first_name"] = $row["user_first_name"];
				$_SESSION["auth_user_family_name"] = $row["user_family_name"];
			} else {
				$error_email = "Date eronate.";
				$error_password = "Date eronate.";
			}
		}
	}

	//$ps->close();
}

$connection->close();

$errors = array(
	'email' => $error_email,
	'password' => $error_password
);
echo json_encode($errors);
