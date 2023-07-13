<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
    header('Location:login');
}

?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Hall Reservation - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!--<link href="css/plugins/iCheck/custom.css" rel="stylesheet">-->
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addhallbooking.php';
    } else {
    ?>

        <div id="wrapper">

            <?php
            include 'nav.php';
            ?>

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
                        <h2>Add New Hall Reservation</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="hallbookings">Reservations</a> </li>
                            <li class="active">
                                <strong>Add Hall Reservation</strong>
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
                                    <h5>Add New Hall Reservation <small>All fields marked (*) shouldn't be left blank</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php

                                    if (isset($_POST['fullname'], $_POST['number'], $_POST['people'], $_POST['advance'], $_POST['description'], $_POST['country'], $_POST['checkin'], $_POST['checkout'])) {
                                        $fullname = mysqli_real_escape_string($con, trim($_POST['fullname']));
                                        $phone = mysqli_real_escape_string($con, trim($_POST['number']));
                                        $people = mysqli_real_escape_string($con, trim($_POST['people']));
                                        $buffets = $_POST['buffets'];

                                        $room = $_POST['room'];
                                        $country = mysqli_real_escape_string($con, trim($_POST['country']));
                                        $description = mysqli_real_escape_string($con, trim($_POST['description']));
                                        $checkin = mysqli_real_escape_string($con,  $_POST['checkin']);
                                        $checktime= mysqli_real_escape_string($con,  $_POST['checktime']);
                                        // combine date and time like this 2018-01-01 12:00:00  (Y-m-d H:i:s)
                                        $checkin = strtotime("$checkin $checktime") ;
                                        $checkout = mysqli_real_escape_string($con,  $_POST['checkout']);
                                        $checkouttime= mysqli_real_escape_string($con,  $_POST['checkouttime']);
                                        // combine date and time
                                        $checkout =strtotime("$checkout $checkouttime");
                                        $advance = mysqli_real_escape_string($con, trim($_POST['advance']));
                                        $reason = mysqli_real_escape_string($con, trim($_POST['reason']));
                                        $discount = mysqli_real_escape_string($con, trim($_POST['discount']));
                                        $service = $_POST['service'];

                                        $servicedays = $_POST["service_days"];
                                        $quantity = $_POST['quantity'];
                                        $otherservices = $_POST['otherservices'];
                                        $othercharge = $_POST['othercharge'];
                                        if ((empty($fullname)) || (empty($phone)) || (empty($checkin)) || (empty($checkout))) {
                                            $errors[] = 'All Fields Marked * shouldnt be blank';
                                        }
                                        if ($checkin > $checkout) {
                                            $errors[] = 'CheckIn Date Cant be later than CheckOut';
                                        }

                                        if (!empty($advance)) {
                                            if (is_numeric($advance) == FALSE) {
                                                $errors[] = 'Payment Amount should be an integer';
                                            }
                                        }
                                        if (!empty($errors)) {
                                            foreach ($errors as $error) {
                                    ?>
                                                <div class="alert alert-danger"><?php echo $error; ?></div>
                                            <?php
                                            }
                                        } else {
                                            $split = explode('_', $room);
                                            $room_id = $split[0];
                                            $charge = $split[1];
                                            $vat = 0;

                                            mysqli_query($con, "INSERT INTO hallreservations(room_id,fullname,phone,people,charge,country,checkin,checkout,reason,vat,discount,description,timestamp,creator,ocreator,status) VALUES('$room_id','$fullname','$phone','$people','$charge','$country','$checkin','$checkout','$reason','$vat','$discount','$description',UNIX_TIMESTAMP(),'" . $_SESSION['emp_id'] . "','" . $_SESSION['emp_id'] . "','1')") or die(mysqli_error($con));
                                            $last_id = mysqli_insert_id($con);
                                            $addpayment =  mysqli_query($con, "INSERT INTO hallpayments(hallbooking_id,amount,creator,timestamp) VALUES('$last_id','$advance','" . $_SESSION['emp_id'] . "',UNIX_TIMESTAMP())");
                                            $allbuffets = sizeof($buffets);
                                            $items = $_POST['items'] ?? [];
                                            $buffetdays = $_POST["buffet_days"];
                                            $buffetquantity = $_POST['buffet_quantity'];
                                            foreach ($buffets as $key => $value) {
                                                if (!$value) continue;
                                                $splitbuffet = explode('_', $buffets[$key]);
                                                $buffet_id = $splitbuffet[0];
                                                $price = $splitbuffet[1];
                                                $days = $buffetdays[$key];
                                                $bquantity = $buffetquantity[$key];
                                                $itemslist = implode(', ', $items[$key] ?? []);
                                                mysqli_query($con, "INSERT INTO reservationbuffets(hallbooking_id,hallbuffet_id,price,otheritems,days,quantity,status) VALUES('$last_id','$buffet_id','$price','$itemslist','$days','$bquantity',1)") or die(mysqli_error($con));
                                            }

                                            $bookingservices = sizeof($service);
                                            // print_r($service); die();
                                            for ($i = 0; $i < $bookingservices; $i++) {
                                                if (empty($service[$i])) continue;
                                                $splitservices = explode('_', $service[$i]);
                                                $service_id = $splitservices[0];
                                                $servicecharge = $splitservices[1];
                                                $servedays = $servicedays[$i];
                                                mysqli_query($con, "INSERT INTO hallservices(hallreservation_id,service,price,quantity,days,status) VALUES('$last_id','$service_id','$servicecharge','$quantity[$i]','$servedays',1)");
                                            }

                                            foreach ($otherservices as $key => $serv2) {
                                                if (!empty($serv2)) {
                                                    $scharge = $othercharge[$key];
                                                    mysqli_query($con, "INSERT INTO hallservices2(hallreservation_id,service,price,status) VALUES('$last_id','$serv2','$scharge',1)");
                                                }
                                            }
                                            ?>
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <div class="alert alert-success"><i class="fa fa-check"></i>Hall Reservation Successfully Added. Click <a href="hallinvoice_print?id=<?php echo $last_id; ?>">Here</a> To finish Reservation</div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>

                                    <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="form-group col-lg-6"><label class="control-label">* Full Name</label>

                                                <input type="text" name='fullname' class="form-control" placeholder="Enter Full Name" required="required">

                                            </div>

                                            <div class="form-group col-lg-6"><label class="control-label">* Contact Number</label>
                                                <input type="text" name="number" class="form-control" placeholder="Enter your contact  Number" required="required">
                                            </div>

                                            <div class="form-group col-lg-6">
                                                <label class="ccontrol-label">*Conference Room</label>

                                                <select class="form-control" name='room'>
                                                    <option value="" selected="selected">Select Room</option>
                                                    <?php
                                                    $purposes = mysqli_query($con, "SELECT * FROM conferencerooms WHERE status='1'");
                                                    while ($row = mysqli_fetch_array($purposes)) {
                                                        $conferenceroom_id = $row['conferenceroom_id'];
                                                        $room = $row['room'];
                                                        $people = $row['people'];
                                                        $charge = $row['charge'];
                                                        //                              $check= mysqli_query($con,"SELECT * FROM hallreservations WHERE room_id='$conferenceroom_id' AND status IN (1,2)");
                                                        //                              if(mysqli_num_rows($check)==0){
                                                    ?>
                                                        <option value="<?php echo $conferenceroom_id . '_' . $charge; ?>"><?php echo $room . ' (' . $people . ' People)'; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6"><label class="control-label">* Number of People to attend</label>
                                                <input type="number" name="people" class="form-control" placeholder="Number of people" required>
                                            </div>
                                            <div class="form-group col-lg-6"><label class="control-label">Reason</label>
                                                <input type="text" name="reason" class="form-control" placeholder="Reason">

                                            </div>
                                        </div>
                                        

                                        <div class="row">
                                            
                                            <div class="form-group col-sm-6 data_5">
                                                <label class="control-label">* Check in</label>
                                                <div class="input-daterange">
                                                    <input type="date" class="form-control" name="checkin" autocomplete="off" placeholder="Check In date" required="required" style="text-align: left;" />
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">* Check In Time</label>
                                                <input type="time" class="form-control" name="checktime" placeholder="start time" required="required" />
                                            </div>
                                        
                                            <!-- <div class="form-group col-lg-6">
                                                <label class="control-label">* Check in</label>
                                                <input type="date" class="form-control" name="checkin" required="required" />
                                            </div> -->
                                            <div class="form-group col-lg-6">
                                                <label class="control-label">* Check Out</label>
                                                <input type="date" class="form-control" name="checkout" required="required" />
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">* Check out Time</label>
                                                <input type="time" class="form-control" name="checkouttime" placeholder="start time" required="required" />
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label class="control-label">Country</label>
                                                <select data-placeholder="Choose a Country..." class="chosen-select" style="width: 100%" tabindex="2" name="country">
                                                    <option value="" selected="selected">Choose country...</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Aland Islands">Aland Islands</option>
                                                    <option value="Albania">Albania</option>
                                                    <option value="Algeria">Algeria</option>
                                                    <option value="American Samoa">American Samoa</option>
                                                    <option value="Andorra">Andorra</option>
                                                    <option value="Angola">Angola</option>
                                                    <option value="Anguilla">Anguilla</option>
                                                    <option value="Antarctica">Antarctica</option>
                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                    <option value="Argentina">Argentina</option>
                                                    <option value="Armenia">Armenia</option>
                                                    <option value="Aruba">Aruba</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Austria">Austria</option>
                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                    <option value="Bahamas">Bahamas</option>
                                                    <option value="Bahrain">Bahrain</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Barbados">Barbados</option>
                                                    <option value="Belarus">Belarus</option>
                                                    <option value="Belgium">Belgium</option>
                                                    <option value="Belize">Belize</option>
                                                    <option value="Benin">Benin</option>
                                                    <option value="Bermuda">Bermuda</option>
                                                    <option value="Bhutan">Bhutan</option>
                                                    <option value="Bolivia, Plurinational State of">Bolivia, Plurinational State of</option>
                                                    <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>
                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                    <option value="Botswana">Botswana</option>
                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                    <option value="Brazil">Brazil</option>
                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                    <option value="Bulgaria">Bulgaria</option>
                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                    <option value="Burundi">Burundi</option>
                                                    <option value="Cambodia">Cambodia</option>
                                                    <option value="Cameroon">Cameroon</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="Cape Verde">Cape Verde</option>
                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                    <option value="Central African Republic">Central African Republic</option>
                                                    <option value="Chad">Chad</option>
                                                    <option value="Chile">Chile</option>
                                                    <option value="China">China</option>
                                                    <option value="Christmas Island">Christmas Island</option>
                                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                    <option value="Colombia">Colombia</option>
                                                    <option value="Comoros">Comoros</option>
                                                    <option value="Congo">Congo</option>
                                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                                    <option value="Cook Islands">Cook Islands</option>
                                                    <option value="Costa Rica">Costa Rica</option>
                                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                    <option value="Croatia">Croatia</option>
                                                    <option value="Cuba">Cuba</option>
                                                    <option value="Curacao">Curacao</option>
                                                    <option value="Cyprus">Cyprus</option>
                                                    <option value="Czech Republic">Czech Republic</option>
                                                    <option value="Denmark">Denmark</option>
                                                    <option value="Djibouti">Djibouti</option>
                                                    <option value="Dominica">Dominica</option>
                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                    <option value="Ecuador">Ecuador</option>
                                                    <option value="Egypt">Egypt</option>
                                                    <option value="El Salvador">El Salvador</option>
                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                    <option value="Eritrea">Eritrea</option>
                                                    <option value="Estonia">Estonia</option>
                                                    <option value="Ethiopia">Ethiopia</option>
                                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                    <option value="Fiji">Fiji</option>
                                                    <option value="Finland">Finland</option>
                                                    <option value="France">France</option>
                                                    <option value="French Guiana">French Guiana</option>
                                                    <option value="French Polynesia">French Polynesia</option>
                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                    <option value="Gabon">Gabon</option>
                                                    <option value="Gambia">Gambia</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Ghana">Ghana</option>
                                                    <option value="Gibraltar">Gibraltar</option>
                                                    <option value="Greece">Greece</option>
                                                    <option value="Greenland">Greenland</option>
                                                    <option value="Grenada">Grenada</option>
                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                    <option value="Guam">Guam</option>
                                                    <option value="Guatemala">Guatemala</option>
                                                    <option value="Guernsey">Guernsey</option>
                                                    <option value="Guinea">Guinea</option>
                                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                                    <option value="Guyana">Guyana</option>
                                                    <option value="Haiti">Haiti</option>
                                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                    <option value="Honduras">Honduras</option>
                                                    <option value="Hong Kong">Hong Kong</option>
                                                    <option value="Hungary">Hungary</option>
                                                    <option value="Iceland">Iceland</option>
                                                    <option value="India">India</option>
                                                    <option value="Indonesia">Indonesia</option>
                                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                    <option value="Iraq">Iraq</option>
                                                    <option value="Ireland">Ireland</option>
                                                    <option value="Isle of Man">Isle of Man</option>
                                                    <option value="Israel">Israel</option>
                                                    <option value="Italy">Italy</option>
                                                    <option value="Jamaica">Jamaica</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Jersey">Jersey</option>
                                                    <option value="Jordan">Jordan</option>
                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                    <option value="Kenya">Kenya</option>
                                                    <option value="Kiribati">Kiribati</option>
                                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                                    <option value="Kuwait">Kuwait</option>
                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                    <option value="Latvia">Latvia</option>
                                                    <option value="Lebanon">Lebanon</option>
                                                    <option value="Lesotho">Lesotho</option>
                                                    <option value="Liberia">Liberia</option>
                                                    <option value="Libya">Libya</option>
                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                    <option value="Lithuania">Lithuania</option>
                                                    <option value="Luxembourg">Luxembourg</option>
                                                    <option value="Macao">Macao</option>
                                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                                    <option value="Madagascar">Madagascar</option>
                                                    <option value="Malawi">Malawi</option>
                                                    <option value="Malaysia">Malaysia</option>
                                                    <option value="Maldives">Maldives</option>
                                                    <option value="Mali">Mali</option>
                                                    <option value="Malta">Malta</option>
                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                    <option value="Martinique">Martinique</option>
                                                    <option value="Mauritania">Mauritania</option>
                                                    <option value="Mauritius">Mauritius</option>
                                                    <option value="Mayotte">Mayotte</option>
                                                    <option value="Mexico">Mexico</option>
                                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                    <option value="Monaco">Monaco</option>
                                                    <option value="Mongolia">Mongolia</option>
                                                    <option value="Montenegro">Montenegro</option>
                                                    <option value="Montserrat">Montserrat</option>
                                                    <option value="Morocco">Morocco</option>
                                                    <option value="Mozambique">Mozambique</option>
                                                    <option value="Myanmar">Myanmar</option>
                                                    <option value="Namibia">Namibia</option>
                                                    <option value="Nauru">Nauru</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Netherlands">Netherlands</option>
                                                    <option value="New Caledonia">New Caledonia</option>
                                                    <option value="New Zealand">New Zealand</option>
                                                    <option value="Nicaragua">Nicaragua</option>
                                                    <option value="Niger">Niger</option>
                                                    <option value="Nigeria">Nigeria</option>
                                                    <option value="Niue">Niue</option>
                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                    <option value="Norway">Norway</option>
                                                    <option value="Oman">Oman</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Palau">Palau</option>
                                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                    <option value="Panama">Panama</option>
                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                    <option value="Paraguay">Paraguay</option>
                                                    <option value="Peru">Peru</option>
                                                    <option value="Philippines">Philippines</option>
                                                    <option value="Pitcairn">Pitcairn</option>
                                                    <option value="Poland">Poland</option>
                                                    <option value="Portugal">Portugal</option>
                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                    <option value="Qatar">Qatar</option>
                                                    <option value="Reunion">Reunion</option>
                                                    <option value="Romania">Romania</option>
                                                    <option value="Russian Federation">Russian Federation</option>
                                                    <option value="Rwanda">Rwanda</option>
                                                    <option value="Saint Barthelemy">Saint Barthelemy</option>
                                                    <option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>
                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                    <option value="Saint Lucia">Saint Lucia</option>
                                                    <option value="Saint Martin (French part)">Saint Martin (French part)</option>
                                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                                    <option value="Samoa">Samoa</option>
                                                    <option value="San Marino">San Marino</option>
                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                    <option value="Senegal">Senegal</option>
                                                    <option value="Serbia">Serbia</option>
                                                    <option value="Seychelles">Seychelles</option>
                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                    <option value="Singapore">Singapore</option>
                                                    <option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>
                                                    <option value="Slovakia">Slovakia</option>
                                                    <option value="Slovenia">Slovenia</option>
                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                    <option value="Somalia">Somalia</option>
                                                    <option value="South Africa">South Africa</option>
                                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                                    <option value="South Sudan">South Sudan</option>
                                                    <option value="Spain">Spain</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="Sudan">Sudan</option>
                                                    <option value="Suriname">Suriname</option>
                                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                    <option value="Swaziland">Swaziland</option>
                                                    <option value="Sweden">Sweden</option>
                                                    <option value="Switzerland">Switzerland</option>
                                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                    <option value="Tajikistan">Tajikistan</option>
                                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                    <option value="Thailand">Thailand</option>
                                                    <option value="Timor-leste">Timor-leste</option>
                                                    <option value="Togo">Togo</option>
                                                    <option value="Tokelau">Tokelau</option>
                                                    <option value="Tonga">Tonga</option>
                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                    <option value="Tunisia">Tunisia</option>
                                                    <option value="Turkey">Turkey</option>
                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                    <option value="Tuvalu">Tuvalu</option>
                                                    <option value="Uganda">Uganda</option>
                                                    <option value="Ukraine">Ukraine</option>
                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                    <option value="Uruguay">Uruguay</option>
                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                    <option value="Vanuatu">Vanuatu</option>
                                                    <option value="Venezuela, Bolivarian Republic of">Venezuela, Bolivarian Republic of</option>
                                                    <option value="Viet Nam">Viet Nam</option>
                                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                    <option value="Western Sahara">Western Sahara</option>
                                                    <option value="Yemen">Yemen</option>
                                                    <option value="Zambia">Zambia</option>
                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6"><label class="control-label">Advance Payments (if any)</label>
                                                <input type="text" name='advance' class="form-control" placeholder="Enter advance payments if any">
                                            </div>
                                            <div class="form-group col-lg-6"><label class="control-label">Discount in TSHS</label>
                                                <input type="te" name='discount' class="form-control" placeholder="Enter discount if any">
                                            </div>
                                        </div>

                                        <hr>
                                        <div class='buffetsec mt-3'>

                                            <h3>Add Buffets</h3>
                                            <div class="row">
                                                <div class="col-lg-11">
                                                    <div class='row'>
                                                        <div class="form-group col-lg-4">
                                                            <label class="control-label">Buffet</label>
                                                            <select class="form-control" name='buffets[]'>
                                                                <option value="">Select Buffet</option>
                                                                <?php
                                                                $buffets = mysqli_query($con, "SELECT * FROM hallbuffets WHERE status='1'");
                                                                while ($row = mysqli_fetch_array($buffets)) {
                                                                    $hallbuffet_id = $row['hallbuffet_id'];
                                                                    $buffet = $row['buffet'];
                                                                    $price = $row['price'];
                                                                ?>
                                                                    <option value="<?php echo $hallbuffet_id . '_' . $price; ?>"><?php echo $buffet; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-4">
                                                            <label class="control-label">Days to serve</label>
                                                            <input type="number" class="form-control" name="buffet_days[]">
                                                        </div>
                                                        <div class="form-group col-lg-4">
                                                            <label class="control-label">Quantity</label>
                                                            <input type="number" class="form-control" name="buffet_quantity[]" required>
                                                        </div>


                                                        
                                                        
                                                    </div>
                                                </div>
                                                <a href='#' class="buffet_button btn btn-success" style="margin-top:22px">+</a>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class='subobj mt-3'>
                                            <h3>Add Other Services</h3>
                                            <div class='row'>
                                                <div class="form-group col-lg-6"><label class="control-label">Select Service</label>
                                                    <select data-placeholder="Choose Service.." name="service[]" class="chosen-select" style="width:100%;" tabindex="2">
                                                        <option value="" selected="selected">choose Service..</option>
                                                        <?php
                                                        $services = mysqli_query($con, "SELECT * FROM conferenceotherservices WHERE status='1'");
                                                        while ($row = mysqli_fetch_array($services)) {
                                                            $conferenceotherservice_id = $row['conferenceotherservice_id'];
                                                            $service = stripslashes($row['service']);
                                                            $charge = $row['charge'];
                                                        ?>
                                                            <option value="<?php echo $conferenceotherservice_id . '_' . $charge; ?>"><?php echo $service . ' (' . $charge . ')'; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-5"><label class="control-label">Quantity</label>
                                                    <input type="number" name='quantity[]' class="form-control" placeholder="Enter Quantity" step="0.01">
                                                </div>

                                                <div class="form-group col-lg-1">
                                                    <a href='#' class="subobj_button btn btn-success" style="margin-top:25px">+</a>
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label class="control-label">Days to use</label>
                                                    <input type="number" class="form-control" name="service_days[]">
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class='subobj3 mt-3'>
                                            <h3>Add Other Services 2</h3>
                                            <div class='row'>
                                                <div class="form-group col-lg-6"><label class="control-label">Service</label>
                                                    <input type="text" class="form-control" name="otherservices[]">
                                                </div>
                                                <div class="form-group col-lg-5"><label class="control-label">Charge</label>
                                                    <input type="number" name='othercharge[]' class="form-control" placeholder="Enter Service charge" step="0.01">
                                                </div>

                                                <div class="form-group col-lg-1">
                                                    <a href='#' class="subobj2_button btn btn-success" style="margin-top:25px">+</a>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group"><label class="control-label">Description</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Add Hall Reservation</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    <?php } ?>
    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <script src="js/plugins/chosen/chosen.jquery.js"></script>
    <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- iCheck -->
    <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
</body>

</html>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
            allow_single_deselect: true
        },
        '.chosen-select-no-single': {
            disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
            no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
            width: "95%"
        }
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

    $('.subobj2_button').on('click', function(e) {
        e.preventDefault();
        $('.subobj3').append(`
        <div class='row'>
            <div class="form-group col-lg-6"><label class="control-label">Service</label>
                <input type="text" class="form-control" name="otherservices[]">
            </div>
            <div class="form-group col-lg-5"><label class="control-label">Charge</label>
                <input type="number" name='othercharge[]' class="form-control" placeholder="Enter Service charge" step="0.01">
            </div>

            <div class="form-group col-lg-1">
                <button type="button" class="remove_subobj2  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button>
            </div>    
        </div>
        `)
    })


    $('.subobj_button').click(function(e) { //on add input button click
        e.preventDefault();
        $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">Select Service</label>    <select data-placeholder="Choose Service.." name="service[]" class="chosen-select" style="width:100%;" tabindex="2"> <option value="" selected="selected">choose Service..</option>       <?php $services = mysqli_query($con, "SELECT * FROM conferenceotherservices WHERE status='1'");
                                                                                                                                                                                                                                                                                                                                                                                                                                                    while ($row = mysqli_fetch_array($services)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                        $conferenceotherservice_id = $row['conferenceotherservice_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                        $service = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['service']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                        $charge = $row['charge'];               ?>           <option value="<?php echo $conferenceotherservice_id . '_' . $charge; ?>"><?php echo $service . ' (' . $charge . ')'; ?></option>  <?php } ?>     </select></div><div class="form-group col-lg-6"><label class="control-label">Quantity</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required="required"  step="0.0001">  </div> <div class="form-group col-lg-6"> <label class="control-label">Days to use</label>  <input type="number" class="form-control" name="service_days[]"> </div> </div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button>  </div>'); //add input box
        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            },
            '.chosen-select-width': {
                width: "95%"
            }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
    });
    $('.subobj3').on("click", ".remove_subobj2", function(e) { //user click on remove text
        e.preventDefault();
        $(this).closest('.row').remove();

    });

    $('.subobj').on("click", ".remove_subobj", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    var buffetIdx = 0;
    $('.buffet_button').click(function(e) { //on add input button click
        e.preventDefault();
        buffetIdx += 1;
        $('.buffetsec').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row">  <div class="form-group col-lg-4">  <label class="control-label">* Select Buffet</label> <select  class="form-control" name="buffets[' + buffetIdx + ']">         <?php $buffets = mysqli_query($con, "SELECT * FROM hallbuffets WHERE status='1'");
                                                                                                                                                                                                                                                                                                                                        while ($row = mysqli_fetch_array($buffets)) {
                                                                                                                                                                                                                                                                                                                                            $hallbuffet_id = $row['hallbuffet_id'];
                                                                                                                                                                                                                                                                                                                                            $buffet = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['buffet']);
                                                                                                                                                                                                                                                                                                                                            $price = $row['price'];             ?>        <option value="<?php echo $hallbuffet_id . '_' . $price; ?>"><?php echo $buffet; ?></option><?php } ?>   </select>    </div>  <div class="form-group col-lg-4"> <label class="control-label">* Days to serve</label><input type="number" class="form-control" name="buffet_days[]"></div><div class="form-group col-lg-4"><label class="control-label">* Quantity</label><input type="number" class="form-control" name="buffet_quantity[]" required></div> </div></div> <button class="remove_buffet  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box



        var config = {
            '.chosen-select': {},
            '.chosen-select-deselect': {
                allow_single_deselect: true
            },
            '.chosen-select-no-single': {
                disable_search_threshold: 10
            },
            '.chosen-select-no-results': {
                no_results_text: 'Oops, nothing found!'
            },
            '.chosen-select-width': {
                width: "95%"
            }
        }
        for (var selector in config) {
            $(selector).chosen(config[selector]);
        }
        var items = $('.items').length;
        $(".items").each(function(i) {
            $(this).attr('name', 'items[' + i + '][]');
        });
    });
    $('.buffetsec').on("click", ".remove_buffet", function(e) { //user click on remove text
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
</script>