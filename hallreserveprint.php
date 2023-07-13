<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
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

    <title>Hall Reservations</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
    <?php
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/hallreserveprint.php';                     
                                       }else{
          ?>          
                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                                <div class="col-xs-4">
                                </div>

                              
                                
                            </div>
                 <h1 class="text-center">All Hall Bookings</h1>
                            <div class="table-responsive m-t">

                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>#</th>
                          <th>Guest</th>
                        <th>phone</th>
                          <th>People</th>
                          <th>Dates</th>
                        <th>Room</th>
                                   <th>Status</th>
                    
                    </tr>
                    </thead>
                    <tbody>
                                      <?php
$reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE status IN (1,2)   ORDER BY hallreservation_id DESC");
        while($row=  mysqli_fetch_array($reservations)){
  $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
   $status=$row['status'];
   $people=$row['people'];
  $room_id=$row['room_id'];
  
   $description=$row['description'];
  $country=$row['country'];
  $creator=$row['creator'];
  $timestamp=$row['timestamp'];
  $getyear=date('Y',$timestamp);
        $count=1;
   $beforeorders=  mysqli_query($con, "SELECT * FROM hallreservations WHERE status=1  AND hallreservation_id<'$hallreservation_id'") or die(mysqli_error($con));
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
           
                 ?>
               
                    <tr class="gradeA">
                    <td><?php echo $invoice_no; ?></td>
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                                              <td><?php 
                                             echo $people;
                                                     ?></td>
                               <td><?php echo date('d/m/Y',$checkin).' to '.date('d/m/Y',$checkout);; ?></td>
                        <td><?php 
                         $purposes=mysqli_query($con,"SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id'");
                        $rowc = mysqli_fetch_array($purposes);
                     $room=$rowc['room'];      
                        echo $room; ?></td>
                                                <td><?php
                     if($status==1){
                                      echo 'BOOKED';
                                      }
                     else if ($status==2) {
                                        echo 'CHECKED IN';
                                 }
                                        ?></td>
                   
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>

                            </div><!-- /table-responsive -->

                        
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">@<?php echo date('Y',$timenow);?> All Rights Reserved To <?php echo $hotelname; ?><strong>
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

    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
