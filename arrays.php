<?php 
include 'includes/conn.php';
   if((!isset($_SESSION['hotelsys']))){
header('Location:login');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Add User - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

   <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/addadmin.php';                     
                                       }else{
          ?>                               
  
    <div id="wrapper">

     <?php
     include 'nav.php';
              ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
         
        </div>
             
        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add New Admin</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a href="admins">Admins</a>                       </li>
                        <li class="active">
                            <strong>Add Admin</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add Values<small> All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                            
                             <?php         
     if(isset($_POST['submit'])){
   $username=$_POST['username']; 
   $roles=$_POST['roles']; 
  $allusernames=sizeof($username);    
foreach ($roles as $key => $value) {
    echo $username[$key].'<br>';
//    print_r($value);
    $List = implode(', ', $value);
    echo $List;
//    foreach ($value as $k => $v) {
//        echo "<tr>";
//          echo "<td>$v</td>"; // Get value.
//        echo "</tr>";
//    }
}

          //  foreach ($roles as $role){   
//     $getroles= implode(',',$roles[$i]);
//  echo $username[$i].' '.$roles[$i][$i].'<br/>';
//                echo $role;
   //             foreach ($username as $username){
//                    echo $username;
      //          }
    //   mysqli_query($con,"INSERT INTO arrayvalues(username,roles) VALUES('$username[$i]','$getroles[$i]')") or die(mysqli_error($con));
   // }
 
 ?>
     <div class="alert alert-success"><i class="fa fa-check"></i> Admin successfully Added</div>
    <?php

     }
?>
     <div class="rolestotal"></div>
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                       <div class="form-group"><label class="col-sm-2 control-label">* Username</label>

                                           <div class="col-sm-10"><input type="text" name="username[]" class="form-control roles" placeholder="Enter your username" value="Andrew">
                                                                        </div>
                                </div>
                            
                                                                 
                                <div class="hr-line-dashed"></div>
                                  
                                <div class="form-group">
                                <label class="col-sm-2 control-label">* Select Role</label>
                                <div class="col-sm-10" style="">
                                    <select data-placeholder="Choose a role..." class="form-control roles" name='roles[0][]' multiple>
                              <option value="manager">Manager</option>
                                <option value="Bar attendant">Bar Attendant</option>
                                <option value="Store Attendant">Store Attendant</option>
                                 <option value="Receptionist">Receptionist</option>
                                <option value="Hall Attendant">Hall Attendant</option>
                                <option value="Laundry Attendant">Laundry Attendant</option>
                                <option value="Restaurant Attendant">Restaurant Attendant</option>
                                <option value="Accountant">Accountant</option>
                                                                             </select>   
                                </div>
                                                            
                            </div>            
                                  <div class="form-group"><label class="col-sm-2 control-label">* Username</label>

                                    <div class="col-sm-10"><input type="text" name="username[]" class="form-control" placeholder="Enter your username" value="Mawanda">
                                                                        </div>
                                </div>
                            
                                                                 
                                <div class="hr-line-dashed"></div>
                                  
                                <div class="form-group">
                                <label class="col-sm-2 control-label">* Select Role</label>
                                <div class="col-sm-10" style="">
                                    <select data-placeholder="Choose a role..." class="form-control" name='roles[1][]' multiple>
                               <option value="manager">Manager</option>
                                <option value="Bar attendant">Bar Attendant</option>
                                <option value="Store Attendant">Store Attendant</option>
                                 <option value="Receptionist">Receptionist</option>
                                <option value="Hall Attendant">Hall Attendant</option>
                                <option value="Laundry Attendant">Laundry Attendant</option>
                                <option value="Restaurant Attendant">Restaurant Attendant</option>
                                <option value="Accountant">Accountant</option>
                                                                             </select>   
                                                      
                                </div>
                                                            
                            </div>                                                                                   
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">                                   
                                        <button class="btn btn-primary" type="submit" name="submit">Add Admin</button>
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
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

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
     var roles=$('.roles').length;
     $('.rolestotal').html(roles);
 });
             var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }

 var frmvalidator  = new Validator("form");
 frmvalidator.EnableOnPageErrorDisplay();
 frmvalidator.EnableMsgsTogether();
              frmvalidator.addValidation("password","minlength=6","*password  should atleast be 6 characters");
 frmvalidator.addValidation("repeat","eqelmnt=password", "*The passwords dont match");

    
</script>