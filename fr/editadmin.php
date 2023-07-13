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
                <div class="col-lg-10">
                    <h2>Add New User</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="admins">Admins</a>                       </li>
                        <li class="active">
                            <strong>Edit Admin</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Admin Details <small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                             <?php
if(isset($_POST['fullname'],$_POST['email'],$_POST['role'])){
   $fullname=mysqli_real_escape_string($con,trim( $_POST['fullname'])); 
   $email=mysqli_real_escape_string($con,trim($_POST['email']));
        $role=$_POST['role'];
     if($role=='manager'){
         $status=1;
     }  else {
     $status=0;    
     }
     if((empty($fullname))||(empty($email))||(empty($role))){
         $errors[]='All Fields marked *  should be filled';
     }
if(!empty($errors)){
foreach($errors as $error){ 
 ?>
 <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-danger"><?php echo $error; ?></div></div>
<?php 
   }
}
else{
            mysqli_query($con,"UPDATE  users SET fullname='$fullname',email='$email',role='$role',status='$status' WHERE user_id='$id' ") or die(mysql_error());                     
                       
?>
  
     <div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> Admin Details Successfully Edited</div></div>
    <?php

    }
     }
        $user=mysqli_query($con,"SELECT * FROM users WHERE user_id='$id'");
           $row=  mysqli_fetch_array($user);
                 $fullname1=$row['fullname'];
                    $email1=$row['email'];
                   $role1=$row['role'];
?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">* Fullname</label>

                                    <div class="col-sm-10"><input type="text" name='fullname'  value="<?php echo $fullname1; ?>" class="form-control" placeholder="Enter fullname" required="required">
                                                                            </div>
                                </div>
                              
                                  <div class="form-group"><label class="col-sm-2 control-label"> *Email Address</label>

                                      <div class="col-sm-10"><input type="email" name="email"  value="<?php echo $email1; ?>" class="form-control "  placeholder="Enter a valid email address" required="required">
                                      <div id='form_email_errorloc' class='text-danger'></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-sm-2 control-label">* Select Role</label>
                                <div class="col-sm-10" style="">
                                    
                                <select data-placeholder="Choose a role..." class="form-control" name='role'>
                                    <option value="<?php echo $role1; ?>"><?php echo $role1; ?></option>
                                <option value="manager">Manager</option>
                                <option value="bar attendant">Bar Attendant</option>
                                <option value="Store Attendant">Store Attendant</option>
                                 <option value="Receptionist">Receptionist</option>
                                <option value="Laundry Attendant">Laundry Attendant</option>
                                <option value="Restaurant Attendant">Restaurant Attendant</option>
                                <option value="Accountant">Accountant</option>
                                                                             </select>   
                                                      
                                </div>
                                                            
                            </div>                                                                                   
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">                                   
                                        <button class="btn btn-primary" type="submit">Edit User</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>
