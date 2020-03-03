<?php
session_start();
require_once('classes/API.php');

if (isset($_POST["old_password"]) && isset($_POST["new_password"])) {
    $old_password = $_POST['old_password'];
    $password = $_POST['new_password'];

    $data = array(
        'newPassword' => password_hash($password, PASSWORD_BCRYPT),
        'oldPassword' => $old_password,
    );
    $payload = http_build_query($data);
    $api = new API;
    $changePassword = $api->callAPI("PUT", "http://localhost:8090/api/user/" . $_SESSION['user_id'] . "" . "?" . $payload, null, $_SESSION['user_token']);
    echo $changePassword;
} else {
    echo "error";
}