<?php
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
   } 
   ?>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hall Buffets | Hotel Manager</title>
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
                                           include 'fr/hallbuffets.php';                     
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
                    <h2>Hall Buffets</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                      
                        <li class="active">
                            <strong>Hall Buffets</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">
                     
                                 <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Hall Buffets</h5>
                        
                        </div>
                        <div class="ibox-content">
                             <table class="table table-striped  table-hover">
                    <thead>
                    <tr>
                       <th>Name</th>
                        <th>Charge</th>
                        <th>Description</th>
                        <th>Meal Plans</th>
                            <th>Items</th>
                        <th>Action</th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>     <?php
                            $buffets=mysqli_query($con,"SELECT * FROM hallbuffets WHERE status='1'");
                            if(mysqli_num_rows($buffets)>0){
                                while ($row = mysqli_fetch_array($buffets)) {
                                                     $hallbuffet_id=$row['hallbuffet_id'];
                                                     $buffet=$row['buffet'];
                                                     $price=$row['price'];
                                                     $description=$row['description'];
                                                          $status=$row['status'];
                                                                         ?>
                                     
                       <tr>
                                      <td><?php echo $buffet; ?></td>
                                   <td><?php echo $price; ?></td>
                                   <td><?php echo $description; ?></td>
                              
                                      <td>
                                          <ul>
    <?php 
                                   $getplans= mysqli_query($con,"SELECT * FROM hallbuffetmealplans WHERE hallbuffet_id='$hallbuffet_id'") or die(mysqli_error($con));
                                   while($row1= mysqli_fetch_array($getplans)){
                                       $mealplan_id=$row1['mealplan_id'];
                                 $mealplans=  mysqli_query($con,"SELECT * FROM mealplans WHERE status=1 AND mealplan_id='$mealplan_id'");
                                    $row2 = mysqli_fetch_array($mealplans);
                                           $mealplan=$row2['mealplan'];
                                      echo '<li>'.$mealplan.'</li>';
                                   }
                                   ?>
                                     </ul>
                                          </td>
                                            <td>
                                              <ul>
                                       <?php 
                                   $getitems= mysqli_query($con,"SELECT * FROM hallbuffetitems WHERE hallbuffet_id='$hallbuffet_id'") or die(mysqli_error($con));
                                   while($row1= mysqli_fetch_array($getitems)){
                                       $item_id=$row1['item_id'];
                                             $fooditem=mysqli_query($con,"SELECT * FROM menuitems WHERE status='1' AND menuitem_id='$item_id'");
                                  $row2=  mysqli_fetch_array($fooditem);
                                      $menuitem=$row2['menuitem'];
                                      echo '<li>'.$menuitem.'</li>';
                                   }
                                   ?>
                                          </ul>
                                   </td>
                                  <td>
                                        <?php
                                            if(($_SESSION['hotelsyslevel']==1)){ 
                                        ?>
                                        <a href="edithallbuffet?id=<?php echo $hallbuffet_id;?>" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a>
                                        <a href="removehallbuffet?id=<?php echo $hallbuffet_id;?>" onclick="return cdelete<?php echo $hallbuffet_id;?>()" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Remove</a>
                       <script type="text/javascript">
                         function cdelete<?php echo $hallbuffet_id; ?>() {
  return confirm('You are about To Delete this item. Do you want to proceed?');
}
</script>                 
         <?php } ?>
                                    </td>
                       </tr>
                       
                                    <?php
                                }
                            }  else {
echo "<div class='alert alert-danger'>No Buffets Added Yet</div>";                             
}
                            ?>
                    
                    </tbody>
                             </table>
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
