<?php
if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
?>

    <li>
        <a href=""><i class="fa fa-home"></i> <span class="nav-label">Pièces</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="roomtypes">Types de chambres</a></li>
            <li><a href="occupiedrooms">Chambres occupées</a></li>
            <li><a href="rooms">Chambres inoccupées</a></li>
            <li><a href="addroom">Ajouter une chambre</a></li>

        </ul>
    </li>

    <li>
        <a href=""><i class="fa fa-folder-open"></i> <span class="nav-label">Réservations</span> <span class="fa arrow"></ étendue></a>
        <ul class="nav nav-second-level">
            <li>
                <a href="addreservation">Ajouter une réservation</a>
            </li>
            <li>
                <a href="reservations">Réservations en attente</a>
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
        <a href=""><i class="fa fa-cutlery"></i> <span class="nav-label">Bar & Resto</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="mealplans">Plans de repas</a></li>
            <li><a href="rtables">Tableaux</a></li>
            <li><a href="foodmenu">Éléments de menu</a></li>

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
            <li><a href="addrestaurantorder">Ajouter une commande</a></li>
        </ul>
    </li>
    <!--                    <li>
                        <a href=""><i class="fa fa-glass"></i> <span class="nav-label">Bar</span><span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                      <li><a href="bartables">Tables</a></li> 
                                                       <li><a href="drinks">Drinks</a></li>                                                  
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
        <a href=""><i class="fa fa-bookmark"></i> <span class="nav-label">Piscine</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="poolpackages">Forfaits Piscine</a></li>
            <li><a href="poolsubscriptions">Abonnements au pool</a></li>
            <li><a href="addpoolsubscription">Ajouter un abonnement au pool</a></li>
            <li><a href="poolcommands">Commandes de pool</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-female"></i> <span class="nav-label">Blanchisserie</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="laundrytypes">Forfaits de blanchisserie</a></li>
            <li><a href="addlaundry">Ajouter des travaux de blanchisserie</a></li>
            <li><a href="laundrywork">Travail de blanchisserie</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Salle de conférence</span> <span class="fa arrow"></span></a>
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
    <li>
        <a href=""><i class="fa fa-certificate"></i> <span class="nav-label">Salle de sport</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="gymbouquets">Bouquets de gym</a></li>
            <li><a href="addgymsubscription">Ajouter un abonnement à une salle de sport</a></li>
            <li><a href="gymsubscriptions">Abonnements aux salles de sport</a></li>
        </ul>
    </li>

    <li>
        <a href=""><i class="fa fa-arrow-down"></i> <span class="nav-label">Dépenses</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="costs">Afficher les dépenses</a></li>
            <li><a href="addcost">Ajouter une dépense</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-suitcase"></i> <span class="nav-label">Inventaire</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="stockitems">Afficher l'inventaire</a></li>
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
            <li><a href="addstockitem">Ajouter un article en stock</a></li>
            <li><a href="addstock">Ajouter des stocks</a></li>
            <li><a href="measurements">Mesures de l'article</a></li>
            <li><a href="categories">Catégories d'articles</a></li>
            <li><a href="suppliers">Fournisseurs</a></li>
        </ul>
    </li>

    <li>
        <a href="departments"><i class="fa fa-building-o"></i> <span class="nav-label">Départements et désignations </span></a>
    </li>
    <li>
        <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Rapports</span> <span class="fa arrow"> </span></a>
        <ul class="nav nav-second-level">
            <li><a href="getreservationreport">Rapport sur les réservations</a></li>
            <li><a href="getgymreport">Rapport sur la salle de sport</a></li>
            <li><a href="gethallreport">Rapport de la salle de conférence</a></li>
            <li><a href="getrestaurantreport">Rapport sur les restaurants</a></li>
            <li><a href="getexpensesreport">Rapport de dépenses</a></li>

        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-group"></i> <span class="nav-label">Employés</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="employees">Afficher les employés</a></li>
            <li><a href="addemployee">Ajouter un employé</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-reply"></i> <span class="nav-label">Feuilles</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="addleave">Ajouter un congé</a></li>
            <li><a href="activeleaves">Feuilles actives</a></li>
            <li><a href="pendingleaves">Feuilles en attente</a></li>
            <li><a href="leaveshistory">Feuille l'historique</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-user"></i> <span class="nav-label">Administrateurs</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="admins">Afficher les administrateurs</a></li>
            <li><a href="addadmin">Ajouter un administrateur</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-cogs"></i> <span class="nav-label">Paramètres</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
            <li><a href="settings">Identité de l'hôtel</a></li>
            <li><a href="taxes">Taxes</a></li>
        </ul>
    </li>
    <li>
        <a href="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Déconnexion </span></a>
    </li>
    </ul>

    </div>
    </nav>
