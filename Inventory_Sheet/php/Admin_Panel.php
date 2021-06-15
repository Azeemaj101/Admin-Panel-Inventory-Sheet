<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/inventory_sheet/index.php");
    exit;
}
include '../partials/_ConnectionDB.php';
$User_Table = "CREATE TABLE `USER`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `NAME` VARCHAR(25) NOT NULL,
                                  `USERNAME` VARCHAR(25) UNIQUE,
                                  `PASSWORD` VARCHAR(50) NOT NULL,
                                  `PIN_CODE` VARCHAR(50) NOT NULL,
                                  `EMAIL` VARCHAR(50) NOT NULL,
                                  PRIMARY KEY (`SID`))";
$U_Table_Query = mysqli_query($Connect_DB, $User_Table);

if ($U_Table_Query) {
    $User_FIRST_INSERT = "INSERT INTO USER (`NAME`,`USERNAME`,`PASSWORD`,`PIN_CODE`,`EMAIL`) VALUES('NONE','user','user','1234','NONE')";
    mysqli_query($Connect_DB, $User_FIRST_INSERT);
}

$check = 0;
if (isset($_POST['U_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['Name2'];
        $user = $_POST['Username2'];
        $pass = $_POST['Password2'];
        $pin = $_POST['pin_code2'];
        $email = $_POST['Email2'];
        $User_FIRST_INSERT = "INSERT INTO USER (`NAME`,`USERNAME`,`PASSWORD`,`PIN_CODE`,`EMAIL`) VALUES('$name','$user','$pass','$pin','$email')";
        $RUN = mysqli_query($Connect_DB, $User_FIRST_INSERT);
        if (!$RUN) {
            $check = 1;
        } else {
            $check = 2;
        }
    }
}
$check1 = 0;
if (isset($_POST['C_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $pin = $_POST['pin_code'];
        $email = $_POST['email'];
        $hash1 = password_hash($password, PASSWORD_DEFAULT);
        $h_pin = password_hash($pin, PASSWORD_DEFAULT);
        $User_FIRST_Update = "UPDATE `admin` SET `NAME` ='$name', `USERNAME` = '$username', `PASSWORD` = '$hash1', `PIN_CODE` = '$h_pin', `EMAIL` = '$email' WHERE `admin`.`SID` = 1";
        $RUN = mysqli_query($Connect_DB, $User_FIRST_Update);
        if (!$RUN) {
            $check1 = 1;
        } else {
            $check1 = 2;
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/inventory_sheet/css/Panel.css">
    <script src="/inventory_sheet/js/jquery.js"></script>
    <script src="/inventory_sheet/media/js/jquery.dataTables.min.js"></script>
    <link href="/inventory_sheet/media/css/jquery.dataTables.min.css" rel="stylesheet">

    <title>Admin-Panel</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <!-- Optional JavaScript; choose one of the two! -->
    <header>
        <?php
        include '../partials/Navbar.php';
        if ($check == 1) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
Username Already exits, Set different Username 
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
        } elseif ($check1 == 2) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Dear <b>' . $_SESSION['name'] . '</b> Account Updated Successfully 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        } elseif ($check == 2) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Dear account ADD successfully 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        ?>
    </header>
    <section>
        <!-- Modal 1 for insert -->
        <!-- <div class="d-flex flex-row-reverse bd-highlight mt-5 px-5">
            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">+ADD</button> -->
        <!-- </div> -->
        <div class="modal fade " id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-USER-Account</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/Admin_Panel.php" method="POST">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" minlength="4" maxlength="30" class="form-control" id="Name2" name="Name2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" minlength="4" maxlength="30" class="form-control" id="Username2" name="Username2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" id="Password2" name="Password2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Pin Code</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" id="pin_code2" name="pin_code2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" maxlength="40" class="form-control" id="Email2" name="Email2">
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" name="U_Submit" class="btn btn-primary">+ADD</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        <div class="modal fade " id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel"><strong><?php echo $_SESSION['name'] ?>-Update Your Account</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/inventory_sheet/php/Admin_Panel.php" method="POST">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" minlength="4" maxlength="30" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" minlength="4" maxlength="30" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" id="password" name="password" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">PIN-CODE</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" id="pin_code" name="pin_code">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" maxlength="40" class="form-control" id="email" name="email">
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" name="C_Submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center py-5 flex-wrap">
            <!-- //////////////////////////////////////////////////// -->
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                <div class="text-center">
                        <h6><b>Your Account Data</b></h6>
                    </div>
                    <hr>
                    <p class="card-text"><strong>Name:&nbsp <?php echo $_SESSION['name'] ?><br>Username:&nbsp <?php echo $_SESSION['username'] ?><br>Default PIN => 1234</strong></p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal">Update Account</button>
                    </div>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/inventory_sheet/pictures/Admin-Logo1.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <img src="/inventory_sheet/pictures/User-Logo.png" class="card-img-top" alt="...">
                    <p class="card-text text-center mt-3"><strong style="width: 16rem;">
                            Total Users:
                            <?php
                            $sql = "SELECT *FROM `USER`";
                            $RESULT = mysqli_query($Connect_DB, $sql);
                            if ($RESULT) {
                                $NUM = mysqli_num_rows($RESULT);
                                echo $NUM;
                            } else {
                                echo "0";
                            }
                            ?>
                        </strong></p>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <img src="/inventory_sheet/pictures/Admin-Logo3.png" style="width: 7rem;" class="card-img-top" alt="...">

                    <p class="card-text text-center"><strong><button type="button" class="btn btn-outline-info btn-sm m-3" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">+ADD-USER</button> </strong></p>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/inventory_sheet/pictures/Admin-Logo1.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <img src="/inventory_sheet/pictures/inventory.png" id="box" style="width: 4rem;" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <p class="card-text"><strong><?php
                                                        $sql = "SELECT *FROM `inventory_t`";
                                                        $RESULT = mysqli_query($Connect_DB, $sql);
                                                        if ($RESULT) {
                                                            $NUM = mysqli_num_rows($RESULT);
                                                            echo $NUM;
                                                        } else {
                                                            echo "0";
                                                        }
                                                        ?>-Inventory-Records</strong></p>
                        <a href="/inventory_sheet/php/inventory_Table.php">
                            <button type="button" class="btn btn-outline-info">View</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <img src="/inventory_sheet/pictures/donation.png" id="box" style="width: 4rem;" class="card-img-top" alt="...">

                    <div class="card-body text-center">
                        <p class="card-text"><strong><?php
                            $sql = "SELECT *FROM `donation`";
                            $RESULT = mysqli_query($Connect_DB, $sql);
                            if ($RESULT) {
                                $NUM = mysqli_num_rows($RESULT);
                                echo $NUM;
                            } else {
                                echo "0";
                            }
                            ?>-Donation-Records</strong></p>
                        <a href="/inventory_sheet/php/Food_Table.php">
                            <button type="button" class="btn btn-outline-info">View</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/inventory_sheet/pictures/Admin-Logo1.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <img src="/inventory_sheet/pictures/user1.png" id="box1" style="width: 4rem;" class="card-img-top" alt="...">

                    <div class="card-body text-center">
                        <p class="card-text"><strong><?php
                            $sql = "SELECT *FROM `USER`";
                            $RESULT = mysqli_query($Connect_DB, $sql);
                            if ($RESULT) {
                                $NUM = mysqli_num_rows($RESULT);
                                echo $NUM;
                            } else {
                                echo "0";
                            }
                            ?>-User's-Records</strong></p>
                    <a href="/inventory_sheet/php/User_Table.php" >
                        <button type="button" class="btn btn-outline-info">View</button>
                    </a>
                </div>
            </div>
        </div>
        </div>
        <!-- //////////////////////////////////////////////////// -->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <script>
            let g = document.getElementById("box1");
            console.log(g);
            g.addEventListener("mouseover", function(e) {
                this.style.transitionDuration = "0.5s"
                this.style.webkitTransform = "rotate(360deg) rotateZ(0deg)";
            })
            g.addEventListener("mouseout", function(e) {
                this.style.transitionDuration = "0.5s"
                this.style.webkitTransform = "rotate(-360deg) rotateZ(-0deg)";

            });
        </script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    </section>
    <?php
    include '../partials/Footer.php';
    ?>
</body>

</html>