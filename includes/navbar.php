<?php session_start(); ?>

<nav class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="navbar-header">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          <a class="navbar-brand" href="index.php">Blog Vincent</a>
        </div>
      <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <?php
              if(!isset($_SESSION['id']))
              {
            ?>
              <li><a href="sign.php">S'inscrire</a></li>
              <li><a href="login.php">Se connecter</a></li>
              <?php } ?>
            <?php
              if(isset($_SESSION['id']))
              { ?>
                <li><a href="publish.php">Publier</a></li> <?php
              }
            ?>
          </ul>
          <div class="search">
            <form class="navbar-form navbar-right inline-form" action="index.php" method="post">
              <div class="form-group">
                <input type="search" class="input-sm form-control" placeholder="Recherche" name="search">
                <button type="submit" class="btn btn-primary btn-sm" name="submit_search"><span class="glyphicon glyphicon-eye-open"></span> Chercher</button>
              </div>
            </form>
          </div>
        </div><!-- /.nav-collapse -->
      </div>
      <?php if(isset($_SESSION['id']) AND isset($_SESSION['login']))
      { ?>
        <div class="col-lg-3 col-lg-push-4">
          <div class="row">
            <div class="col-lg-3">
              <img class ="avatar" src=<?php echo $_SESSION['avatar']; ?> />
            </div>
            <div class="col-lg-6">
              <?php echo "<a href='profile.php?id_u=".$_SESSION['id']."'>"; ?><p class="connected"> <?php echo $_SESSION['login']; ?> </p></a>
              <a href="logout.php" class="connected"> Se deconnecter </a>
            </div>
          </div>
        </div>
    <?php } ?>
    </div>
  </div><!-- /.container -->
</nav><!-- /.navbar -->
