<!DOCTYPE html>
<?php
require('classes/API.php');
session_start();

if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == "user") {
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zarządzanie intencjami">
    <meta name="author" content="Rafal Stanek">
    <title>Ustawienia konta</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand w3-bar-item text-truncate" style="font-size: 2.1vmin;" href="panel.php">Parafia
                Najświętszej
                Maryi Panny Częstochowskiej
                w Brzezinach</a>
            <button style="font-size: 2.1vmin;" class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link" href="panel.php">Intencje</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link" href="zarzadzaj.php">Zarządzaj</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link active" href="#">Zmień hasło</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link" href="wyloguj.php">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container" style="padding-top: 8%">
        <div class="row d-flex justify-content-center mx-auto">
            <div class="col-lg-12 text-center mt-2">

                <form method="post" action="">
                    <div class="form-group">
                        <div class="row ustify-content-md-center">
                            <div class="col-md-2 align-self-center text-left">
                                <label class=" font-weight-bold">Stare hasło:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="password" id="old_password" name="old_password"
                                    placeholder="stare hasło">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 align-self-center text-left">
                                <label class=" font-weight-bold">Nowe hasło:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="password" id="new_password" name="new_password"
                                    placeholder="nowe hasło">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 align-self-center text-left">
                                <label class="font-weight-bold">Potwórz hasło:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="password" id="re_password" name="re_password"
                                    placeholder="powtórz hasło">
                            </div>
                        </div>
                    </div>
                    <div id="error_text">
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary" type="submit" name="change" value="Zmień">
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <?php
                if (isset($_POST['change'])) {
                    $old_password = $_POST['old_password'];
                    $password = $_POST['new_password'];
                    $re_password = $_POST['re_password'];
                    if (strlen($old_password) == 0 or strlen($password) == 0 or strlen($re_password) == 0) {
                        echo '<script>document.getElementById("error_text").innerHTML = "Wszystkie pola muszą być uzupełnione!";
                        document.getElementById("error_text").style.color = "red";</script>';
                    } else {
                        if ($password == $re_password) {
                            $api = new API;
                            $data = array(
                                'newPassword' => password_hash($password, PASSWORD_BCRYPT),
                                'oldPassword' => $old_password,
                            );
                            $payload = http_build_query($data);

                            $changePassword = $api->callAPI("PUT", "http://localhost:8090/api/user/" . $_SESSION['user_id'] . "" . "?" . $payload, null, null);

                            if (strlen($changePassword) != 0) {
                                echo '<script>document.getElementById("error_text").innerHTML = "Hasło zostało pomyślnie zmienione!";
                        document.getElementById("error_text").style.color = "green";</script>';
                            } else {
                                echo '<script>document.getElementById("error_text").innerHTML = "Podano błędne hasło!";
                        document.getElementById("error_text").style.color = "red";</script>';
                            }
                        } else {
                            echo '<script>document.getElementById("error_text").innerHTML = "Hasła muszą się zgadzać!";
                        document.getElementById("error_text").style.color = "red";</script>';
                        }
                    }
                }
                ?>
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <?php
                include "footer.php";
                ?>
</body>

</html>
<?php
    }
} else {
    header('Location: logowanie.php');
}
?>