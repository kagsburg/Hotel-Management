    <div id="wrapper">

        
        <?php include 'nav.php'; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
         
        </div>
            <ul class="nav navbar-top-links navbar-right">
                 
                <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
            <li><a href="switchlanguage?lan=en">English</a> </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Chambres occupées</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Accueil</a>                    </li>
                       
                         <li>
                            <a>Chambres</a>
                        </li>
                        <li class="active">
                            <strong>Voir les chambres</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <?php
                $rooms=mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
        ?>
                <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-building-o fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Toutes les chambres </span>
                            <h2 class="font-bold"><?php  echo mysqli_num_rows($rooms); ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-folder fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Chambres occupées</span>
                            <?php
                       $occupied=  mysqli_query($con, "SELECT * FROM reservations WHERE  status='1'");
        ?>
                            <h2 class="font-bold">
                                <?php echo mysqli_num_rows($occupied); ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-4">
                <div class="widget style1 yellow-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-folder-open fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Chambres disponibles</span>
                            <h2 class="font-bold"><?php
        $available=  mysqli_num_rows($rooms)-mysqli_num_rows($occupied);
        echo $available;
        ?></h2>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Toutes les chambres <small>Trier, chercher</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php

if (mysqli_num_rows($rooms)>0) {
    ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numéro Chambre</th>
                        <th>Type de chambre</th>
                        <th>Disponibilité</th>
                        <th>Ajouté par</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
              <?php
                  while ($row=  mysqli_fetch_array($rooms)) {
                      $roomnumber=$row['roomnumber'];
                      $room_id=$row['room_id'];
                      $type=$row['type'];
                      $status=$row['status'];
                      $creator=$row['creator'];
                      $check=  mysqli_query($con, "SELECT * FROM reservations WHERE  status='1'");
                      $row2= mysqli_fetch_array($check);
                      $room2=$row2['room'];
                      $roomtypes=mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                      $row1=  mysqli_fetch_array($roomtypes);
                      $roomtype=$row1['roomtype'];
                      if ($room_id!=$room2) {
                          ?>
               
                    <tr class="gradeA">
                    <td><?php echo $room_id; ?></td>
                        <td><?php echo $roomnumber; ?></td>
                         <td class="center">
                                         <?php
                                                        $roomtypes=mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
                          $row1=  mysqli_fetch_array($roomtypes);
                          $roomtype=$row1['roomtype'];
                          echo $roomtype; ?>
                        </td>
                        <td>
                            <?php
                             $check=  mysqli_query($con, "SELECT * FROM reservations WHERE  room='$room_id' AND status='1'");
                          $row2= mysqli_fetch_array($check);
                          if (mysqli_num_rows($check)>0) {
                              echo '<div class="text-danger">Occupied</div>';
                          } else {
                              $check2=  mysqli_query($con, "SELECT * FROM reservations WHERE  
                              room='$room_id' AND status='0' AND checkin>='$timenow' ORDER BY checkin");
                              if (mysqli_num_rows($check2)>0) {
                                  $row3= mysqli_fetch_array($check2);
                                  $checkin=date("d/m/Y", $row3['checkin']);
                                  $checkout=date("d/m/Y", $row3['checkout']);
                                  echo '<div class="text-primary">Available till '.$checkin.'</div>';
                              } else {
                                  echo '<div class="text-success">Available</div>';
                              }
                          }
                          ?>
                        </td>
                     <td> <div class="tooltip-demo">                               
                                <a href="employee?id=<?php echo $creator; ?>" 
                                data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php
                                                       $employee=  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$creator'");
                          $row = mysqli_fetch_array($employee);
                          $employee_id=$row['employee_id'];
                          $fullname=$row['fullname'];
                          echo $fullname; ?></a> </div> </td>                    
                                               
  <td class="center"> 
         <?php
         if (($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)) {
             ?>
                      <a href="hideroom.php?id=<?php echo $room_id.'&&status='.$status; ?>"
                       class="btn btn-danger btn-xs" onclick="return confirm_delete<?php echo $room_id;?>()">supprimer <i class="fa fa-arrow-down"></i></a> 
     <script type="text/javascript">
function confirm_delete<?php echo $room_id; ?>() {
  return confirm('You are about To Remove this Room. Are you sure you want to proceed?');
}
</script>                                             
  <?php
         }
                          ?>
  </td>
                    </tr>
                                            <?php }
                      }?>
                    </tbody>
                                    </table>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>
