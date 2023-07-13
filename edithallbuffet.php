<?php 
include 'includes/conn.php';
   if(($_SESSION['hotelsys']!=1)&&($_SESSION['sysrole']!='manager')){
header('Location:login');
}
$id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Edit Hall Buffet - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
       <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/edithallbuffet.php';                     
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
            <li> <a href="logout">Logout</a> </li>
         </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Edi Hall Buffet</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>  <a href="hallbuffets">Hall Buffets</a>                       </li>
                        <li class="active">
                            <strong>Edit Hall Buffet</strong>
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
                            <h5>Edit Buffet <small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        
                        <div class="ibox-content">
                             <?php
if(isset($_POST['submit'])){ 
          $buffetname= mysqli_real_escape_string($con,trim($_POST['buffetname']));
          $buffetprice= mysqli_real_escape_string($con,trim($_POST['buffetprice']));
          $description= mysqli_real_escape_string($con,trim($_POST['description']));
          $item=$_POST['item'];
//          $quantity=$_POST['quantity'];
          $mealplans=$_POST['mealplans'];
   mysqli_query($con,"UPDATE hallbuffets SET buffet='$buffetname',price='$buffetprice',description='$description' WHERE hallbuffet_id='$id'") or die(mysqli_error($con));
   mysqli_query($con,"DELETE FROM hallbuffetitems WHERE hallbuffet_id='$id'");
   foreach ($item as $item){
      if(!empty($item)){      
   mysqli_query($con,"INSERT INTO hallbuffetitems(hallbuffet_id,item_id,status) VALUES('$id','$item',1)");
  }   
  } 
    mysqli_query($con,"DELETE FROM hallbuffetmealplans WHERE hallbuffet_id='$id'");
  foreach ($mealplans as $mealplan){
      if(!empty($mealplan)){
          mysqli_query($con,"INSERT INTO hallbuffetmealplans(hallbuffet_id,mealplan_id,status) VALUES('$id','$mealplan',1)") or die (mysqli_error($con));
      }
  }
?>
<div class="alert alert-success"><i class="fa fa-check"></i>Hall Buffet Successfully Added</div>
  <?php         
}
    $getbuffet=mysqli_query($con,"SELECT * FROM hallbuffets WHERE status='1' AND hallbuffet_id='$id'");
                                   $row = mysqli_fetch_array($getbuffet);
                                                     $hallbuffet_id=$row['hallbuffet_id'];
                                                     $buffet=$row['buffet'];
                                                     $price=$row['price'];
                                                     $description=$row['description'];
                                                          $status=$row['status'];
?>
    <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
            <div class="row">
           <div class="form-group col-lg-6"><label class="control-label">* Buffet Name</label>
               <input type="text" name="buffetname" class="form-control" placeholder="Enter Buffet Name" value="<?php echo $buffet; ?>">
             </div>
       
           <div class="form-group col-lg-6"><label class="control-label">* Buffet Price</label>
               <input type="text" name="buffetprice" class="form-control" placeholder="Enter Buffet Name" value="<?php echo $price; ?>">
             </div>
         </div>
                                            <div class="form-group"><label class="control-label">* Description</label>
              <textarea name="description" class="form-control" placeholder="Enter Description" cols="8"><?php echo $description; ?></textarea>
             </div>
           
            <div class="form-group"><label class="control-label">* Meal Plan(s)</label>
                <select data-placeholder="Choose Meal Plans..." name="mealplans[]" class="chosen-select" style="width:800px;" tabindex="2" multiple>
                                                                         <?php
                                                                           
             $getplans=  mysqli_query($con,"SELECT * FROM mealplans WHERE status=1");
                               while ($row = mysqli_fetch_array($getplans)) {
                                                          $mealplan_id=$row['mealplan_id'];
                                                          $mealplan=$row['mealplan'];
                                                         $check= mysqli_query($con,"SELECT * FROM hallbuffetmealplans WHERE hallbuffet_id='$id' AND mealplan_id='$mealplan_id'") or die(mysqli_error($con));
                                      if(mysqli_num_rows($check)>0){                                                         
                                                         ?>
                    <option value="<?php echo $mealplan_id; ?>" selected><?php echo $mealplan ?></option>
               <?php }else{?>
 <option value="<?php echo $mealplan_id; ?>"><?php echo $mealplan ?></option>
                                                      <?php }}?>
                                         </select>
                                                             </div>
                               <div class="form-group"><label class="control-label">* Item</label>
                              <select data-placeholder="Choose item..." name="item[]" class="chosen-select"  style="width:800px;"  tabindex="2" multiple>
                                 
                                        <?php
         $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");
 while($row=  mysqli_fetch_array($fooditems)){
     $menuitem_id=$row['menuitem_id'];
    $menuitem=$row['menuitem'];
    $itemprice=$row['itemprice'];
      $getitems= mysqli_query($con,"SELECT * FROM hallbuffetitems WHERE hallbuffet_id='$id' AND item_id='$menuitem_id' AND status=1") or die(mysqli_error($con));
      if(mysqli_num_rows($getitems)>0){ 
      ?>
                                  <option value="<?php echo $menuitem_id; ?>" selected="selected"><?php echo $menuitem; ?></option>
 <?php }else{?>
 <option value="<?php echo $menuitem_id; ?>"><?php echo $menuitem; ?></option>
 <?php }}?>
                                         </select>
                       </div>
                              <div class="form-group">
                                  <button class="btn btn-info" type="submit" name="submit">Edit Buffet</button>
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
  <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- iCheck -->
   <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
 <script type="text/javascript">
          $('.dataTables-example').dataTable();
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
        $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Item</label>   <select data-placeholder="Choose item..." name="item[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">choose item..</option><?php   $fooditems=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' ORDER BY menuitem");  while($row=  mysqli_fetch_array($fooditems)){     $menuitem_id=$row['menuitem_id']; $menuitem=preg_replace('/[^a-zA-Z0-9\-]/', ' ',$row['menuitem']);  $itemprice=$row['itemprice']; ?><option value="<?php echo $menuitem_id; ?>"><?php echo $menuitem; ?></option>               <?php }?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantity</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required="required">  </div> </div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
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