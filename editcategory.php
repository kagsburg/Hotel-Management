    <?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
       }else{
       $id=$_GET['id'];
                       if(isset($_POST['category'])){
                       $category=  mysqli_real_escape_string($con,trim($_POST['category']));
                       if(empty($category)){
                           $errors[]='Category Name Required';
                       }
                       $check=  mysqli_query($con,"SELECT * FROM categories WHERE category='$category' AND status=1 AND category_id!='$id'");
                       if(mysqli_num_rows($check)>0){
                           $errors[]='Category Already Added';    
                       }
                       if(!empty($errors)){
                       foreach ($errors as $error){
                       echo '<div class="alert alert-danger">'.$error.'</div>';
                       }
                       }else{
                           mysqli_query($con,"UPDATE categories SET category='$category' WHERE category_id='$id'") or die(mysqli_error($con));
 header('Location:'.$_SERVER['HTTP_REFERER']);
                      }
                      } 
                      } 
                          ?>