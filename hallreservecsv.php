<?php
include 'includes/conn.php';
 if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
      } else{
          

   $delimiter = ",";

    $filename ="Hall Reservations as of  ".date('d/m/Y',$timenow).".csv";    

    $f = fopen('php://memory', 'w');                            
                 
      $fields = array('S/N','Guest','Phone','People','Check in','Check Out','Room','Status');

       fputcsv($f, $fields, $delimiter);

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
        $purposes=mysqli_query($con,"SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id'");
                        $rowc = mysqli_fetch_array($purposes);
                     $room=$rowc['room'];       
                       if($status==1){
                                   $st='BOOKED';
                                      }
                     else if ($status==2) {
                                     $st='CHECKED IN';
                                 }
   $lineData = array($invoice_no,$fullname,$phone,$people,date('d/m/Y',$checkin),date('d/m/Y',$checkout),$room,$st);

        fputcsv($f, $lineData, $delimiter);

        }   
     
     fputcsv($f, $lineData, $delimiter);           

                     fseek($f, 0);    

    header('Content-Type: text/xls');

    header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
   }
?>