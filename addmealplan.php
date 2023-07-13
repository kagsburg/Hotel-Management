<?php
include 'includes/conn.php';
 if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Receptionist')){
header('Location:login.php');
   }
   ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Meal Plan | Hotel Manager</title>
<script src="ckeditor/ckeditor.js"></script>
  <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    

    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">

  

    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">

   
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/addmealplan.php';                     
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
                    <h2>Add Meal plan</h2>
                    <ol class="breadcrumb">
                         <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                         <li>              <a href="mealplans">Meal Plans</a>                    </li>
                      
                        <li class="active">
                            <strong>Meal Plans</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
 
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Meal Plan <small>Ensure to fill all necessary fields</small></h5>
                        
                        </div>
                        <div class="ibox-content">
                                               <?php
                                                    if(isset($_POST['mealplan'],$_POST['price'])){
                                     $mealplan=  mysqli_real_escape_string($con,trim($_POST['mealplan']));
                                     $price=  mysqli_real_escape_string($con,trim($_POST['price']));
                                        $item=$_POST['item'];
          $quantity=$_POST['quantity'];
                                      if((empty($mealplan))||(empty($price))){
                                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Enter All Fields To Proceed</div>';
                                }                               
                                else{          
              mysqli_query($con,"INSERT INTO mealplans(mealplan,price,status) VALUES('$mealplan','$price','1')") or die(mysqli_error($con));
               $last_id=mysqli_insert_id($con);    
              $allitems= sizeof($item);
   for($i=0;$i<$allitems;$i++){        
   mysqli_query($con,"INSERT INTO mealplanitems(item_id,quantity,mealplan_id,status) VALUES('$item[$i]','$quantity[$i]','$last_id',1)");
   }
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Meal Plan  successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Meal Plan</label>

                             <input type="text" class="form-control" name='mealplan' placeholder="Enter Meal Plan" required='required'>
                                </div>
                     <div class="form-group"><label class="control-label">Price</label>
     <input type="text" class="form-control" name='price' placeholder="Enter Meal Plan Price" required='required'>
                                </div>                   
                              <div class='subobj'>
                          <div class='row'>
                                  <div class="form-group col-lg-6"><label class="control-label">* Product </label>
                                         <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">
                                    <option value="" selected="selected">choose item..</option>
                                        <?php
           $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
 while($row=  mysqli_fetch_array($fooditems)){
     $menuitem_id=$row['menuitem_id'];
$menuitem=$row['menuitem'];
  $itemprice=$row['itemprice'];
               ?>
                                    <option value="<?php echo $menuitem_id; ?>"><?php echo $menuitem; ?></option>
               <?php }?>
                                         </select>
                                                                                                        </div>
                                  <div class="form-group col-lg-5"><label class="control-label">Quantity</label>
                                    <input type="text" name='quantity[]' class="form-control" placeholder="Enter Quantity">
                                                                                                        </div>
                        
                               <div class="form-group col-lg-1">
                                                         <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>                                              
                                            </div> 
                           
                          
                                  </div>
                                                                                                        </div>                     
              <div class="form-group">
                                                                                                          <button class="btn btn-primary btn-sm" name="submit" type="submit">Add Meal Plan</button>
                                 
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

  
    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->

    <!-- MENU -->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

</body>
</html>
<script>
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
$('.subobj_button').click(function(e){ //on add input button click
        e.preventDefault();  
        $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Product</label>   <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">choose item..</option>       <?php  $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");  while($row=  mysqli_fetch_array($fooditems)){    $menuitem_id=$row['menuitem_id']; $menuitem=$row['menuitem'];   $itemprice=$row['itemprice'];     ?>      <option value="<?php echo $menuitem_id; ?>"><?php echo $menuitem; ?></option>               <?php }?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantity</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required="required">  </div></div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
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
      });
          $('.subobj').on("click",".remove_subobj", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
</script>
