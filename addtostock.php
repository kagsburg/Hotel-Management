<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login.php');
   }else{ ?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<?php
$ty=$_GET['ty'];

 if(isset($_POST['checkbox'])){    

                         $checkbox=$_POST['checkbox'];

                         foreach ($checkbox as $checkboxv){         

mysqli_query($con,"UPDATE salary_advances SET status='3' WHERE id='$checkboxv'") or die(mysqli_error($con));

                         } 

 echo '<div class="alert alert-success">Salary Advances  archived.Click <a href="archivedsalaryadvances">Here</a> to view</div>';

}
}



 ?>