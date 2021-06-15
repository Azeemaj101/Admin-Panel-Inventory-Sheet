<?php
include '../partials/_ConnectionDB.php';
if(isset($_GET['delete']))
{
    $sno = $_GET['delete'];
    echo $sno;
    $sql2 = "DELETE FROM `USER` WHERE `USER`.`SID` = $sno";
    $result2 = mysqli_query($Connect_DB,$sql2);
    if($result2)
    {
        header("location:/inventory_sheet/php/User_Table.php");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
if(isset($_POST['snoEdit']))
{
    $SNO = $_POST['snoEdit'];
    $NAME = $_POST['Name1'];
    $USERNAME = $_POST['Username1'];
    $PASSWORD  = $_POST['Password1'];
    $PIN  = $_POST['pin1'];
    $EMAIL  = $_POST['Email1'];
    echo $SNO;
    $sql = "UPDATE `user` SET `NAME` = '$NAME', `USERNAME` = '$USERNAME', `PASSWORD` = '$PASSWORD', `PIN_CODE` = '$PIN', `EMAIL` = '$EMAIL' WHERE `user`.`SID` = $SNO";
    $result = mysqli_query($Connect_DB,$sql);
    if ($result)
    {
        header("location:/inventory_sheet/php/User_Table.php");
    }
    else
    {
        header("location:/inventory_sheet/php/User_Table.php");
    }

}
}
?>