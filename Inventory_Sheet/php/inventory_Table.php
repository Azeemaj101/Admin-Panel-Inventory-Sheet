<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/inventory_sheet/index.php");
    exit;
}
include '../partials/_ConnectionDB.php';
$_SESSION['PDF']='Empty...';
$Inventory_Table = "CREATE TABLE `INVENTORY_T`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `USERNAME` VARCHAR(50) NOT NULL,
                                  `ITEAM_NAME` VARCHAR(50) NOT NULL,
                                  `DATE` DATE NOT NULL,
                                  `DESCRIPTION` VARCHAR(150) NOT NULL,
                                  `QUANTITY` INT NOT NULL,
                                  `ESTIMATED_COST` INT NOT NULL,
                                  PRIMARY KEY (`SID`))";


// <!-- #SR Username Item Name Date Description Quantity Estimated Cost -->

$I_Table_Query = mysqli_query($Connect_DB, $Inventory_Table);
if ($I_Table_Query) {
    $Inventory_FIRST_INSERT = "INSERT INTO `INVENTORY_T` (`USERNAME`,`ITEAM_NAME`,`DATE`,`DESCRIPTION`,`QUANTITY`,`ESTIMATED_COST`) VALUES('NONE','NONE','NONE','NONE','NONE','NONE')";
    mysqli_query($Connect_DB, $Inventory_FIRST_INSERT);
}
$check = false;
if (isset($_POST['I_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $user = $_POST['username2'];
        $iteam_name = $_POST['iteam_name2'];
        // $donation_info = $_POST['date2'];
        $description = $_POST['description2'];
        $quantity = $_POST['quantity2'];
        $estimated = $_POST['estimated_cost2'];
        $date = date('Y-m-d');

        $Inventory1_FIRST_INSERT = "INSERT INTO `INVENTORY_T` (`USERNAME`,`ITEAM_NAME`,`DATE`,`DESCRIPTION`,`QUANTITY`,`ESTIMATED_COST`) VALUES('$user','$iteam_name','$date','$description','$quantity','$estimated')";
        $RUN = mysqli_query($Connect_DB, $Inventory1_FIRST_INSERT);
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
    <title>Inventory-Table</title>
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
        <!-- Modal 1 for insert with button -->
        <div class="d-flex flex-row-reverse bd-highlight mt-5 px-5">
            <button type="button" class="btn btn-warning hov btn-lg mx-2" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass"><ion-icon name="add-circle"></ion-icon>ADD</button>
            <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-lg hov">
                <ion-icon name="copy"></ion-icon>&nbspGenerate-Report
            </button>
        </div>

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
                        <form action="/inventory_sheet/php/inventory_PDF.php" method="POST">
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

        <!-- modal 2 -->
        <div class="modal fade " id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD Inventory</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/inventory_Table.php" method="POST">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" maxlength="20" class="form-control" id="username2" name="username2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Item Name</label>
                                <input type="text" maxlength="20" class="form-control" id="iteam_name2" name="iteam_name2">
                            </div>
                            <!-- #SR Username Iteam Name Date Description Quantity Estimated Cost -->

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Description</label>
                                <input type="text" class="form-control" maxlength="25" id="description2" name="description2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Quantity</label>
                                <input type="number" maxlength="20" class="form-control" id="quantity2" name="quantity2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Estimated Cost</label>
                                <input type="number" maxlength="20" class="form-control" id="estimated_cost2" name="estimated_cost2">
                            </div>

                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" NAME="I_Submit" class="btn btn-primary">ADD</button>
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
                        <h5 class="modal-title" id="insertModalLabel"><strong>Inventory-SET</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/inventoryscript.php" method="POST">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" maxlength="20" class="form-control" id="username1" name="username1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Item Name</label>
                                <input type="text" maxlength="20" class="form-control" id="iteam_name1" name="iteam_name1">
                            </div>
                            <!-- #SR Username Iteam Name Date Description Quantity Estimated Cost -->

                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Description</label>
                                <input type="text" class="form-control" maxlength="25" id="description1" name="description1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Quantity</label>
                                <input type="number" maxlength="20" class="form-control" id="quantity1" name="quantity1">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Extimated Cost</label>
                                <input type="number" maxlength="20" class="form-control" id="estimated_cost1" name="estimated_cost1">
                            </div>

                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" aut class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="mx-1 my-5 py-3 text-center">
            <table class="table table-dark table-striped table-responsive" id="myTable">
                <!-- #SR Username Iteam Name Date Description Quantity Estimated Cost -->

                <thead>
                    <tr>
                        <th scope="col"><small>SR#</small></th>
                        <th scope="col"><small>Username</small></th>
                        <th scope="col"><small>Item Name</small></th>
                        <th scope="col"><small>Description</small></th>
                        <th scope="col"><small>Date</small></th>
                        <th scope="col"><small>Quantity</small></th>
                        <th scope="col"><small>Estimated Cost</small></th>
                        <th scope="col"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <?php
                        $sql1 = "SELECT *FROM `INVENTORY_T`";
                        $result1 = mysqli_query($Connect_DB, $sql1);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                echo "<tr>
                                <th scope='row'><small>" . $form . "</small></th>
                                <td><small>" . $row['USERNAME'] . "</small></td>
                                <td><small>" . $row['ITEAM_NAME'] . "</small></td>
                                <td><small>" . $row['DESCRIPTION'] . "</small></td>
                                <td><small>" . $row['DATE'] . "</small></td>
                                <td><small>" . $row['QUANTITY'] . "</small></td>
                                <td><small>" . $row['ESTIMATED_COST'] . "</small></td>
                                <td><button type='button' id=j" . $row['SID'] . " class='detail btn btn-primary btn-sm mb-1' style='font-size: 10px;'>Detail</button>&nbsp<button type='button' id=" . $row['SID'] . " class='mb-1 btn btn-primary edit btn-sm' style='font-size: 10px;'>Edit</button>&nbsp<button type='button' id=d" . $row['SID'] . " class='delete btn btn-primary btn-sm' style='font-size: 10px;'>Delete</button></td>
                                </tr>";
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="/inventory_Sheet/php/Admin_Panel.php"><button type="button" class="btn btn-outline-light text-dark mb-3"><strong>
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
        <script>
            edits = document.getElementsByClassName('edit');
            // console.log(edits);
            // <!-- #SR Username Iteam Name Date Description Quantity Estimated Cost -->
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    username = tr.getElementsByTagName("td")[0].innerText;
                    iteam_name = tr.getElementsByTagName("td")[1].innerText;
                    // donation_info = tr.getElementsByTagName("td")[3].innerText;
                    description = tr.getElementsByTagName("td")[2].innerText;
                    quantity = tr.getElementsByTagName("td")[4].innerText;
                    estimated_cost = tr.getElementsByTagName("td")[5].innerText;
                    username1.value = username;
                    iteam_name1.value = iteam_name;
                    description1.value = description;
                    quantity1.value = quantity;
                    estimated_cost1.value = estimated_cost;
                    snoEdit.value = e.target.id;
                    $('#editModal').modal('toggle');
                })
            })
            detail = document.getElementsByClassName('detail');
            Array.from(detail).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    username = tr.getElementsByTagName("td")[0].innerText;
                    iteam_name = tr.getElementsByTagName("td")[1].innerText;
                    // donation_info = tr.getElementsByTagName("td")[3].innerText;
                    description = tr.getElementsByTagName("td")[2].innerText;
                    quantity = tr.getElementsByTagName("td")[4].innerText;
                    estimated_cost = tr.getElementsByTagName("td")[5].innerText;
                    alert("                               ****Record Details****" + "\nUsername => " + username + "\nItem Name => " + iteam_name + "\nDescription => " + description);
                    // d_username = username;
                    // iteam_name1.value = iteam_name;
                    // description1.value = description;
                    // quantity1.value = quantity;
                    // estimated_cost1.value = estimated_cost;
                    // snoEdit.value = e.target.id;
                    // $('#detailModal').modal('toggle');
                })
            })
            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    // console.log(e.target.id.substr(1, ));
                    sno = e.target.id.substr(1, );
                    if (confirm("You want to delete this record?")) {
                        // console.log("yes");
                        window.location = `/inventory_sheet/php/inventoryscript.php?delete=${sno}`;
                    }

                })
            })
        </script>
    </section>

</body>

</html>