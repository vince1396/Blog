<?php include("includes/bdd.php") ?>

<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title> Blog </title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/offcanvas.css" rel="stylesheet">
  </head>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
  <body>
    <?php include("includes/navbar.php"); ?>

  <div class="container well span6 user">
      <div class="col-lg-offset-3 col-lg-6">
  	     <div class="row-fluid">
          <div class="span2 user-img" >
  		    <?php echo "<img src='".$_GET['avatar']."' class='img-circle user-img'>"; ?>
          </div>

          <div class="span8">
              <h3><?php echo $_GET['login']; ?></h3>
              <h6>Email: <?php echo $_GET['email']; ?></h6>
          </div>
        </div>
</div>
  </body>
</html>
