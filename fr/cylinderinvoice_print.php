<?php 
include 'includes/conn.php';
   if(!isset($_SESSION['hotelsys'])){
header('Location:login');
}
$id=$_GET['id'];
?>
<!DOCTYPE html>
<html>

<head>
<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0;  /* this affects the margin in the printer settings */
}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gas Cylinder purchase Invoice  | Grace Land Hotel</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="white-bg">
                <div class="wrapper wrapper-content p-xl">
             <div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-2"><img src="assets/demo/graceland-logo.png" class="img img-responsive"></div>
                                <div class="col-sm-4">
                                                                       <address>
                                                                           <h3></h3>
                                        <strong>Graceland Hotel</strong><br>
                                        Mbela Misugwi<br>
                                        Mwanza, Tanzania<br>
                                        <strong>P : </strong> 0769657573 , 0767747515<br/>
                                        www.gracelandhotel.com<br/>
                                            
                                    </address>
                                 
                                </div>

                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $id*23; ?></h4>
                                    <strong>TIV:</strong>104591272</span>
                                    <address>
                                       
                                          <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                                <?php
$sale=mysqli_query($con,"SELECT * FROM cylindersales WHERE cylindersale_id='$id'");
$row=  mysqli_fetch_array($sale);
$cylindersale_id=$row['cylinder_id'];
  $cylinder_id=$row['cylinder_id'];
   $price=$row['price'];
   $timestamp=$row['timestamp'];
   $gettype=  mysqli_query($con, "SELECT * FROM cylinders WHERE cylinder_id='$cylinder_id'");
   $row2=  mysqli_fetch_array($gettype);
$cylinder_type=$row2['cylinder_type'];
 
 ?>
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                        <th>Gas Cylinder</th>
                                        <th>Quantity</th>
                                        <th>Unit Charge</th>
                                                                           
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                                    <?php echo $cylinder_type; ?>
                                                </strong></div>
                                            </td>
                                        <td> 1</td>
                                       
                                        <td><?php echo number_format($price);?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($price);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Buying your Cylinder at GraceLand Hotel <strong>
                            </div>
                        </div>

    </div>

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
