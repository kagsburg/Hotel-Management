<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pool Command | Hotel Manager</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
<?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/poolcommand.php';                     
                                       }else{
          ?>          
   
                  <div class="wrapper wrapper-content p-xl">
               <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                                <div class="col-xs-4"> </div>
<?php
    $commands= mysqli_query($con, "SELECT * FROM poolcommands WHERE status=1 AND poolcommand_id='$id'") or die(mysqli_error($con));
          $row=  mysqli_fetch_array($commands);
  $poolcommand_id=$row['poolcommand_id'];
  $firstname=$row['firstname'];
  $lastname=$row['lastname'];
$contact=$row['contact'];
  $charge=$row['charge'];
  $status=$row['status'];
  $admin_id=$row['admin_id'];
 $reserve_id=$row['reserve_id'];
 $timestamp=$row['timestamp'];
  $getyear=date('Y',$timestamp);
     $package=$row['package_id'];
     $customername=$firstname.' '.$lastname;
   $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
      if(mysqli_num_rows($reservation)>0){
   $row2=  mysqli_fetch_array($reservation);
 $firstname=$row2['firstname'];
$lastname=$row2['lastname'];
$room_id=$row2['room'];
$contact=$row2['phone'];
   $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomnumber=$row1['roomnumber'];
$customername=$firstname.' '.$lastname.' ('.$roomnumber.')';
      }
       $count=1;
   $beforeorders=  mysqli_query($con, "SELECT * FROM poolcommands WHERE status=1  AND  poolcommand_id<'$id'") or die(mysqli_error($con));
                     while ($rowb = mysqli_fetch_array($beforeorders)) {
                      $timestamp2=$rowb['timestamp']; 
                     $getyear2=date('Y',$timestamp2);
                      if($getyear==$getyear2){
                          $count=$count+1;
                      }
                     }
                      if(strlen($count)==1){
    $invoice_no='000'.$count;
     }
       if(strlen($count)==2){
      $invoice_no='00'.$count;
     }      
          if(strlen($count)==3){
      $invoice_no='0'.$count;
     }      
  if(strlen($count)>=4){
      $invoice_no=$count;
     }       
     
   $getpackage=mysqli_query($con,"SELECT * FROM poolpackages WHERE status='1' AND poolpackage_id='$package'");
   $row1 = mysqli_fetch_array($getpackage);
     $poolpackage=$row1['poolpackage'];
   
              ?>
                                <div class="col-xs-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $invoice_no; ?></h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $customername ?></strong><br>
                                            <span><strong>Date:</strong> <?php echo date('d/m/Y',$timestamp); ?></span><br/>
                                    </address>
                            </div>
                                
                            </div>
    <h2 style="text-align:center;width: 100%;margin: auto;font-weight: bold">SWIMMING POOL INVOICE</h2> 
                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                             <th>Package</th>
                        <th>Contact</th>
                   
                        <th>Charge</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                             <?php echo $poolpackage; ?>
                                                </strong></div>
                                            </td>
                                      
                        <td><?php echo $contact; ?></td>
                        <td><?php echo $poolpackage; ?></td>
                        <td><?php echo $charge; ?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                    
                                          <tr>
                                    <td><strong>NET TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($charge);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Visiting our Hotel <strong>
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
<script type="text/javascript">
        window.print();
    </script>


</body>

</html>
