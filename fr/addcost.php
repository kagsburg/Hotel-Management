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
                    <h2>Ajouteles depenses d'hôtel</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                        <li>
                            <a href="costs">Dépenses</a>
                        </li>
                        <li class="active">
                            <strong>Ajouter une dépense</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Ajouteles depenses d'hôtel<small>Tapez Assurez-vous de 
                                remplir tous les champs nécessaires</small></h5>
                                                </div>
                        <div class="ibox-content">
                                               <?php
                            include_once 'includes/thumbs3.php';
       if (isset($_POST['item'],$_POST['amount'],$_POST['date'])) {
           if ((empty($_POST['item']))||(empty($_POST['amount']))||(empty($_POST['date']))) {
               echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Fill All Fields To Proceed</div>';
           } else {
               $item=  mysqli_real_escape_string($con, trim($_POST['item']));
               $amount=  mysqli_real_escape_string($con, trim($_POST['amount']));
               $date=  mysqli_real_escape_string($con, strtotime($_POST['date']));
               mysqli_query($con, "INSERT INTO costs(cost_item,amount,date,creator,status)
               VALUES('$item','$amount','$date','".$_SESSION['emp_id']."','1')") or die(mysqli_errno($con));
               echo '<div class="alert alert-success"><i class="fa fa-check"></i>Expense successfully added</div>';
           }
       }



       ?>
  <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Article</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name='item' placeholder="Article" required='required'></div>
                                </div>
        <div class="form-group"><label class="col-sm-2 control-label">Montant</label>
                                    <div class="col-sm-10">   <div class="input-group">
                                            <span class="input-group-addon">shs</span>
                                            <input type="text" class="form-control" name="amount" required="required">
                                </div></div>
                                </div>
                            <div class="form-group" id="data_1">
                              <label class="col-sm-2 control-label">Date</label>
                               <div class="col-sm-10">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i>
                                </span><input type="text" class="form-control" name="date">
                                </div>
                                </div>
                            </div>                   <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                  <button class="btn btn-primary" name="submit" type="submit">Ajouter un coût</button>
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
