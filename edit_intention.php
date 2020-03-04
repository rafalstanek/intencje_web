<?php
session_start();
require_once('classes/API.php');

if (isset($_POST["getText"])) {

    $api = new API;
    $getIntention = $api->callAPI("GET", "http://localhost:8090/api/intention/" . $_POST["getText"], null, $_SESSION['user_token']);
    echo $getIntention;
}