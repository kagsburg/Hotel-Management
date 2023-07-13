<?php
include '../includes/conn.php';
include '../includes/baseurl.php';
   if(!isset($_SESSION['oseadmin'])){
header('Location:login.php');
   }
  ?>
<html>


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title>EA champs admin</title>
<script src="ckeditor/ckeditor.js"></script>
      <script language="JavaScript" src="js/gen_validatorv4.js" type="text/javascript"></script>
<link rel="stylesheet" href="ckeditor/samples/sample.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
      <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>

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
                    <h2>Add Audio</h2>
                    <ol class="breadcrumb">
                        <li>              <a href=""><i class="fa fa-home"></i> Home</a>                    </li>
                        <li>                         <a>Music</a>                       </li>
                        <li>                         <a>Audio</a>                       </li>
                        <li class="active">
                            <strong>Add Audio</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
                                <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Upload  New Audio  <small>Ensure to fill all neccesary fields</small></h5>
                           
                        </div>
                        <div class="ibox-content">
                            <?php
                             
                               if(isset($_POST['name'],$_POST['artists'],$_POST['chooseartist'],$_FILES['song'],$_POST['country'],$_POST['genre'],$_FILES['cover'])){
                                     $image_name=$_FILES['song']['name'];
$image_size=$_FILES['song']['size'];
$image_temp=$_FILES['song']['tmp_name'];
  $name=  trim($_POST['name']);
  $artists=  mysql_real_escape_string(trim($_POST['artists']));
  $artist=$_POST['chooseartist'];
  $country=$_POST['country'];
  $genre=$_POST['genre'];
//$allowed_ext=array('jpg','jpeg','png','gif','');
//$image_ext=strtolower(end(explode('.',$image_name)));
$kaboom = explode(".", $image_name); // Split file name into an array using the dot
$image_ext= end($kaboom);
//$name=md5($id);

if(($image_ext!='mp3')&&($image_ext!='MP3')&&($image_ext!='ogg')&&($image_ext!='wav')){
    echo '<div class="alert alert-danger"><i class="fa fa-warning"></i> Incorpatible File Format</div>';
}else{
            mysql_query("INSERT INTO audios VALUES('','$name','$artist','$artists','$country','$genre','$image_ext','$fullname','".$_SESSION['oseadmin']."','published','0','0','null')") or die(mysql_error());
               $last_id=mysql_insert_id();
               $image_file=$name.'-'.$artists.'_'.$last_id.'[eachamps.com]'.'.'.$image_ext;
              // $image_file=md5($last_id).'.'.$image_ext;
move_uploaded_file($image_temp,'../audio_files/'.$image_file) or die(mysql_error());
$last_audio=mysql_query("SELECT * FROM audios WHERE song_id='$last_id'");
$row=mysql_fetch_array($last_audio);
$name=$row['song_name'];
$artists=$row['artists'];
$addslug=  mysql_query("UPDATE audios SET slug='$image_file' WHERE song_id='$last_id'") or die(mysql_error());
                   $string='{
  "id":"gearContainer",
  "albumCover":"img/thumbs/01.jpg",
  "albumTitle":"'.$name.'",
  "albumAuthor":"'.$artists.'",
  "soundcloudEnabled":false,
  "soundcloudClientID":"go to http://soundcloud.com/you/apps/new and get your client ID there",
  "soundcloudSet":"this should be something like http://soundcloud.com/you/sets/youralbum",
  "soundcloudOverwrite":false,
  "autoPlay": true,
  "shuffle": false,
  "volume": 100,
  "peak": true,
  "equalizer": true,
  "equalizerSVG":false,
  "equalizerSize":200,
  "equalizerPadding":25,
  "equalizerColor":"#EAEAEA",
  "equalizerBars":128,
  "equalizerRatio":0.6,
  "width": 800,
  "height": 800,
  "outerRay": 100,
  "innerRay": 90,
  "outerPadding":20,
  "innerPadding":20,
  "sectorPadding":2.5,
  "trackColor":"#111111",
  "loadedColor": "#222222",
  "progressColor": "#EAEAEA",
  "loadedThickness":26,
  "progressThickness":18,
  "timeColor":"#FFFFFF",
  "timeSize": 20,
  "randomColors": true,
  "textColor": "#FFFFFF",
  "overColor": "#F2F2F2",
  "titleSize": 14,
  "authorSize": 12,
  "dockToRight": false,
  "entries": [
      {"title":"'.$name.'", "author":"'.$artists.'", "media":"'.BASE_URL.'/audio_files/'.$image_file.'", "link":"'.BASE_URL.'/song/'.$last_id.'/'.str_replace(' ','-',$name).'.html", "color":"#56B0E8" }
     
    ]
}';
   $photo="../player/json/".md5($last_id).".json";
  
//Write out data to file
if( $fp = fopen( $photo, 'wb' ) )
{
//Write data to the file
fwrite( $fp, $string );
  
//Close the file
fclose( $fp );
//echo 'Data safely recieved';
}
else
{
die( "Error writing to json file $photo" );
}
if(!empty($_FILES["cover"]["name"])){
        $coverName = $_FILES["cover"]["name"]; // The file name
$coverTmpLoc = $_FILES["cover"]["tmp_name"]; // File in the PHP tmp folder
$coverType = $_FILES["cover"]["type"]; // The type of file it is
$coverSize = $_FILES["cover"]["size"]; // File size in bytes
//$coverErrorMsg = $_FILES["cover"]["error"]; // 0 for false... and 1 for true
  $allowed_ext=array('jpg','jpeg','png','gif','');
$kaboom2 = explode(".", $coverName); // Split file name into an array using the dot
$coverExt = strtolower(end($kaboom2));
 if (in_array($coverExt,$allowed_ext)===false){
$errors[]='File type not allowed';
}
if($coverSize>10097152){
$errors[]='Maximum size is 10Mb';
}
 include  'includes/thumbs3.php';
if(!empty($errors)){
   
foreach($errors as $error){ 
echo '<div class="alert alert-danger">'.$error.'</div><br/>';
}
}else{
           $coverimg=md5($last_id).'.'.$coverExt;
            move_uploaded_file($coverTmpLoc, "../images/covers/$coverimg") or die("Error moving file");                    
           mysql_query("INSERT INTO covers VALUES('','$last_id','$coverExt')") or die(mysql_error());
           create_thumb('../images/covers/',$coverimg,'../images/covers/thumbs/');
}}
  echo '<div class="col-sm-2"></div><div class="col-sm-10"><div class="alert alert-success"><i class="fa fa-check"></i> Song Uploaded successfully</div></div>';
                               }}
                            
                            ?>
                          <form method="post" class="form-horizontal" action=''  name="form" enctype="multipart/form-data">
                                <div class="form-group"><label class="col-sm-2 control-label">Song Name</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name="name" placeholder="Enter Song Title" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                  <div class="form-group"><label class="col-sm-2 control-label">Enter Artist (s)</label>

                                    <div class="col-sm-10"><input type="text" class="form-control" name="artists" placeholder="Enter name of singer" required="required"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                                 <div class="form-group">
                                         <label class="col-sm-2 control-label">Select Artist</label>

                                    <div class="col-sm-10">
                                     <div class="input-group">
                                <select data-placeholder="Choose artist..." name="chooseartist" class="chosen-select" style="width:350px;" tabindex="2">
                                    <option value="" selected="selected">choose artist..</option>
                              <?php 
                   $artists=mysql_query("SELECT * FROM artists  WHERE status='published' ORDER BY stagename");
                 if(mysql_num_rows($artists)>0){
                     while($row2=mysql_fetch_array($artists)){
                         $artist_id=$row2['artist_id'];
                         $stagename=$row2['stagename'];
                         echo '<option value="'.$artist_id.'">'.$stagename.'</div>';
                 }            }          
                 ?>
                               
                                                  
                               
                                </select>
                                </div>
                                         <div id='form_chooseartist_errorloc' class='text-danger'></div>
                                    </div>
                                </div>
                             
                                                           <div class="hr-line-dashed"></div>
                                         <div class="form-group"><label class="col-sm-2 control-label">Select Country</label>

                                    <div class="col-sm-10"><select class="form-control m-b" name="country">
                                              <option value="" selected="selected">select country...</option>
                                        <option value='Uganda'>Uganda</option>
                                        <option  value='Tanzania'>Tanzania</option>
                                        <option  value='Kenya'>Kenya</option>
                                        <option  value='Rwanda'>Rwanda</option>
                                    </select>
 <div id='form_country_errorloc' class='text-danger'></div>
                                        
                                    </div>
                                </div>
                             
                                                           <div class="hr-line-dashed"></div>
                            
                                  <div class="form-group"><label class="col-sm-2 control-label">Upload Audio</label>

                                    <div class="col-sm-10"><input type="file" class="form-control " name="song" style="padding: 0px" required="required" ></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">Select Genre</label>

                                    <div class="col-sm-4"><select name="genre" data-placeholder="Choose a genre..." class="chosen-select" style="width:350px;" >
                                        <option value="" selected="selected">choose genre... </option>
                                            <?php  
                                       $cat=mysql_query("SELECT * FROM genres WHERE status='published' ");                                                   
                                     while($row=  mysql_fetch_array($cat)){
                                         $cat_id=$row['genre_id'];
                                         $category=$row['genre'];
                                             echo '  <option value="'.$cat_id.'">'.$category.'</option>';
                                     }
                                            ?>
                                    </select>

                                       <div id='form_genre_errorloc' class='text-danger'></div> 
                                    </div>
                                       
                                </div>
                                   <div class="hr-line-dashed"></div>
                            
                                  <div class="form-group"><label class="col-sm-2 control-label">Add Cover Photo</label>

                                    <div class="col-sm-10"><input type="file" class="form-control " name="cover" style="padding: 0px"></div>
                                </div>
                             
                                                           <div class="hr-line-dashed"></div>
                                                                                                  
                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                   
                                        <button class="btn btn-primary" type="submit">Submit song</button>
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

    <!-- Mainly scripts -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/chosen/chosen.jquery.js"></script>
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- iCheck -->
    <!--<script src="js/plugins/iCheck/icheck.min.js"></script>-->
        <script>
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

        </script>
</body>
<script type="text/javascript">
     
 var frmvalidator  = new Validator("form");
 frmvalidator.EnableOnPageErrorDisplay();
 frmvalidator.EnableMsgsTogether();
              frmvalidator.addValidation("country","req","*Select artist Country");
              frmvalidator.addValidation("chooseartist","req","*Select artist ");
              frmvalidator.addValidation("genre","req","*Select song genre ");
              //            frmvalidator.addValidation("repeat","eqelmnt=password", "*The passwords dont match");

    
</script>

<!-- Mirrored from webapplayers.com/inspinia_admin-v1.2/form_basic.html by HTTrack Website Copier/3.x [XR&CO'2013], Sun, 15 Jun 2014 11:38:04 GMT -->
</html>