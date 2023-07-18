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
    <title>Add Gym and Pool Subscription - Hotel Manager</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php
    if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
        include 'fr/addpoolsubscription.php';
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
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                                <i class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li> <a href="switchlanguage?lan=fr">Francais</a> </li>
                            <li><a href="switchlanguage?lan=en">English</a> </li>
                        </ul>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Add New Gym and Pool Subscription</h2>
                        <ol class="breadcrumb">
                            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>
                            <li> <a href="poolsubscriptions">Subscriptions</a> </li>
                            <li class="active">
                                <strong>Add Subscription</strong>
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
                                    <h5>Add New Subscription <small>All fields marked (*) shouldn't be left blank</small></h5>
                                </div>
                                <div class="ibox-content">
                                    <?php
                        if (isset($_POST['package'], $_POST['startdate'])) {
                            $reserve_id = mysqli_real_escape_string($con, trim($_POST['reserve']));
                            if ((!empty($_POST['customername']))) {
                                $customername =$_POST['customername'];
                                $splitName = explode(' ', $customername);
                                $firstname = mysqli_real_escape_string($con, trim($splitName[0]));
                                $lastname = mysqli_real_escape_string($con, trim($splitName[1]));
                            } elseif (!empty($_POST['reserve'])) {
                                $poolsubscription_id = $_POST['reserve'];
                                $specificClient = mysqli_query($con, "SELECT * FROM poolsubscriptions 
                                 WHERE poolsubscription_id=$poolsubscription_id  ORDER BY firstname");
                                while ($row =  mysqli_fetch_array($specificClient)) {
                                    $firstname1 = $row['firstname'];
                                    $lastname1 = $row['lastname'];
                                    $firstname = mysqli_real_escape_string($con, trim($firstname1));
                                    $lastname = mysqli_real_escape_string($con, trim($lastname1));
                                    $phone = $row['phone'];
                                    $phone = mysqli_real_escape_string($con, trim($phone));
                                }
                            }
                            $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
                            $startdate = mysqli_real_escape_string($con, strtotime($_POST['startdate']));
                            $package = mysqli_real_escape_string($con, trim($_POST['package']));
                            $reduction = mysqli_real_escape_string($con, trim($_POST['reduction']));
                            if ((empty($startdate)) || (empty($package))) {
                                $errors[] = 'All Fields Marked * shouldnt be blank';
                            }
                            $split = explode('_', $package);
                            $package_id = $split[0];
                            $charge = $split[1];
                            if (!empty($errors)) {
                                foreach ($errors as $error) {
                                    ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                     <?php
                                }
                            } else {
                                mysqli_query($con, "INSERT INTO poolsubscriptions(reserve_id,firstname,lastname,phone,package,charge,startdate,reduction,timestamp,creator,status) 
                                VALUES('$reserve_id','$firstname','$lastname','$phone','$package_id','$charge','$startdate','$reduction',UNIX_TIMESTAMP(),'" . $_SESSION['emp_id'] . "','1')") or die(mysqli_error($con));
                                $last_id =  mysqli_insert_id($con);
                                ?>
                                <div class="alert alert-success"><i class="fa fa-check"></i>
                                Gym and Pool Subscription Successfully Added. 

                                View <a href="poolsubscriptionprint?id=<?php echo $last_id;?>" target="_blank">Card</a></div>
                                    <?php
                            }
                        }
        ?>
                                    <form method="post" name='form' class="form" action="" enctype="multipart/form-data">
                                        <div class="single-load">
                                             <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="linked" id="resident">
                                                            <label class="form-check-label" for="resident">
                                                                Is Resident ?
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="nonresidents">
                                                    <div class="form-group col-lg-6">
                                                            <label class="control-label">*Customer Name</label>
                                                            <input type="text" name='customername' class="form-control" placeholder="Enter Fullname">
                                                        </div>
                                                     <div class="form-group col-lg-6">
                                                <label class="control-label">Phone</label>
                                                <input type="text" name='phone' value="" class="form-control" placeholder="Enter phone number">
                                                    </div>
                                            </div>
                                                    <div class="form-group forresidents col-lg-6" style="display:none">
                                                        <label class="control-label">*Select Resident</label>
                                                            <select name="reserve" class="form-control">
                                                                <option value="0" selected="selected">Select Resident</option>
                                                                    <?php
                        $oldsubs = mysqli_query($con, "SELECT * FROM reservations WHERE status='1' ORDER BY firstname");
        while ($row =  mysqli_fetch_array($oldsubs)) {
            $firstname1 = $row['firstname'];
            $lastname1 = $row['lastname'];
            $phone = $row['phone'];
            $room_id = $row['room_id'];
            $poolsubscription_id= $row['reservation_id']
            ?>
                                                                <option value="<?php echo $poolsubscription_id; ?>">
                                                                <?php echo $firstname1 . ' ' . $lastname1;  ?></option>
                                                                <?php } ?>
                                                            </select>
                                                    </div>                                             
                                            <!--<div class="form-group col-lg-6">-->
                                            <!--    <label class="control-label">Phone</label>-->
                                            <!--    <input type="text" name='phone' value="" class="form-control" placeholder="Enter phone number">-->
                                            <!--</div>-->
                                            <div class="form-group col-lg-6">    
                                                <label class="control-label">* Select Package</label>
                                                <select class="form-control" name='package'>
                                                    <option value="" selected="selected">Select Package</option>
                                                    <?php
                $getpackages = mysqli_query($con, "SELECT * FROM poolpackages WHERE status='1'");
        while ($row = mysqli_fetch_array($getpackages)) {
            $poolpackage_id = $row['poolpackage_id'];
            $poolpackage = $row['poolpackage'];
            $charge = $row['charge'];
            $creator = $row['creator'];
            $status = $row['status'];
            ?>
                                                        <option value="<?php echo $poolpackage_id . '_' . $charge; ?>"><?php echo $poolpackage; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-6"><label class="control-label">Reduction</label>
                                                <input type="text" name='reduction' class="form-control" placeholder="Enter Reduction">
                                            </div>
                                            <div class="form-group col-lg-6"><label class="control-label">Start Date</label>
                                                <input type="date" name='startdate' class="form-control" placeholder="Enter Date">
                                            </div>                                            
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary" type="submit">Add Subscription</button>
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
    // function get_text(event){
    //     var string = event.textContent;
    //     document.getElementById('search_box')[0].value = string;
    //     document.getElementById('search_box').innerHTML= '';
    // }
    // function load_data(query){
    //     if(query.length>2){
    //         var form_data = new FormData();
    //         form_data.append('query',query);
    //         var ajax_request =  new XMLHttpRequest();
    //         ajax_request.open('POST', 'process_data.php');
    //         ajax_request.send(form_data);
    //         ajax_request.onreadystatechange =   function(){
    //             if(ajax_request.readyState == 4 && ajax_request.status == 200){
    //                 var response = JSON.parse(ajax_request.responseText);
    //                 var html = '<div class="list-group">';
    //                 if(response.length > 0){
    //                     for(var count = 0; count < response.length; count++){
    //                         html+='<a href="#" class="list-group-item list-group-item-action onclick="get_text(this)">'response[count].post_title+ '</a>'
    //                     }
    //                 }else{
    //                     html+='<a href="#" class="list-group-item list-group-item-action disabled"> No data found</a>'
    //                 }
    //                 html+='</div>';
    //                 document.getElementById('search_result').innerHTML = html;
    //             }
    //         }
    //     }else{
    //         document.getElementById('search_result').innerHTML = '';
    //     }
    // }
    $(document).ready(function() {
        $('#resident').click(function() {
            if ($(this).prop("checked") === true) {
                $('.forresidents').show();
                $('.nonresidents').hide();
            } else {
                $('.forresidents').hide();
                $('.nonresidents').show();
            }
        });
    });
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
    $('#data_5 .input-daterange').datepicker({
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true
    });
    //Javascript for subscribed customers
    $(document).ready(function() {
        $('#form').on('click', '#resident', function() {
            var $load = $(this).closest('.single-load');
            if ($(this).prop("checked") === true) {
                $load.find('.forresidents').show();
                $load.find('.nonresidents').hide();
            } else {
                $load.find('.forresidents').hide();
                $load.find('.nonresidents').show();
            }
        });

        $('#form').on('click', '.rmload', function() {
            var $load = $(this).closest('.single-load');
            $load.remove();
        })
    });
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
    $('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    $('#addloadbtn').on('click', function() {
        var loadhtml = `
        
        <div class="single-load">
        <hr style="border-color: #5d5d5d;" />
        <div class="pull-right">
            <button class="btn btn-danger rmload">x</button>
        </div>
        
        <div class="form-group"><label class="control-label">* Number of Clothes</label>
            <input type="number" name='clothes[]' class="form-control" placeholder="Enter number of clothes" required="required" min="1">
        </div>
        <div class="form-group"><label class="control-label">* Charge</label>
            <select name="package[]" class="form-control">
                <option value="" selected="selected"> Select ...</option>
                <?php
                $getpackages = mysqli_query($con, "SELECT * FROM laundrypackages WHERE status='1'");
while ($row = mysqli_fetch_array($getpackages)) {
    $laundrypackage_id = $row['laundrypackage_id'];
    $laundrypackage = $row['laundrypackage'];
    $charge = $row['charge'];
    ?>
                    <option value="<?php echo $laundrypackage_id . '_' . $charge; ?>"> <?php echo $laundrypackage . ' (' . $charge . ')'; ?></option>
                <?php } ?>
            </select>

        </div>
        </div>
        `;

        $('#other-loads').append(loadhtml);
    })
</script>