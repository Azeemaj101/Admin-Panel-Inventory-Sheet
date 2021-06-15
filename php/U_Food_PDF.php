<?php
session_start();
if (!isset($_SESSION['U_loggedin']) || $_SESSION['U_loggedin'] != true) {
    header("Location:/inventory_sheet/php/User_login.php");
    exit;
}
include '../partials/_ConnectionDB.php';
require "../vendor/autoload.php";
$html = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['DOS'])) {
    $Start = $_POST['DOS'];
    $End = $_POST['DOE'];
    $Que = "SELECT *FROM `donation` where `DATE` BETWEEN '$Start' AND '$End'";
    $RUN = mysqli_query($Connect_DB, $Que);
    if (mysqli_num_rows($RUN)) {
        if (mysqli_num_rows($RUN) > 0) {
            $html = '<hr>File Created By:' . strtoupper($_SESSION['username']) . '<br><br>Date Start:' . $Start . '<br>Date End:' . $End . '<br><hr><style>table, th, td{border: 1px solid black;}table{width: 100%;}th {height:70px;}td {text-align: center;}</style><table cellspacing="0px" cellpadding ="20px" height = "50px" width = "40px" border="4px">';
            $html .= '<tr><th>#SR</th><th>Username</th><th>Email</th><th>Donation Information</th><th>Address</th><th>Date</th><th>Phone Number</th><th>Amount Recieved</th></tr>';
            $i = 0;
            while ($row = mysqli_fetch_assoc($RUN)) {
                date_default_timezone_set("Asia/Karachi");
                $i += 1;
                $html .= '<tr><td>' . $i . '</td><td>' . $row['USERNAME'] . '</td><td>' . $row['EMAIL'] . '</td><td>' . $row['DONATION_INFO'] . '</td><td>' . $row['ADDRESS'] . '</td><td>' . $row['DATE'] . '</td><td>' . $row['PHONE_NUMBER'] . '</td><td>' . $row['AMOUNT_RECIEVED'] . '</td></tr>';
            }
            $html .= '</table><hr><br>Print Date Time:' . date('Y-m-d H:i');
            $_SESSION['PDF'] = $html;
        } else {
            $html = "Data not found";
        }
    } else {
        $html = "Data not found";
    }
}
if (isset($_POST['Download'])) {
    $HTML1 = $_SESSION['PDF'];
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($HTML1);
    $file = 'Donation' . time() . '.pdf';
    $mpdf->output($file, 'D');
    header("location:/inventory_sheet/php/Food_Table.php");
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    include '../partials/web_logo.php';
    ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="/inventory_sheet/css/Panel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Monthly Report</title>
</head>

<body style="background-color: gray;" id="body-pd">
    <?php
    include '../partials/U_Navbar.php';
    if ($html <> '') {
        echo '<div class="bg-light m-3 p-x-3 px-1 rounded">' . strtoupper($html) . '</div>';
    } elseif (isset($_SESSION['PDF'])) {
        echo '<div class="bg-light m-3 p-x-3 px-1 rounded">' . strtoupper($_SESSION['PDF']) . '</div>';
    } elseif (!isset($_POST['DOS'])) {
        echo '<div class="bg-light m-3 p-x-3 px-1 rounded">Empty...</div>';
    }
    ?>



    <form action="/inventory_sheet/php/U_Food_PDF.php" method="POST">
        <div class="d-flex justify-content-end m-5">
            <a href="/inventory_Sheet/php/U_Food_Table.php"><button type="button" class="btn btn-outline-light text-dark mx-2 btn-lg"><strong>
                        <ion-icon name="arrow-back"></ion-icon>
                    </strong></button></a>
            <button type="submit" class="btn btn-warning hov btn-lg" name='Download'>
                <ion-icon name="download"></ion-icon>&nbspDownload-PDF
            </button>
        </div>
        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
    </form>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>