<?php
include 'includes/conn.php';
$type=$_POST['type'];
if($type == 'fetch') {
    $events = array();
    $getevents = mysqli_query($con, "SELECT * FROM reservations WHERE status IN (0,1)");
    while($row = mysqli_fetch_array($getevents)) {
     $e = array();
     $reservation_id=$row['reservation_id'];
     $firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$checkout=$row['checkout']+(24*3600);
$room_id=$row['room'];
  $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                                           $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row2=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row2['roomtype'];
	 $id=$row['reservation_id'];
               $getsdate=date("Y-m-d",$checkin);
	 $getedate=date("Y-m-d",$checkout);
	 $e['url']="reservation?id=".$id;
     $e['id'] = $id;
      $e['title'] =$roomtype.' : '.$roomnumber;
     $e['start'] = $getsdate.'T00:01:00+05:30';
     $e['end'] = $getedate.'T00:01:00+05:30';
     $e['color']='#1ab394';
          $e['allDay'] = "false";      
     array_push($events, $e);
    }
  $reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE status IN (1,2)   ORDER BY hallreservation_id DESC");
     while($row=  mysqli_fetch_array($reservations)){
  $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$checkout=$row['checkout']+(24*3600);
   $status=$row['status'];
     $room_id=$row['room_id']; 
      $purposes=mysqli_query($con,"SELECT * FROM conferencerooms WHERE conferenceroom_id='$room_id'");
       if(mysqli_num_rows($purposes)>0){
                        $rowc = mysqli_fetch_array($purposes);
                     $room=$rowc['room'];      
       }else{
           $room='Hall';
       }    
      $getsdate=date("Y-m-d",$checkin);
	 $getedate=date("Y-m-d",$checkout);
	 $e['url']="halldetails?id=".$hallreservation_id;
     $e['id'] = $hallreservation_id;
      $e['title'] =$room.' Hall Reservation';
     $e['start'] = $getsdate.'T00:01:00+05:30';
     $e['end'] = $getedate.'T00:01:00+05:30';
       $e['color']='#ff5454';
//      "color": 
       $e['allDay'] = "false";    
         array_push($events, $e);
     }
    echo json_encode($events);
}
?>