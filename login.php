<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/offcanvas.css" rel="stylesheet">
  </head>

  <body>
    <?php include("includes/navbar.php"); ?>
    <?php include("includes/bdd.php"); ?>
    <?php include("fonctions.php"); ?>

    <div class="container">

      <form class="form-signin" action="#" method="post">
        <h2 class="form-signin-heading">Veuillez vous connectez</h2>
        <label for="inputLogin" class="sr-only">Adresse Email</label>
        <input type="text" id="inputLogin" class="form-control" placeholder="Login" name="login" autofocus>
        <label for="inputPassword" class="sr-only">Mot de passe</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Mot de passe" name="mdp">

        <button class="btn btn-lg btn-primary btn-block signbtn" type="submit">Se connecter</button>
      </form>

    </div> <!-- /container -->


    <?php
    if(isset($_POST['login']) OR isset($_POST['mdp']))
    {
      echo login($_POST['login'], $_POST['mdp'], $bdd);
      header("index.php");
    }
    ?>
  </body>
</html>
