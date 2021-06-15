<?php
include '../partials/_ConnectionDB.php';
//Incase table is not created so create by this query 
$User_Table = "CREATE TABLE `USER`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `NAME` VARCHAR(25) NOT NULL,
                                  `USERNAME` VARCHAR(25) UNIQUE,
                                  `PASSWORD` VARCHAR(25) NOT NULL,
                                  `PIN_CODE` VARCHAR(25) NOT NULL,
                                  `EMAIL` VARCHAR(50) NOT NULL,
                                  PRIMARY KEY (`SID`))";

$U_Table_Query = mysqli_query($Connect_DB, $User_Table);
if ($U_Table_Query) {
    // $hash = password_hash('admin',PASSWORD_DEFAULT);
    $User_FIRST_INSERT = "INSERT INTO USER (`NAME`,`USERNAME`,`PASSWORD`,`PIN_CODE`,`EMAIL`) VALUES('NONE','user','user','9876','NONE')";
    mysqli_query($Connect_DB, $User_FIRST_INSERT);
}

$username = " ";
$password = " ";
$fatch_USER = "SELECT *FROM `USER`";
$USER_U_P = mysqli_query($Connect_DB, $fatch_USER);
$USER_TUPLE = mysqli_num_rows($USER_U_P);
$C_Username = " ";
$check = 0;
if (isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $C_Username = $_POST['Username'];
        $C_Password = $_POST['Password'];
        $L_Username = strtolower($C_Username);
        if ($USER_U_P and $USER_TUPLE > 0) {
            while ($row = mysqli_fetch_assoc($USER_U_P)) {
                $SID = $row['SID'];
                $name = $row['NAME'];
                $username = $row['USERNAME'];
                $D_Username = strtolower($username);
                $password = $row['PASSWORD'];
                $pin = $row['PIN_CODE'];
                $email = $row['EMAIL'];
                if ($C_Password == $password && $L_Username == $D_Username) {
                    //add admin panel
                    session_start();
                    $_SESSION['U_loggedin'] = true;
                    $_SESSION['username'] = $C_Username;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['SID'] = $SID;
                    $_SESSION['PIN'] = $pin;
                    header("location:/INVENTORY_SHEET/php/User_panel.php");
                } else {
                    $check = 1;
                }
            }
        }
        if ($check == 1) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Wrong Password -- You should check in Username or Password again.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
    }
}
$check1;
if (isset($_POST['F_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $F_Name = $_POST['name'];
        $F_Username = $_POST['username'];
        $F_Pin = $_POST['pin_code'];
        $F_email = $_POST['email'];
        if ($USER_U_P and $USER_TUPLE > 0) {
            while ($row = mysqli_fetch_assoc($USER_U_P)) {
                $SID = $row['SID'];
                $name = $row['NAME'];
                $username = $row['USERNAME'];
                $D_Username = strtolower($username);
                $pin = $row['PIN_CODE'];
                $email = $row['EMAIL'];
                $E_Name = strtolower($F_Username);
                $D_Name = strtolower($username);
                if ($E_Name == $D_Name && $pin == $F_Pin) {
                    //add admin panel
                    session_start();
                    $_SESSION['U_forgot'] = true;
                    $_SESSION['username'] = $C_Username;
                    $_SESSION['name'] = $name;
                    $_SESSION['pin'] = $pin;
                    $_SESSION['SID'] = $SID;
                    header("location:/INVENTORY_SHEET/php/U_Forgot.php");
                } else {
                    $check1 = 1;
                }
            }
        }
        if ($check1 == 1) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Wrong PIN -- Please contact to admin if you forgot your PIN.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="/INVENTORY_SHEET/css/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>


<div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content text-light bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"><strong>Forgot Password</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/inventory_sheet/php/User_login.php" method="POST">
                        <input type="hidden" name="snoEdit" id="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">PIN-CODE</label>
                            <input type="password" class="form-control" id="pin_code" name="pin_code">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <br>
                        <HR>
                        <div class="text-center">
                            <button type="submit" name="F_Submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->
    <div class="pin justify-content-center align-items-center ">
        <div class="card py-5 px-5 border border-primary container1 bg-dark text-light text-center">
            <div class="text-center mb-3">
                <img src="/INVENTORY_SHEET/pictures/Admin_L.png" id="box" class="img-fluid" alt="LOGO" width="200" height="50">
            </div>
            <h2 class="heading mx-2 px-2 pb-2">Login to User-Panel</h2>
            <form action="/INVENTORY_SHEET/php/User_login.php" method="POST">
                <div class="mb-1">
                    <input type="text" placeholder="Username" class="form-control" size="35" id="Username" maxlength="25" name="Username" aria-describedby="emailHelp ">
                </div>
                <div class="mb-3">

                    <input type="password" maxlength="20" placeholder="Password" class="form-control" id="Password" name="Password">
                </div>
                <div class="text-center text-danger "><u>Hint:User</u></div>
                <hr>
                <div class="text-center mt-3">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" id="change_pass">Forgot Password</button>
                    <button type="submit" onkeypress="return
enterKeyPressed(event)" name="submit" id="A_submit" class="btn btn-success btn-block">Log in</button>
                    <a href="/inventory_sheet/index.php"><button type="button" class="btn btn-primary btn-sm">Admin-Panel</button></a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function enterKeyPressed(event) {
            if (event.keyCode == 13) {
                console.log("Enter key is pressed");
                return true;
            } else {
                return false;
            }
        }
        let g = document.getElementById("box");
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
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>