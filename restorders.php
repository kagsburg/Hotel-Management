<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!='Restaurant Attendant' && $_SESSION['sysrole'] != 'Accountant' && $_SESSION['sysrole'] != 'Marketing and Events'&& $_SESSION['sysrole'] != 'Kitchen Exploitation Officer')){
header('Location:login.php');
   }
$id=$_GET['id'];
$restorder=mysqli_query($con,"SELECT * FROM orders WHERE order_id='$id'");
          $row=  mysqli_fetch_array($restorder);
  $order_id=$row['order_id'];
  $guest=$row['guest'];
  $customer=$row['customer'];
  
   $timestamp=$row['timestamp'];
    
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

    <title>Restaurant Order</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
                <div class="wrapper wrapper-content p-xl col-lg-offset-2 col-lg-8">
                   <div class="ibox-content p-xl">
                            <div class="row">
                               <div class="col-sm-2"><img src="assets/demo/logo.jpg" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                        <address>
                                                                           <h3></h3>
                                         <strong>LE PANORAMIQUE</strong><br>
                                         7, Avenue de la J.R.R <br/>
                                          Bujumbura BP 381, Burundi<br>
                                        Burundi<br>
                                        <strong>Tel : </strong>(+257) 22 27 85 82<br/>
                                       Email: info@celexonhotel.com<br/>
                                        
                                    </address>
                                 
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Order No.</h4>
                                    <h4 class="text-navy"><?php echo $id*23; ?></h4>                                                                        
                                                    <?php 
                                     if($customer==3){ ?>
                                     <span><strong>Guest Name:</strong>   <?php
                                                                                   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$guest'");
$row=  mysqli_fetch_array($reservation);
 $firstname1=$row['firstname'];
$lastname1=$row['lastname'];
              echo $firstname1.' '.$lastname1;
                            
                            ?></span><br/>
                                      <?php }
                                   if($customer==2){ ?>
                                     <span><strong>Customer Name:</strong> 
  <?php
                                                                                   $customers= mysqli_query($con,"SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                         $row = mysqli_fetch_array($customers);                        
                                          
                         $customername=$row['customername'];                              
                        echo $customername;
          
                            
                            ?></span><br/>
                                      <?php }?> 
                                    <address>
                                      <span><strong>Order Date:</strong> <?php echo date('d/m/Y',$timestamp); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>
                       <?php
                       $count=0;
                       $restround=mysqli_query($con,"SELECT * FROM restrounds WHERE order_id='$id'");
    while($row2=  mysqli_fetch_array($restround)){
$order_id=$row2['order_id'];
$restround_id=$row2['restround_id'];
  $instructions=$row2['instructions'];
    $waiter=$row2['waiter'];
    $count=$count+1;
                       ?>
                            <div class="table-responsive m-t">
                                <?php 
                                if(mysqli_num_rows($restround)>1){
                                ?>
                                <h3 class="pull-left">Round <?php echo $count; ?></h3>
                                <?php }?>
                                <div class="pull-right"><strong>Waiter/Waitress : </strong> <?php echo $waiter; ?></div>
                                <table class="table invoice-table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Food Name</th>
                                        <th>Items</th>
                                                    </tr>
                                    </thead>
                                    <tbody>
                                          <?php
                                           $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE restround_id='$restround_id'");
      while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
                                         
 ?>
                                    <tr>
                                        <td><div><strong>
                                                   <?php 
                                              
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                            echo $menuitem;
                
                                                   ?>
                                                </strong></div>
                                            </td>
                                        <td> <?php echo $quantity; ?></td>
                                       
                                                                           </tr>
                                      <?php }?>

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                                     <?php if($instructions!=''){ ?>                 
                            <div class="well m-t">
                                <strong style="font-style: italic">INSTRUCTIONS : </strong><?php echo $instructions;?>
                            </div>
    <?php }}?>
                            
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
