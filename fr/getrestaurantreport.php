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
                <div class="col-lg-10">
                    <h2>Générer le rapport du Stock </h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Accueil</a>                    </li>
                                          <li class="active">
                            <strong>Générer le rapport</strong>
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
                            <h5>Générer le Rapport du stock <small>
                                tous les champs marqués(*) ne doivent pas restés vides</small></h5>
                           
                        </div>
                        <div class="ibox-content">                           
     <form method="GET" name='form' class="form-horizontal" action="restaurantreport">
                         <div class="form-group" id="data_5">
                               <label class="col-sm-2 control-label">* Sélectionnez l’intervalle de la date</label>
                              <div class="col-sm-10">   <div class="input-daterange input-group" id="datepicker">
                                      <input type="text" class="input-sm form-control" name="start" placeholder="date du début" required="required"/>
                                    <span class="input-group-addon">à</span>
                                    <input type="text" class="input-sm form-control" name=end 
                                    placeholder="date du fin" required="required"/>
                                </div>
                                </div>
                            </div>                                                                      
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-info btn-sm" type="submit">Procéder</button>
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