<?php } else { ?>
    <li>
        <a href=""><i class="fa fa-home"></i> <span class="nav-label">Rooms</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li>
                <a href="#">Room Types <span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="addroomtype">Add Room Type</a>
                    </li>
                    <li>
                        <a href="roomtypes">Room Types</a>
                    </li>
                </ul>
            </li>
            <li><a href="rooms">All Rooms</a></li>
            <li><a href="addroom">Add Room</a></li>

        </ul>
    </li>

    <li>
        <a href=""><i class="fa fa-folder-open"></i> <span class="nav-label">Reservations</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <!-- <li>
                <a href="addreservation">Add Reservation</a>
            </li> -->
            <li>
                <a href="reservations">Pending Reservations</a>
            </li>
            <li><a href="guestsin">Check Ins</a></li>
            <li>
                <a href="#">Checked out <span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li>
                        <a href="cleared">Without Debt</a>
                    </li>
                    <li>
                        <a href="uncleared">With Debt</a>
                    </li>
                </ul>
            </li>
            <li><a href="pendingouts">Pending Check Outs</a></li>
            <!-- <li><a href="payments">Payments</a></li> -->

        </ul>
    </li>

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
            <li>
                <a href="#">Hall Buffets<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <!-- <li>
                        <a href="addhallbuffet">Add Buffet</a>
                    </li> -->
                    <li>
                        <a href="hallbuffets">View Buffets</a>
                    </li>
                </ul>
            </li>
            <!-- <li><a href="addrestaurantorder">Add Order</a></li> -->
            <li><a href="getrestinvoicesreport">Invoices Report</a></li>
        </ul>
    </li>
    <!--                    <li>
                        <a href=""><i class="fa fa-glass"></i> <span class="nav-label">Bar</span><span class="fa arrow"></span></a>
                                                <ul class="nav nav-second-level">
                                                      <li><a href="bartables">Tables</a></li> 
                                                       <li><a href="drinks">Drinks</a></li>                                                  
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
        <a href=""><i class="fa fa-bookmark"></i> <span class="nav-label">Gym & Swimming Pool</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="poolpackages">Bouquets</a></li>
            <!-- <li><a href="addpoolsubscription">Add Subscription</a></li> -->
            <li><a href="poolsubscriptions">Subscriptions</a></li>

        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-female"></i> <span class="nav-label">Laundry</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="laundrytypes">Laundry Packages</a></li>
            <!-- <li><a href="addlaundry">Add Laundry work</a></li> -->
            <li><a href="laundrywork">Laundry work</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-building-o"></i> <span class="nav-label">Conference Hall</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="conferencerooms">Conference Rooms</a></li>
            <li><a href="conferenceotherservices">Other Services</a></li>
            <li>
                <a href="#">Hall Bookings<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <!-- <li><a href="addhallbooking">Add Hall booking</a></li> -->
                    <li><a href="hallbookings">Hall Bookings</a></li>
                </ul>
            </li>
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
        <a href=""><i class="fa fa-arrow-down"></i> <span class="nav-label">Expenses</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="costs">View Expenses</a></li>
            <!-- <li><a href="addcost">Add Expense</a></li> -->
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
            <!-- <li><a href="addstock">Add Stock</a></li> -->
            <li><a href="issuestock">Issue Stock</a></li>
            <li><a href="measurements">Item Measurements</a></li>
            <li><a href="categories">Item Categories</a></li>
            <li>
                <a href="">Requisitions<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <li><a href="requisitions">View Requisitions</a></li>
                    <!-- <li><a href="addrequisition">Add Requisition</a></li> -->
                </ul>
            </li>
            <li><a href="suppliers">Suppliers</a></li>
            <li><a href="#">Item Losses<span class="fa arrow"></span></a>
                <ul class="nav nav-third-level">
                    <!-- <li>
                        <a href="additemloss">Add Loss</a>
                    </li> -->
                    <li>
                        <a href="itemlosses">view Losses</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    <li>
        <a href="departments"><i class="fa fa-building-o"></i> <span class="nav-label">Departments & Designations </span></a>
    </li>
    <li>
        <a href=""><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
        <li><a href="getoverallreport"> Overall Report</a></li>
            <li><a href="getreservationreport">Reservations Report</a></li>
            <li><a href="getinventoryreport">Inventory Report</a></li>
            <li><a href="getstockreport">Stock Report</a></li>
            <li><a href="gethallreport">Conference room Report</a></li>
            <li><a href="getrestaurantreport">Restaurant Report</a></li>
            <li><a href="getlaundryreport">Laundry Report</a></li>
            <li><a href="getexpensesreport">Expenses Report</a></li>
            <li><a href="getpoolreport">Gym and Pool Report</a></li>
            <li><a href="getleavereport">Leave Report</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-group"></i> <span class="nav-label">Services</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="services">View Services</a></li>
            <li><a href="addservice">Add Service</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-group"></i> <span class="nav-label">Employees</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="employees">View Employees</a></li>
            <li><a href="addemployee">Add Employee</a></li>
        </ul>
    </li>

    <li>
        <a href=""><i class="fa fa-reply"></i> <span class="nav-label">Leaves</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="addleave">Add Leave</a></li>
            <li><a href="activeleaves">Active Leaves</a></li>
            <li><a href="pendingleaves">Pending Leaves</a></li>
            <li><a href="leaveshistory">Leaves History</a></li>
            <li><a href="annualleaves">Annual Leaves</a></li>
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
        <a href=""><i class="fa fa-user"></i> <span class="nav-label">Admins</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="admins">View Admins</a></li>
            <li><a href="addadmin">Add Admin</a></li>
        </ul>
    </li>
    <li>
        <a href=""><i class="fa fa-cogs"></i> <span class="nav-label">Settings</span> <span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <li><a href="settings">Hotel Identity</a></li>
            <li><a href="taxes">Taxes</a></li>
            <li><a href="exchangerates">Exchange Rates</a></li>
        </ul>
    </li>

    <li>
        <a href="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout </span></a>
    </li>
    </ul>

    </div>
    </nav>

<?php } ?>