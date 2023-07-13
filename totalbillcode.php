<?php 
$reserverevenue=0;
             $reservations=mysqli_query($con,"SELECT * FROM reservations WHERE status='2' AND checkout>='$start' AND checkout<='$end'");
              while ($row=  mysqli_fetch_array($reservations)){
  $id=$row['reservation_id'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
//$id_number=$row['id_number'];
$checkout=$row['checkout'];
$room_id=$row['room'];
  $email=$row['email'];
  $status=$row['status'];
  $country=$row['country'];
  $creator=$row['creator'];
 $invoice_no=23*$id;
  $nights=  round(($checkout-$checkin)/(3600*24))+1;
            
                                            $getnumber=mysqli_query($con,"SELECT * FROM rooms  WHERE room_id='$room_id'");
                                            $row1=  mysqli_fetch_array($getnumber);
                                            $roomnumber=$row1['roomnumber'];
                                            $type_id=$row1['type'];
                     
                                            $roomtypes=mysqli_query($con,"SELECT * FROM roomtypes WHERE roomtype_id='$type_id'");
                                            $row1=  mysqli_fetch_array($roomtypes);
                                            $roomtype=$row1['roomtype'];
                                            $charge=$row1['charge'];
                                      
                     
                                    $totalcharge=$charge*$nights;
                                                               $restbill=0;
                             $restorder=mysqli_query($con,"SELECT * FROM orders WHERE guest='$id' AND status='1'");
                             if(mysqli_num_rows($restorder)>0){
                           
                                                   
                              while ($row=  mysqli_fetch_array($restorder)){
  $order_id=$row['order_id'];
  $guest=$row['guest'];
  $timestamp=$row['timestamp'];
                          
                                           $foodsordered=  mysqli_query($con,"SELECT * FROM restaurantorders WHERE order_id='$order_id'");
      while ($row3=  mysqli_fetch_array($foodsordered)){
                      $restorder_id=$row3['restorder_id'];
                      $food_id=$row3['food_id'];
                      $price=$row3['foodprice'];
                      $quantity=$row3['quantity'];
                      $type=$row3['type'];
                    

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
                                           
                                             
                          
                                              $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(foodprice*quantity), 0) AS totalcosts FROM restaurantorders WHERE order_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalrestcosts=$row['totalcosts'];
                            $restbill=$totalrestcosts+$restbill;
                                                                                          
                                                               } }  }
                               $laundrycharge=0;
                               $laundry=mysqli_query($con,"SELECT * FROM laundry WHERE status='1' AND reserve_id='$id' ORDER BY timestamp");
                               if(mysqli_num_rows($laundry)){
                         
         while($row=  mysqli_fetch_array($laundry)){
           $laundry_id=$row['laundry_id'];
           $reserve_id=$row['reserve_id'];
           $clothes=$row['clothes'];
           $charge=$row['charge'];
           $timestamp=$row['timestamp'];
           $status=$row['status'];
           $creator=$row['creator'];
           $laundrycharge=$laundrycharge+$charge;
            $invoice_no=23*$id;
           $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
           $row2=  mysqli_fetch_array($reservation);
 $firstname=$row2['firstname'];
$lastname=$row2['lastname'];
$room_id=$row2['room'];
$phone=$row2['phone'];
$country=$row2['country'];
              }  }
 $reservebill=$restbill+$totalcharge+$laundrycharge;
 $reserverevenue=$reservebill+$reserverevenue;
              }    
              echo number_format($reserverevenue);
 ?>

                