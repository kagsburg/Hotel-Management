
    <div id="wrapper">

        <?php include 'nav.php'; ?>
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
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
                <div class="col-lg-9">
                    <h2>Dashboard</h2>
                 <ol class="breadcrumb">
                         <li>              <a href=""><i class="fa fa-home"></i>Cost Stats</a></li>
                        
                    </ol>
                </div>
                           </div>
            <div class="wrapper wrapper-content animated fadeInRight">
           
                <div class="row">
                 <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Costs Report</h5>
                  
                    </div>
                    <div class="ibox-content">
                       
                     <div class="panel blank-panel">

                        <div class="panel-heading">
                                                     <div class="panel-options">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#tab-1">Costs Incurred in Past 7 days</a></li>
                                    <li class=""><a data-toggle="tab" href="#tab-2">Costs Incurred in Past 30 days</a></li>
                                                                                                    </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div id="tab-1" class="tab-pane active">
      <?php 
                            $costs= mysqli_query($con,"SELECT * FROM costs WHERE round(($timenow-date)/(3600*24))<=7") or die(mysqli_errno($con));
                            if(mysqli_num_rows($costs)>0){
                            ?>
                             <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                     
                    <tr>
                        <th>Item</th>
                        <th>Cost</th>
                        <th>Date</th>
                            
                    </tr>
                                                 
                    </thead>
                    <tbody>
                     <?php
                while ($row = mysqli_fetch_array($costs)) {
                         $cost_id=$row['cost_id'];                              
                         $cost_item=$row['cost_item'];                              
                         $amount=$row['amount'];                              
                         $date=$row['date'];                              
                         $creator=$row['creator'];                              
                                                    
                        ?>
                    <tr class="gradeA">
                        <td><?php echo $cost_item; ?></td>
                        <td><?php echo $amount;?> </td>
                        <td><?php echo date('d/m/Y',$date);?> </td>
                   
                                             
                    </tr>   <?php } ?>
                    </tbody>
                             </table>
                            <?php }else{ ?>
                            <div class="alert alert-danger">No Costs Incurred on Items yet</div>
                            <?php }?>
                                </div>

                                <div id="tab-2" class="tab-pane">
                                  <?php 
                            $costs= mysqli_query($con,"SELECT * FROM costs WHERE round(($timenow-date)/(3600*24))<=30") or die(mysqli_errno($con));
                            if(mysqli_num_rows($costs)>0){
                            ?>
                             <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                     
                    <tr>
                        <th>Item</th>
                        <th>Cost</th>
                        <th>Date</th>
                            
                    </tr>
                                                 
                    </thead>
                    <tbody>
                     <?php
                while ($row = mysqli_fetch_array($costs)) {
                         $cost_id=$row['cost_id'];                              
                         $cost_item=$row['cost_item'];                              
                         $amount=$row['amount'];                              
                         $date=$row['date'];                              
                         $creator=$row['creator'];                              
                                                    
                        ?>
                    <tr class="gradeA">
                        <td><?php echo $cost_item; ?></td>
                        <td><?php echo $amount;?> </td>
                        <td><?php echo date('d/m/Y',$date);?> </td>
                   
                                             
                    </tr>   <?php } ?>
                    </tbody>
                             </table>
                            <?php }else{ ?>
                            <div class="alert alert-danger">No Costs Incurred on Items yet</div>
                            <?php }?>
                                </div>
                                                             
                            </div>

                        </div>

                    </div>
                    </div>
                </div>
            </div>

                                   </div>
                   </div>
    </div>
