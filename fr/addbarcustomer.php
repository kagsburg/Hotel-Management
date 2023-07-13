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
                    <h2>Add Bar Customer</h2>
                    <ol class="breadcrumb">
                        <li>              <a href="index"><i class="fa fa-home"></i> Home</a>                    </li>
                      
                        <li class="active">
                            <strong>Add Bar Customer</strong>
                        </li>
                    </ol>
                </div>
             
            </div>
        <div class="wrapper wrapper-content animated fadeInRight">
                       <div class="row">

                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            
                            <h5>Add Bar Customer <small>Ensure to fill all necessary fields</small></h5>
                                                </div>
                        <div class="ibox-content">
                                               <?php
                                                     if(isset($_POST['customername'],$_POST['customercompany'],$_POST['customerphone'],$_POST['customeremail'],$_POST['passport_id'])){
                                                           $customername=  mysqli_real_escape_string($con,trim($_POST['customername']));
                               $customercompany=  mysqli_real_escape_string($con,trim($_POST['customercompany']));
                               $customerphone=  mysqli_real_escape_string($con,trim($_POST['customerphone']));
                               $customeremail=  mysqli_real_escape_string($con,trim($_POST['customeremail']));
                               $passport_id=  mysqli_real_escape_string($con,trim($_POST['passport_id']));         
                                if(empty($customername)){
                                   $errors[]='Enter Customer name To Proceed';
                                }
                                                $check=  mysqli_query($con,"SELECT * FROM customers WHERE passport_id='$passport_id' AND type='bar' AND status=1");
                                if(mysqli_num_rows($check)>0){
                                    $errors[]='Customer Already Exists';
                                }
                                   if(!empty($errors)){
                                foreach ($errors as $error) {
                                    echo '<div class="alert alert-danger">'.$error.'</div>';
                                }}else{
                                                            
              mysqli_query($con,"INSERT INTO customers(customername,customercompany,customerphone,customeremail,passport_id,type,status) VALUES('$customername','$customercompany','$customerphone','$customeremail','$passport_id','bar','1')") or die(mysqli_errno($con));
             
echo '<div class="alert alert-success"><i class="fa fa-check"></i>Customer successfully added</div>';
                                 }
                            }
                                                
	
	
                           ?>
  <form method="post" class="form" action=''  name="form" enctype="multipart/form-data">
                                 <div class="form-group">
                                     <label class="control-label">*Customer Name</label>
                                     <input type="text" class="form-control" name='customername' placeholder="Enter customer Name" required="required">
                                                                                                                  </div>
                                     <div class="form-group">
                                     <label class="control-label">Company</label>
                                    <input type="text" class="form-control" name='customercompany' placeholder="Enter Customer Name">
                                                                                                                  </div>
           <div class="form-group">
                                     <label class="control-label">Telephone</label>
                                    <input type="text" class="form-control" name='customerphone' placeholder="Enter Customer telephone">
                                                                                                                  </div>
                                       <div class="form-group">
                                     <label class="control-label">Email</label>
                                    <input type="text" class="form-control" name='customeremail' placeholder="Enter Customer Name">
                                                                                                                  </div>
                                      <div class="form-group">
                                     <label class="control-label">Passport ID</label>
                                    <input type="text" class="form-control" name='passport_id' placeholder="Enter Passport ID">
                                                                                                                  </div>
<!--                                      <div class="form-group">
                                     <label class="control-label">Discount (%)</label>
                                    <input type="text" class="form-control" name='discount' placeholder="Enter Discount">
                                                                                                                  </div>-->
                                        
                               <div class="form-group">                                 
                     <button class="btn btn-primary" name="submit" type="submit">Add Customer</button>
                                               </div>
                            </form>
                                                 

                    </div>

                  
                </div>
             
                    </div>
                        


    </div>

   