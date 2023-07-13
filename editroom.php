<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   }
   $id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Edit room | Hotel Manager</title>
     <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
<link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
     <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
 <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/editroom.php';                     
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
           <li><a href="logout">Logout</a> </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Edit Room</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>   <a href="rooms">Rooms</a>            </li>
                        <li class="active">
                            <strong>Edit Room</strong>
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
                            <h5>Edit Room<small>Ensure to fill all neccesary fields</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                           <?php
                          if(isset($_POST['number'],$_POST['type'])){
                                if((!empty($_POST['number']))||(!empty($_POST['type']))){
                                                                       $number=  mysqli_real_escape_string($con,trim($_POST['number']));
                                    $type= mysqli_real_escape_string($con,trim($_POST['type']));
                                       $item=$_POST['item'];
                                    $check=  mysqli_query($con,"SELECT * FROM rooms WHERE roomnumber='$number' AND room_id!='$id'");
                                    if(mysqli_num_rows($check)>0){
                                          echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i> Room Number Already Exists</div>';
                                    }  else {
        mysqli_query($con,"UPDATE rooms SET roomnumber='$number',type='$type' WHERE room_id='$id'") or die(mysqli_errno($con)); 
        mysqli_query($con,"DELETE FROM roomitems WHERE room_id='$id'");
         foreach ($item as $item){
                            if(!empty($item)){      
                         mysqli_query($con,"INSERT INTO roomitems(room_id,item_id,status) VALUES('$id','$item',1)");
                         }   
                         }    
                                   echo '<div class="alert alert-success"><i class="fa fa-check"></i> Room successfully Edited</div>';
                                    }
                                }else{
                                   echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>All Fields Required</div>';
                                 }
                            }
                             $getroom=mysqli_query($con,"SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
                             $row=  mysqli_fetch_array($getroom);
                       $roomnumber=$row['roomnumber'];
                           $type=$row['type'];
                             $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                            ?>
                          
                            <form method="post" name='form' class="form" action=""  enctype="multipart/form-data">
                                <div class="form-group"><label class="control-label">Room Number</label>
                                    <input type="text" name="number" class="form-control" placeholder="Enter Room Number"  required="required" value="<?php echo $roomnumber; ?>">
                                </div>
                                                   <div class="form-group"><label class="control-label">Room Type</label>
                                        <select name="type" class="form-control">
                                                         <option value="<?php echo $type; ?>" selected="selected"><?php echo $roomtype; ?></option>
                                                      <?php 
                                                        $gettypes=  mysqli_query($con,"SELECT * FROM roomtypes WHERE status=1");
                                                      while ($row = mysqli_fetch_array($gettypes)) {
                                                          $roomtype_id=$row['roomtype_id'];
                                                          $roomtype=$row['roomtype'];
                                                          $status=$row['status'];
                                                      ?>
                                                     <option value="<?php echo $roomtype_id; ?>"><?php echo $roomtype; ?></option>
                                                  
                                                      <?php } ?>
                                                       
                                          </select></div>
                       <div class="form-group"><label class="control-label">Room  Items</label>
                              <select data-placeholder="Choose item..." name="item[]" class="chosen-select"  style="width:650px;"  tabindex="2" multiple>
                                 
                                        <?php
         $stock=mysqli_query($con,"SELECT * FROM stock_items WHERE status=1");
               while($row=  mysqli_fetch_array($stock)){
  $stockitem_id=$row['stockitem_id'];
  $cat_id=$row['category_id'];
$stockitem=$row['stock_item'];
  $getitems= mysqli_query($con,"SELECT * FROM roomitems WHERE room_id='$id' AND item_id='$stockitem_id'") or die(mysqli_error($con));
 if(mysqli_num_rows($getitems)>0){
  ?>
                                  <option value="<?php echo $stockitem_id; ?>" selected="selected"><?php echo $stockitem; ?></option>
               <?php }else{?>
 <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem; ?></option>
               <?php }}?>
                                         </select>
                       </div>                                                                             
                               <div class="form-group">
                                    <button class="btn btn-primary " type="submit">Edit Room</button>
                               
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
     <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
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
        </script>
</body>
</html>