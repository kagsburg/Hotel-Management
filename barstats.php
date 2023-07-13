<?php
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Bar attendant')){
header('Location:login.php');
   }
?>
<!DOCTYPE html>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Bar Stats-Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>
<body>

    <div id="wrapper">

        <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
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
                <div class="col-lg-9">
                    <h2>Dashboard</h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i>Bar Stats</a></li>
                        
                    </ol>
                </div>
                           </div>
            <div class="wrapper wrapper-content animated fadeInRight">
           
                <div class="row">
                                     <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-glass fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders Today</span>
                            <h2 class="font-bold">
                             <?php
                         $today=mysqli_query($con,"SELECT * FROM barorders WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                                     echo mysqli_num_rows($today);
                            ?>
                            </h2>
                        
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-glass fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders  In Past 7 days</span>
                            <h2 class="font-bold">
                              <?php
                            $week=mysqli_query($con,"SELECT * FROM barorders WHERE round(($timenow-timestamp)/(3600*24))<=7 AND status='1'");
                                     echo mysqli_num_rows($week);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-glass fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Bar Orders Past 30 Days</span>
                            <h2 class="font-bold">
                              <?php
                              $month=mysqli_query($con,"SELECT * FROM barorders WHERE round(($timenow-timestamp)/(3600*24))<=30 AND status='1'");
                                     echo mysqli_num_rows($month);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-7">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Most Ordered Drinks</h5>
                  
                    </div>
                    <div class="ibox-content">
                       
                     <div class="panel blank-panel">

                   
                       
    <?php
     $week=mysqli_query($con,"SELECT  drinkorder_id,drink_id, SUM(items) AS drinkcount   FROM   barorder_drinks  GROUP BY drink_id  ORDER BY drinkcount  DESC   LIMIT 80");

if(mysqli_num_rows($week)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                     <tr>
                         <th>Drink Name</th>
                              <th>Orders</th>
                       
                      
                    </tr>
                    </thead>
                    <tbody>
              <?php
              while($row=  mysqli_fetch_array($week)){
  $drink_id=$row['drink_id'];
  $drinkcount=$row['drinkcount'];
  $drinkorder_id=$row['drinkorder_id'];
 $drinks=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
   $row2=  mysqli_fetch_array($drinks);
  $drink=$row2['drinkname'];
  $drinkquantity=$row2['quantity'];
  
              ?>    <tr class="gradeA">
                      <td><?php echo $drink.'('.$drinkquantity.')'; ?></td>
                        
                          <td class="center">
                                        <?php  echo $drinkcount; ?>
                        </td>
                                   
  
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Drink Orders Added Yet</div>
 <?php }?>
                              

                      
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


</body>

</html>
