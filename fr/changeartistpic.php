<?php 
include '../includes/conn.php';
$id=$_GET['id'];
$ext=$_GET['ext'];
    include 'includes/thumbs3.php';
         if ((isset($_FILES['uploaded_file']))&&(!empty($_FILES['uploaded_file']))){
        $fileName = $_FILES["uploaded_file"]["name"]; // The file name
$fileTmpLoc = $_FILES["uploaded_file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["uploaded_file"]["type"]; // The type of file it is
$fileSize = $_FILES["uploaded_file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["uploaded_file"]["error"]; // 0 for false... and 1 for true
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom);
if (!$fileTmpLoc) { // if file not chosen
    echo "ERROR: Please browse for a file before clicking the upload button.";
    exit();
} else if($fileSize > 5242880) { // if file size is larger than 5 Megabytes
    echo "ERROR: Your file was larger than 5 Megabytes in size.";
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName) ) {
     // This condition is only if you wish to allow uploading of specific file types    
     echo "ERROR: Your image was not .gif, .jpg, or .png.";
     unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
     exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
    echo "ERROR: An error occured while processing the file. Try again.";
    exit();
}
           $image_file=md5($id).'.'.$fileExt;
//           unlink("../images/artists/$image_file");
//           unlink("../images/artists/thumbs/$image_file");
//           unlink("../images/artists/thumbsx100/$image_file");
            move_uploaded_file($fileTmpLoc, "../images/artists/$image_file") or die("Error moving file");                    
             create_thumb('../images/artists/',$image_file,'../images/artists/thumbs/') or die(mysql_error());
 mysql_query("UPDATE artists  SET ext='$fileExt' WHERE artist_id='$id'") or die(mysql_error());
 echo '<div class="alert alert-success">Profile picture succefully changed</div>';
   header('Location:'.$_SERVER['HTTP_REFERER']);
                }
                else {
                    header('Location:'.$_SERVER['HTTP_REFERER']);
}
    ?>

