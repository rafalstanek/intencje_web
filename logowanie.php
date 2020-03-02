<!DOCTYPE html>
<?php
require('classes/API.php');
session_start();

if (isset($_SESSION['user_type'])) {
    header('Location: panel.php');
}

?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zarządzanie intencjami">
    <meta name="author" content="Rafal Stanek">
    <title>Logowanie</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand w3-bar-item text-truncate" style="font-size: 2.1vmin;" href="index.php">Parafia
                Najświętszej
                Maryi Panny Częstochowskiej
                w Brzezinach</a>
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
                                <label class="font-weight-bold">Nazwa użytkownika:</label>
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control" type="text" id="login" name="login"
                                    placeholder="nazwa użytkownika">
                            </div>
                            <div id="user_text" class="col-sm align-self-center text-center">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 align-self-center text-left">
                                <label class="font-weight-bold">Hasło:</label>
                            </div>
                            <div class="col-sm-7">
                                <input class="form-control" type="password" id="password" name="password"
                                    placeholder="hasło">
                            </div>
                            <div id="pass_text" class="col-sm align-self-center text-center">
                            </div>
                        </div>
                    </div>
                    <div id="error_text">
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="btn btn-primary" type="submit" name="logging" value="Zaloguj">
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <?php
        if (isset($_POST['logging'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            $validate = 0;
            if (strlen($password) == 0) {
                echo '<script>document.getElementById("pass_text").innerHTML = "To pole nie może być puste!";
                document.getElementById("pass_text").style.color = "red";</script>';
            } else {
                $validate++;
            }

            if (strlen($login) == 0) {
                echo '<script>document.getElementById("user_text").innerHTML = "To pole nie może być puste!";
                document.getElementById("user_text").style.color = "red";</script>';
            } else {
                $validate++;
            }

            if ($validate == 2) {
                $data = array(
                    'username' => $login,
                    'password' => $password
                );
                $payload = http_build_query($data);
                $api = new API;
                $loginUser = $api->callAPI("GET", "http://localhost:8090/token" . "?" . $payload, null, null);
                if ($loginUser != "error") {
                    $result = json_decode($loginUser);
                    if ($result != null) {
                        $_SESSION['user_id'] = $result->id;
                        $_SESSION['user_token'] = $result->token;
                        $_SESSION['user_type'] = "user";
                        header('Location: panel.php');
                    } else {
                        echo '<script>document.getElementById("error_text").innerHTML = "Brak połączenia z serwerem";
                    document.getElementById("error_text").style.color = "red";</script>';
                    }
                } else {
                    echo '<script>document.getElementById("error_text").innerHTML = "Niepoprawny login i/lub hasło!";
                    document.getElementById("error_text").style.color = "red";</script>';
                }
            } else {
                echo '<script>document.getElementById("error_text").innerHTML = "Uzupełnij pole loginu i hasła!";
                document.getElementById("error_text").style.color = "red";</script>';
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