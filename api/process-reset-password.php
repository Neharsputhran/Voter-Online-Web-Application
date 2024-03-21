<?php

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

// Include the connection file
$con = require __DIR__ . "/connect.php";

$sql = "SELECT * FROM user
        WHERE resettoken = ?";

$stmt = $con->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    die("Token not found");
}

if (strtotime($user["resettokenexpired"]) <= time()) {
    die("Token has expired");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Passwords must match");
}

$password = password_hash($_POST["password"],PASSWORD_DEFAULT);

$sql = "UPDATE user
        SET password = ?,
            resettoken = NULL,
            resettokenexpired = NULL
        WHERE id = ?";

$stmt = $con->prepare($sql);

$stmt->bind_param("ss", $password, $user["id"]);

$stmt->execute();

header("Location: /registration/team_project_final/loginpage.html");
exit;
?>
