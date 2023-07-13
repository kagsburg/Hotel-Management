
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
                            <a href="admin_home">Accueil</a>
                        </li>
                        <li>
                            Admins
                        </li>
                        <li class="active">
                            <strong>Tout les admins</strong>
                        </li>
                    </ol>
                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
          
        <div class="row">
             <?php
           $name=  mysqli_query($con, "SELECT * FROM users WHERE user_id='".$_SESSION['hotelsys']."'");
 while ($row=  mysqli_fetch_array($name)) {
     $employee=$row['employee'];
     $level=$row['level'];
     $user_id=$row['user_id'];
     $role=$row['role'];
     $status=$row['status'];
     $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee'");
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
                            <img alt="<?php echo $fullname; ?>" class="img-circle m-t-xs img-responsive" src="img/employees/thumbs/<?php echo md5($employee_id).'.'.$ext; ?>">
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
                                <?php if ($status==1) {
                                    echo ' <i class="fa fa-circle" style="color:#18A78A;"></i> Active';
                                } else {
                                    echo ' <i class="fa fa-circle" style="color:#BC2915"></i> Inactive';
                                }?>
                          
                        </p>
                        <address>
                            <strong>Téléphone</strong><br>
                          
                            <abbr title="Phone"><i class="fa fa-envelope"></i> :</abbr> <?php echo $email; ?>
                        </address>
                    </div>
                    <div class="clearfix"></div>
                        </a>
                    
                </div>
            </div>
            <?php } ?>
               </div>
        </div>

        </div>
    </div>
