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
                    <h2>Ajouter une réservation</h2>
                    <ol class="breadcrumb">
                        <li> <a href=""><i class="fa fa-home"></i> Accueil</a> </li>
                        <li> <a href="reservations">Réservation</a> </li>
                        <li class="active">
                            <strong>Ajouter une réservation</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <div class="wrapper wrapper-content">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Ajouter une réservation<small>Tous les champs marqués (*) ne doivent pas être laissés vides</small></h5>
                            </div>
                            <div class="ibox-content">
                                <?php
                                if (isset($_POST['submit'])) {
                                    $fname = mysqli_real_escape_string($con, trim($_POST['firstname']));
                                    $lname = mysqli_real_escape_string($con, trim($_POST['lastname']));
                                    $phone = mysqli_real_escape_string($con, trim($_POST['number']));
                                    $email = mysqli_real_escape_string($con, trim($_POST['email']));
                                    $idnumber = mysqli_real_escape_string($con, trim($_POST['idnumber']));
                                    $occupation = mysqli_real_escape_string($con, trim($_POST['occupation']));
                                    $adults = mysqli_real_escape_string($con, trim($_POST['adults']));
                                    $kids = mysqli_real_escape_string($con, trim($_POST['kids']));
                                    $mealplan = mysqli_real_escape_string($con, trim($_POST['mealplan']));
                                    $extrabed = mysqli_real_escape_string($con, trim($_POST['extrabed']));
                                    $nationality = mysqli_real_escape_string($con, trim($_POST['nationality']));
                                    $dob = mysqli_real_escape_string($con, trim($_POST['dob']));
                                    $address = mysqli_real_escape_string($con, trim($_POST['address']));
                                    $company = mysqli_real_escape_string($con, trim($_POST['company']));
                                    $room = mysqli_real_escape_string($con, trim($_POST['room']));
                                    $checkin = mysqli_real_escape_string($con, strtotime($_POST['checkin']));
                                    $arrivaltime = mysqli_real_escape_string($con, trim($_POST['arrivaltime']));
                                    $arrivingfrom = mysqli_real_escape_string($con, trim($_POST['arrivingfrom']));
                                    $departuretime = mysqli_real_escape_string($con, trim($_POST['departuretime']));
                                    $usdtariff = mysqli_real_escape_string($con, trim($_POST['usdtariff']));
                                    $fax = mysqli_real_escape_string($con, trim($_POST['fax']));
                                    $website = mysqli_real_escape_string($con, trim($_POST['website']));
                                    $mode = mysqli_real_escape_string($con, trim($_POST['mode']));
                                    $voucher = mysqli_real_escape_string($con, trim($_POST['voucher']));
                                    $other = mysqli_real_escape_string($con, trim($_POST['other']));
                                    $modevalue = 0;
                                    if ($mode == 'voucher') {
                                        $modevalue = $voucher;
                                    }
                                    if ($mode == 'other') {
                                        $modevalue = $other;
                                    }
                                    $checkout = mysqli_real_escape_string($con, strtotime($_POST['checkout']));
                                    if ((empty($fname)) || (empty($lname)) || (empty($phone)) || (empty($room)) || (empty($checkin)) || (empty($checkout)) || (empty($occupation))) {
                                        $errors[] = 'All Fields Marked with * should be filled';
                                    }
                                    if ($checkin > $checkout) {
                                        $errors[] = 'CheckIn Date Cant be later than CheckOut';
                                    }
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                            ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php
                                        }
                                    } else {
                                        mysqli_query($con, "INSERT INTO reservations(firstname,lastname,phone,email,nationality,room,adults,kids,mealplan,extrabed,dob,address,company,checkin,arrivaltime,arrivingfrom,checkout,actualcheckout,departuretime,usdtariff,fax,website,mode,modevalue,id_number,occupation,creator,timestamp,status) VALUES('$fname','$lname','$phone','$email','$nationality','$room','$adults','$kids','$mealplan','$extrabed','$dob','$address','$company','$checkin','$arrivaltime','$arrivingfrom','$checkout','0','$departuretime','$usdtariff','$fax','$website','$mode','$modevalue','$idnumber','$occupation','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP(),'0')") or die(mysqli_error($con));
                                        ?>
                                        <div class="alert alert-success"><i class="fa fa-check"></i>Réservation ajoutée avec succès</div>
                                <?php
                                    }
                                }
        ?>
                                <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="form-group col-lg-6"><label class="control-label">* Prénom</label>
                                            <input type="text" name='firstname' class="form-control" placeholder="Prénom" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Nom</label>
                                            <input type="text" name="lastname" class="form-control" placeholder="Nom" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Adulte</label>
                                            <input type="number" name="adults" class="form-control" placeholder="Adulte" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* des gamins</label>
                                            <input type="number" name="kids" class="form-control" placeholder="des gamins" required="required">
                                        </div>
                                        <div class="form-group col-lg-6" id="data_5">
                                            <label class="control-label">Plan de repas</label>
                                            <select class="form-control" name="mealplan">
                                                <option value="" selected="selected">Plan de repas</option>
                                                <?php
                        $getplans =  mysqli_query($con, "SELECT * FROM mealplans WHERE status=1");
        while ($row = mysqli_fetch_array($getplans)) {
            $mealplan_id = $row['mealplan_id'];
            $mealplan = $row['mealplan'];
            ?>
                                                    <option value="<?php echo $mealplan_id; ?>"><?php echo $mealplan; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6" id="data_5">
                                            <label class="control-label">* Numéro Chamre</label>
                                            <select class="form-control" name="room">
                                                <option value="" selected="selected">Chambre</option>
                                                <?php
            $rooms = mysqli_query($con, "SELECT * FROM rooms WHERE status='1' ORDER BY roomnumber");
        while ($row =  mysqli_fetch_array($rooms)) {
            $roomnumber = $row['roomnumber'];
            $room_id = $row['room_id'];
            $type = $row['type'];
            $status = $row['status'];
            $creator = $row['creator'];
            $roomtypes = mysqli_query($con, "SELECT * FROM roomtypes  WHERE roomtype_id='$type'");
            $row1 =  mysqli_fetch_array($roomtypes);
            $roomtype = $row1['roomtype'];
            $check =  mysqli_query($con, "SELECT * FROM reservations WHERE  status IN (0,1) AND room='$room_id'");
            $row2 = mysqli_fetch_array($check);
            $room2 = $row2['room'];
            if (mysqli_num_rows($check) == 0) {
                ?>
                                                        <option value="<?php echo $room_id; ?>"><?php echo $roomnumber . ' (' . $roomtype . ')'; ?></option>
                                                <?php }
            } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6" id="data_5">
                                            <label class="control-label">Lit supplémentaire</label>
                                            <select class="form-control" name="extrabed">
                                                <option value="No" selected="selected">Non</option>
                                                <option value="Yes">Oui</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Numéro de passeport/d'identité</label>
                                            <input type="text" name="idnumber" class="form-control" placeholder="Numéro de passeport/d'identité<">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Nationalité</label>
                                            <input type="text" name="nationality" class="form-control" placeholder="Nationalité">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Date de naissance</label>
                                            <input type="date" name="dob" class="form-control" placeholder="Date de naissance">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">adresse permanente</label>
                                            <input type="text" name="address" class="form-control" placeholder="adresse permanente">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">Occupation</label>
                                            <input type="text" name="occupation" class="form-control" placeholder="Occupation">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">C Compagnie</label>
                                            <input type="text" name="company" class="form-control" placeholder="C Compagnie">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group  col-lg-4"><label class="control-label">Date d'arrivée</label>
                                            <input type="date" name="checkin" class="form-control" placeholder="Date d'arrivée">
                                        </div>
                                        <div class="form-group  col-lg-4"><label class="control-label">Heure d'arrivée</label>
                                            <input type="time" name="arrivaltime" class="form-control" placeholder="Heure d'arrivée">
                                        </div>
                                        <div class="form-group  col-lg-4"><label class="control-label">Arrivant de</label>
                                            <input type="text" name="arrivingfrom" class="form-control" placeholder="Arrivant de">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">Date de départ</label>
                                            <input type="date" name="checkout" class="form-control" placeholder="Date de départ">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">Heure de départ</label>
                                            <input type="time" name="departuretime" class="form-control" placeholder="Heure de départ">
                                        </div>
                                        <div class="form-group  col-lg-6"><label class="control-label">USD Tariff</label>
                                            <input type="text" name="usdtariff" class="form-control" placeholder="USD Tariff">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">* Téléphone</label>
                                            <input type="text" name="number" class="form-control" placeholder="Téléphone" required="required">
                                        </div>
                                        <div class="form-group col-lg-6"><label class=" control-label">Addresse Email</label>
                                            <input type="email" name="email" class="form-control " placeholder="Addresse Email">
                                            <div id='form_email_errorloc' class='text-danger'></div>
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">FAX</label>
                                            <input type="text" name="fax" class="form-control" placeholder="Fax">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Site Internet</label>
                                            <input type="text" name="website" class="form-control" placeholder="Site Internet">
                                        </div>
                                        <div class="form-group col-lg-6"><label class="control-label">Mode de paiement</label>
                                            <select class="form-control" name="mode" id="paymentmode">
                                                <option value="" selected="selected">Sélectionnez le mode</option>
                                                <option value="cash">Cash</option>
                                                <option value="credit card">Credit Card</option>
                                                <option value="voucher">Voucher</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 forvoucher" style="display: none"><label class="control-label">Voucher No</label>
                                            <input type="text" name="voucher" class="form-control" placeholder="Voucher No">
                                        </div>
                                        <div class="form-group col-lg-6 forother" style="display: none"><label class="control-label">Autre</label>
                                            <input type="text" name="other" class="form-control" placeholder="Autre">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit" name="submit">Ajouter Réservation</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>