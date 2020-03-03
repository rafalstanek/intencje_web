<?php
session_start();
require_once('classes/API.php');

if (isset($_POST["create_datetime"])) {
    $date = $_POST["create_datetime"];
    $text = $_POST["create_text"];
    $api = new API;
    $array = array(
        'text' => $text,
        'date' => $date
    );
    $arrayEncode = json_encode($array);
    $addIntention = $api->callAPI("POST", "http://localhost:8090/api/intention",  $arrayEncode, $_SESSION['user_token']);
    echo $addIntention;
} else {
    echo "error";
}