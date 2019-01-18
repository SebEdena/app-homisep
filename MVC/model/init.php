<?php
  function getRegle($regle)
  {
    require("./model/config.php");
    $query = $database -> prepare('select * from regle where nomRegle = ?');
    $query -> bindParam(1,$regle);
    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }

  function Genere_mdp($size)
  {
      $mot_de_passe = "";
      $chiffres = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
      $lettres = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
      $symboles = array(".", "@", "*", "!","?", "-");
      $decalage = 0;
      for($i=0;$i<$size;$i++)
      {
          if (($i + $decalage)%3==0){
              $mot_de_passe .= ($i%2) ? strtoupper($lettres[array_rand($lettres)]) : $lettres[array_rand($lettres)];
          }else if(($i + $decalage)%3==1){
              $mot_de_passe .= $chiffres[array_rand($chiffres)];
          }else{
              $mot_de_passe .= $symboles[array_rand($symboles)];
          }
      }
      return $mot_de_passe;
  }

  function verifyUser($mail)
  {
    require("./model/config.php");
    $res = $database -> prepare('select * from client where client.mail = ?');
    $res -> bindParam(1, $mail);
    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if(is_null($row['mail']))
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  function verifyAdmin($mail)
  {
    require("./model/config.php");
    $res = $database -> prepare('select * from administrateur where administrateur.mail = ?');
    $res -> bindParam(1, $mail);
    $res -> execute();
    $row = $res->fetch(PDO::FETCH_ASSOC);
    if(is_null($row['mail']))
    {
      return false;
    }
    else
    {
      return true;
    }
  }

  function insere_mdp($mdp,$mail)
  {
    require("./model/config.php");
    $res = $database -> prepare('update client set passe = ? where mail = ?');
    $passHash = password_hash($mdp,PASSWORD_DEFAULT);
    $res -> bindParam(1, $passHash);
    $res -> bindParam(2, $mail);
    try
    {
      $res -> execute();
      return true;
    }
    catch(PDOException $exception)
    {
      return false;
    }
  }

  function insere_mdp_admin($mdp,$mail)
  {
    require("./model/config.php");
    $res = $database -> prepare('update administrateur set passe = ? where mail = ?');
    $passHash = password_hash($mdp,PASSWORD_DEFAULT);
    $res -> bindParam(1, $passHash);
    $res -> bindParam(2, $mail);
    try
    {
      $res -> execute();
      return true;
    }
    catch(PDOException $exception)
    {
      return false;
    }
  }

  function send_mail_mdp($mdp,$adresse)
  {
    require("./model/mailConfig.php");
    /* Open the try/catch block. */
    try {
        /* Set the mail sender. */
        $mail->setFrom('homisep@free.fr', "L'équipe Homisep");

        /* Add a recipient. */
        $mail->addAddress($adresse);

        /* Set the subject. */
        $mail->Subject = 'Réinitialisation de mot de passe';

        /* Set the mail message body. */
        $mail->Body = 'Vous avez demandé la réinitialisation de votre mot de passe.</br> Nous vous communiquons votre mot de passe temporaire : ' . $mdp . ' </br> Cordialement </br> Equipe Homisep' ;

        /* Finally send the mail. */
        $mail->send();
    }
    catch (Exception $e)
    {
        /* PHPMailer exception. */
        echo $e->errorMessage();
    }
    catch (\Exception $e)
    {
        /* PHP exception (note the backslash to select the global namespace Exception class). */
        echo $e->getMessage();
    }
  }
?>
