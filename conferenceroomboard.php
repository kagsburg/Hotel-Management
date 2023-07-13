<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
   header('Location:login.php');
}


$mnth = $_GET["month"] ?? date("m-Y");
$datetime = DateTimeImmutable::createFromFormat('m-Y', $mnth);
$month = $datetime->format('F Y');
$days = $datetime->format('t');
$start = strtotime("1 $month");
$end = strtotime("1 $month +1 month");

$months = [
   'January',
   'February',
   'March',
   'April',
   'May',
   'June',
   'July ',
   'August',
   'September',
   'October',
   'November',
   'December',
];

function status_color($reservation)
{
   if ($reservation["status"] == 0)
      return "tdpending";
   if ($reservation["status"] == 1)
      return "tdoccupied";
   else return "tdattention";
}
?>
<html>

<head>

   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>Conference Rooms Planning Board | Hotel Manager</title>
   <script src="ckeditor/ckeditor.js"></script>
   <script language="JavaScript" src="../js/gen_validatorv4.js" type="text/javascript"></script>
   <link rel="stylesheet" href="ckeditor/samples/sample.css">
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
   <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
   <link href="css/animate.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">
   <style>
      .tdpending {
         background-color: grey !important;
      }

      .tdoccupied {
         background-color: green !important;
      }

      .tdattention {
         background-color: orange !important;
      }

      table {
         background-color: #fff;
      }

      .mx-5 {
         margin-left: 15px;
         margin-right: 15px;
      }

      .resbar {
         padding-top: 3px;
         padding-bottom: 4px;
      }

      .resbar a {
         color: #fff;
         display: block;
         text-align: center;
      }
   </style>
</head>

