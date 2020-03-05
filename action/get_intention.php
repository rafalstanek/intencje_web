<?php
session_start();
require_once('../classes/API.php');

if (isset($_POST["intentionData"])) {
    $date = $_POST["intentionData"];
    $from = $date . "%2000:00:00";
    $to = $date . "%2023:59:59";
    $api = new API;
    $getIntentionJson = $api->callAPI("GET", "http://localhost:8090/api/intention/between?first=" . $from . "&second=" . $to, null, $_SESSION['user_token']);
    echo $getIntentionJson;
} else {
    echo "error";
}