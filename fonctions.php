<?php
  function inscription($login, $email, $mdp, $confirm, $avatar, $bdd)
  {
      if(empty($login) OR empty($email) OR empty($mdp) OR empty($confirm))
      {
        $erreur = "<div class =' alert alert-warning erreur col-lg-3'>Veuillez remplir tous les champs du formulaire</div>";
        return $erreur;
      }
      else
      {
        if($_POST['mdp'] != $_POST['confirm'])
      {
          $erreur = "<div class ='alert alert-warning erreur col-lg-3'>Vos mots de passe ne correspondent pas</div>";
          return $erreur;
        }
        else
        {
          $req = $bdd->prepare("SELECT * FROM user WHERE login = :login");
          $req->execute(array(
            'login'=>$login
          ));
          $resultat = $req->fetch();
          if($resultat)
          {
            $erreur = "<div class ='alert alert-warning erreur col-lg-3'>Le login est déja utilisé</div>";
            return $erreur;
          }
          else
          {
            if(isset($avatar['file']) AND $avatar['file']['error'] == 0)
            {
              if ($avatar['file']['size'] <= 1000000)
              {
                $infosfichier = pathinfo($avatar['file']['name']);
                $extension_upload = $infosfichier['extension'];
                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                  $infosfichier = pathinfo($avatar['file']['name']);
                  $extension_upload = $infosfichier['extension'];
                  $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
                  if (in_array($extension_upload, $extensions_autorisees))
                  {
                    move_uploaded_file($avatar['file']['tmp_name'], 'uploads/' . basename($avatar['file']['name']));

                    $avatar = 'uploads/'.basename($avatar['file']['name']);
                    $crypt = sha1($mdp);

                    $req = $bdd->prepare('INSERT INTO user (id_u, login, email, mdp, lvl, avatar) VALUES(NULL, :login, :email, :mdp, 1, :avatar)');
                    $req->execute(array(
                      'login' => $login,
                      'email' => $email,
                      'mdp' => $crypt,
                      'avatar' =>$avatar
                    ));

                    $_SESSION['id'] = $bdd->lastInsertId(); ;
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['avatar'] = $avatar;
                    $_SESSION['lvl'] = 1;
                    header("Location:index.php");

                    $message = "<div class ='alert alert-success erreur col-lg-3'> Vous êtes maintenant inscrit</div>";
                    return $message;
                  }
                  else
                  {
                    $erreur = "<div class ='alert alert-warning erreur col-lg-3'>Format incorrect</div>";
                    return $erreur;
                  }
                }
                else
                {
                  $erreur = "<div class ='alert alert-warning erreur col-lg-3'>Format incorrect</div>";
                  return $erreur;
                }
              }
              else
              {
                $erreur = "<div class ='alert alert-warning erreur col-lg-3'>Fichier trop volumineux</div>";
                return $erreur;
              }
            }
            else
            {
              $erreur = "<div class ='alert alert alert-warning erreur col-lg-3'>Veuillez sélectionnez un fichier</div>";
              return $erreur;
            }
          }
        }
      }
  }
?>

<!-- ====================================================================================================================================================== -->

<?php
  function login($login, $mdp, $bdd)
  {
    if(empty($login) OR empty($mdp))
    {
      $erreur = "<div class =' alert alert-warning erreur col-lg-3'>Veuillez remplir tous les champs du formulaire.</div>";
      return $erreur;
    }
    else
    {
      $req = $bdd -> prepare("SELECT * FROM user WHERE login = :login AND mdp = :mdp");
      $req->execute(array(
        'login'=>$login,
        'mdp'=>sha1($mdp)
        ));
      $resultat=$req->fetch();

      if (!$resultat)
      {
        $erreur = "<div class =' alert alert-warning erreur col-lg-3'>Mauvais identifiant ou mot de passe !</div>";
        return $erreur;
      }
      else
      {
        $_SESSION['id'] = $resultat['id_u'];
        $_SESSION['login'] = $resultat['login'];
        $_SESSION['lvl'] = $resultat['lvl'];
        $_SESSION['avatar'] = $resultat['avatar'];
        header("Location:index.php");
      }
    }
  }
?>

<!-- ====================================================================================================================================================== -->

<?php
  function update_email($email, $id_u, $bdd)
  {
    if(empty($email))
    {
      $erreur = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Veuillez saisir une adresse email</div>";
      return $erreur;
    }
    else
    {
      $req = $bdd->prepare("UPDATE user set email = :email WHERE id_u = :id_u");
      $req->bindValue('email', $email, PDO::PARAM_STR);
      $req->bindValue('id_u', $id_u, PDO::PARAM_INT);
      $req->execute();

      $message = "<div class='alert alert-success col-lg-offset-4 col-lg-3'> Email modifié ! </div>";
      return $message;
    }
  }
?>

<!-- ====================================================================================================================================================== -->

