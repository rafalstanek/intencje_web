<!DOCTYPE html>
<?php
ob_start();
session_start();
require_once('classes/API.php');

if (isset($_SESSION['user_type'])) {
    if ($_SESSION['user_type'] == "user") {

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
                        <a style="font-size: 2.1vmin;" class="nav-link" href="wyloguj.php">Wyloguj</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container">
        <div class="row d-flex justify-content-center mx-auto ">
            <div class="col-lg text-center mt-2">
                <button class="btn btn-info" data-toggle="modal" data-target="#checkByDateModal">Dodaj
                    intencję</button>
            </div>
            <div class="col-lg text-center mt-2">
                <button class="btn btn-info" data-toggle="modal" data-target="#generatePDFModal">Generuj PDF</button>
            </div>
            <div class="col-lg text-center mt-2">
                <button class="btn btn-info" data-toggle="modal" data-target="#changePasswordModal">Zmień hasło</button>
            </div>

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
                        <br />
                        <div id="intention_list">

                        </div>
                        <div id="textarea_intention_add">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL CHANGE PASSWORD -->
        <div id="changePasswordModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="mt-1">Zmiana hasła do konta</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-2 align-self-center text-left">
                                <label class=" font-weight-bold">Aktualne hasło:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="password" id="old_password" name="old_password"
                                    placeholder="nowe hasło">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 align-self-center text-left">
                                <label class=" font-weight-bold">Nowe hasło:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="password" id="new_password" name="new_password"
                                    placeholder="nowe hasło">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 align-self-center text-left">
                                <label class=" font-weight-bold">Powtórz hasło:</label>
                            </div>
                            <div class="col-sm">
                                <input class="form-control" type="password" id="re_password" name="re_password"
                                    placeholder="nowe hasło">
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-sm px-md-5"><button type="submit" name="change_pass_button"
                                    id="change_pass_button" class="btn btn-info">Zmień</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL GENERATE PDF-->
        <div id="generatePDFModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="mt-1">Generowanie PDF</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p class="lead">Wybierz zakres dat, z których ma się wygenerować plik .pdf z intencjami</p>
                        <label><b>Początek:</b></label>
                        <form method="POST">
                            <input type="date" name="date_start" id="date_start" class="form-control" />
                            <label><b>Koniec:</b></label>
                            <input type="date" name="date_end" id="date_end" class="form-control" /><br />
                            <div class="row text-center">
                                <div class="col-sm px-md-5"><button type="submit" name="generate_pdf_button"
                                        id="generate_pdf_button" class="btn btn-info">Generuj</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL EDIT INTENTION-->
        <div id="editIntentionModal" style="background-color: gray;" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="mt-1">Edycja intencji</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label><b>Treść:</b></label><textarea rows="2" name="text_intention_edit"
                            placeholder="Wpisz treść intencji" id="text_intention_edit" class="form-control"></textarea>
                        <button type="button" name="edit_intention_button" id="edit_intention_button"
                            class="btn btn-info">Edytuj</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php
            if (isset($_POST['generate_pdf_button'])) {
                $start = $_POST['date_start'];
                $end = $_POST['date_end'];
                if ($start != null && $end != null) {
                    if (strtotime($end) - strtotime($start) >= 0) {
                        $api = new API;
                        $getList = $api->callAPI("GET", "http://localhost:8090/api/intention/between?first=" . $start . "%2000:00:00&second=" . $end . "%2023:59:59",  null, $_SESSION['user_token']);
                        echo $getList;
                        require_once('pdf.php');
                        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                        $pdf->SetSettings(json_decode($getList), "intencje_" . $start);
                    } else {
                        echo '<script>alert("Błedne daty!")</script>';
                    }
                } else {
                    echo '<script>alert("Wybierz daty!")</script>';
                }
            }
            ?>

    <?php
            include "footer.php";
            ?>
</body>

</html>
<?php
    }
} else {
    header('Location: index.php');
}
?>