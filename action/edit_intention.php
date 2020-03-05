<?php
session_start();
require_once('../classes/API.php');

if (isset($_POST["getText"])) {

    $api = new API;
    $getIntention = $api->callAPI("GET", "http://localhost:8090/api/intention/" . $_POST["getText"], null, $_SESSION['user_token']);
    echo $getIntention;
}

if (isset($_POST["id_intention"])) {

    $api = new API;
    $array = array(
        'text' => $_POST["text_intention"]
    );
    $arrayEncode = json_encode($array);
    $editIntention = $api->callAPI("PUT", "http://localhost:8090/api/intention/" . $_POST["id_intention"],  $arrayEncode, $_SESSION['user_token']);
    echo $editIntention;
}

if (isset($_POST["delete_intention"])) {

    $api = new API;

    $deleteIntention = $api->callAPI("DELETE", "http://localhost:8090/api/intention/" . $_POST["delete_intention"],  null, $_SESSION['user_token']);
    echo $deleteIntention;
}