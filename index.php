<!DOCTYPE html>
<?php
require('classes/API.php');
?>

<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zarządzanie intencjami">
    <meta name="author" content="Rafal Stanek">
    <title>Intencje</title>
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
            <button style="font-size: 2.1vmin;" class="navbar-toggler" type="button" data-toggle="collapse"
                data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link" href="logowanie.php">Zaloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container">
        <div class="row ">
            <div class="col-lg-12 text-center">
                <img src="./img/nmp.jpg" class="img-responsive mt-3" width="300" height="420" alt="obraz">
                <h3 class="mt-4">Intencje parafialne na najbliższe dni</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-nonfluid">
                <tbody>
                    <?php
					$api = new API;
					$getIntentionJson = $api->callAPI("GET", "http://localhost:8090/api/intention/week", null, "123");
					$result = json_decode($getIntentionJson);
					if ($result != null) {
						for ($i = 0; $i < sizeof($result); $i++) {
							if (sizeof($result) > 0) {
								echo
									'<tr>
									<td class="font-weight-bold text-center w-25">' . $result[$i]->dayName . '<br/>
									' . str_replace("-", ".", substr($result[$i]->date, -5)) . '
									</td>
									<td>';
								for ($j = 0; $j < sizeof($result[$i]->intentionList); $j++) {
									$intention = $result[$i]->intentionList[$j];
									echo '<p><b>' . substr($intention->date, 11, -12) . '</b>        ' . $intention->text . '</p>';
								}
								echo '</td>
							</tr>';
							}
						}
					} else {
						echo '<p class="lead text-center">Brak wprowadzonych intencji do systemu</p>';
					}

					?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <?php
	include "footer.php";
	?>
</body>

</html>