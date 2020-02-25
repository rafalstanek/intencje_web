<!DOCTYPE html>
<?php
session_start();
require('classes/API.php');
if (isset($_SESSION['user'])) {
	//header('Location: controll.php');
}
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zarządzanie intencjami">
    <meta name="author" content="Rafal Stanek">
    <title>Panel</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand" href="#">Panel</a>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Logowanie</h1>
                <p class="lead">Aby się zalogować użyj loginu i hasła</p>
                <center>
                    <form method="post" action="">
                        <div class="form-group mx-sm-3 mb-2">
                            <input class="form-control w-25" type="text" id="login" name="login"
                                placeholder="nazwa użytkownika"><br>
                            <input class="form-control w-25" type="password" id="password" name="password"
                                placeholder="hasło"><br>
                            <input class="btn btn-primary" type="submit" name="loginUser" value="Zaloguj">
                        </div>
                    </form>
                </center>
                <?php

				if (isset($_POST['loginUser'])) {
					$login = $_POST['login'];
					$password = $_POST['password'];

					$data = array(
						'login' => $login,
						'password' => $password
					);
					$payload = http_build_query($data);
					$api = new API;
					$loginUser = $api->callAPI("GET", "http://localhost:8090/api/user/login" . "?" . $payload, null, "123");
					$result = json_decode($loginUser);

					if ($result->id > 0) {
						if ($result->role == 0) {
							$_SESSION['user'] = "user";
							header('Location: controll.php');
						} else {
							$_SESSION['doctor'] = "doctor";
							$_SESSION['hospital_ID'] = -1;
							$_SESSION['title'] = $result->title;
							$_SESSION['speciality'] = $result->speciality;
							header('Location: main.php');
						}
						$_SESSION['id'] = $result->id;
						$_SESSION['firstName'] = $result->firstName;
						$_SESSION['lastName'] = $result->firstName;
					} else {
						echo "<p class='lead'><font color='red'>Nieprawidłowy login lub hasło</font></p>";
					}

					//else
					//{
					//	echo "<p class='lead'><font color='red'>Nieprawidłowe dane logowania</font></p>";
					//}
				}
				?>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>