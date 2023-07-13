<?php 
include 'includes/conn.php';
$id=$_GET['id'];
$ext=$_GET['ext'];
   include 'includes/thumbs3.php';
         if ((isset($_FILES['image']))&&(!empty($_FILES['image']))){
    $image_name=$_FILES['image']['name'];
$image_size=$_FILES['image']['size'];
$image_temp=$_FILES['image']['tmp_name'];
$allowed_ext=array('jpg','jpeg','png','gif','');
$ext=explode('.',$image_name);
$image_ext=end($ext);
//$image=$_POST['image'];
$name=md5($id);
$image_file=$name.'.'.$image_ext;
//unlink('img/users/'.$name.'.'.$ext);
//unlink('img/users/thumbs/'.$name.'.'.$ext);
move_uploaded_file($image_temp,'img/users/'.$image_file) or die(mysqli_errno($con));
     create_thumb('img/users/',$image_file,'img/users/thumbs/');
  mysqli_query($con,"UPDATE users  SET ext='$image_ext' WHERE user_id='$id'") or die(mysqli_errno($con));
   header('Location:'.$_SERVER['HTTP_REFERER']);
                }
                else {
                    header('Location:'.$_SERVER['HTTP_REFERER']);
}
    ?>

