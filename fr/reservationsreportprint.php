                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
                                                      
                                
                            </div>
                 <h1 class="text-center">Rapport de réservation entre entre
                     <?php echo date('d/m/Y', $start); ?> et <?php echo date('d/m/Y', $end); ?></h1>
                     
  
    <div class="table-responsive m-t">
        <?php
                       $reservations=mysqli_query($con, "SELECT * FROM reservations WHERE timestamp>='$start' AND timestamp<='$end' AND status IN(0,1,2)");
                                if (mysqli_num_rows($reservations)>0) {
                                    ?>
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                         <th>Client</th>
                        <th>Numéro de chambre</th>
                           <th>Date Entrée</th>
                        <th>Date Sortie</th>
                        <th>Statut</th>
                 
                    </tr>
                                    </thead>
                                    <tbody>
                                         <?php
            while ($row=  mysqli_fetch_array($reservations)) {
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
                $status=$row['status'];
                ?>
                                 <tr class="gradeA">
                    <td><?php echo $firstname.' '.$lastname; ?></td>
                     
                         <td class="center">
                                         <?php
                                                      $roomtypes=mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room_id'");
                $row1=  mysqli_fetch_array($roomtypes);
                $roomtype=$row1['roomnumber'];
                echo $roomtype; ?>
                        </td>
                        <td><?php echo date('d/m/Y', $checkin); ?></td>
                        <td><?php echo date('d/m/Y', $checkout); ?></td>
                        <td><?php if ($status==0) {
                            echo 'Pending';
                        } if ($status==1) {
                            echo 'Guest In';
                        } if ($status==2) {
                            echo 'Guest Out';
                        } ?></td>
                                 </tr>
                <?php } ?>

                                    </tbody>
                                </table>
                            <?php } ?>
                            </div><!-- /table-responsive -->
     </div>

    </div>
