<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Blog</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/blog.css" rel="stylesheet">
  </head>

  <body>
    <?php include("includes/navbar.php") ?>
    <?php include("includes/bdd.php"); ?>

    <?php
      $requete = $bdd->query("SELECT * FROM article, user WHERE article.auteur = user.id_u AND article.id_a = ".$_GET['id_a']."");
      $reponse = $requete->fetch();
    ?>

    <div class="container">

      <div class="row">

        <div class="col-sm-12 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title"><?php echo $reponse['titre'] ?></h2>
            <p class="blog-post-meta"><?php echo $reponse['date_a']; ?> par <?php echo "<a href='user.php?login=".$reponse['login']."&email=".$reponse['email']."&avatar=".$reponse['avatar']."'>";?> <?php echo $reponse['login']; ?></a></p>
            <?php if(isset($_SESSION['id']))
            {
              if($_SESSION['id'] == $reponse['auteur'] OR $_SESSION['lvl'] > 1)
              {
                echo "<a href='article.php?supp_a=".$reponse['id_a']."&id_a=".$_GET['id_a']."'> Supprimer l'article </a>";
              }
            } ?>

            <p>
              <?php echo $reponse['corps']; ?>
            </p>
          </div><!-- /.blog-post -->

        </div><!-- /.blog-main -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    <!-- ==== TITRE ==== -->
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h3> Commentaires </h3>
        </div><!-- /col-sm-12 -->
      </div><!-- /row -->

    <?php
    $query = $bdd->prepare("SELECT * FROM comments c, user u WHERE c.article = :id_a AND c.auteur = u.id_u");
    $query->bindValue('id_a', $_GET['id_a'], PDO::PARAM_INT);
    $query->execute();

    while($resultat = $query->fetch())
    {
        echo
          "<div class='row'>
            <div class='col-sm-1'>
              <div class='thumbnail'>
                <img class='img-responsive user-photo' src='".$resultat['avatar']."'>
              </div>
            </div>

            <div class='col-sm-11'>
              <div class='panel panel-default'>
                <div class='panel-heading'>
                  <strong><a href='user.php?login=".$resultat['login']."&email=".$resultat['email']."&avatar=".$resultat['avatar']."'>".$resultat['login']."</a></strong> <span class='text-muted'>".$resultat['date_post']."</span>";
                  if(isset($_SESSION['id']))
                  {
                    if($_SESSION['id'] == $resultat['auteur'] OR $_SESSION['lvl'] > 1)
                    {
                      echo "<a class='supp' href='article.php?id_a=".$_GET['id_a']."&id_c=".$resultat['id_c']."'> X </a>";
                    }
                  }
              echo
                "</div>
                <div class='panel-body'>
                  ".$resultat['comm']."
                </div>
              </div>
            </div>
          </div>";
    } ?> <hr>
<!-- ---------------------------------------------------------------------------------------------------------------------- -->
    <?php
      if(isset($_SESSION['id']))
      { ?>
        <h3>Laissez un commentaire :</h3>
        <form action="#" method="post">
          <textarea class="comm" name="comm" id="comm" rows="10" cols="50"></textarea><br />
          <input type="submit" name="submit"/>
        </form>
        <?php }
        else
        { ?>
          <p> Veuillez vous connecter pour écrire un commentaire </p>
  <?php	}
        ?>
<!-- ---------------------------------------------------------------------------------------------------------------------- -->
    <?php
      if(isset($_POST['submit']))
      {
        $requete = $bdd->query("SELECT * FROM article, user WHERE article.auteur = user.id_u AND article.id_a = ".$_GET['id_a']."");
        $reponse = $requete->fetch();

        $auteur = $_SESSION['id'];
        $article = $reponse['id_a'];
        $comm = $_POST['comm'];

        $requete = $bdd->prepare("INSERT INTO comments (auteur, article, date_post, comm) VALUES (:auteur, :article, :date_post, :comm)");
        $requete->bindValue('auteur', $auteur, PDO::PARAM_STR);
        $requete->bindValue('article', $article, PDO::PARAM_INT);
        $requete->bindValue('comm', $comm, PDO::PARAM_STR);
        $requete->bindValue('date_post', date("Y/m/d"), PDO::PARAM_STR);
        $requete->execute();

        echo "<meta http-equiv='refresh' content='0;url=article.php?id_a=".$_GET['id_a']."' />";
      }
    ?>
<!-- ---------------------------------------------------------------------------------------------------------------------- -->
    <?php
      if(isset($_GET['supp_a']))
      {
        $clear_child = $bdd->prepare("DELETE FROM comments WHERE article = :id_a");
        $clear_child->bindValue('id_a', $_GET['id_a'], PDO::PARAM_INT);
        $clear_child->execute();

        $delete_a = $bdd->prepare("DELETE FROM article WHERE id_a = :id_a");
        $delete_a->bindValue('id_a', $_GET['id_a'], PDO::PARAM_INT);
        $delete_a->execute();
        header("location:index.php");
      }
    ?>


    <?php
      if(isset($_GET['id_c']))
      {
        $delete = $bdd->prepare("DELETE FROM comments WHERE id_c = :id_c");
        $delete->bindValue('id_c', $_GET['id_c'], PDO::PARAM_INT);
        $delete->execute();

        echo "<meta http-equiv='refresh' content='0;url=article.php?id_a=".$_GET['id_a']."' />";
      }
    ?>

    <footer class="blog-footer">
      <p>
        <a href="#">Back to top</a>
      </p>
    </footer>

  </body>
</html>
