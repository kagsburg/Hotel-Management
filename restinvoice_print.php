<?php
include 'includes/conn.php';
if (($_SESSION['hotelsyslevel'] != 1) && ($_SESSION['sysrole'] != 'Restaurant Attendant') && ($_SESSION['sysrole'] != 'Accountant'&& $_SESSION['sysrole'] != 'Marketing and Events' && $_SESSION['sysrole'] != 'Kitchen Exploitation Officer')) {
  header('Location:login.php');
}
$order_id = $_GET['id'];
$restorder = mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2) AND order_id='$order_id'");
$row =  mysqli_fetch_array($restorder);
$order_id = $row['order_id'];
$guest = $row['guest'];
$rtable = $row['rtable'];
$vat = $row['vat'];
$waiter = $row['waiter'];
$mode = $row['mode'];
$customer = $row['customer'];
$creator = $row['creator'];
$timestamp = $row['timestamp'];
$getyear = date('Y', $timestamp);
$count = 1;
$beforeorders =  mysqli_query($con, "SELECT * FROM orders WHERE status IN (1,2)  AND  order_id<'$order_id'") or die(mysqli_error($con));
while ($rowb = mysqli_fetch_array($beforeorders)) {
  $timestamp2 = $rowb['timestamp'];
  $getyear2 = date('Y', $timestamp2);
  if ($getyear == $getyear2) {
    $count = $count + 1;
  }
}
if (strlen($count) == 1) {
  $invoice_no = '000' . $count;
}
if (strlen($count) == 2) {
  $invoice_no = '00' . $count;
}
if (strlen($count) == 3) {
  $invoice_no = '0' . $count;
}
if (strlen($count) >= 4) {
  $invoice_no = $count;
}

?>
<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Restaurant Order Invoice</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="css/animate.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <style type="text/css" media="print">
    html,
    div,
    body,
    td,
    tr,
    table {
      overflow-x: hidden !important;
    }

    @page {
      size: auto;
      /* auto is the initial value */
      margin: 0;
      /* this affects the margin in the printer settings */
      font-size: 20px;
      font-family: times new roman;
    }

    @media print {

      .invoice-table thead>tr>th:last-child,
      .invoice-table thead>tr>th:nth-child(4),
      .invoice-table thead>tr>th:nth-child(3),
      .invoice-table thead>tr>th:nth-child(2) {
        text-align: left;
      }

      .invoice-table tbody>tr>td:last-child,
      .invoice-table tbody>tr>td:nth-child(4),
      .invoice-table tbody>tr>td:nth-child(3),
      .invoice-table tbody>tr>td:nth-child(2) {
        text-align: left;
      }

      .invoice-total>tbody>tr>td:last-child {
        width: 30%;
        text-align: left;
      }

      .invoice-table tbody>tr>td:first-child {
        width: 80px;
      }

      .invoice-table tbody>tr>td:first-child span {
        word-break: break-all;
      }
    }

    #sizer {
      width: 300px;
    }
  </style>
</head>

