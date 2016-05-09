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

if(isset($_POST['dir_parent'])){
    $path = $_POST['dir_parent'];
    $query2 = "SELECT * FROM files where file_dir='$path'";
    $run2 = mysqli_query($con,$query2);
    if($run2){
        while($row_folders = mysqli_fetch_array($run2)){
                $fName = $row_folders['file_name'];
                echo "
                <div class='col-lg-6' id = 'file' name='$fName'>
                <img src='img/filemanager/file_icon.png' style='width:50px'>
                 $fName
                </div>";
        }
    }
    else { echo "error";}


    $query2 = "SELECT * FROM directories where dir_path='$path'";
    $run2 = mysqli_query($con,$query2);
    if($run2){
        while($row_folders = mysqli_fetch_array($run2)){
                $fName = $row_folders['dir_name'];
                echo "
                <div class='col-lg-6' id = 'dir' name='$fName'>
                <img src='img/filemanager/folder_icon.png' style='width:50px'>
                 $fName
                </div>";
        }
    }
    else { echo "error";}
}

if(isset($_POST['left_dir_parent'])){
    $path = $_POST['left_dir_parent'];
    $query2 = "SELECT * FROM files where file_dir='$path'";
    $run2 = mysqli_query($con,$query2);
    if($run2){
        while($row_folders = mysqli_fetch_array($run2)){
            $fName = $row_folders['file_name'];
            echo "
                <h5><img src='img/filemanager/file_icon.png' style='width:20px'> $fName</h5>
                <div id = 'lfile' name='$fName'>

                </div>";
        }
    }
    else { echo "error";}


    $query2 = "SELECT * FROM directories where dir_path='$path'";
    $run2 = mysqli_query($con,$query2);
    if($run2){
        while($row_folders = mysqli_fetch_array($run2)){
            $fName = $row_folders['dir_name'];
            echo "
                    <h5 id=$fName><img src='img/filemanager/folder_icon.png' style='width:20px'> $fName</h5>
                <div id = 'ldir' name='$fName'>

                </div>";
        }
    }
    else { echo "error";}

}


if(isset($_POST['dit_parent_back'])){
    $path = $_POST['dit_parent_back'];
    $query2 = "SELECT * FROM directories WHERE dir_name='$path'";
    $run2 = mysqli_query($con,$query2);
    if($run2){
        while($row_folders = mysqli_fetch_array($run2)){
            $fName = $row_folders['dir_name'];
            echo "$fName";
        }
    }
    else { echo "error";}

}


if(isset($_POST['fName'])){
    $fName = $_POST['fName'];
    $dir_parent = $_POST['dir_parent'];
    $query1 = "SELECT * FROM directories WHERE dir_name = '$fName' AND dir_parent = '$dir_parent'";
     $run1 = mysqli_query($con,$query1);
    if($run1){
        if(mysqli_fetch_row($run1)>0){
            echo "$fName already exist";
        }
        else{
            $query = "INSERT INTO directories VALUES ('' , '$fName' , '$dir_parent' , '$dir_parent' , '1')";
            $run = mysqli_query($con,$query);
            if($run){
                echo "Successfully created directory: $fName";
            }
        }
    }
    else{
        echo "php error";
    }
}

if(isset($_POST['remove_dir'])){
    $dirName = $_POST['remove_dir'];
    $dirParent = $_POST['remove_dir_parent'];
    $query = "DELETE FROM directories WHERE dir_name = '$dirName' AND dir_parent = '$dirParent'";
    $run = mysqli_query($con,$query);
    if($run){
        echo "Removed $dirName";
    }
    else{
        echo "Unable to remove";
    }
}

//if(isset($_FILES['file_name'])){
  //  $tmp_file = addslashes($_FILES['file_name']['tmp_name']);
//    $name = addslashes($_FILES['file_name']['name']);
  //  $type = $_FILES['file_name']['type'];
    //$size = $_FILES['file_name']['size'];
    //$data=mysqli_real_escape_string($con,file_get_contents($_FILES['file_name']['tmp_name']));
    //$dir = $_POST['dir_parent'];
    //move_uploaded_file($tmp_file,'upload_folder/'.$name);

    //$move_table = mysqli_query($con,"insert into files values('','$name','$size','$data','$dir','$type')");

    //echo "$dir";
//}
if(isset($_POST['file_name'])){
    $data = $_FILES['file_name']['tmp_name']; //instead of data we are sending the path.
    $file_name = $_FILES['file_name']['name'];
    $size = $_FILES['file_name']['size'];
    $type = $_FILES['file_name']['type'];
    $path = "/";
    $query = "INSERT INTO `datafog`.`files` (`file_id`, `file_name`, `file_size`, `file_data`, `file_dir`, `file_type`) VALUES (NULL, '$file_name', '$size', '$data' , '$path' , '$type' )";
    $run = mysqli_query($con,$query);
    if(!$run){
        echo "unable to add file $run";
    }
    else{
        echo"file added successfully ";
    }
}


if(isset($_POST['remove_file'])){
    $fileName = $_POST['remove_file'];
    $fileDir = $_POST['remove_fileDir'];
    $query = "DELETE FROM files WHERE file_name = '$fileName' AND file_dir = '$fileDir'";
    $run = mysqli_query($con,$query);
    if($run){
        echo "Removed $fileName";
    }
    else{
        echo "Unable to remove";
    }

}

if(isset($_POST['paste_path'])){
    $cut_name=$_POST['cut_name'];
    $cut_path= $_POST['cut_path'];
    $paste_parent=$_POST['paste_path'];

    $query = "UPDATE directories SET dir_path='$paste_parent', dir_parent='$paste_parent' WHERE dir_name='$cut_name' AND dir_path='$cut_path'";
    $run = mysqli_query($con,$query);

    if($run){
        echo "Directory Moved Successfully";
    }
    else{
        echo "Directory cannot be moved";
    }
}

if(isset($_POST['file_paste_path'])){
    $cut_name = $_POST['file_cut_name'];
    $cut_path = $_POST['file_cut_path'];
    $paste_parent = $_POST['file_paste_path'];

    $query = "UPDATE files SET file_dir='$paste_parent' WHERE file_name='$cut_name' AND file_dir='$cut_path'";
    $run = mysqli_query($con,$query);
    if($run){
        echo "File moved";
    }
    else{
        echo "unable to move selected file";
    }
}

if(isset($_POST['download'])){
	$download = $_POST['download'];
	$currentDir = $_POST['currentDir'];
	
	$query = "SELECT * from files where file_name='download' AND file_dir='currentDir'";
	$run = mysqli_query($con,$query);
	if($run){
		//while($row_files = mysqli_fetch_array($run)){
          // here error is caused because script is unable to read rows from table "file".
        //}
		  echo "File Will be downloaded";
	}
	else{
		echo"Unable to download the file, May be file is corrupt or is deleted. Refresh and Try again.";
	}
}
?>