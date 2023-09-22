<?php
$name =  mysqli_query($con, "SELECT * FROM users WHERE user_id='" . $_SESSION['hotelsys'] . "'");
$row =  mysqli_fetch_array($name);
$employee = $row['employee'];
$level = $row['level'];
$user_id = $row['user_id'];
$role = $row['role'];
$employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$employee'");
$row = mysqli_fetch_array($employee);
$employee_id = $row['employee_id'];
$fullname = $row['fullname'];
$gender = $row['gender'];
$design_id = $row['designation'];
$status = $row['status'];
$ext = $row['ext'];
$email = $row['email'];
$phone = $row['phone'];
$salary = $row['salary'];
$date = $row['start_date'];
if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
?>
   <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
         <ul class="nav" id="side-menu">
            <li class="nav-header">

               <div class="dropdown profile-element"> <span>
                     <?php
                     if (!empty($ext)) { ?>
                        <img alt="image" class="img-circle" src="img/employees/thumbs/<?php echo md5($employee_id) . '.' . $ext; ?>" width="50">
                     <?php } else { ?>
                        <img alt="image" class="img-circle" src="img/avatar.png" width="50">
                     <?php } ?>
                  </span>
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                     <span class="clear">
                        <span class="block m-t-xs">
                           <strong class="font-bold"><?php echo $fullname; ?></strong>
                        </span>
                        <span class="text-muted text-xs block">
                           <?php echo $role;        ?>
                           <b class="caret"></b>
                        </span>
                     </span>
                  </a>
                  <ul class="dropdown-menu animated fadeInRight m-t-xs">
                     <li><a href="employee?id=<?php echo $employee_id; ?>">Profil</a></li>
                     <!-- <li class="divider"></li> -->
                     <!-- <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                     <li class="divider"></li>
                     <li><a href="switchlanguage?lan=en">English</a> </li> -->
                     <li class="divider"></li>
                     <li><a href="logout">Se déconnecter</a></li>

                  </ul>
               </div>
               <div class="logo-element">
               </div>

            </li>
            <li> <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">Accueil</span></a>
            </li>
            <?php
            if ($level == 1) {
               include 'adminnav.php';
            } else {
               if ($role == 'Receptionist') {
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
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getreservationreport">Reservations Report</a></li>
                        <li><a href="gethallreport">Conference room Report</a></li>
                        <li><a href="getrestaurantreport">Restaurant Report</a></li>
                        <li><a href="getpoolreport">Gym and Pool Report</a></li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Restaurant Attendant') {
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
               if ($role == 'Hall Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Salle de conférence</span> <span class="fa arrow">
                           < /span></a>
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
               if ($role == 'Bar attendant') {
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
               if ($role == 'Accountant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-money"></i> <span class="nav-label">Dépenses</span> <span class="fa arrow"></span> </a>
                     <ul class="nav nav-second-level">
                        <li><a href="costs">Afficher les dépenses</a></li>
                        <li><a href="addcost">Ajouter des dépenses</a></li>
                     </ul>
                  </li>
                  <!--                    <li>
                        <a href="getincomestatement"><i class="fa fa-money"></i><span class="nav-label">Income Statement</span></a>
                    </li>-->
               <?php }
               if ($role == 'Store Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventaire</span> <span class="fa arrow"></span> </a>
                     <ul class="nav nav-second-level">
                        <li><a href="stockitems">Afficher l'inventaire</a></li>
                        <li><a href="addstockitem">Ajouter un article en stock</a></li>
                        <li><a href="addstock">Ajouter des stocks</a></li>
                        <li><a href="#">Listes d'achat<span class="fa arrow"></span></a>
                           <ul class="nav nav-troisième-niveau">
                              <li>
                                 <a href="createlist">Créer une liste</a>
                              </li>
                              <li>
                                 <a href="approvedlists">Listes approuvées</a>
                              </li>
                              <li>
                                 <a href="pendinglists">Listes en attente</a>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Laundry Attendant') { ?>

               <?php }
               if ($role == 'Laundry Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-female"></i> <span class="nav-label">Blanchisserie</span> <span class="fa arrow"></span> </a>
                     <ul class="nav nav-second-level">
                        <li><a href="addlaundry">Ajouter des travaux de blanchisserie</a></li>
                        <li><a href="laundrywork">Travail de blanchisserie</a></li>
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
               if ($_SESSION['hotelsyslevel'] == 1) {
               ?>
                  <li>
                     <a href=""><i class="fa fa-user"></i> <span class="nav-label">Administrateurs</span> <span class="fa arrow"></span> </a>
                     <ul class="nav nav-second-level">
                        <li><a href="admins">Afficher les administrateurs</a></li>
                        <li><a href="addadmin">Ajouter un administrateur</a></li>
                     </ul>
                  </li>
            <?php }
            } ?>
            <li>
               <a href="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Se déconnecter</span></a>
            </li>
         </ul>

      </div>
   </nav>

<?php } else { ?>
   <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
         <ul class="nav" id="side-menu">
            <li class="nav-header">

               <div class="dropdown profile-element"> <span>
                     <?php
                     if (!empty($ext)) { ?>
                        <img alt="image" class="img-circle" src="img/employees/thumbs/<?php echo md5($employee_id) . '.' . $ext; ?>" width="50">
                     <?php } else { ?>
                        <img alt="image" class="img-circle" src="img/avatar.png" width="50">
                     <?php } ?>
                  </span>
                  <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                     <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $fullname; ?></strong>
                        </span>
                        <span class="text-muted text-xs block">
                           <?php
                           echo $role;
                           ?>
                           <b class="caret"></b>
                        </span>
                     </span>
                  </a>
                  <ul class="dropdown-menu animated fadeInRight m-t-xs">
                     <li><a href="employee?id=<?php echo $employee_id; ?>">Profile</a></li>
                     <!-- <li class="divider"></li> -->
                     <!-- <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                     <li class="divider"></li>
                     <li><a href="switchlanguage?lan=en">English</a> </li> -->
                     <li class="divider"></li>
                     <li><a href="logout">Logout</a></li>
                  </ul>
               </div>
               <div class="logo-element">
               </div>

            </li>
            <li> <a href="index.php"><i class="fa fa-home"></i> <span class="nav-label">Home </span></a>
            </li>
            <?php
            if ($level == 1) {
               include 'adminnav.php';
            } else {
               if ($role == 'Receptionist') {
            ?>
                  <li>
                     <a href=""><i class="fa fa-home"></i> <span class="nav-label">Rooms</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="roomtypes">Room Types</a></li>
                        <li><a href="rooms">View Rooms</a></li>
                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-folder-open"></i> <span class="nav-label">Reservations</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">

                        <li>
                           <a href="#">Bookings <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="addreservation">Add Reservation</a>
                              </li>
                              <li>
                                 <a href="reservations">Hotel Bookings</a>
                              </li>
                           </ul>
                        </li>

                        <li><a href="guestsin">Check Ins</a></li>

                        <li>
                           <a href="#">Checked out <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="cleared">Without Debt</a>
                              </li>
                              <li>
                                 <a href="unclearedcredit">With Credit</a>
                              </li>
                              <li>
                                 <a href="uncleared">With Debt Cash</a>
                              </li>
                           </ul>
                        </li>
                        <li><a href="pendingouts">Pending Check Outs</a></li>

                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-female"></i> <span class="nav-label">Laundry</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <!-- <li><a href="laundrytypes">Laundry Packages</a></li> -->
                        <li><a href="addlaundry">Add Laundry work</a></li>
                        <li><a href="laundrywork">Laundry work</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-bookmark"></i> <span class="nav-label">Gym & Swimming Pool</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <!-- <li><a href="poolpackages">Bouquets</a></li> -->
                        <li><a href="addpoolsubscription">Add Subscription</a></li>
                        <li><a href="poolsubscriptions">Subscriptions</a></li>

                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Conference Hall</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="conferencerooms">Conference Rooms</a></li>
                        <li><a href="addhallbooking">Add Hall booking</a></li>
                        <li><a href="hallbookings">Hall Bookings</a></li>
                        <li>
                           <a href="#">Checked out <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="hallcleared">Fully Paid</a>
                              </li>
                              <li>
                                 <a href="halluncleared">With Debt</a>
                              </li>
                           </ul>
                        </li>

                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-book"></i> <span class="nav-label">Planning Boards</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="hotelroomboard">Hotel Rooms</a></li>
                        <li><a href="conferenceroomboard">Conference Rooms</a></li>
                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>

                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getreservationreport">Reservations Report</a></li>
                        <li><a href="gethallreport">Conference room Report</a></li>
                        <li><a href="getpoolreport">Gym and Pool Report</a></li>
                        <li><a href="getlaundryreport">Laundry Report</a></li>
                     </ul>
                  </li>
         <?php }
               if ($role == 'Restaurant Attendant') { ?>

                  <li>
                     <a href=""><i class="fa fa-cutlery"></i> <span class="nav-label">Restaurant</span><span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li>
                           <a href="#">Restaurant orders<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="gfoodorders">Orders From Residents</a>
                              </li>
                              <li>
                                 <a href="foodorders">Orders from Non Residents</a>
                              </li>
                              <li>
                                 <a href="restinvoices">All Invoices</a>
                              </li>
                           </ul>
                        </li>
                        <li><a href="addrestaurantorder">Add Restaurant Order</a></li>
                        <li><a href="getrestinvoicesreport">Invoices Report</a></li>
                        
                     </ul>
                  </li>
                  <li>
                <a href="#">Hall Buffets<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="addhallbuffet">Add Buffet</a>
                    </li>
                    <li>
                        <a href="hallbuffets">View Buffets</a>
                    </li>
                </ul>
            </li>
            <li>
               <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
               <ul class="nav nav-second-level">
                  <li><a href="requisitions">View Requisitions</a></li>
                  <li><a href="addrequisition">Add Requisition</a></li>
               </ul>
            </li>
            <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getrestaurantreport">Restaurant Report</a></li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Hall Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Conference Hall</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="conferencerooms">Conference Rooms</a></li>
                        <li><a href="addhallbooking">Add Hall booking</a></li>
                        <li><a href="hallbookings">Hall Bookings</a></li>
                        <li><a href="issuedstock">Issued Stock</a></li>

                        <li>
                           <a href="#">Checked out <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="hallcleared">Fully Paid</a>
                              </li>
                              <li>
                                 <a href="halluncleared">With Debt</a>
                              </li>
                           </ul>
                        </li>

                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-basket"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="gethallreport">Conference room Report</a></li>

                     </ul>
                  </li>
               <?php }
               if ($role == 'Bar attendant') {
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
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Marketing and Events') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-home"></i> <span class="nav-label">Rooms</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="roomtypes">Room Types</a></li>
                        <li><a href="rooms">View Rooms</a></li>
                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-folder-open"></i> <span class="nav-label">Reservations</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">

                        <li>
                           <a href="#">Bookings <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="addreservation">Add Reservation</a>
                              </li>
                              <li>
                                 <a href="reservations">Hotel Bookings</a>
                              </li>

                           </ul>
                        </li>

                        <li><a href="guestsin">Check Ins</a></li>

                        <li>
                           <a href="#">Checked out <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="cleared">Without Debt</a>
                              </li>
                              <li>
                                 <a href="unclearedcredit">With Credit</a>
                              </li>
                              <li>
                                 <a href="uncleared">With Debt Cash</a>
                              </li>
                           </ul>
                        </li>
                        <li><a href="pendingouts">Pending Check Outs</a></li>

                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-cutlery"></i> <span class="nav-label">Restaurant</span><span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li>
                           <a href="#">Restaurant orders<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="gfoodorders">Orders From Residents</a>
                              </li>
                              <li>
                                 <a href="foodorders">Orders from Non Residents</a>
                              </li>
                              <li>
                                 <a href="restinvoices">All Invoices</a>
                              </li>
                           </ul>
                        </li>

                        <li><a href="getrestinvoicesreport">Invoices Report</a></li>

                     </ul>
                  </li>

                  <li>
                     <a href=""><i class="fa fa-female"></i> <span class="nav-label">Laundry</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <!-- <li><a href="laundrytypes">Laundry Packages</a></li> -->
                        <li><a href="addlaundry">Add Laundry work</a></li>
                        <li><a href="laundrywork">Laundry work</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-bookmark"></i> <span class="nav-label">Gym & Swimming Pool</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <!-- <li><a href="poolpackages">Bouquets</a></li> -->
                        <li><a href="addpoolsubscription">Add Subscription</a></li>
                        <li><a href="poolsubscriptions">Subscriptions</a></li>

                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Conference Hall</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="conferencerooms">Conference Rooms</a></li>
                        <li><a href="addhallbooking">Add Hall booking</a></li>
                        <li><a href="hallbookings">Hall Bookings</a></li>
                        <li>
                           <a href="#">Checked out <span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="hallcleared">Fully Paid</a>
                              </li>
                              <li>
                                 <a href="halluncleared">With Debt</a>
                              </li>
                           </ul>
                        </li>

                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getreservationreport">Reservations Report</a></li>
                        <li><a href="getrestaurantreport">Restaurant Report</a></li>
                        <li><a href="gethallreport">Conference room Report</a></li>
                        <li><a href="getpoolreport">Gym and Pool Report</a></li>
                        <li><a href="getlaundryreport">Laundry Report</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-book"></i> <span class="nav-label">Planning Boards</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="hotelroomboard">Hotel Rooms</a></li>
                        <li><a href="conferenceroomboard">Conference Rooms</a></li>
                     </ul>
                  </li>


               <?php }
               if ($role == 'Accountant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-money"></i> <span class="nav-label">Expenses</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="costs">View Expenses</a></li>
                        <li><a href="addcost">Add Expenses</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-barcode"></i> <span class="nav-label">Invoices</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getreservationinvoices">Reservations</a></li>
                        <li><a href="getrestaurantinvoices">Restaurant</a></li>
                        <li><a href="getlaundryinvoices">Laundry</a></li>
                        <li><a href="getpoolinvoices">Gym and Swimming Pool</a></li>
                        <li><a href="gethallinvoices">Conference room</a></li>
                        <li><a href="#">Confirmed Invoices<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li><a href="getconfirmedinvoices">Confirmed Reservation</a></li>
                              <li><a href="getconfirmedrestinvoices">Confirmed Restaurant Invoices</a></li>
                              <li><a href="getconfirmedlaundryinvoices">Confirmed Laundry Invoices</a></li>
                              <li><a href="getconfirmedpoolgyminvoices">Confirmed Gym and pool Invoices</a></li>
                              <li><a href="getconfirmedhallinvoices">Confirmed Hall invoices</a></li>
                           </ul>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getreservationreport">Reservations Report</a></li>
                        <li><a href="getstockreport">Stock Report</a></li>
                        <li><a href="gethallreport">Conference room Report</a></li>
                        <li><a href="getrestaurantreport">Restaurant Report</a></li>
                        <li><a href="getlaundryreport">Laundry Report</a></li>
                        <li><a href="getexpensesreport">Expenses Report</a></li>
                        <li><a href="getpoolreport">Gym and Pool Report</a></li>
                     </ul>
                  </li>
                  <li><a href="addrestaurantorder">Add Restaurant Order</a></li>
                  <li>
                     <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventory</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="stockitems">View Inventory</a></li>
                        <li><a href="addstockitem">Add Stock Item</a></li>
                        <li><a href="addstock">Add Stock</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  <!--                    <li>
                        <a href="getincomestatement"><i class="fa fa-money"></i><span class="nav-label">Income Statement</span></a>
                    </li>-->
               <?php }
               if ($role == 'Store Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventory</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="stockitems">View Inventory</a></li>
                        <li><a href="addstockitem">Add Stock Item</a></li>
                        <li><a href="issuedstock">Issued Stock</a></li>
                        <li><a href="addstock">Add Stock</a></li>
                        <!-- <li><a href="issuestock">Issue Stock</a></li> -->
                        <li><a href="#">Purchase Lists<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="createlist">Create List</a>
                              </li>
                              <li>
                                 <a href="approvedlists">Approved Lists</a>
                              </li>
                              <li>
                                 <a href="pendinglists">Pending Lists</a>
                              </li>
                           </ul>
                        </li>
                        <li><a href="#">Item Losses<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="additemloss">Add Loss</a>
                              </li>
                              <li>
                                 <a href="itemlosses">view Losses</a>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="orders"><i class="fa fa-bookmark"></i>Orders</a></li>

                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getstockreport">Stock Report</a></li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Laundry Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-female"></i> <span class="nav-label">Laundry</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="addlaundry">Add Laundry work</a></li>
                        <li><a href="laundrywork">Laundry work</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getlaundryreport">Laundry Report</a></li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Pool Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-bookmark"></i> <span class="nav-label">Gym & Swimming Pool</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="poolpackages">Packages</a></li>
                        <li><a href="poolsubscriptions">Subscriptions</a></li>
                        <li><a href="addpoolsubscription">Add Subscription</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>

                  <li>
                     <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="getpoolreport">Gym and Pool Report</a></li>
                     </ul>
                  </li>
               <?php }
               if ($role == 'Small Stock Attendant') {
               ?>
                  <li>
                     <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventory</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="stockitems">View Inventory</a></li>

                        <li><a href="addstockitem">Add Stock Item</a></li>
                        <li><a href="addstock">Add Stock</a></li>
                        <li><a href="issuestock">Issue Stock</a></li>
                        <li><a href="issuedstock">Issued Stock</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
               <?php }
               if ($role == 'Kitchen Exploitation Officer') { ?>
                  <li>
                     <a href=""><i class="fa fa-cutlery"></i> <span class="nav-label">Bar & Restaurant</span><span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="mealplans">Meal Plans</a></li>
                        <li><a href="rtables">Tables</a></li>
                        <li>
                           <a href="#">Menu items<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li><a href="menucategories">Categories</a></li>
                              <li><a href="foodmenu">View Menu Items</a></li>
                              <li>
                                 <a href="addmenuitem">Add Menu Item</a>
                              </li>
                           </ul>
                        </li>
                        <li>
                <a href="#">Hall Buffets<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="addhallbuffet">Add Buffet</a>
                    </li>
                    <li>
                        <a href="hallbuffets">View Buffets</a>
                    </li>
                </ul>
            </li>

                        <li>
                           <a href="#">Restaurant orders<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="gfoodorders">Orders From Residents</a>
                              </li>
                              <li>
                                 <a href="foodorders">Orders from Non Residents</a>
                              </li>
                              <li>
                                 <a href="restinvoices">All Invoices</a>
                              </li>

                           </ul>
                        </li>
                        <!-- <li>
                           <a href="#">Hall Buffets<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="addhallbuffet">Add Buffet</a>
                              </li>
                              <li>
                                 <a href="hallbuffets">View Buffets</a>
                              </li>
                           </ul>
                        </li> -->
                        <li><a href="addrestaurantorder">Add Order</a></li>
                        <li><a href="getrestinvoicesreport">Invoices Report</a></li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventory</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="stockitems">View Inventory</a></li>
                        <li><a href="#">Purchase Lists<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="createlist">Create List</a>
                              </li>
                              <li>
                                 <a href="approvedlists">Approved Lists</a>
                              </li>
                              <li>
                                 <a href="pendinglists">Pending Lists</a>
                              </li>
                           </ul>
                        </li>
                        <li><a href="addstockitem">Add Stock Item</a></li>
                        <li><a href="#">Kitchen Stock<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li><a href="kitchenstock">Kitchen Stock</a></li>
                              <li><a href="getturnoverreport">Turnover Report</a></li>
                              <li><a href="getordereditemsreport">Ordered Items Report</a></li>
                           </ul>
                        </li>
                        <!-- <li><a href="addkitchenstock">Add Kitchen Stock</a></li> -->
                        <li><a href="addstock">Add Stock</a></li>
                        <li><a href="issuestock">Issue Stock</a></li>

                        <li><a href="measurements">Item Measurements</a></li>
                        <li><a href="issuedstock">Issued Stock</a></li>
                        <li><a href="categories">Item Categories</a></li>
                        <li><a href="suppliers">Suppliers</a></li>
                        <li><a href="#">Item Losses<span class="fa arrow"></span></a>
                           <ul class="nav nav-third-level">
                              <li>
                                 <a href="additemloss">Add Loss</a>
                              </li>
                              <li>
                                 <a href="itemlosses">view Losses</a>
                              </li>
                           </ul>
                        </li>
                     </ul>
                  </li>
                  <li>
                     <a href=""><i class="fa fa-shopping-cart"></i> <span class="nav-label">Requisitions <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="requisitions">View Requisitions</a></li>
                        <li><a href="addrequisition">Add Requisition</a></li>
                     </ul>
                  </li>
                  <li><a href="issuedstock"><i class="fa fa-suitcase"></i>Issued Stock</a></li>
                  
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
               if ($_SESSION['hotelsyslevel'] == 1) {
               ?>
                  <li>
                     <a href=""><i class="fa fa-user"></i> <span class="nav-label">Admins</span> <span class="fa arrow"></span></a>
                     <ul class="nav nav-second-level">
                        <li><a href="admins">View Admins</a></li>
                        <li><a href="addadmin">Add Admin</a></li>
                     </ul>
                  </li>
            <?php }
            } ?>
            <li>
               <a href="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout </span></a>
            </li>
         </ul>

      </div>
   </nav>

<?php } ?>