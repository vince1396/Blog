<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Signin</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/offcanvas.css" rel="stylesheet">
  </head>

  <body>
    <?php include("includes/navbar.php"); ?>
    <?php include("includes/bdd.php"); ?>
    <?php include("fonctions.php"); ?>

  <div class="container">

      <form class="form-signin" action="#" method="post" enctype="multipart/form-data">
        <h2 class="form-signin-heading">Inscrivez-vous</h2>
        <label for="inputLogin" class="sr-only">Email address</label>
        <input type="text" id="inputLogin" class="form-control" placeholder="Login" name="login" autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Adresse Email" name="email">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" name="mdp">
        <label for="inputComfirm" class="sr-only">Password</label>
        <input type="password" id="inputComfirm" class="form-control" placeholder="Confirmez" name ="confirm">
        <p class="sign-avatar"> Avatar </p>
        <label for="inputFile" class="sr-only">Avatar</label>
        <input type="file" id="inputFile" class="form-control" placeholder="File" name ="file">

        <button class="btn btn-lg btn-primary btn-block signbtn" type="submit">S'inscrire</button>
      </form>

    </div> <!-- /container -->



    <?php
      if(isset($_POST['login']) OR isset($_POST['email']) OR isset($_POST['mdp']) OR isset($_POST['confirm']))
      {
        echo inscription($_POST['login'], $_POST['email'], $_POST['mdp'], $_POST['confirm'], $_FILES, $bdd);
      }
    ?>
  </body>
</html>
