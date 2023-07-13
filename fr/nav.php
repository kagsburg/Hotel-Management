<?php
    $name=  mysqli_query($con,"SELECT * FROM users WHERE user_id='".$_SESSION['hotelsys']."'");  
  $row=  mysqli_fetch_array($name);
  $employee=$row['employee'];
  $level=$row['level'];
  $user_id=$row['user_id'];
  $role=$row['role'];
    $employee=  mysqli_query($con,"SELECT * FROM employees WHERE employee_id='$employee'");
     $row = mysqli_fetch_array($employee);
       $employee_id=$row['employee_id'];
                                           $fullname=$row['fullname'];
                                          $gender=$row['gender'];
                                          $design_id=$row['designation'];
                                            $status=$row['status'];
                                            $ext=$row['ext'];											
                                            $email=$row['email'];											
                                            $phone=$row['phone'];											
                                            $salary=$row['salary'];											
                                            $date=$row['start_date'];	
?>
<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>
                                <img alt="image" class="img-circle" src="img/employees/thumbs/<?php echo md5($employee_id).'.'.$ext; ?>" width="50">
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $fullname; ?></strong>
                             </span> <span class="text-muted text-xs block">
                                 <?php 
                                 echo $role;
                                                              ?>
                                 <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="employee?id=<?php echo $employee_id;?>">Profil</a></li>
                                                               <li class="divider"></li>
                                    <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                                            <li class="divider"></li>
            <li><a href="switchlanguage?lan=en">English</a> </li>                  
        <li class="divider"></li>            
                                <li><a href="logout">Se déconnecter</a></li>
                                
                            </ul>
                        </div>
                        <div class="logo-element">
                                                    </div>

                    </li>
                       <li>       <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">Accueil </span></a>
                    </li>
                    <?php 
                    if($level==1){
                        include 'adminnav.php';
                    }else{
                                      if($role=='Receptionist'){
                    ?>
                <li>
                        <a href=""><i class="fa fa-home"></i> <span class="nav-label">Chambres</span> <span class="fa arrow"></span> </a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="roomtypes">Types de chambres</a></li>
                            <li><a href="rooms">Afficher les chambres</a></li>
                        </ul>
                    </li>
                  
                    <li>
                        <a href=""><i class="fa fa-folder-open"></i> <span class="nav-label">Réservations</span> <span class="fa arrow"></ étendue></a>
                                                <ul class="nav nav-second-level">
                                                
                           <li>
                                <a href="#">Réservations <span class="fa arrow"></span></a>
                                <ul class="nav nav-troisième-niveau">
                                      <li>
                                          <a href="addreservation">Ajouter une réservation</a>
                                    </li>
                                    <li>
                                        <a href="reservations">Réservations d'hôtel</a>
                                    </li>
                                  
                                                                 </ul>
                            </li>
                           
                              <li><a href="guestsin">Enregistrements</a></li>
                                                                           
                 <li>
                                <a href="#">Vérifié <span class="fa arrow"></span></a>
                                <ul class="nav nav-troisième-niveau">
                                    <li>
                                        <a href="cleared">Sans dette</a>
                                    </li>
                                    <li>
                                        <a href="uncleared">Avec une dette</a>
                                    </li>
                                                                 </ul>
                            </li>
                                                          <li><a href="pendingouts">Paiements en attente</a></li>
                                                  
                        </ul>
                    </li>
                       <li>
                           <a href="laundrywork"><i class="fa fa-female"></i><span class="nav-label">Travail de blanchisserie </span></a>
                    </li>
                      <?php } 
                                   if($role=='Restaurant Attendant'){
                    ?>
                        <li>
                        <a href=""><i class="fa fa-cutlery"></i> <span class="nav-label">Restaurant</span><span class="fa arrow"></span> </a>
                                                <ul class="nav nav-second-level">
                                                      <li>
                                <a href="#">Commandes au restaurant<span class="fa arrow"></span></a>
                                <ul class="nav nav-troisième-niveau">
                                    <li>
                                        <a href="gfoodorders">Commandes des résidents</a>
                                    </li>
                                    <li>
                                        <a href="foodorders">Commandes de non-résidents</a>
                                    </li>
                                                                 </ul>
                            </li>
                                                    <li><a href="addrestaurantorder">Ajouter une commande de restaurant</a></li>
                                                                                               
                                                                                                 
                        </ul>
                    </li>
                           <?php } 
                                   if($role=='Hall Attendant'){
                    ?>
                    <li>
                        <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Salle de conférence</span> <span class="fa arrow">< /span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="hallpurposes">Objectifs</a></li>
                                                       <li><a href="addhallbooking">Ajouter une réservation de salle</a></li>
                                                    <li><a href="hallbookings">Réservations de salle</a></li>
                                                    <li>
                                <a href="#">Vérifié <span class="fa arrow"></span></a>
                                <ul class="nav nav-troisième-niveau">
                                    <li>
                                        <a href="hallcleared">Entièrement payé</a>
                                    </li>
                                    <li>
                                        <a href="halluncleared">Avec une dette</a>
                                    </li>
                                                                 </ul>
                            </li>
                                                                                                  
                        </ul>
                    </li>
                                                 <?php } 
                                   if($role=='Bar attendant'){
                    ?>
<!--                        <li>
                        <a href=""><i class="fa fa-glass"></i> <span class="nav-label">Bar</span><span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">                                                                                                  
                                                         <li>
                                <a href="#">Bar Orders<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="gbarorders">Orders From Residents</a>
                                    </li>
                                    <li>
                                        <a href="bar">Orders from Non Residents</a>
                                    </li>
                                                                 </ul>
                            </li>                                                                                            
                                                    <li><a href="addbarorder">Add Bar Order</a></li>                                                  
                                                                                                 
                        </ul>
                    </li>-->
                      <?php } 
                    if($role=='Accountant'){
                    ?>
                    <li>
                        <a href=""><i class="fa fa-money"></i> <span class="nav-label">Expenses</span> <span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="costs">View Expenses</a></li>
                                                    <li><a href="addcost">Add Expenses</a></li>                                                  
                        </ul>
                    </li>
<!--                    <li>
                        <a href="getincomestatement"><i class="fa fa-money"></i><span class="nav-label">Income Statement</span></a>
                    </li>-->
                      <?php } 
                   if($role=='Store Attendant'){
                    ?>
                    <li>
                        <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventory</span> <span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="stockitems">View Inventory</a></li>
                                                    <li><a href="addstockitem">Add Stock Item</a></li>                                                  
                                                    <li><a href="addstock">Add Stock</a></li>                                                  
                                                   <li><a href="#">Purchase Lists<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="createlist">Create List</a>
                                    </li>
                                    <li>
                                        <a href="approvedlists">Approved Lists</a>
                                    </li>
                                      <li>
                                          <a href="pendinglists">Pending  Lists</a>
                                    </li>
                                 </ul>                                                                        
                                   </li>                                                   
                        </ul>
                    </li>
                      <?php } 
                      if($role=='Laundry Attendant'){
                    ?>
                        <li>
                        <a href=""><i class="fa fa-female"></i> <span class="nav-label">Laundry</span> <span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="addlaundry">Add Laundry work</a></li>
                                                    <li><a href="laundrywork">Laundry work</a></li>                                                  
                        </ul>
                    </li>
                      <?php } 
//                    $reservrights=  mysqli_query($con, "SELECT * FROM user_roles WHERE role='6' AND user_id=user_id='".$_SESSION['hotelsys']."'");
//                    if(mysqli_num_rows($reservrights)>0){
                    ?>
<!--                           <li>
                        <a href=""><i class="fa fa-table"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="checkoutstats">Checkouts Report</a></li>
                                                    <li><a href="reservationstats">Reservations Report</a></li>   
                                                      <li><a href="inventorystats">Inventory Stats</a></li>
                                                    <li><a href="barstats">Bar Report</a></li>   
                                                      <li><a href="restaurantstats">Restaurant Report</a></li>
                                                    <li><a href="coststats">Costs Report</a></li>   
                                                      <li><a href="hallstats">Hall Report</a></li>
                                                    <li><a href="gardenstats">Garden Report</a></li>   
                        </ul>
                    </li>      -->
                    <?php 
                       if($_SESSION['hotelsyslevel']==1){

                    ?>
                     <li>
                        <a href=""><i class="fa fa-user"></i> <span class="nav-label">Admins</span> <span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                    <li><a href="admins">View Admins</a></li>
                                                    <li><a href="addadmin">Add Admin</a></li>                                                  
                        </ul>
                    </li>      
                    <?php } }?>           
                    <li>
                        <a href="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout </span></a>
                    </li>
                </ul>

            </div>
        </nav>