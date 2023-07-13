<?php
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Restaurant Attendant")){
header('Location:index.php');
   }
   ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Restaurant Customer | Hotel Manager</title>
<script src="ckeditor/ckeditor.js"></script>
  <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

  

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
   
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/addrestcustomer.php';                     
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
             <ul class="nav navbar-top-links navbar-right">
            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Add Restaurant Customer</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                      
                        <li class="active">
                            <strong>Add Restaurant Customer</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Customer <small>Ensure to fill all necessary fields</small></h5>
                                                </div>
                        <div class="ibox-content">
                                               <?php
                                                     if(isset($_POST['customername'],$_POST['customercompany'],$_POST['customerphone'],$_POST['customeremail'],$_POST['passport_id'])){
                                                           $customername=  mysqli_real_escape_string($con,trim($_POST['customername']));
                               $customercompany=  mysqli_real_escape_string($con,trim($_POST['customercompany']));
                               $customerphone=  mysqli_real_escape_string($con,trim($_POST['customerphone']));
                               $customeremail=  mysqli_real_escape_string($con,trim($_POST['customeremail']));
                               $passport_id=  mysqli_real_escape_string($con,trim($_POST['passport_id']));         
                                if(empty($customername)){
                                   $errors[]='Enter Customer name To Proceed';
                                }
                                                $check=  mysqli_query($con,"SELECT * FROM customers WHERE passport_id='$passport_id' AND type='bar' AND status=1");
                                if(mysqli_num_rows($check)>0){
                                    $errors[]='Customer Already Exists';
                                }
                                   if(!empty($errors)){
                                foreach ($errors as $error) {
                                    echo '<div class="alert alert-danger">'.$error.'</div>';
                                }}else{
                                                            
              mysqli_query($con,"INSERT INTO customers(customername,customercompany,customerphone,customeremail,passport_id,type,status) VALUES('$customername','$customercompany','$customerphone','$customeremail','$passport_id','rest','1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Customer successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                 <div class="form-group">
                                     <label class="control-label">*Customer Name</label>
                                     <input type="text" class="form-control" name='customername' placeholder="Enter customer Name" required="required">
                                                                                                                  </div>
                                     <div class="form-group">
                                     <label class="control-label">Company</label>
                                    <input type="text" class="form-control" name='customercompany' placeholder="Enter Customer Name">
                                                                                                                  </div>
           <div class="form-group">
                                     <label class="control-label">Telephone</label>
                                    <input type="text" class="form-control" name='customerphone' placeholder="Enter Customer telephone">
                                                                                                                  </div>
                                       <div class="form-group">
                                     <label class="control-label">Email</label>
                                    <input type="text" class="form-control" name='customeremail' placeholder="Enter Customer Name">
                                                                                                                  </div>
                                      <div class="form-group">
                                     <label class="control-label">Passport ID</label>
                                    <input type="text" class="form-control" name='passport_id' placeholder="Enter Passport ID">
                                                                                                                  </div>
<!--                                      <div class="form-group">
                                     <label class="control-label">Discount (%)</label>
                                    <input type="text" class="form-control" name='discount' placeholder="Enter Discount">
                                                                                                                  </div>-->
                                        
                               <div class="form-group">                                 
                     <button class="btn btn-primary" name="submit" type="submit">Add Customer</button>
                                               </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                        


    </div>
                                       <?php }?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- Chosen -->
    <script src="js/plugins/chosen/chosen.jquery.js"></script>

   <!-- Input Mask-->
    <!--<script src="js/plugins/jasny/jasny-bootstrap.min.js"></script>-->

   <!-- Data picker -->
   <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

  <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
 <script>
        $(document).ready(function(){

            $('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: "dd/mm/yyyy",
            });
              $('.dataTables-example').dataTable();

            /* Init DataTables */
            var oTable = $('#editable').dataTable();

            /* Apply the jEditable handlers to the table */
            oTable.$('td').editable( 'http://webapplayers.com/example_ajax.php', {
                "callback": function( sValue, y ) {
                    var aPos = oTable.fnGetPosition( this );
                    oTable.fnUpdate( sValue, aPos[0], aPos[1] );
                },
                "submitdata": function ( value, settings ) {
                    return {
                        "row_id": this.parentNode.getAttribute('id'),
                        "column": oTable.fnGetPosition( this )[2]
                    };
                },

                "width": "90%"
            } );
            });
   </script>
 
</body>


</html>
