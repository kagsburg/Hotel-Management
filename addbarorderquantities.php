<?php 
include 'includes/conn.php';
if($_SESSION['sysrole']!='Bar attendant'){
header('Location:index.php');
   }
   $id=$_GET['id'];
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Add Bar Order Drinks Quantities- Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
      <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
                    <h2>Add Number of Drink Items</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Bar</a>                       </li>
                        <li class="active">
                            <strong>Add Number of Drink Items</strong>
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
                            <h5>Add number of Drink Items</h5>
                           
                        </div>
                        <div class="ibox-content">
                          
                         <?php
                                      $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE baround_id='$id'");
                                      while($row=  mysqli_fetch_array($getdrinks)){ 
                                          $barorder_id=$row['barorder_id'];
                                          $drink_id=$row['drink_id'];
                                          $drinkorder_id=$row['drinkorder_id'];
                                          $baround_id=$row['baround_id'];
                                          $getdrink=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
                                            $row2=  mysqli_fetch_array($getdrink);
                                                  $drink=$row2['drinkname'];
                                                  $quantity=$row2['quantity'];
                                          ?>
     <form method="post" name='form' class="form-horizontal" action=""  enctype="multipart/form-data">
                                                           <?php
                                        if(isset($_POST['quantity'.$drinkorder_id])){
                                          $quantity2=$_POST['quantity'.$drinkorder_id];
                                            mysqli_query($con,"UPDATE barorder_drinks SET items='$quantity2' WHERE drinkorder_id='$drinkorder_id'");
                                            mysqli_query($con,"UPDATE barorders SET status='1' WHERE barorder_id='$barorder_id'");
                                            echo '<div class="alert alert-success">Number of  '.$drink.' Successfully Added.Click <a href="barorder?id='.$baround_id.'">here</a> to view Order</div>';
                                            //header('Location:barinvoice?id='.$order_id);
                                        }                                              
                                      ?>
                                <div class="form-group"><label class="col-sm-3 control-label"><?php echo $drink.' ('.$quantity.')'; ?></label>

                                    <div class="col-sm-9"><input type="text" class="form-control" name='quantity<?php echo $drinkorder_id; ?>' placeholder="Enter number of Items" required='required'></div>
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