<body>
   <?php
   if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
      include 'fr/addroom.php';
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
                  <h2>Conference Rooms Board</h2>
                  <ol class="breadcrumb">
                     <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

                     <li class="active">
                        <strong>Conference Rooms Board</strong>
                     </li>
                  </ol>
               </div>
               <div class="col-lg-2">

               </div>
            </div>
            <div class="wrapper wrapper-content">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="ibox float-e-margins">
                        <div class="ibox-title">
                           <h2>
                              <a href="?month=<?php echo $datetime->modify("-1 month")->format("m-Y"); ?>"><i class="fa fa-chevron-left"></i></a>
                              <a href="#" data-toggle="modal" data-target="#chooseMonthModal" class="mx-5"><?php echo $month; ?></a>
                              <a href="?month=<?php echo $datetime->modify("+1 month")->format("m-Y"); ?>"><i class="fa fa-chevron-right"></i></a>
                           </h2>
                        </div>
                        <div class="ibox-content">
                           <div class="table-responsive">
                              <table class="table table-bordered table-striped">
                                 <thead>
                                    <tr>

                                       <th rowspan="2">Hall</th>
                                       <th colspan="<?php echo $days; ?>">Calendar</th>
                                    </tr>
                                    <tr>
                                       <?php

                                       for ($i = 1; $i <= $days; $i++) : ?>
                                          <th><?php echo $i; ?></th>
                                       <?php endfor; ?>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                    $getrooms = mysqli_query($con, "SELECT * FROM conferencerooms WHERE status='1'");
                                    while ($row =  mysqli_fetch_array($getrooms)) {
                                       $roomnumber = $row['room'];
                                       $room_id = $row['conferenceroom_id'];

                                       $rows = [[]];
                                       $dayreservation = null;
                                       $dday = strtotime("1 $month");
                                       $getresertions = mysqli_query($con, "SELECT * FROM hallreservations WHERE room_id='$room_id' AND ((checkin >= '$start' AND checkin < '$end') OR (checkout >= '$start' AND checkout < '$end'))");
                                       while ($reservation = mysqli_fetch_array($getresertions)) {
                                          $arrival = $reservation["checkin"];
                                          $arrival = $arrival < $dday ? $dday : $arrival;
                                          $departure = $reservation["checkout"];
                                          $firstname = $reservation["fullname"];
                                          $length = DateTime::createFromFormat('U', $arrival)->diff(DateTime::createFromFormat('U', $departure));

                                          $event = [
                                             "start" => $arrival,
                                             "end" => $departure,
                                             "length" => $length->days + 1,
                                             "name" => $firstname,
                                             "reservation" => $reservation,
                                          ];
                                          $collision = false;
                                          foreach ($rows as $key => $row) {
                                             $collision = false;
                                             foreach ($row as $ev) {
                                                if ($ev["start"] <= $event["end"] && $ev["end"] >= $event["start"])
                                                   $collision = true;
                                                break;
                                             }
                                             if (!$collision)
                                                $rows[$key][$arrival] = $event;
                                          }
                                          if ($collision)
                                             $rows[] = [$arrival => $event];
                                       }
                                    ?>
                                       <?php foreach ($rows as $rowidx => $row) : ?>
                                          <tr>
                                             <?php if ($rowidx === 0) { ?>
                                                <td rowspan="<?php echo count($rows); ?>" class="pd"><?php echo $roomnumber; ?></td>
                                             <?php }

                                             for ($i = 1; $i <= $days; $i++) {
                                                $dday = strtotime("$i $month");
                                                if (isset($row[$dday])) {
                                                   $ev = $row[$dday];
                                                   $rs = $ev["reservation"];
                                                   $cols = ($ev["length"] + ($i - 1) > $days)
                                                      ? $days - $ev["length"] + $i
                                                      : $ev["length"];
                                                   $i += $ev["length"] - 1;

                                                ?>
                                                   <td colspan="<?php echo $cols; ?>">
                                                      <div class="resbar <?php echo status_color($ev["reservation"]); ?>">
                                                         <a href="halldetails?id=<?php echo $rs["hallreservation_id"] ?>"><?php echo $ev["name"]; ?></a>
                                                      </div>
                                                   </td>
                                                <?php
                                                } else {


                                                ?>
                                                   <td></td>
                                             <?php }
                                             } ?>
                                          </tr>


                                       <?php endforeach; ?>
                                       <tr>
                                          <td colspan="<?php echo $days + 1; ?>">
                                             <div class="table-spacer"></div>
                                          </td>
                                       </tr>
                                    <?php } ?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            <div class="modal fade" id="chooseMonthModal" tabindex="-1" role="dialog" aria-labelledby="chooseMonthModalLabel" aria-hidden="true">
               <div class="modal-dialog modal-sm" role="document">
                  <div class="modal-content">
                     <form id="mnthform" class="form-horizontal">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                           <h4 class="modal-title" id="chooseMonthModalLabel">Select Month</h4>
                        </div>
                        <div class="modal-body">
                           <div class="form-group">
                              <div class="control-label col-md-3">Year</div>
                              <div class="col-md-9">
                                 <input type="text" id="syear" class="form-control" value="<?php echo $datetime->format("Y") ?>">
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="control-label col-md-3">Month</div>
                              <div class="col-md-9">
                                 <select id="smonth" class="form-control">
                                    <?php foreach ($months as $idx => $m) : ?>
                                       <option value="<?php echo $idx + 1; ?>" <?php if ($datetime->format("F") == $m) echo "selected"; ?>><?php echo $m; ?></option>
                                    <?php endforeach; ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                           <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                     </form>
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
   <script src="js/plugins/chosen/chosen.jquery.js"></script>
   <!-- Custom and plugin javascript -->
   <script src="js/inspinia.js"></script>
   <script src="js/plugins/pace/pace.min.js"></script>

   <!-- iCheck -->
   <script src="js/plugins/iCheck/icheck.min.js"></script>
   <script>
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

      $(function() {
         $("#mnthform").on("submit", function(e) {
            e.preventDefault();
            var syear = $("#syear").val();
            var smonth = $("#smonth").val();
            var url = new URL(window.location);

            var digitMonth = `0${smonth}`.slice(-2);
            url.searchParams.set("month", `${digitMonth}-${syear}`);

            // console.log(url)
            window.location = url.toString()
         })
      })
   </script>
</body>

</html>