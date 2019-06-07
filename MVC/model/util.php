<?php
  /**
   * fonction permettant le traitement des caractères spéciaux
   * @param $mot le mot à traiter
   * @return retourne le mot à traiter
   */
  function traitementCaractereSpeciaux($mot){
      return htmlspecialchars($mot);
  }

  /**
   * fonction permettant l'envoi d'un accusé de réception pour l'utilisateur
   * @param $dest l'adresse mail de l'Utilisateur
   * @param $nom nom de l'utilisateur
   * @param $prenom prénom de l'utilisateur
   * @param $subject le sujet du message
   * @param $body le texte du mail
   */
  function sendMail($dest, $nom, $prenom, $subject, $body){
      require_once("./model/mailConfig.php");
      try {
          $mail->setFrom('homisep@free.fr', "L'équipe Homisep");
          $mail->addAddress($dest, $prenom.' '.$nom);
          $mail->Subject = $subject;
          $mail->Body = $body."</br></br>Cordialement,</br>L'équipe Homisep.";
          $mail->send();
      }
      catch (Exception $e){
          echo $e->errorMessage();
      }
      catch (\Exception $e){
          echo $e->getMessage();
      }
  }

  function translateCeMacToServer($donnees){
      switch($donnees)
      {
          case "5":
              return "1";
          case "3":
              return "4";
          default:
              return "0";
      }
  }

  function translateServerToCeMac($donnees)
  {
      switch($donnees)
      {
          case "4":
              return "3";
          case "1":
              return "5";
          case "6":
              return "a";
          default:
              return "0";
      }
  }
?>
