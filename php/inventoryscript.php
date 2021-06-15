<?php
include '../partials/_ConnectionDB.php';
if(isset($_GET['delete']))
{
    $sno = $_GET['delete'];
    echo $sno;
    $sql2 = "DELETE FROM `INVENTORY_T` WHERE `INVENTORY_T`.`SID` = $sno";
    $result2 = mysqli_query($Connect_DB,$sql2);
    if($result2)
    {
        header("location:/inventory_sheet/php/inventory_Table.php");
    }
}
// <!-- `USERNAME`,`EMAIL`,`DONATION_INFO`,`ADDRESS`,`PHONE_NUMBER`,`AMOUNT_RECIEVED` -->

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if(isset($_POST['snoEdit']))
{
    $SNO = $_POST['snoEdit'];
    $USERNAME = $_POST['username1'];
    $iteam_name = $_POST['iteam_name1'];
        // $donation_info = $_POST['date2'];
    $description = $_POST['description1'];
    $quantity = $_POST['quantity1'];
    $estimated = $_POST['estimated_cost1'];
    $date = date('Y-m-d');
    // $date = date('Y-m-d');
    $sql = "UPDATE `INVENTORY_T` SET `USERNAME` = '$USERNAME',`ITEAM_NAME` = '$iteam_name',`DATE`='$date',`DESCRIPTION`='$description',`QUANTITY`='$quantity',`ESTIMATED_COST`='$estimated' WHERE `INVENTORY_T`.`SID` = $SNO";
    $result = mysqli_query($Connect_DB,$sql);
    echo var_dump($result);
    if ($result)
    {
        header("location:/inventory_sheet/php/inventory_Table.php");
    }

}
}
