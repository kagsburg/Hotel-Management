<?php
include 'includes/conn.php';
 if(!isset($_SESSION['hotelsys'])){
header('Location:login.php');
      } else{
          

   $delimiter = ",";

    $filename ="Pending Reservations as of  ".date('d/m/Y',$timenow).".csv";    

    $f = fopen('php://memory', 'w');                            
                 
      $fields = array('Guest','Room Number','Check In','Check Out','Status','Added By');

       fputcsv($f, $fields, $delimiter);

  $reservations=mysqli_query($con,"SELECT * FROM reservations WHERE status='0' ORDER BY reservation_id DESC");
        while($row=  mysqli_fetch_array($reservations)){
  $reservation_id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
  $creator=$row['creator'];
    $roomtypes=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomnumber'];   
         $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$creator'");
                                         $roww = mysqli_fetch_array($employee);
                                          $employee_id=$roww['employee_id'];
                                           $fullname=$roww['fullname'];
   $lineData = array($firstname.' '.$lastname,$roomtype,date('d/m/Y',$checkin),date('d/m/Y',$checkout),'Pending',$fullname);

        fputcsv($f, $lineData, $delimiter);

        }   
     
     fputcsv($f, $lineData, $delimiter);           

                     fseek($f, 0);    

    header('Content-Type: text/xls');

    header('Content-Disposition: attachment; filename="' . $filename . '";');

        fpassthru($f);
   }
?>