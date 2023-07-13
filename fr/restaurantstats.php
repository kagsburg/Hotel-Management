    <div id="wrapper">
 <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
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
                <div class="col-lg-9">
                    <h2>Dashboard</h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i>Restaurant Stats</a></li>
                        
                    </ol>
                </div>
                           </div>
            <div class="wrapper wrapper-content animated fadeInRight">
           
                <div class="row">
                        <div class="col-lg-4">
                <div class="widget style1 lazur-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders Today</span>
                            <h2 class="font-bold">
                              <?php
                         $today=mysqli_query($con,"SELECT * FROM orders WHERE round(($timenow-timestamp)/(3600*24))+1=1");
                                     echo mysqli_num_rows($today);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 navy-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders  In Past 7 days</span>
                            <h2 class="font-bold">
                              <?php
                                  $week=mysqli_query($con,"SELECT * FROM orders WHERE round(($timenow-timestamp)/(3600*24))<=7");
                                     echo mysqli_num_rows($week);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                             <div class="col-lg-4">
                <div class="widget style1 red-bg">
                    <div class="row">
                        <div class="col-xs-4">
                            <i class="fa fa-cutlery fa-5x"></i>
                        </div>
                        <div class="col-xs-8 text-right">
                            <span>Orders in Past 30 Days</span>
                            <h2 class="font-bold">
                              <?php
                              $month=mysqli_query($con,"SELECT * FROM orders WHERE round(($timenow-timestamp)/(3600*24))<=30");
                                     echo mysqli_num_rows($month);
                            ?>
                            </h2>
                        </div>
                    </div>
                </div>
                </div>
                 <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Most Ordered ITems</h5>
                  
                    </div>
                    <div class="ibox-content">
                       
                     <div class="panel blank-panel">

                
                        <div class="panel-body">

                         
    <?php
     $week=mysqli_query($con,"SELECT   type,food_id,restorder_id, SUM(quantity) AS ordercount    FROM    restaurantorders  GROUP BY food_id  ORDER BY ordercount  DESC   LIMIT 80");
//   $week=mysqli_query($con,"SELECT * FROM reservations WHERE round(($timenow-timestamp)/(3600*24))<=7");
if(mysqli_num_rows($week)>0){
 
 ?>
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                     <tr>
                         <th>Menu Item</th>
                              <th>Orders</th>
                       
                      
                    </tr>
                    </thead>
                    <tbody>
              <?php
              while($row=  mysqli_fetch_array($week)){
 $restorder_id=$row['restorder_id'];
$ordercount=$row['ordercount'];
$food_id=$row['food_id'];
$type=$row['type'];
               ?>    <tr class="gradeA">
                      <td><?php 
                      if($type=='drink'){
                      $drinks=mysqli_query($con,"SELECT * FROM drinks WHERE drink_id='$food_id'");
   $row2=  mysqli_fetch_array($drinks);
  $drinkname=$row2['drinkname'];
  $drinkquantity=$row2['quantity'];   
                      echo $drinkname.'('.$drinkquantity.')';
                      }else{
                    $foodmenu=mysqli_query($con,"SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                    $row=  mysqli_fetch_array($foodmenu);
                    $menuitem_id=$row['menuitem_id'];
                            $menuitem=$row['menuitem'];
 
                            echo $menuitem;
                      }
                      ?></td>
                        
                          <td class="center">
                                        <?php  echo $ordercount; ?>
                        </td>
                                   
  
                    </tr>
                 <?php }?>
                    </tbody>
                                    </table>
 <?php }else{?>
                        <div class="alert alert-danger">No Food Orders Added Yet</div>
 <?php }?>
                               

                        </div>

                    </div>
                    </div>
                </div>
            </div>

                                   </div>
                   </div>
    </div>