<?php
  function update_mdp($oldmdp, $mdp, $confirm, $id, $bdd)
  {
    $req = $bdd->prepare("SELECT mdp FROM user WHERE id_u = :id_u");
    $req->bindValue('id_u', $id, PDO::PARAM_INT);
    $req->execute();
    $reponse = $req->fetch();

    $current_mdp = $reponse['mdp'];

    if(empty($oldmdp) OR empty($mdp) OR empty($confirm))
    {
      echo "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Veuillez remplir tous les champs</div>";
    }
    else
    {
      if(sha1($oldmdp) != $current_mdp)
      {
        echo "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Mot de passe incorrect</div>";
      }
      else
      {
        if($mdp != $confirm)
        {
          echo "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Les mots de passe ne correspondent pas</div>";
        }
        else
        {
          $cryptmdp = sha1($mdp);
          $req = $bdd->prepare("UPDATE user set mdp = :mdp WHERE id_u = :id_u");
          $req->bindValue('mdp', $cryptmdp, PDO::PARAM_STR);
          $req->bindValue('id_u', $id, PDO::PARAM_INT);
          $req->execute();

          $message = "<div class='alert alert-success col-lg-offset-4 col-lg-3'> Mot de passe modifié !";
          return $message;
        }
      }
    }
  }
?>

<!-- ====================================================================================================================================================== -->

<?php
  function update_avatar($avatar, $id, $bdd)
  {
    if (isset($avatar['file']) AND $avatar['file']['error'] == 0)
    {
      if ($avatar['file']['size'] <= 1000000)
      {
        $infosfichier = pathinfo($avatar['file']['name']);
        $extension_upload = $infosfichier['extension'];
        $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
        if (in_array($extension_upload, $extensions_autorisees))
        {
          $infosfichier = pathinfo($avatar['file']['name']);
          $extension_upload = $infosfichier['extension'];
          $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png');
          if (in_array($extension_upload, $extensions_autorisees))
          {
            move_uploaded_file($avatar['file']['tmp_name'], 'uploads/' . basename($avatar['file']['name']));

            $avatar = 'uploads/'.basename($avatar['file']['name']);

            $req = $bdd->prepare('UPDATE user SET avatar = :avatar WHERE id_u = :id_u');
            $req->bindValue('avatar', $avatar, PDO::PARAM_STR);
            $req->bindValue('id_u', $id, PDO::PARAM_INT);
            $req->execute();

            $message = "<div class='alert alert-success col-lg-offset-4 col-lg-3'> Avatar modifié !";
            return $message;
          }
          else
          {
            $erreur = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Format incorrect</div>";
            return $erreur;
          }
        }
        else
        {
          $erreur = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Format incorrect</div>";
          return $erreur;
        }
      }
      else
      {
        $erreur = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Fichier trop volumineux</div>";
        return $erreur;
      }
    }
    else
    {
      $erreur = "<div class='alert alert-warning col-lg-offset-4 col-lg-3'>Sélectionnez un fichier</div>";
      return $erreur;
    }
  }
?>

<!-- =============================================================================================================================== -->

<?php
  function select($name, $values){
    $html = "<select class = 'form-control' name='$name' id='$name'>";
    foreach($values as $value){
      $html .="<option value='$value'>$value</option>";
    }
    $html .="</select>";

    return $html;
  }
?>

<!-- =============================================================================================================================== -->

<?php
  // $pdo = dbConnect();
  //
  // $userIp = $_SERVER['REMOTE_ADDR'];
  // $limite = $pdo->query("SELECT * ban WHERE ip = '$userip'")->fetch(PDO::FETCH_ASSOC)['limite'];
  //
  // $isStillBanned = strtotime($limite) > strtotime(time()- 60*5);
  // if(isStillBanned){
  //   unset($_SESSION['nbFailedAuth']);
  //   $pdo->query("DELETE FROM ban WHERE ip = '$userIp' ");
  // }else{
  //   die('Vous êtes ban !');
  // }
  //
  // if($_POST){
  //
  //   $login = htmlentities($_POST['login']);
  //   $mdp = sha1($_POST['mdp']);
  //
  //   $req = $pdo->prepare("SELECT COUNT(*) as nb FROM user WHERE login = :login AND mdp = :mdp");
  //   $req->execute([$login, $mdp]);
  //   $has = $req->fecth(PDO::FETCH_ASSOC)['nb'];
  //   if($has){
  //     header('Location: profil.php');
  //     die();
  //   }
  //   else{
  //     if(!isset($_SESSION['nbFailedAuth'])){
  //       $_SESSION['nbFailedAuth'] = 1;
  //     }
  //     else{
  //       $_SESSION['nbFailedAuth'] += 1;
  //     }
  //
  //     if($_SESSION['nbFailedAuth'] > 3)
  //     {
  //       $pdo->query("INSERT INTO ban (ip) VALUES ('userIP')");
  //     }
  //   }
  // }
?>
