<?php

  function getDemandes()
  {
      require('./model/config.php');
      require_once('./model/classes/message.php');
      $query = $database -> prepare('select * from message');

      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Message');
      return $res;
  }

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
