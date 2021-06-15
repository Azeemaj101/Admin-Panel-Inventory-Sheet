<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/inventory_sheet/index.php");
    exit;
}
include '../partials/_ConnectionDB.php';
//Incase table is not created so create by this query
$User_Table = "CREATE TABLE `USER`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `NAME` VARCHAR(35) NOT NULL,
                                  `USERNAME` VARCHAR(50) UNIQUE,
                                  `PASSWORD` VARCHAR(255) NOT NULL,
                                  `PIN_CODE` VARCHAR(50) NOT NULL,
                                  `EMAIL` VARCHAR(50) NOT NULL,
                                  PRIMARY KEY (`SID`))";

$U_Table_Query = mysqli_query($Connect_DB, $User_Table);

if ($U_Table_Query) {
    $User_FIRST_INSERT = "INSERT INTO USER (`NAME`,`USERNAME`,`PASSWORD`,`PIN_CODE`,`EMAIL`) VALUES('NONE','user','user','1234','NONE')";
    mysqli_query($Connect_DB, $User_FIRST_INSERT);
}
$check = false;
if (isset($_POST['U_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['Name2'];
        $user = $_POST['Username2'];
        $pass = $_POST['Password2'];
        $pin = $_POST['pin2'];
        $email = $_POST['Email2'];
        $User_FIRST_INSERT = "INSERT INTO USER (`NAME`,`USERNAME`,`PASSWORD`,`PIN_CODE`,`EMAIL`) VALUES('$name','$user','$pass','$pin','$email')";
        $RUN = mysqli_query($Connect_DB, $User_FIRST_INSERT);
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
        @media screen and (max-width: 700px) {

            div.dataTables_wrapper {
                width: 100%;
                margin: 0 auto;
                display: nowrap;
            }
        }
    </style>
    <title>User-Table</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <header>
        <?php
        include '../partials/Navbar.php';
        if ($check == true) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    Username Already exits, Set different Username 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        ?>
    </header>
    <section>
        <!-- Modal 1 for insert -->
        <div class="d-flex flex-row-reverse bd-highlight mt-5 px-5">
            <button type="button" class="btn btn-warning hov btn-lg mx-2" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass"><ion-icon name="add-circle"></ion-icon>ADD</button>
            <!-- <a href="USER_PDF.php"><button type="button"  class="btn btn-warning btn-lg"><ion-icon name="download"></ion-icon>&nbspDownload-PDF</button></a> -->
        </div>
        <div class="modal fade " id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-USER-DATA</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/User_Table.php" method="POST">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" maxlength="25" class="form-control" id="Name2" name="Name2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" maxlength="40" class="form-control" id="Username2" name="Username2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" minlength="4" maxlength="25" class="form-control" id="Password2" name="Password2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">PIN</label>
                                <input type="password" minlength="4" maxlength="25" class="form-control" id="pin2" name="pin2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" maxlength="40" class="form-control" id="Email2" name="Email2">
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" name="U_Submit" class="btn btn-primary">ADD</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <!-- Modal 2 for Update or Delete -->
        <div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel"><strong>UPDATE-USER-DATA</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/Userscript.php" method="POST">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" maxlength="25" class="form-control" id="Name1" name="Name1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" maxlength="40" class="form-control" id="Username1" name="Username1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password"  minlength="4" maxlength="25" class="form-control" id="Password1" name="Password1">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">PIN</label>
                                <input type="password"  minlength="4" maxlength="25" class="form-control" id="pin1" name="pin1">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" maxlength="40" class="form-control" id="Email1" name="Email1">
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mx-1 my-3 py-3 text-center">
            <table class="table table-dark table-striped table-responsive" id="myTable">
                <thead>
                    <tr>
                        <th scope="col"><small>SR#</small></th>
                        <th scope="col"><small>Name</small></th>
                        <th scope="col"><small>Username</small></th>
                        <th scope="col"><small>Password</small></th>
                        <th scope="col"><small>PIN</small></th>
                        <th scope="col"><small>Email</small></th>
                        <th scope="col"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <?php
                        $U_VIEW = "SELECT *FROM `USER`";
                        $result1 = mysqli_query($Connect_DB, $U_VIEW);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                echo "<tr>
            <th scope='row'><small>" . $form . "</small></th>
            <td><small>" . $row['NAME'] . "</small></td>
            <td><small>" . $row['USERNAME'] . "</small></td>
            <td><small>" . $row['PASSWORD'] . "</small></td>
            <td><small>" . $row['PIN_CODE'] . "</small></td>
            <td><small>" . $row['EMAIL'] . "</small></td>
            <td><button type='button' id=" . $row['SID'] . " class='btn btn-primary btn-sm edit' style='font-size: 10px;'>Edit</button>&nbsp<button type='button' id=d" . $row['SID'] . " class='delete btn btn-primary btn-sm ' style='font-size: 10px;'>Delete</button></td>
          </tr>";
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <div class = "text-center">
                <a href="/inventory_Sheet/php/Admin_Panel.php"><button type="button" class="btn btn-outline-light text-dark mb-3"><strong><ion-icon name="arrow-back"></ion-icon></strong></button></a>
            </div>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
        <script>
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    name = tr.getElementsByTagName("td")[0].innerText;
                    username = tr.getElementsByTagName("td")[1].innerText;
                    password = tr.getElementsByTagName("td")[2].innerText;
                    PIN = tr.getElementsByTagName("td")[3].innerText;
                    email = tr.getElementsByTagName("td")[4].innerText;
                    Name1.value = name;
                    Username1.value = username;
                    Password1.value = password;
                    pin1.value = PIN;
                    Email1.value = email;
                    snoEdit.value = e.target.id;
                    $('#editModal').modal('toggle');
                })
            })
            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    // console.log(e.target.id.substr(1, ));
                    sno = e.target.id.substr(1, );
                    if (confirm("You want to delete this record?")) {
                        console.log(e.target);
                        window.location = `/inventory_sheet/php/Userscript.php?delete=${sno}`;
                    }

                })
            })
        </script>
    </section>
</body>

</html>