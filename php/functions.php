<?php
/**
 * Created by PhpStorm.
 * User: AKASH GUPTA
 * Date: 2/20/2016
 * Time: 1:00 PM
 */

//connecting to host and database.
$con=mysqli_connect('localhost','root','','datafog');
if(!$con){
    die("Error onnecting database: ".mysqli_error($con));
}
else{
    //echo"connected";
}


?>

