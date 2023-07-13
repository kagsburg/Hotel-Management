<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant')){
header('Location:login.php');
   }
   $st=$_GET['start'];
$en=$_GET['end'];
$start=strtotime($_GET['start']);
$end=strtotime($_GET['end']);
?>
<!DOCTYPE html>
<html>

<head>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Restaurant Sales  | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                               <div class="col-sm-2"><img src="assets/demo/logo.jpg" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                       <address>
                                                                           <h3></h3>
                                         <strong>HOTEL NAME</strong><br>
                                         7, Avenue de la J.R.R <br/>
                                          Bujumbura BP 381,<br>
                                        Burundi<br>
                                        <strong>Tel : </strong>(+257) 22 27 85 82<br/>
                                       Email: info@hotel.com<br/>
                                        
                                    </address>
                                 
                                </div>

                                
                            </div>
                 <h1 class="text-center">All Restaurant Orders between <?php echo date('d/m/Y',$start); ?> and <?php echo date('d/m/Y',$end); ?></h1>
                            <div class="table-responsive m-t">
                           <?php
                           if($start>$end){
   $errors[]='Start Date Cant be later than End Date'; 
}

if(!empty($errors)){
foreach($errors as $error){ 
?>
                                 <div class="alert alert-danger"><?php echo $error; ?></div>
<?php 
}         }else{ ?>
                                <table class="table invoice-table table-responsive">
                                    <thead>
                                     <tr>
                     <tr>
                       
                         <th>Order items</th>
                              <th>Total Bill</th>
                                <th>Date</th>
                                        </tr>
                        
                    </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                             $restorders=mysqli_query($con,"SELECT * FROM orders WHERE status='1'  AND  timestamp>='$start' AND timestamp<='$end'  ORDER BY order_id DESC");               
               while($row=  mysqli_fetch_array($restorders)){
  $order_id=$row['order_id'];
  $creator=$row['creator'];
  $timestamp=$row['timestamp'];
  $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
                ?>
                                
                    <tr class="gradeA">
                                          <td><?php 
                  while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
                               
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                            echo $quantity.' '.$menuitem.'<br/>';
                  }
                      ?></td>
                         <td class="center">
                                        <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            echo number_format($totalcosts);
                                                                    ?>
                        </td>
                      
                   
                           <td><?php echo date('d/m/Y',$timestamp);?></td>    
                                      
                      </tr>
                 <?php }?>
                                    </tbody>
                                </table>
<?php } ?>
                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved</strong>
                            </div>
                        </div>

    </div>

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
