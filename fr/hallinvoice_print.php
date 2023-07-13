                <div class="wrapper wrapper-content p-xl">
                    <div class="ibox-content p-xl">
                        <div class="row">
                            <div class="col-xs-2"><img src="assets/demo/pearllogo.png" class="img img-responsive"></div>
                            <div class="col-xs-4">

                            </div>
                            <?php
                            $reservation = mysqli_query($con, "SELECT * FROM hallreservations WHERE  hallreservation_id='$id'");
                            $row =  mysqli_fetch_array($reservation);
                            $hallreservation_id = $row['hallreservation_id'];
                            $fullname = $row['fullname'];
                            $checkin = $row['checkin'];
                            $phone = $row['phone'];
                            $checkout = $row['checkout'];
                            $status = $row['status'];
                            $purpose = $row['purpose'];
                            $people = $row['people'];
                            $country = $row['country'];
                            $creator = $row['creator'];

                            $invoice_no = 23 * $id;
                            $days = ($checkout - $checkin) / (3600 * 24) + 1;
                            $purposes = mysqli_query($con, "SELECT * FROM hallpurposes WHERE hallpurpose_id='$purpose'");
                            $row3 = mysqli_fetch_array($purposes);
                            $hallpurpose_id = $row3['hallpurpose_id'];
                            $hallpurpose = $row3['hallpurpose'];
                            $charge = $row3['charge'];
                            ?>
                            <div class="col-sm-6 text-right">
                                <h4>Invoice No.</h4>
                                <h4 class="text-navy"><?php echo $invoice_no; ?></h4>
                                <span>To:</span>
                                <address>
                                    <strong><?php echo $fullname; ?></strong><br>
                                    <strong>P:</strong> <?php echo $phone; ?><br />
                                    <strong>Country:</strong><?php echo $country; ?><br />
                                    <span><strong>Invoice Date:</strong> <?php echo date('d/m/Y', $timenow); ?></span><br />
                                </address>

                            </div>

                        </div>

                        <div class="table-responsive m-t">
                            <table class="table invoice-table">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Check in</th>
                                        <th>Days</th>
                                        <th>Purpose</th>
                                        <th>People</th>
                                        <th>Unit Charge</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div><strong>
                                                    Hall Reservation
                                                </strong></div>
                                        </td>
                                        <td><?php echo date('d/M', $checkin); ?></td>
                                        <td><?php echo $days;  ?></td>
                                        <td><?php echo $purpose;  ?></td>
                                        <td><?php echo $people;  ?></td>
                                        <td><?php echo number_format($charge); ?></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div><!-- /table-responsive -->

                        <table class="table invoice-total">
                            <tbody>
                                <tr>
                                    <td><strong>TOTAL :</strong></td>
                                    <td><strong><?php
                                                $totalcharge = $charge * $days;
                                                echo number_format($totalcharge); ?></strong></td>
                                </tr>

                                <tr>
                                    <td><strong>PAID :</strong></td>
                                    <td><strong><?php
                                                $hallincome = mysqli_query($con, "SELECT COALESCE(SUM(amount), 0) AS totalhallincome FROM hallpayments WHERE hallbooking_id='$id'");
                                                $row =  mysqli_fetch_array($hallincome);
                                                $totalhallincome = $row['totalhallincome'];
                                                echo number_format($totalhallincome); ?></strong></td>
                                </tr>
                                <tr>
                                    <td><strong>BALANCE :</strong></td>
                                    <td><strong><?php echo number_format($totalcharge - $totalhallincome); ?></strong></td>
                                </tr>

                            </tbody>
                        </table>

                        <div class="well m-t">
                            <strong style="font-style: italic">Thanks for Visiting Our Hotel <strong>
                        </div>
                    </div>

                </div>