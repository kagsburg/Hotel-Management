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
                <div class="col-lg-8">
                    <h2>Invoice</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index">Home</a>
                        </li>
                        <li>
                            <a href="laundrywork">Laundry</a>
                        </li>
                        <li class="active">
                            <strong>Invoice</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-4">
                    <div class="title-action">
<!--                        <a href="#" class="btn btn-white"><i class="fa fa-pencil"></i> Edit </a>
                        <a href="#" class="btn btn-white"><i class="fa fa-check "></i> Save </a>-->
                        <a href="laundryinvoice_print?id=<?php echo $id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>Print Invoice </a>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInRight">
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
                                            <span><strong>TIV:</strong>104591272</span>
                                    </address>
                                 
                                </div>
<?php
$laundry=mysqli_query($con,"SELECT * FROM laundry WHERE status='1' AND laundry_id='$id'");
         $row=  mysqli_fetch_array($laundry);
           $laundry_id=$row['laundry_id'];
           $reserve_id=$row['reserve_id'];
           $clothes=$row['clothes'];
           $charge=$row['charge'];
           $timestamp=$row['timestamp'];
           $status=$row['status'];
           $creator=$row['creator'];
            $invoice_no=23*$id;
           $reservation=mysqli_query($con,"SELECT * FROM reservations WHERE reservation_id='$reserve_id'");
           $row2=  mysqli_fetch_array($reservation);
 $firstname=$row2['firstname'];
$lastname=$row2['lastname'];
$room_id=$row2['room'];
$phone=$row2['phone'];
$country=$row2['country'];
              ?>
                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <h4 class="text-navy"><?php echo $invoice_no; ?></h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $firstname.' '.$lastname; ?></strong><br>
                                         <strong>P:</strong> <?php echo $phone; ?><br/>
                                         <strong>Country:</strong><?php echo $country; ?><br/>
                                          <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y',$timenow); ?></span><br/>
                                    </address>
                                     
                                       
                                 
                                </div>
                                
                            </div>

                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
                                    <tr>
                                           <th>Item Type</th>
                                        <th>Number of Clothes</th>
                                        <th>Date</th>
                                        <th>Charge</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><div><strong>
                                                   Laundry Work
                                                </strong></div>
                                            </td>
                                                                              <td><?php  echo $clothes;  ?></td>
                                                                              <td><?php echo date('d/m/Y',$timestamp); ?></td>
                                        <td><?php echo number_format($charge);?></td>
                                    </tr>
                                    

                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                            <table class="table invoice-total">
                                <tbody>
                                                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php echo number_format($charge);?></strong></td>
                                </tr>
                                </tbody>
                            </table>
                            
                            <div class="well m-t">
                                <strong style="font-style: italic">Thanks for Visiting our Hotel <strong>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        </div>
    </div>
