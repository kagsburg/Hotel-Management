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
                <div class="col-lg-12">
                    <h2>Conference  Bar Orders</h2>
                    <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                       
                         <li>
                            <a>Menu</a>
                        </li>
                        <li class="active">
                            <strong>View Drinks</strong>
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
                        <h5 class="pull-left">All Orders <small>Sort, search</small></h5>
                                             <div style="clear:both"></div>
                    </div>
                    <div class="ibox-content">
<?php
   $barorders=  mysqli_query($con,"SELECT * FROM barorders WHERE status='1' AND customer='4' ORDER by barorder_id");
   if(mysqli_num_rows($barorders)>0){
 ?>
                                               
                        <table class="table table-striped table-bordered table-hover dataTables-example"  id="datatable">
                    <thead>
                    <tr>
                         <th>Order Id</th>
                        <th>Ordered Drinks</th>
                        <th>Total charge</th>
                           <th>Guest Name</th>
                           <th>Hall Package</th>
                              <th>Table</th>
                        <th>Date</th>
                        <th>Action</th>
                         
                          </tr>
                    </thead>
                    <tbody>
              <?php
           
               while($row=  mysqli_fetch_array($barorders)){
    $order_id=$row['barorder_id'];
      $guest=$row['guest'];
  $creator=$row['creator'];
     $table=$row['bartable'];
   $timestamp=$row['timestamp'];
   $getdrinks=  mysqli_query($con,"SELECT * FROM barorder_drinks WHERE barorder_id='$order_id'");
                                     
  
              ?>
               
                    <tr class="gradeA">
                      <td><?php echo 23*$order_id; ?></td>
                         <td class="center">
                                          <?php
                                           while($row=  mysqli_fetch_array($getdrinks)){ 
                                          $drink_id=$row['drink_id'];
                                          $charge=$row['charge'];
                                          $items=$row['items'];
                                          $drinkorder_id=$row['drinkorder_id'];
                                          $getdrink=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$drink_id'");
                                            $row2=  mysqli_fetch_array($getdrink);
                                                  $drink=$row2['drinkname'];
                                                  $quantity=$row2['quantity'];
                                              $drinktotal=$charge*$items;   
                                          echo $items.' '.$drink.' ('.$quantity.')<br/>'; 
                                           }
                                          ?>
                        </td>
                          <td class="center">
                                      <?php
                                               $totalcharges=mysqli_query($con,"SELECT COALESCE(SUM(charge*items), 0) AS totalcosts FROM barorder_drinks WHERE barorder_id='$order_id'");
                            $row=  mysqli_fetch_array($totalcharges);
                            $totalcosts=$row['totalcosts'];
                            echo number_format($totalcosts);
                                                                    ?>
                        </td>
                             <td>
                            <?php
                           $reservations=mysqli_query($con,"SELECT * FROM hallreservations WHERE  hallreservation_id='$guest'");
$row=  mysqli_fetch_array($reservations);
 $fullname=$row['fullname'];    
   $type_id=$row['type'];
echo $fullname;                     
        $purposes=mysqli_query($con,"SELECT * FROM hallpurposes WHERE hallpurpose_id='$type_id'");
                                                     $row3 = mysqli_fetch_array($purposes);
                                                     $type=$row3['type']; 
                         
                            ?>
                        </td>
                        <td><?php echo $type;?></td>
              
                           
                           
                     
                                               <td>                             
                                             <?php             
                                             echo $table;
                                             ?> </td>
                     
                     
                                   
                       <td><?php echo date('d/m/Y',$timestamp);?></td>               
                       <td>
                           <a href="barorders?id=<?php echo $order_id; ?>" class="btn btn-xs btn-info" target="_blank">View Details</a>
                 
                           <a href="addmorebaritems?id=<?php echo $order_id; ?>" class="btn btn-xs btn-primary">Add More Items</a>
                           <a href="barinvoice?id=<?php echo $order_id; ?>" class="btn btn-xs btn-success">View Invoice</a>
                        <a href="hidebarorder?id=<?php echo $order_id;?>" class="btn btn-xs btn-danger" onclick="return confirm_delete<?php echo $order_id; ?>()">Cancel</a>
                            
                                 <script type="text/javascript">
function confirm_delete<?php echo $order_id; ?>() {
  return confirm('You are about To Remove this Order. Are you sure you want to proceed?');
}
</script>                 
                       </td>               
    
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Drink Orders Added Yet</div>
 <?php }?>
                    </div>
                </div>
            </div>
            </div>
          
        </div>
        </div>


    </div>
