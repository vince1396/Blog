<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Signin</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/signin.css" rel="stylesheet">
    <link href="css/offcanvas.css" rel="stylesheet">
    <script src="ckeditor/ckeditor.js"></script>
  </head>

  <body>
    <?php include("includes/navbar.php"); ?>
    <?php include("includes/bdd.php"); ?>
    <?php
    if(isset($_SESSION['id']))
    { ?>
      <div class="container">

        <form action="#" method="post">
          <div class="row">
            <h2 class="col-lg-offset-4 col-lg-5 signhead">Créer votre article</h2>
        </div>
          <div class="row">
            <div class="col-lg-offset-4 col-lg-4">
              <label for="inputTitre" class="sr-only">Titre</label>
              <input type="text" id="inputTitre" class="form-control titre_a" placeholder="Titre" name="titre" autofocus>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <textarea id="inputBody" class="form-control ckeditor" placeholder="Corps de l'article" name="body"></textarea>
            </div>
          </div>
          <script>
            CKEDITOR.replace( 'inputBody' );
          </script>
          <div class="row">
            <div class="col-lg-offset-4 col-lg-4">
              <button class="btn btn-lg btn-primary btn-block signbtn" type="submit" name="submit">Publier</button>
            </div>
          </div>
        </form>

      </div> <!-- /container --> <?php
    }
    else
    {
      echo "<div class='alert warning-alert col-lg-4 erreur'> Veuillez vous connecter </div>";
    } ?>
  </body>
</html>

<?php
  if(isset($_POST['submit']))
  {
    if(empty($_POST['titre']) AND empty($_POST['body']))
    {
      echo "<div class='alert warning-alert col-lg-4 erreur'> veuiller remplir tous les champs du formulaire. </div>";
    }
    else
    {
      $titre = $_POST['titre'];
      $auteur = $_SESSION['id'];
      $date_a = date("Y/m/d");
      $body = $_POST['body'];

      $req = $bdd->prepare("INSERT INTO article (titre, auteur, date_a, corps) VALUES (:titre, :auteur, :date_a, :body)");
      $req->bindValue('titre', $titre, PDO::PARAM_STR);
      $req->bindValue('auteur', $auteur, PDO::PARAM_INT);
      $req->bindValue('date_a', $date_a, PDO::PARAM_STR);
      $req->bindValue('body', $body, PDO::PARAM_STR);
      $req->execute();
    }
  }
?>
