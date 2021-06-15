<?php
include '../partials/_ConnectionDB.php';
if(isset($_GET['delete']))
{
    $sno = $_GET['delete'];
    echo $sno;
    $sql2 = "DELETE FROM `DONATION` WHERE `DONATION`.`SID` = $sno";
    $result2 = mysqli_query($Connect_DB,$sql2);
    if($result2)
    {
        header("location:/inventory_sheet/php/Food_Table.php");
    }
}
// <!-- `USERNAME`,`EMAIL`,`DONATION_INFO`,`ADDRESS`,`PHONE_NUMBER`,`AMOUNT_RECIEVED` -->

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if(isset($_POST['snoEdit']))
{
    $SNO = $_POST['snoEdit'];
    $USERNAME = $_POST['username1'];
    $EMAIL  = $_POST['email1'];
    $DONATION_INFO  = $_POST['donation_info1'];
    $ADDRESS  = $_POST['address1'];
    $PHONE_NUMBER  = $_POST['phone_number1'];
    $AMOUNT_RECIEVED  = $_POST['amount_recieved1'];
    // $date = date('Y-m-d');
    $sql = "UPDATE `DONATION` SET `USERNAME` = '$USERNAME',`EMAIL` = '$EMAIL',`DONATION_INFO` = '$DONATION_INFO',`ADDRESS` = '$ADDRESS',`PHONE_NUMBER` = '$PHONE_NUMBER',`AMOUNT_RECIEVED` = '$AMOUNT_RECIEVED' WHERE `DONATION`.`SID` = $SNO";
    $result = mysqli_query($Connect_DB,$sql);
    echo var_dump($result);
    if ($result)
    {
        header("location:/inventory_sheet/php/Food_Table.php");
    }

}
}
?>