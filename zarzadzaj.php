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
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/zarzadzaj.js"></script>
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
                <p class="lead">Zarządzanie</p>
                <button name="btn" id="btn" class="btn btn-info" data-toggle="modal"
                    data-target="#checkByDateModal">Dodaj
                    intencję</button>
                <button type="submit" name="btn" id="btn" class="btn btn-info" data-toggle="modal"
                    data-target="#exampleModal">Generuj PDF</button>
                <button type="submit" name="btn" id="btn" class="btn btn-info" data-toggle="modal"
                    data-target="#exampleModal">Zmień hasło</button>
            </div>

            <!-- MODAL BY DATE-->
            <div id="checkByDateModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="mt-1">Dodawanie intencji</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-2"> <label><b>Data:</b></label></div>
                                <div class="col-sm"><input type="date" name="date" id="date" class="form-control" />
                                </div>
                                <div class="col-sm">
                                    <button type="button" name="check_intention_button" id="check_intention_button"
                                        class="btn btn-info">Wybierz</button></div>
                            </div>
                            <div id="intention_list">

                            </div>
                            <div id="textarea_intention_add">

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script type="text/javascript">

        </script>

        <!--

        // require_once('pdf.php');
        // $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // $pdf->SetSettings($result);
        // }

        -->




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