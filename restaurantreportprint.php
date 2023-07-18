<?php
include 'includes/conn.php';
if (!isset($_SESSION['hotelsys'])) {
  header('Location:login');
}
$st = $_GET['st'];
$en = $_GET['en'];
$cat = $_GET['cat'];
?>
<!DOCTYPE html>
<html>

<head>
  <style type="text/css" media="print">
    @page {
      size: auto;
      /* auto is the initial value */
      margin: 0;
      /* this affects the margin in the printer settings */
    }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Bar & Restaurant Report | Hotel Manager</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
  <?php
  if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
    include 'fr/restaurantreportprint.php';
  } else {
  ?>
    <div class="wrapper wrapper-content p-xl">
      <div class="ibox-content p-xl">
        <div class="row">
          <div class="col-xs-2"><img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive"></div>
        </div>
        <h1 class="text-center">Restaurant Report between <?php echo date('d/m/Y H:i', $st); ?> and <?php echo date('d/m/Y H:i', $en); ?></h1>


        <div class="table-responsive m-t">
          <?php
          $totalbill = 0;

          ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ITEM</th>
                <th>QUANTITY</th>
                <th>PRICE</th>
                <!-- <th>TVA</th> -->
                <th>TOTAL</th>

              </tr>
            </thead>
            <tbody>
              <?php
              $totalitems = 0;
              $totalcharge = 0;
              $totalvat = 0;
              $totalnet = 0;




              $ordereditems =  mysqli_query($con, "SELECT food_id FROM restaurantorders  GROUP BY food_id");
              while ($row3 =  mysqli_fetch_array($ordereditems)) {
                $food_id = $row3['food_id'];
                $getquery = "SELECT * FROM menuitems WHERE menuitem_id='$food_id'";
                if ($cat != 'all') {
                  $getquery .= "AND menucategory='$cat'";
                }
                $getfoodmenu = mysqli_query($con, $getquery) or die(mysqli_error($con));
                if (mysqli_num_rows($getfoodmenu) > 0) {
                  $rowf =  mysqli_fetch_array($getfoodmenu);
                  $menuitem = $rowf['menuitem'];

                  $items = 0;
                  $totaltax = 0;
                  $total = 0;
                  $net = 0;

                  $restorders = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND timestamp>='$st' AND timestamp<='$en' ");
                  if (mysqli_num_rows($restorders) > 0) {
                    while ($row =  mysqli_fetch_array($restorders)) {
                      $order_id = $row['order_id'];
                      $guest = $row['guest'];
                      $rtable = $row['rtable'];
                      $vat = $row['vat'];
                      $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE food_id='$food_id'  AND order_id='$order_id'");
                      if (mysqli_num_rows($foodsordered) > 0) {
                        $row3 =  mysqli_fetch_array($foodsordered);
                        $price = $row3['foodprice'];
                        $quantity = $row3['quantity'];
                        $tax = $row3['tax'];
                        if ($tax == 1) {
                          $puhtva = round($price / (($vat / 100) + 1));
                          $tva = $price - $puhtva;
                        } else {
                          $tva = 0;
                          $puhtva = $price;
                        }
                        $pthtva = $puhtva * $quantity;
                        $total += $price;
                        $vatamount = $tva * $quantity;
                        $totaltax = $totaltax + $vatamount;
                        $items = $items + $quantity;
                        // $net += $pthtva;
                      }
                    }
                  }
                  if ($items > 0) {
              ?>
                    <tr class="gradeA">
                      <td> <?php echo $menuitem; ?></td>
                      <td><?php echo $items; ?></td>
                      <td><?php echo number_format($price); ?></td>
                      <!-- <td><?php echo number_format($totaltax); ?></td> -->
                      <td><?php echo number_format($price * $items); ?></td>
                    </tr>

              <?php
                    $net += $price * $items;
                    $totalitems = $totalitems + $items;
                    $totalcharge = $totalcharge + $total;
                    $totalvat = $totalvat + $totaltax;
                    $totalnet = $totalnet + $net;
                  }
                }
              }
              ?>
            </tbody>
            <tr class="gradeA">
              <th>TOTAL</th>
              <th><?php echo number_format($totalitems); ?></th>
              <th><?php echo number_format($totalcharge); ?></th>
              <!-- <th><?php echo number_format($totalvat); ?></th> -->
              <th><?php echo number_format($totalnet); ?></th>
            </tr>

          </table>

        </div><!-- /table-responsive -->


        <div class="d-flex">
          <div class="ml-auto">
            <p class="fs-16" style="margin-bottom: 40px;">
              Created By:
              <?php
              $empid = $_SESSION['emp_id'];
              $employee =  mysqli_query($con, "SELECT * FROM employees WHERE employee_id='$empid'");
              $row = mysqli_fetch_array($employee);
              // $employee_id = $row['employee_id'];
              $fullname = $row['fullname'] ?? "";
              echo $fullname;
              ?>
            </p>
            <p class="fs-12">
              <?php echo date('d/m/Y'); ?>
            </p>
          </div>
        </div>
      </div><!-- /table-responsive -->

    </div>

    </div>
  <?php } ?>
  <!-- Mainly scripts -->
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

  <!-- Custom and plugin javascript -->
  <script src="js/inspinia.js"></script>

  <script type="text/javascript">
    window.print();
  </script>

</body>

</html>