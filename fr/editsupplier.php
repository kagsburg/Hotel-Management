    <?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
        }else{
       $id=$_GET['id'];
                   if(isset($_POST['suppliername'],$_POST['address'],$_POST['phone'],$_POST['email'])){
                    $suppliername=mysqli_real_escape_string($con,trim($_POST['suppliername']));
                    $address=mysqli_real_escape_string($con,trim($_POST['address']));
                    $phone=mysqli_real_escape_string($con,trim($_POST['phone']));
                  $email=  mysqli_real_escape_string($con,trim($_POST['email']));    
               
                   $products=$_POST['products'];
                
     if((empty($suppliername))||(empty($address))||(empty($phone))){
         $errors[]='Some Fields marked * are Empty';
     }
                      if(!empty($errors)){
                    foreach ($errors as $error) {
                        echo '<div class="alert alert-danger">'.$error.'</div>';              
                          }
                      }else{                 
                      mysqli_query($con,"UPDATE suppliers SET suppliername='$suppliername',address='$address',phone='$phone',email='$email' WHERE supplier_id='$id'") or die(mysqli_error($con));
                      mysqli_query($con, "DELETE FROM supplierproducts WHERE supplier_id='$id'");
                 foreach ($products as $product) {
                      mysqli_query($con,"INSERT INTO supplierproducts(product_id,supplier_id,status) VALUES('$product','$id',1)");
                  }        
                      }
                      }  
  header('Location:'.$_SERVER['HTTP_REFERER']);
      }
                          ?>