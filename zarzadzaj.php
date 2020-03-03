<!DOCTYPE html>
<?php
ob_start();
session_start();
require_once('classes/API.php');

if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == "user") {
        include 'modal.php';
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Zarządzanie intencjami">
    <meta name="author" content="Rafal Stanek">
    <title>Zarządzaj</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation menu -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand w3-bar-item text-truncate" style="font-size: 2.1vmin;" href="#">Parafia
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
                        <a style="font-size: 2.1vmin;" class="nav-link active" href="#">Zarządzaj</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link" href="ustawienia.php">Zmień hasło</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-size: 2.1vmin;" class="nav-link" href="wyloguj.php">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container">
        <div class="row d-flex justify-content-center mx-auto">
            <div class="col-lg-12 text-center mt-2">
                <p class="lead">Wybierz dzień, aby zobaczyć intencje</p>
                <form action="" method="post" id="form">
                    <div class="form-group">
                        <div class="row ustify-content-md-center">
                            <div class="col-sm-4 align-self-center text-right">
                                <label class=" font-weight-bold">Data:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control w-50" type="date" id="date" name="date" placeholder="data">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <!--<input type="submit" class="btn btn-primary" name="select_date" value="Wybierz">-->
                            <button type="submit" name="btn" id="btn" class="btn btn-info" data-toggle="modal"
                                data-target="#exampleModal">Send Data</button>
                        </div>
                    </div>
                </form>

            </div>

            <!-- MODAL -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Intencje dnia ...</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="bingo"></div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php
                if (isset($_POST['btn'])) {
                    // echo 'ta';

                    $date = $_POST['date'];
                    $from = $date . "%2000:00:00";
                    $to = $date . "%2023:59:59";
                    $api = new API;
                    // $getIntentionJson = $api->callAPI("GET", "http://localhost:8090/api/intention/between?first=" . $from . "&second=" . $to, null, $_SESSION['user_token']);
                    $getIntentionJson = $api->callAPI("GET", "http://localhost:8090/api/intention/week", null, $_SESSION['user_token']);
                    $result = json_decode($getIntentionJson);
                    //echo $result[0]->dayName;

                    require_once('pdf.php');
                    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                    $pdf->SetSettings($result);
                    // $pdf->SetCreator(PDF_CREATOR);
                    //  $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING);
                    //$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                    //$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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