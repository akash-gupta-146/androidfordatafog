<?php

include ("functions.php");

session_start();

$user_id=$_SESSION['user_id'];
$user_fname=$_SESSION['user_fname'];
$user_lname=$_SESSION['user_lname'];
$email_id=$_SESSION['email_id'];
$phone_no=$_SESSION['phone_no'];
$username=$_SESSION['username'];
$password=$_SESSION['password'];

if(isset($_GET['name'])){
    $file_name=$_GET['name'];
    $image = mysqli_query($con,"select * from files where file_name='$file_name'");
    $image = mysqli_fetch_assoc($image);
    $image = $image['file_data'];
   header ("Content-type: image/jpeg");
    echo file_get_contents($image);

}

?>