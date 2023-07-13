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
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index">Home</a>
                        </li>
                        <li>
                            <a href="admins">Admins</a>
                        </li>
                          
                        <li class="active">
                            <strong>view Profile</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                              <?php 
            $user=mysqli_query($con,"SELECT * FROM users WHERE user_id='$id'");
           $row=  mysqli_fetch_array($user);
                $user_id=$row['user_id'];
                $fullname=$row['fullname'];
                $level=$row['level'];
                $status=$row['status'];
                $email=$row['email'];
               $imgext=$row['ext'];
               $role=$row['role'];
            ?>
                            <h3><?php echo $fullname; ?></h3>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right" style="">
                                <img alt="image" class="img-responsive" src="img/users/<?php echo md5($user_id).'.'.$imgext; ?>" width="100%">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong>   <?php
                                        echo $role;
                                   ?></strong></h4>
                                <p><i class="fa fa-envelope"></i> <?php echo $email;?></p>
                                                              
                                <div class="user-button"> 
                                    <div class="row">
                                        <?php if($user_id==$_SESSION['hotelsys']){ ?>
                                        <div class="col-md-7">
                                                                                </div>
                                        <?php } else{
                                             if($_SESSION['hotelsyslevel']==1){
                                            ?>
                                        <div class="col-md-6">
                                               <a href="editadmin?<?php echo 'id='.$user_id;?>" class="btn btn-info btn-sm btn-block"><i class="fa fa-edit"></i> Edit Admin</a>
                                              
                                        </div>
                                        <div class="col-md-6">
                                            <?php if($status=="1"){?>
                                            <a href='activateadmin?status=<?php echo $status.'&&id='.$user_id;?>' class="btn btn-danger btn-sm btn-block"><i class="fa fa-times"></i> Deactivate</a>
                                            <?php }else{ ?>
                                               <a href='activateadmin?status=<?php echo $status.'&&id='.$user_id;?>' class="btn btn-primary btn-sm btn-block"><i class="fa fa-check"></i> Activate</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                    </div>
                
                <div class="col-md-8">
                   

                </div>
            </div>
        </div>
        </div>

    </div>
<div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12"><h3 class="m-t-none m-b">Upload picture</h3>
                                                    <form role="form" method="POST" action="changeuserpic?id=<?php echo $id; ?>&&ext=<?php echo $imgext;?>" enctype="multipart/form-data">
                                                          <div class="form-group"><input type="file" style="Padding:0px" name="image" required="required" class="form-control"></div>
                                                        <div>
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Change picture</strong></button>
                                                                                                                </div>
                                                    </form>
                                                </div>
                                                
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        </div>
    