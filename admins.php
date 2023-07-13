<?php
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))||($_SESSION['hotelsyslevel']!=1)){
header('Location:login');
}
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

       <title>Admins | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/admins.php';                     
                                       }else{
          ?>          
    <div id="wrapper">
 <?php include 'nav.php'; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          
        </div>
            <ul class="nav navbar-top-links navbar-right">
                                  
                <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-9">
                    <h2>Admins</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="admin_home">Home</a>
                        </li>
                        <li>
                            Admins
                        </li>
                        <li class="active">
                            <strong>All Admins</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
          
        <div class="row">
             <?php 
           $name=  mysqli_query($con,"SELECT * FROM users WHERE user_id!='".$_SESSION['hotelsys']."' AND status=1");  
           while ($row=  mysqli_fetch_array($name)){
  $employee=$row['employee'];
  $level=$row['level'];
  $user_id=$row['user_id'];
  $role=$row['role'];
  $status=$row['status'];
    $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$employee'");
                                         $row = mysqli_fetch_array($employee);
                                          $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                          $gender=$row['gender'];
                                          $design_id=$row['designation'];
                                                 $ext=$row['ext'];											
                                            $email=$row['email'];											
                                            $phone=$row['phone'];											
                                            $salary=$row['salary'];											
                                            $date=$row['start_date'];	
            ?>
          <div class="col-lg-4">
                <div class="contact-box">
                    <a href="employee?id=<?php echo $employee_id;?>">
                    <div class="col-sm-4">
                        <div class="text-center">
                            <?php
                            if(!empty($ext)){
                            ?>
                            <img alt="<?php echo $fullname; ?>" class="img-circle m-t-xs img-responsive" src="img/employees/thumbs/<?php echo md5($employee_id).'.'.$ext; ?>">
                            <?php }else{?>
                            <img alt="<?php echo $fullname; ?>" class="img-circle m-t-xs img-responsive" src="img/avatar.png">
                       
                            <?php }?>
                            <div class="m-t-xs font-bold">
                                <?php
                echo $role;
                                    ?>
                             
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <h3><strong><?php echo $fullname;?></strong></h3>
                        <p>
                                <?php if($status==1){
                                    echo ' <i class="fa fa-circle" style="color:#18A78A;"></i> Active'; }
                                    else{
                                          echo ' <i class="fa fa-circle" style="color:#BC2915"></i> Inactive';
                                    }?>
                          
                        </p>
                        <address>
                            <strong>Contact</strong><br>
                          
                            <abbr title="Phone"><i class="fa fa-envelope"></i> :</abbr> <?php echo $email; ?>
                        </address>
                    </div>
                    <div class="clearfix"></div>
                        </a>
                
                </div>
              <a href="activateadmin?id=<?php echo $user_id;?>&&status=1" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $user_id; ?>()">Remove</a>
                   <script type="text/javascript">
function confirm_delete<?php echo $user_id; ?>() {
  return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
}
</script>                 
            </div>
            <?php } ?>
               </div>
        </div>

        </div>
    </div>
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>


    <script>
        $(document).ready(function(){
            $('.contact-box').each(function() {
                animationHover(this, 'pulse');
            });
        });
    </script>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/contacts.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:37:18 GMT -->
</html>
