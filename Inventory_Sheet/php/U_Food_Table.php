<?php
session_start();
if (!isset($_SESSION['U_loggedin']) || $_SESSION['U_loggedin'] != true) {
    header("Location:/inventory_sheet/index.php");
    exit;
}
$_SESSION['PDF']='Empty...';
include '../partials/_ConnectionDB.php';
$Food_Table = "CREATE TABLE `DONATION`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `USERNAME` VARCHAR(25) NOT NULL,
                                  `EMAIL` VARCHAR(50) NOT NULL,
                                  `DONATION_INFO` VARCHAR(150) NOT NULL,
                                  `ADDRESS` VARCHAR(150) NOT NULL,
                                  `DATE` DATE NOT NULL,
                                  `PHONE_NUMBER` VARCHAR(20) NOT NULL,
                                  `AMOUNT_RECIEVED` INT NOT NULL,
                                  PRIMARY KEY (`SID`))";



$F_Table_Query = mysqli_query($Connect_DB, $Food_Table);
if ($F_Table_Query) {
    $date = date('Y-m-d');
    $Food_FIRST_INSERT = "INSERT INTO `DONATION` (`USERNAME`,`EMAIL`,`DONATION_INFO`,`ADDRESS`,`DATE`,`PHONE_NUMBER`,`AMOUNT_RECIEVED`) VALUES('NONE','NONE','NONE','NONE','$date','NONE','NONE')";
    mysqli_query($Connect_DB, $Food_FIRST_INSERT);
}
$check = false;
if (isset($_POST['F_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_SESSION['username'];
        $email = $_POST['email2'];
        $donation_info = $_POST['donation_info2'];
        $address = $_POST['address2'];
        $phone_number = $_POST['phone_number2'];
        $amount_recieved = $_POST['amount_recieved2'];
        $date = date('Y-m-d');
        $Food1_FIRST_INSERT = "INSERT INTO `DONATION` (`USERNAME`,`EMAIL`,`DONATION_INFO`,`ADDRESS`,`DATE`,`PHONE_NUMBER`,`AMOUNT_RECIEVED`) VALUES('$user','$email','$donation_info','$address','$date','$phone_number','$amount_recieved')";
        $RUN = mysqli_query($Connect_DB, $Food1_FIRST_INSERT);
        if (!$RUN) {
            $check = true;
        }
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="/inventory_sheet/css/Panel.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital@1&display=swap" rel="stylesheet">
    <script src="/inventory_sheet/js/jquery.js"></script>
    <script src="/inventory_sheet/media/js/jquery.dataTables.min.js"></script>
    <link href="/inventory_sheet/media/css/jquery.dataTables.min.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "scrollX": true
            });
        });
    </script>
    <style>
        @media screen and (max-width: 500px) {

            div.dataTables_wrapper {
                width: 50px;
                margin: 0 auto;
                display: nowrap;
            }
        }

        @media screen and (max-width: 1040px) {

            div.dataTables_wrapper {
                width: 100%;
                margin: 0 auto;
                display: nowrap;
            }
        }
    </style>
    <title>Donation-Table</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <header>
        <?php
        include '../partials/U_Navbar.php';
        if ($check == true) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Username Already exits, Set different Username 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        ?>
    </header>
    <section>
        <!-- Button trigger modal
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Monthly Report&nbsp<ion-icon name="calendar"></ion-icon>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/U_Food_PDF.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Date start to</label>
                                <input type="date" class="form-control" id="DOS" name="DOS" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Date end from</label>
                                <input type="date" class="form-control" id="DOE" name="DOE">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal 1 for insert with button -->
        <div class="d-flex flex-row-reverse bd-highlight mt-5 px-5">
            <button type="button" class="btn btn-warning hov btn-lg mx-2" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass"><ion-icon name="add-circle"></ion-icon>ADD</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning hov btn-lg">
                <ion-icon name="copy"></ion-icon>&nbspGenerate-Report
            </button>
        </div>

        <div class="modal fade " id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-DONATION</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/U_Food_Table.php" method="POST">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <!-- `USERNAME`,`EMAIL`,`DONATION_INFO`,`ADDRESS`,`PHONE_NUMBER`,`AMOUNT_RECIEVED` -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Email ID</label>
                                <input type="email" maxlength="40" class="form-control" id="email2" name="email2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Donation Info</label>
                                <input type="text" maxlength="50" class="form-control" id="donation_info2" name="donation_info2">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Address</label>
                                <input type="text" maxlength="40" class="form-control" id="address2" name="address2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Phone Number</label>
                                <input type="text" minlength="11" maxlength="18" class="form-control" id="phone_number2" name="phone_number2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Amount Recieved</label>
                                <input type="number" maxlength="30" class="form-control" id="amount_recieved2" name="amount_recieved2">
                            </div>

                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" NAME="F_Submit" class="btn btn-primary">ADD</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="mx-1 my-2 py-3 text-center">
            <table class="table table-dark table-striped table-responsive" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">SR#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Donation Info</th>
                        <th scope="col">Address</th>
                        <th scope="col">Date</th>
                        <th scope="col">Phone No</th>
                        <th scope="col">Amount Recived</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <?php
                        $sql1 = "SELECT *FROM `DONATION`";
                        $result1 = mysqli_query($Connect_DB, $sql1);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                echo "<tr>
                            <th scope='row'>" . $form . "</th>
                            <td>" . $row['USERNAME'] . "</td>
                            <td>" . $row['EMAIL'] . "</td>
                            <td>" . $row['DONATION_INFO'] . "</td>
            <td>" . $row['ADDRESS'] . "</td>
            <td>" . $row['DATE'] . "</td>
            <td>" . $row['PHONE_NUMBER'] . "</td>
            <td>" . $row['AMOUNT_RECIEVED'] . "</td>
          </tr>";
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="/inventory_Sheet/php/User_Panel.php"><button type="button" class="btn btn-outline-light text-dark mb-3"><strong>
                        <ion-icon name="arrow-back"></ion-icon>
                    </strong></button></a>
        </div>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    </section>
</body>

</html>