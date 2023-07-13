<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
  $id=$_GET['id'];
                                       
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Edit Employee Information - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php include 'nav.php'; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          
        </div>
            <ul class="nav navbar-top-links navbar-right">
               
                <li>
                    <a href="logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Edit Employee Information</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Employees</a>                       </li>
                        <li class="active">
                            <strong>Edit Employee Information</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Edit Employee Information<small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">
 <?php
   if(isset($_POST['fullname'],$_POST['gender'],$_POST['phone'],$_POST['designation'],$_POST['email'],$_POST['salary'],$_POST['joining'])){
                                            $fullname1=  mysqli_real_escape_string($con,trim($_POST['fullname']));
                                     $phone1= mysqli_real_escape_string($con,trim($_POST['phone']));
		 $email1= mysqli_real_escape_string($con,trim($_POST['email']));
		 $salary1= mysqli_real_escape_string($con,trim($_POST['salary']));
		 $gender1= mysqli_real_escape_string($con,trim($_POST['gender']));
		   $employeenumber1=mysqli_real_escape_string($con,trim($_POST['employeenumber']));
       $joining1=mysqli_real_escape_string($con,  strtotime(str_replace('/', '-', $_POST['joining'])));
       $ending1=mysqli_real_escape_string($con,  strtotime(str_replace('/', '-', $_POST['ending'])));
       $dob1=mysqli_real_escape_string($con,  strtotime(str_replace('/', '-', $_POST['dob'])));
        $address1= mysqli_real_escape_string($con,trim($_POST['address']));
                                     $job=explode('-',$_POST['designation']);
                                     $designation1=current($job);
                                      $department1=end($job);
                                     $check=mysqli_query($con,"SELECT * FROM employees WHERE email='$email1' AND status='1' AND employee_id!='$id'");
                                     if (mysqli_num_rows($check)>0){
                                    echo '<div class="alert alert-danger">Oops!!The Email Address Already  exists</div>';
                                                }  
                                                
                                                else {
            $addemployee=  mysqli_query($con,"UPDATE  employees SET fullname='$fullname1',employeenumber='$employeenumber1',dob='$dob1',phone='$phone1',address='$address1',email='$email1',gender='$gender1',designation='$designation1',start_date='$joining1',end_date='$ending1',salary='$salary1' WHERE employee_id='$id'") or die(mysqli_errno($con));
                                               
                echo '<div class="alert alert-success">Employee Data succesfully Edited</div>';                
                                                                    }
                                }
                      $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$id'");
                                                $row = mysqli_fetch_array($employee);
                                            $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                          $gender=$row['gender'];
                                          $design_id=$row['designation'];
                                            $status=$row['status'];
                                            $employeenumber=$row['employeenumber'];
                                            $address=$row['address'];
                                            $ext=$row['ext'];											
                                            $dob=$row['dob'];											
                                            $email=$row['email'];											
                                            $phone=$row['phone'];											
                                            $salary=$row['salary'];											
                                            $startdate=$row['start_date'];											
                                            $enddate=$row['end_date'];												
                                          $dept2=  mysqli_query($con,"SELECT * FROM designations WHERE designation_id='$design_id'");
                                     $row2=  mysqli_fetch_array($dept2);
                                     $dept_id=$row2['department_id'];
                                    $design=$row2['designation'];
                                    $dept=  mysqli_query($con,"SELECT * FROM departments WHERE department_id='$dept_id'");
                                   $row2 = mysqli_fetch_array($dept);
                                     $dept_name=$row2['department'];           
                                    
                                    ?>
                        
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">* Fullname</label>

                                    <div class="col-sm-10">
          <input type="text" name='fullname' class="form-control" placeholder="Enter fullname" value="<?php echo $fullname; ?>" required="required">
                                                                            </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                                  <div class="form-group"><label class="col-sm-2 control-label">Employee Number</label>

                                    <div class="col-sm-10">
          <input type="text" name='employeenumber' class="form-control" placeholder="Enter number" value="<?php echo $employeenumber; ?>" required="required">
                                                                            </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">* Gender</label>

                                    <div class="col-sm-10">
                                        <select name="gender" class="form-control">
                                            <option value="<?php echo $gender;?>"><?php echo $gender;?></option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                                                        </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                   
                                 <div class="form-group"><label class="col-sm-2 control-label">*Phone</label>

                                    <div class="col-sm-10"><input type="text" name="phone" class="form-control" placeholder="Enter  phone Number" value="<?php echo $phone;?>" required="required">
                                                                        </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">* Salary</label>

                                    <div class="col-sm-10"><input type="text" name="salary" class="form-control" placeholder="Enter  Employee Salary" value="<?php echo $salary;?>"  required="required">
                                                                        </div>
                                </div>
                                  <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">* Address</label>

                                    <div class="col-sm-10"><input type="text" name="address" class="form-control" placeholder="Enter  Employee Address" value="<?php echo $address;?>"  required="required">
                                                                        </div>
                                </div>
                                 <div class="hr-line-dashed"></div>
                                 <div class="form-group" id="data_1">
                              <label class="col-sm-2 control-label">Contract Start Date</label>
                               <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="<?php echo date('m/d/Y',$startdate);?>"  class="form-control" name="joining" placeholder="Enter Joining Date" required="required">
                                </div>
                                </div>
                            </div>
                                   <div class="hr-line-dashed"></div>
                                 <div class="form-group" id="data_1">
                              <label class="col-sm-2 control-label">Contract End Date</label>
                               <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" value="<?php echo date('m/d/Y',$enddate);?>"  class="form-control" name="ending" placeholder="Enter Joining Date" required="required">
                                </div>
                                </div>
                            </div>
                                    <div class="hr-line-dashed"></div>
                                 <div class="form-group" id="data_1">
                              <label class="col-sm-2 control-label">Date of Birth</label>
                               <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" value="<?php if(!empty($dob)){ echo date('m/d/Y',$dob); }?>"  class="form-control" name="dob" placeholder="Enter Date of Birth" required="required">
                                </div>
                                </div>
                            </div>
                                   <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">*Designation</label>

                                    <div class="col-sm-10">
                                      <select class="form-control" name="designation">
                                          <option value="<?php echo $design_id.'-'.$dept_id;?>" selected="selected"> <?php echo $design.' ('.$dept_name.')';?></option>
                                            <?php
                                                                           
                                    $dept2=  mysqli_query($con,"SELECT * FROM designations");
                                    if(mysqli_num_rows($dept2)>0){
                                   while($row2=  mysqli_fetch_array($dept2)){
                                        $design_id2=$row2['designation_id'];
                                    $dept_id2=$row2['department_id'];
                                    $design2=$row2['designation'];
                                    $status2=$row2['status'];
                                     $dept=  mysqli_query($con,"SELECT * FROM departments WHERE department_id='$dept_id2'");
                                   $row = mysqli_fetch_array($dept);
                                     $dept_name2=$row['department'];
                                                 ?>
                  <option value="<?php echo $design_id2.'-'.$dept_id2;?>"> <?php echo $design2.' ('.$dept_name2.')';?></option>
                                    <?php }} ?>
                                        </select>
                                                                        </div>
                                </div>
                                                                    
                                                                  
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label"> *Email Address</label>

                                      <div class="col-sm-10"><input type="email" name="email" class="form-control "  placeholder="Enter a valid email address" value="<?php echo $email; ?>" required="required">
                                      <div id='form_email_errorloc' class='text-danger'></div>
                                    </div>
                                </div>
                               

                                                        <div class="hr-line-dashed"></div>
                            
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Edit Employee</button>
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

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- iCheck -->
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
 <script type="text/javascript">
        $(document).ready(function(){
            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
            });
                  

     
</script>