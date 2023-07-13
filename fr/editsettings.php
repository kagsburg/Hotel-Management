<?php
include 'includes/conn.php';
  if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
         }else{
   if(isset($_POST['edit'])){
                                                    $hotelname= mysqli_real_escape_string($con,trim($_POST['hotelname']));
                                                    $nif=mysqli_real_escape_string($con,trim($_POST['nif']));
                                                    $hoteladdress= mysqli_real_escape_string($con,trim($_POST['hoteladdress']));
                                                    $corporatename= mysqli_real_escape_string($con,trim($_POST['corporatename']));
                                                    $hotelcontacts= mysqli_real_escape_string($con,trim($_POST['hotelcontacts']));
                                                    $hotelmanager= mysqli_real_escape_string($con,trim($_POST['hotelmanager']));
                                                      $image_name=$_FILES['logo']['name'];
                      $image_size=$_FILES['logo']['size'];
                      $image_temp=$_FILES['logo']['tmp_name'];
$allowed_ext=array('jpg','jpeg','png','PNG','gif','JPG','JPEG','GIF','');
$imgext=explode('.',$image_name);                             
$image_ext=end($imgext);   
 if (in_array($image_ext,$allowed_ext)===false){
$errors[]='Image File type not allowed';
}
if($image_size>20097152){
$errors[]='Maximum Image size is 20Mb';
}
if(!empty($errors)){
    foreach ($errors as $error) {
        echo $error;
    }
}else{
    if((!empty($hotelname))&&(mysqli_num_rows($getsettings)==0)){
        if(!empty($image_name)){
        mysqli_query($con,"UPDATE settings SET hotelname='$hotelname',nif='$nif',hoteladdress='$hoteladdress',corporatename='$corporatename',hotelcontacts='$hotelcontacts',hotelmanager='$hotelmanager',logo='$image_ext'");
         $image_file='sitelogo.'.$image_ext;                                      
      move_uploaded_file($image_temp,'img/'.$image_file) or die(mysqli_error($con)); 
        }else{
       mysqli_query($con,"UPDATE settings SET hotelname='$hotelname',nif='$nif',hoteladdress='$hoteladdress',corporatename='$corporatename',hotelcontacts='$hotelcontacts',hotelmanager='$hotelmanager'");
         }
        }
        }
     header('Location:'.$_SERVER['HTTP_REFERER']);
    }
   }
?>