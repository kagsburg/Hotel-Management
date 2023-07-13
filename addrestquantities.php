<?php 
include 'includes/conn.php';
 if($_SESSION['sysrole']!='Restaurant Attendant'){
header('Location:index.php');
   }
   $restround_id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add Restaurant Order Quantities- Hotel Manager</title>
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
                                           include 'fr/addrestquantities.php';                     
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
                    <h2>Add Number of plates/ Bottles/ Glasses</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Bar</a>                       </li>
                        <li class="active">
                            <strong>Add Number of food items</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Add number of Plates / Bottles / glasses</h5>
                           
                        </div>
                        <div class="ibox-content">
                          
                         <?php
                                      $getfoods=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE restround_id='$restround_id'");
                                      while($row=  mysqli_fetch_array($getfoods)){ 
                                          $food_id=$row['food_id'];
                                          $order_id=$row['order_id'];
                                          $restorder_id=$row['restorder_id'];
                                          $type=$row['type'];
                                                 if($type=='drink'){
                      $drinks=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$food_id'");
   $row2=  mysqli_fetch_array($drinks);
  $drinkname=$row2['drinkname'];
  $drinkquantity=$row2['quantity'];   
                               }else{
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                  }
                                          ?>
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                                           <?php
                                        if(isset($_POST['quantity'.$restorder_id])){
                                          $quantity2=$_POST['quantity'.$restorder_id];
                                            mysqli_query($con,"UPDATE restaurantorders SET quantity='$quantity2' WHERE restorder_id='$restorder_id'");
                                            mysqli_query($con,"UPDATE orders SET status='1' WHERE order_id='$order_id'");
                               echo '<div class="alert alert-success">Number of  items Successfully Added.Click <a href="restorder?id='.$restround_id.'" target="_blank">here</a> to View order</div>';
                                                                                   }                                              
                                      ?>
                                <div class="form-group"><label class="col-sm-3 control-label"><?php 
                                if($type=='drink'){
                                echo $drinkname.' ('.$drinkquantity.')'; 
                                    } else{
                                    echo $menuitem;
                                }
                                ?></label>

                                    <div class="col-sm-9"><input type="text" class="form-control" name='quantity<?php echo $restorder_id; ?>' placeholder="Enter number of Items" required='required'></div>
                                </div>
                                      <?php } ?>

                                                        <div class="hr-line-dashed"></div>
                            
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Add Item Numbers</button>
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
 
</body>

</html>
 <script type="text/javascript">
     
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