<body class="white-bg" style="font-family: times new roman">
  <?php
  if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {
    include 'fr/restinvoice_print.php';
  } else {
  ?>
    <div class="wrapper wrapper-content p-xl" style="padding:0px;max-width:300px;margin: 0px auto">
      <div class="col-sm-12" style="padding:0px;">

        <div class="row" style="margin-left: 0;">

          <div class="col-sm-12" style="font-size:20px;font-family: times new roman">
                                        <img src="img/sitelogo.<?php echo $logo; ?>" class="img img-responsive" width="200">
                                        <div class="w-100">
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>Chato Beach Resort</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>TIN: 136073761</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>P.O Box 54 Chato, Geita</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                                <span>Tel: +255758301785</span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                            </div>
                                            <div class="d-flex" style="justify-content: space-between;">
                                                <span></span>
                                            </div>
                                        </div>
            <h4 class="text-navy"># <?php echo $invoice_no; ?></h4>
            <?php
            if ($customer == 1) { ?>
              <span>
                <strong>
                  Guest Information <br>
                  Full Names:
                </strong>
                <?php
                $reservation = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id='$guest'");
                $row =  mysqli_fetch_array($reservation);
                $firstname1 = $row['firstname'];
                $lastname1 = $row['lastname'];
                $room = $row['room'];
                $getnumber = mysqli_query($con, "SELECT * FROM rooms  WHERE room_id='$room'");
                $row1 =  mysqli_fetch_array($getnumber);
                $roomnumber = $row1['roomnumber'];
                echo $firstname1 . ' ' . $lastname1;

                ?>
              </span><br />
              <!-- <span><strong>NIF:</strong></span><br>
              <span><strong>Salle:</strong> <?php echo $roomnumber; ?></span><br>
              <span><strong>Assujetti à la TVA:</strong> Oui Non</span><br>
              <span><strong>Doit pour ce qui suit:</strong></span><br> -->
            <?php }
            if ($customer == 2) { ?>
              <span><strong>Customer Name:</strong> <?php
                                                    $customers = mysqli_query($con, "SELECT * FROM customers WHERE status='1' AND customer_id='$guest'") or die(mysqli_errno($con));
                                                    $row = mysqli_fetch_array($customers);

                                                    $customername = $row['customername'];
                                                    echo $customername;


                                                    ?></span><br />
            <?php } ?>

            <address>
              <span><strong>Order Date:</strong> <?php echo date('d/m/Y', $timestamp); ?></span><br />
              <span><strong>Table:</strong> <?php echo $rtable; ?></span><br />
              <span><strong>Waiter:</strong> <?php echo $waiter; ?></span><br />

              <?php
              if (!empty($mode)) {
              ?>

                <span><strong>Payment:</strong> <?php echo $mode; ?></span><br />

              <?php }
              $checkcredit = mysqli_query($con, "SELECT * FROM creditpayments WHERE order_id='$order_id'") or die(mysqli_error($con));
              if (mysqli_num_rows($checkcredit) > 0) {
                $rowc = mysqli_fetch_array($checkcredit);
                $cstatus = $rowc['status'];
                $fullname = $rowc['fullname'];
                $phone = $rowc['phone'];
              ?>
                <span><strong>Customer : </strong> <?php echo $fullname; ?></span><br />
                <span><strong>Phone : </strong> <?php echo $phone; ?></span>
              <?php }
              ?>
            </address>


          </div>

          <div class="col-sm-6 text-right">


          </div>

        </div>

        <div class="table-responsive m-t">

          <table class="table invoice-table" style="width:100%;font-size:10px;font-family:times new roman">
            <thead>
              <tr>
                <th>ITEM</th>
                <th>QTY</th>
                <th>Unit Price</th>
                <th>Sub Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $totaltax = 0;
              $total = 0;
              $foodsordered =  mysqli_query($con, "SELECT * FROM restaurantorders WHERE order_id='$order_id'");
              while ($row3 =  mysqli_fetch_array($foodsordered)) {
                $restorder_id = $row3['restorder_id'];
                $food_id = $row3['food_id'];
                $price = $row3['foodprice'];
                $quantity = $row3['quantity'];
                $tax = $row3['tax'];
                if ($tax == 1) {
                  $puhtva = round($price / (($vat / 110) + 1));
                  $tva = $price - $puhtva;
                } else {
                  $tva = 0;
                  $puhtva = $price;
                }
                $pthtva = $puhtva * $quantity;
                $total = ($total + $pthtva);
                $vatamount = $tva * $quantity;
                $totaltax = ($total * 0.18);
              ?>
                <tr>
                  <td>
                    <div style="width:80px;float:left;word-break:break-all;white-space: normal;"><span>
                        <?php
                        $foodmenu = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$food_id'");
                        $row =  mysqli_fetch_array($foodmenu);
                        $menuitem_id = $row['menuitem_id'];
                        $menuitem = $row['menuitem'];
                        echo $menuitem;
                        ?></span>
                    </div>
                  </td>
                  <td> <?php echo $quantity; ?></td>
                  <td><?php echo $puhtva; ?></td>

                  <td><?php echo $pthtva; ?></td>
                </tr>
              <?php } ?>

            </tbody>
          </table>
        </div><!-- /table-responsive -->

        <table class="table invoice-total">
          <tbody>
            <tr>
              <td><strong>TOTAL :</strong></td>
              <td><strong><?php echo number_format($total); ?></strong></td>
            </tr>
            <tr>
              <td><strong>VAT :</strong></td>
              <td><strong><?php echo number_format($totaltax); ?></strong></td>
            </tr>
            <tr>

              <td><strong>NET :</strong></td>
              <td><strong><?php echo number_format( $total); ?></strong></td>
            </tr>
          </tbody>
        </table>

        <strong style="font-style: italic;font-size:12px; text-align: center; display: block;">Thanks for Spending Time at our Restaurant</strong>

        <div class="d-flex m-t">
          <div class="ml-auto">
            <p class="fs-12">
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
          </div>
        </div>
      </div>
      <div class="big-footer">
                <div class="footer-text__block text-center">
                    <span>Chato, Geita Tanzania• Tel (255) 0758301785 • VAT NO: 400297540</span> <br>
                    <span>Email: info@chatobeachresort.com• Website: www.chatobeachresort.com</span>
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

  <script type="text/javascript">
    $(function() {
      setTimeout(() => {
        window.print();
      }, 800)
    })
  </script>

</body>

</html>