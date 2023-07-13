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
                    <h2>Hall Reservations in Past 30 Days</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Reservations</a>
                        </li>
                        <li class="active">
                            <strong>View Hall Reservations In Past 30 Days</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>All Hall Reservations in Past 30 Days<small>Sort, search</small></h5>
                       
                    </div>
                    <div class="ibox-content">
<?php
$reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE round(($timenow-timestamp)/(3600*24))<=30 ORDER BY hallreservation_id DESC");
if(mysqli_num_rows($reservations)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                          <th>Guest</th>
                        <th>phone</th>
                        <th> Email</th>
                        <th>Country</th>
                        <th>Id Number</th>
                         <th>Check In</th>
                        <th>Check Out</th>
                        <th>Added By</th>
                        <!--<th>Action</th>-->
                    </tr>
                    </thead>
                    <tbody>
              <?php
               while($row=  mysqli_fetch_array($reservations)){
  $hallreservation_id=$row['hallreservation_id'];
$fullname=$row['fullname'];
$checkin=$row['checkin'];
$phone=$row['phone'];
$id_number=$row['id_number'];
$checkout=$row['checkout'];
  $email=$row['email'];
  $status=$row['status'];
  $country=$row['country'];
  $creator=$row['creator'];
  
              ?>
               
                    <tr class="gradeA">
                    <td><?php echo $fullname; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $country; ?></td>
                        <td><?php echo $id_number; ?></td>
                      
                        <td><?php echo date('d/m/Y',$checkin); ?></td>
                        <td><?php echo date('d/m/Y',$checkout); ?></td>
                       <td> <div class="tooltip-demo">
                               
                            <a href="profile?id=<?php echo $creator; ?>" data-original-title="View admin profile"  data-toggle="tooltip" data-placement="bottom" title="">
                                             <?php 
                                              $getname=  mysqli_query($con,"SELECT * FROM users WHERE user_id='$creator'");  
                                             $row2=  mysqli_fetch_array($getname);
                                              $fullname=$row2['fullname'];
                                             echo $fullname; ?></a> </div></td>
                     
                                               
<!--  <td class="center"> 
         <?php
//         if(($creator==$_SESSION['hotelsys'])||($_SESSION['hotelsyslevel']==1)){ 
//                            
//                                                        if($status=='1'){ 
                             
                                    ?>
                                            <a href="hideroom.php?id=<?php //echo $room_id.'&&status='.$status; ?>" class="btn btn-danger btn-xs">unpublish <i class="fa fa-arrow-down"></i></a> 
                                                
                            <?php// } else{ ?>
                             <a href="hideroom.php?id=<?php //echo $room_id.'&&status='.$status; ?>"  class="btn btn-primary  btn-xs">publish <i class="fa fa-arrow-up"></i></a>
                                 <?php
//                                 }
//               }
                                 ?>
  </td>-->
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }  else { ?>
    <div class="alert alert-danger"> No Hall Reservations Added Yet</div>
  <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>
