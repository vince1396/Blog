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

    <?php
      $req = $bdd->prepare("SELECT * FROM user WHERE id_u = :id_u");
      $req->bindValue('id_u', $_GET['id_u'], PDO::PARAM_INT);
      $req->execute();
      $reponse = $req->fetch();
    ?>

    <div class="container">
      <div class="row profile">
        <div class="col-lg-4">
          <p> <?php echo $reponse['login']; ?> </p>
        </div>
      </div>

      <div class="row profile">
        <div class="col-lg-4">
          <p> <?php echo $reponse['email']; ?> </p>
        </div>
        <div class="col-lg-4 col-lg-push-5">
          <form action="#" method="post">
            <input type="text" id="inputEmail" placeholder="Nouvelle adresse email" name ="email">
            <input type="submit" name="submit_email">
          </form>
        </div>
      </div>

      <div class="row profile">
        <div class="col-lg-4">
          <p> Modifiez votre mot de passe </a>
        </div>
        <div class="col-lg-4 col-lg-push-5">
          <form action="#" method="post">
            <input type="password" id="inputOld" placeholder="Ancien mot de passe" name ="oldmdp">
            <input type="password" id="inputPassword" placeholder="Nouveau mot de passe" name ="mdp">
            <input type="password" id="inputConfirm" placeholder="Confirmez" name ="confirm"><br />
            <input type="submit" name="submit_mdp">
          </form>
        </div>
      </div>

      <div class="row profile">
        <div class="col-lg-4">
          <p> Modifiez votre avatar </p>
        </div>
        <div class="col-lg-4 col-lg-push-5  ">
          <form action="#" method="post" enctype="multipart/form-data">
            <input type="file" id="inputFile" name ="file">
            <input type="submit" name="submit_avatar">
          </form>
        </div>
      </div>
    </div> <!-- /container -->
<!-- ------------------------------------------------------------------------------------------------------------------------------ -->
    <?php
      if(isset($_POST['submit_email']))
      {
        echo update_email($_POST['email'], $_SESSION['id'], $bdd);
      }
// -------------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['submit_mdp']))
    {
      echo update_mdp($_POST['oldmdp'], $_POST['mdp'], $_POST['confirm'], $_SESSION['id'], $bdd);
    }

// -------------------------------------------------------------------------------------------------------------------------------
      if(isset($_POST['submit_avatar']))
      {
        echo update_avatar($_FILES, $_SESSION['id'], $bdd);
      }
// ---------------------------------------------------------------------------------------------------------------------------------------
    ?>

  </body>
</html>
