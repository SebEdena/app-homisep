<?php

  /**
   * fonction permettant de récupérer les messages des clients
   * @return retourne la liste des messages
   */
  function getDemandes(){
      require('./model/config.php');
      require_once('./model/classes/message.php');
      $query = $database -> prepare('select * from message');

      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Message');
      return $res;
  }

  /**
   * fonction permettant de récupérer la dernière demande d'un client
   * @param $demandeIdClient l'identifiant du client
   * @return retourne le dernier message du client
   */
  function getClientDem($demandeIdClient){
    require('./model/config.php');
    require_once('./model/classes/client.php');
    $query = $database -> prepare("select * from client inner join message on "
     . $demandeIdClient . " = client.idClient LIMIT 1;");

    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_CLASS, 'Client');
    return $res[0];
  }
?>
