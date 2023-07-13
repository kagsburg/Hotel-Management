<?php 
include 'includes/conn.php';
if(($_SESSION['hotelsyslevel']!=1)&&($_SESSION['sysrole']!="Restaurant Attendant")){
header('Location:login');
}
?>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>Get  Restaurant Report- Hotel Manager</title>
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
     if((isset($_SESSION['lan']))&&($_SESSION['lan']=='fr')){ 
                                           include 'fr/getrestorders.php';                     
                                       }else{
          ?>          
    <div id="wrapper">

        <?php include 'nav.php'; ?>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          
        </div>
            <ul class="nav navbar-top-links navbar-right">
               
                <li>
                    <a href="logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Get Restaurant Order Report</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                                          <li class="active">
                            <strong>Generate Report</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Generate  Report <small>All  fields marked (*) shouldn't be left blank</small></h5>
                           
                        </div>
                        <div class="ibox-content">                           
                            <form method="GET" name='form' class="form-horizontal" action="foodsalesprint.php">
                                                                                                              <div class="form-group" id="data_5">
                               <label class="col-sm-2 control-label">* Select Date Range</label>
                              <div class="col-sm-10">   <div class="input-daterange input-group" id="datepicker">
                                      <input type="text" class="input-sm form-control" name="start" placeholder="start date" required="required"/>
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" name=end placeholder="end date" required="required"/>
                                </div>
                                </div>
                            </div>                                                                      
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-info btn-sm" type="submit">Proceed</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>


    </div>
                                       <?php }?>
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
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
            }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
 $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
            });
 
    
</script>