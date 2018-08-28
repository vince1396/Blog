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
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <div class="container">

      <div class="row row-offcanvas row-offcanvas-right">
          <div class="jumbotron">
            <h1>Bienvenue sur mon Blog !</h1>
            <p>
              Vous trouverez içi tous les derniers articles à propos de tout et n'importe quoi ! N'hésitez pas à lire et à vous inscrire pour laisser des commentaires,
              sauf si vous êtes issus d'une minorité :)
            </p>
          </div>
<!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
          <div class="row">
          <?php
            if(isset($_POST['submit_search']))
            {
              if(!empty($_POST['search']))
              {
                  $recherche =$_POST['search'];
                  $requete = $bdd->query("SELECT * FROM article, user WHERE article.auteur = user.id_u AND article.titre LIKE '%$recherche%' ORDER BY date_a desc");
              }
              else
              {
                $requete = $bdd->query("SELECT * FROM article, user WHERE article.auteur = user.id_u ORDER BY date_a desc");
              }
            }
            else
            {
              $requete = $bdd->query("SELECT * FROM article, user WHERE article.auteur = user.id_u ORDER BY date_a desc");
            }
            while($reponse = $requete->fetch())
            {
              echo  "<div class='col-xs-6 col-lg-6'>
                      <h2>".$reponse['titre']."</h2>
                      <p> ".substr($reponse['corps'], 0, 255)."...</p>
                      <p><a class='btn btn-default' href='article.php?id_a=".$reponse['id_a']."' role='button'> Lire la suite &raquo;</a></p>
                    </div>";
            } ?>
          </div>
      </div>

      <hr>

      <footer>

      </footer>

    </div><!--/.container-->

    <script src="js/offcanvas.js"></script>
  </body>
</html>
