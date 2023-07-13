<?php
include 'includes/conn.php';
if ((!isset($_SESSION['hotelsys'])) ) {
  header('Location:login.php');
}
$id = $_GET['id'];
?>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Edit Menu ITem | Hotel Manager</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="css/plugins/chosen/chosen.css" rel="stylesheet">
  <!-- Data Tables -->
  <link href="css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

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
        <div class="col-lg-12">
          <h2>Edit Hotel Food Menu Item</h2>
          <ol class="breadcrumb">
            <li> <a href=""><i class="fa fa-home"></i> Home</a> </li>

            <li>
              <a href="foodmenu">Menu</a>
            </li>
            <li class="active">
              <strong>Edit Menu Item</strong>
            </li>
          </ol>
        </div>
        <div class="col-lg-2">

        </div>
      </div>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-7">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Edit Menu Item</h5>

              </div>
              <div class="ibox-content">
                <?php
                //                            include_once 'includes/thumbs3.php';
                if (isset($_POST['item'], $_POST['price'])) {
                  $item =  mysqli_real_escape_string($con, trim($_POST['item']));
                  $price =  mysqli_real_escape_string($con, trim($_POST['price']));
                  $itemtype = mysqli_real_escape_string($con, trim($_POST['itemtype']));
                  $category = mysqli_real_escape_string($con, trim($_POST['category']));
                  $menucategory = mysqli_real_escape_string($con, trim($_POST['menucategory']));
                  if (isset($_POST['taxed'])) {
                    $taxed = $_POST['taxed'];
                  } else {
                    $taxed = 'no';
                  }
                  $stockitems = $_POST['stockitems'];
                  $quantity = $_POST['quantity'];
                  if ((empty($_POST['item'])) || (empty($_POST['price'])) || (empty($_POST['itemtype']))) {
                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Enter Menu Item To Proceed</div>';
                  } else  if (is_numeric($price) == FALSE) {
                    echo '  <div class="alert alert-danger"><i class="fa fa-warning"></i>Price Should Be An Integer</div>';
                  } else {
                    mysqli_query($con, "UPDATE menuitems SET menuitem='$item',itemprice='$price',category='$category',menucategory='$menucategory',taxed='$taxed',type='$itemtype' WHERE menuitem_id='$id'") or die(mysqli_error($con));
                    $allproducts = sizeof($stockitems);
                    for ($i = 0; $i < $allproducts; $i++) {
                      if (!empty($stockitems[$i])) {
                        mysqli_query($con, "INSERT INTO menuitemproducts(stockitem_id,menuitem_id,quantity,status) VALUES('$stockitems[$i]','$id','$quantity[$i]',1)") or die(mysqli_error($con));
                      }
                    }
                    echo '<div class="alert alert-success"><i class="fa fa-check"></i>Menu Item successfully Edited</div>';
                  }
                }
                $menuitem = mysqli_query($con, "SELECT * FROM menuitems WHERE menuitem_id='$id'");
                $row =  mysqli_fetch_array($menuitem);
                $menuitem1 = $row['menuitem'];
                $itemprice1 = $row['itemprice'];
                $type = $row['type'];
                $taxed = $row['taxed'];
                $category = $row['category'];
                $menucategory = $row['menucategory'];
                $getcat =  mysqli_query($con, "SELECT * FROM menucategories WHERE status=1 AND category_id='$menucategory'");
                $row1 =  mysqli_fetch_array($getcat);
                $categoryname = $row1['category'];
                ?>
                <form method="post" class="form" action='' name="form" enctype="multipart/form-data">
                  <div class="form-group"><label class="control-label">Item</label>
                    <input type="text" class="form-control" name='item' placeholder="Enter item name" value="<?php echo $menuitem1; ?>" required='required'>
                  </div>
                  <div class="form-group">
                    <label class="control-label">Menu Category</label>
                    <select name="menucategory" class="form-control itemtype">
                      <option value="<?php echo $menucategory; ?>" selected="selected"><?php echo $categoryname; ?></option>
                      <?php
                      $getcats =  mysqli_query($con, "SELECT * FROM menucategories WHERE status=1");
                      while ($row1 =  mysqli_fetch_array($getcats)) {
                        $category_id = $row1['category_id'];
                        $categoryname = $row1['category'];
                      ?>
                        <option value="<?php echo $category_id; ?>"><?php echo $categoryname; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group"><label class="control-label">Price</label>

                    <input name="price" value="<?php echo $itemprice1; ?>" class="form-control" placeholder="Enter item price" type="text">
                  </div>

                  <div class="form-group">
                    <label class="control-label">Item Type</label>
                    <select name="itemtype" class="form-control itemtype">
                      <option value="<?php echo $type; ?>" selected="selected"><?php echo $type; ?></option>
                      <option value="food">food</option>
                      <option value="drink">drink</option>
                    </select>
                  </div>
                  <?php
                  if ($type == 'drink') {
                  ?>
                    <div class="form-group drinkcategory">
                    <?php } else { ?>
                      <div class="form-group drinkcategory" style="display: none">
                      <?php } ?>
                      <label class="control-label">Drink Category</label>
                      <select name="category" class="form-control">
                        <option value="<?php echo $category; ?>" selected="selected"><?php echo $category; ?></option>
                        <option value="local">Local Drink</option>
                        <option value="imported">Imported Drink</option>
                      </select>
                      </div>
                      <div class="form-group">
                        <div class="form-check">
                          <?php
                          if ($taxed == 'yes') {
                          ?>
                            <input class="form-check-input" type="checkbox" value="yes" name="taxed" checked="checked">
                          <?php } else { ?>
                            <input class="form-check-input" type="checkbox" value="yes" name="taxed">
                          <?php } ?>
                          <label class="form-check-label" for="defaultCheck1">
                            Is item Taxed?
                          </label>
                        </div>
                      </div>
                      <div class='subobj'>
                        <h3>Add Menu Item Contents</h3>
                        <div class='row'>
                          <div class="form-group col-lg-6"><label class="control-label">* Stock Item </label>
                            <select data-placeholder="Choose item..." name="stockitems[]" class="chosen-select" style="width:100%;" tabindex="2">
                              <option value="" selected="selected">choose item..</option>
                              <?php
                              $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                              while ($row =  mysqli_fetch_array($stock)) {
                                $stockitem_id = $row['stockitem_id'];
                                $cat_id = $row['category_id'];
                                $stockitem = $row['stock_item'];
                                $minstock = $row['minstock'];
                                $measurement = $row['measurement'];
                                $status = $row['status'];
                                $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                $row2 =  mysqli_fetch_array($getmeasure);
                                $measurement2 = $row2['measurement'];
                              ?>
                                <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group col-lg-5"><label class="control-label">Quantity</label>
                            <input type="number" name='quantity[]' class="form-control" placeholder="Enter Quantity" step="0.0001">
                          </div>

                          <div class="form-group col-lg-1">
                            <a href='#' class="subobj_button btn btn-success" style="margin-top:20px">+</a>
                          </div>


                        </div>
                      </div>
                      <div class="form-group">
                        <button class="btn btn-primary " name="submit" type="submit">Edit menu item</button>

                      </div>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="ibox float-e-margins">
              <div class="ibox-title">
                <h5>Menu Items</h5>
              </div>
              <div class="ibox-content">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $products = mysqli_query($con, "SELECT * FROM menuitemproducts WHERE menuitem_id='$id' AND status=1") or die(mysqli_error($con));
                    while ($row = mysqli_fetch_array($products)) {
                      $stockitem_id = $row['stockitem_id'];
                      $menuitemproduct_id = $row['menuitemproduct_id'];
                      $quantity = $row['quantity'];
                      $stockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$stockitem_id'");
                      $row1 =  mysqli_fetch_array($stockitem);
                      $stockitem = $row1['stock_item'];
                      $measurement = $row1['measurement'];
                      $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                      $row2 =  mysqli_fetch_array($getmeasure);
                      $measurement2 = $row2['measurement'];
                    ?>
                      <tr>
                        <td><?php echo $stockitem . '(' . $measurement2 . ')'; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td> <button data-toggle="modal" data-target="#basicModal<?php echo $menuitemproduct_id; ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button>
                          <a href="removemenuitemproduct?id=<?php echo $menuitemproduct_id; ?>" class="btn btn-sm btn-danger" onclick="return confirm_delete<?php echo $menuitemproduct_id; ?>()"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                      <script type="text/javascript">
                        function confirm_delete<?php echo $menuitemproduct_id; ?>() {
                          return confirm('You are about To Remove this Item. Are you sure you want to proceed?');
                        }
                      </script>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <?php
  $products = mysqli_query($con, "SELECT * FROM menuitemproducts WHERE menuitem_id='$id'") or die(mysqli_error($con));
  while ($row = mysqli_fetch_array($products)) {
    $stockitem_id = $row['stockitem_id'];
    $menuitemproduct_id = $row['menuitemproduct_id'];
    $quantity = $row['quantity'];
    $getstockitem = mysqli_query($con, "SELECT * FROM stock_items WHERE stockitem_id='$stockitem_id'");
    $row1 =  mysqli_fetch_array($getstockitem);
    $stockitem = $row1['stock_item'];
    $measurement = $row1['measurement'];
  ?>
    <div id="basicModal<?php echo $menuitemproduct_id; ?>" class="modal fade" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <form action="editmenuitemproduct?id=<?php echo $menuitemproduct_id; ?>" method="POST">
              <div class="form-group"><label class="control-label">* Stock Item </label>
                <select class="form-control" name="item">
                  <option value="<?php echo $stockitem_id; ?>" selected="selected"><?php echo $stockitem; ?></option>
                  <?php
                  $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                  while ($row =  mysqli_fetch_array($stock)) {
                    $stockitem_id = $row['stockitem_id'];
                    $cat_id = $row['category_id'];
                    $stockitem = $row['stock_item'];
                    $minstock = $row['minstock'];
                    $measurement = $row['measurement'];
                    $status = $row['status'];
                    $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                    $row2 =  mysqli_fetch_array($getmeasure);
                    $measurement2 = $row2['measurement'];
                  ?>
                    <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group"><label class="control-label">Quantity</label>
                <input type="number" name='quantity' class="form-control" placeholder="Enter Quantity" step="0.00001" value="<?php echo $quantity; ?>">
              </div>
              <div class="form-group">
                <button class="btn btn-primary" type="submit">Edit</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  <?php  } ?>
  <script src="js/jquery-1.10.2.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

  <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
  <script src="js/plugins/chosen/chosen.jquery.js"></script>
  <!-- Data Tables -->
  <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
  <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

  <!-- Custom and plugin javascript -->
  <script src="js/inspinia.js"></script>
  <script src="js/plugins/pace/pace.min.js"></script>

  <!-- Page-Level Scripts -->
  <script>
    $('.itemtype').on('change', function() {
      var getoption = $(this).val();
      if (getoption === 'drink') {
        $('.drinkcategory').show();
      } else {
        $('.drinkcategory').hide();
      }
    });
    var config = {
      '.chosen-select': {},
      '.chosen-select-deselect': {
        allow_single_deselect: true
      },
      '.chosen-select-no-single': {
        disable_search_threshold: 10
      },
      '.chosen-select-no-results': {
        no_results_text: 'Oops, nothing found!'
      },
      '.chosen-select-width': {
        width: "95%"
      }
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    $('.subobj_button').click(function(e) { //on add input button click
      e.preventDefault();
      <?php
      if ((isset($_SESSION['lan'])) && ($_SESSION['lan'] == 'fr')) {  ?>
        $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Article en stock</label>   <select data-placeholder="Choisissez l article..." name="stockitems[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">Choisissez l article..</option>       <?php $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                          while ($row =  mysqli_fetch_array($stock)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $stockitem_id = $row['stockitem_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $stockitem = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['stock_item']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $measurement = $row['measurement'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $row2 =  mysqli_fetch_array($getmeasure);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $measurement2 = $row2['measurement'];              ?>      <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>               <?php } ?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantité</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Quantité" required="required"  step="0.01">  </div></div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
      <?php } else { ?>
        $('.subobj').append('<div class="row"><div class="col-lg-12"><hr style="border-top: dashed 1px #b7b9cc;"></div><div class="col-lg-11"><div class="row"> <div class="form-group col-lg-6"><label class="control-label">* Stock Item</label>   <select data-placeholder="Choose item..." name="stockitems[]" class="chosen-select" style="width:100%;" tabindex="2">     <option value="" selected="selected">choose item..</option>       <?php $stock = mysqli_query($con, "SELECT * FROM stock_items WHERE status=1");
                                                                                                                                                                                                                                                                                                                                                                                                                                                  while ($row =  mysqli_fetch_array($stock)) {
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $stockitem_id = $row['stockitem_id'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $stockitem = preg_replace('/[^a-zA-Z0-9\-]/', ' ', $row['stock_item']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $measurement = $row['measurement'];
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $getmeasure =  mysqli_query($con, "SELECT * FROM stockmeasurements WHERE measurement_id='$measurement'");
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $row2 =  mysqli_fetch_array($getmeasure);
                                                                                                                                                                                                                                                                                                                                                                                                                                                    $measurement2 = $row2['measurement'];              ?>      <option value="<?php echo $stockitem_id; ?>"><?php echo $stockitem . ' (' . $measurement2 . ')'; ?></option>               <?php } ?>            </select></div><div class="form-group col-lg-6"><label class="control-label">* Quantity</label>  <input type="number" name="quantity[]" class="form-control" placeholder="Enter Quantity" required="required"  step="0.01">  </div></div> </div> <button class="remove_subobj  btn btn-danger" style="height:30px;margin-top:22px"><i class="fa fa-minus"></i></button></div>'); //add input box
      <?php } ?>
      var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {
          allow_single_deselect: true
        },
        '.chosen-select-no-single': {
          disable_search_threshold: 10
        },
        '.chosen-select-no-results': {
          no_results_text: 'Oops, nothing found!'
        },
        '.chosen-select-width': {
          width: "95%"
        }
      }
      for (var selector in config) {
        $(selector).chosen(config[selector]);
      }
    });
    $('.subobj').on("click", ".remove_subobj", function(e) { //user click on remove text
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
    });
  </script>
</body>

</html>