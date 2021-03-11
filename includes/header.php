<?php require_once 'php_action/core.php'; ?>

<!DOCTYPE html>
<html>
<head>

	<title>Jonaki Motors</title>

	<link rel="icon" href="motorsLogo.png">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap.min.css">
	<!-- bootstrap theme-->
	<link rel="stylesheet" href="assests/bootstrap/css/bootstrap-theme.min.css">
	<!-- font awesome -->
	<link rel="stylesheet" href="assests/font-awesome/css/font-awesome.min.css">

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

	<!-- DataTables -->
  <link rel="stylesheet" href="assests/plugins/datatables/jquery.dataTables.min.css">

  <!-- file input -->
  <link rel="stylesheet" href="assests/plugins/fileinput/css/fileinput.min.css">

  <!-- jquery -->
	<script src="assests/jquery/jquery.min.js"></script>
  <!-- jquery ui -->
  <link rel="stylesheet" href="assests/jquery-ui/jquery-ui.min.css">
  <script src="assests/jquery-ui/jquery-ui.min.js"></script>

  <!-- bootstrap js -->
	<script src="assests/bootstrap/js/bootstrap.min.js"></script>

</head>
<body>


<div class="col-md-16">
	<nav class="navbar navbar-default navbar-static-top" >
		<div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header" >
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#">Brand</a> -->
	  <a class="navbar-brand" href="http://localhost/inventory-management-system/index.php" style="padding:0px;">
                    <img src="motorsLogo.png" alt="">
                </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1 || $_SESSION['userType']==2) { ?>
      	<li id="navDashboard"><a href="index.php"><i class="glyphicon glyphicon-list-alt"></i>  Dashboard</a></li>
				<?php } ?>
        <?php if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
        <li id="navBrand"><a href="brand.php"><i class="glyphicon glyphicon-btc"></i>  Brand</a></li>
		<?php } ?>
		<?php if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
        <li id="navCategories"><a href="categories.php"> <i class="glyphicon glyphicon-th-list"></i> Category</a></li>
		<?php } ?>
		<?php if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
        <li id="navProduct"><a href="product.php"> <i class="glyphicon glyphicon-ruble"></i> Product </a></li>
		<?php } ?>
		<?php if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
        <li id="navProductReport"><a href="product-report.php"> <i class="glyphicon glyphicon-check"></i> Product Report </a></li>
		<?php } ?>

<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1 || $_SESSION['userType']==2) { ?>
        <li class="dropdown" id="navOrder">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-shopping-cart"></i> Orders <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li id="topNavAddOrder"><a href="orders.php?o=add"> <i class="glyphicon glyphicon-plus"></i> Add Orders</a></li>
            <li id="topNavManageOrder"><a href="orders.php?o=manord"> <i class="glyphicon glyphicon-edit"></i> Manage Orders</a></li>
          </ul>
        </li>
<?php } ?>
		<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
        <li id="navReport"><a href="report.php"> <i class="glyphicon glyphicon-check"></i> Report </a></li>
		<?php } ?>
		<?php  if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
        <li id="navPurchase"><a href="purchases.php"> <i class="glyphicon glyphicon-shopping-cart"></i> Purchases</a></li>
		<?php } ?>
        <li class="dropdown" id="navSetting">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="glyphicon glyphicon-user"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
			<?php if(isset($_SESSION['userId']) && $_SESSION['userType']==1) { ?>
            <li id="topNavSetting"><a href="setting.php"> <i class="glyphicon glyphicon-wrench"></i> Setting</a></li>
            <li id="topNavUser"><a href="user.php"> <i class="glyphicon glyphicon-wrench"></i> Add User</a></li>
			<?php } ?>
            <li id="topNavLogout"><a href="logout.php"> <i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
          </ul>
        </li>

				<li><a>Hello <?php echo $_SESSION['userName']?></a></li>

      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
	</nav>
</div>
	<div class="container" style="margin-bottom: 50px;">
