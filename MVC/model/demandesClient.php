<?php

  function getDemandes()
  {
      require('./model/config.php');
      require('./model/classes/client.php');
      $query = $database -> prepare('select * from message');

      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Message');
      return $res;
  }

  function getClientDem($demandeClient){
    require('./model/config.php');
    require('./model/classes/client.php');
    $query = $database -> prepare("select * from client inner join message on "
     . $demandeClient . " = client.idClient;");

    $query -> execute();

    $res = $query->fetchAll(PDO::FETCH_CLASS, 'Client');
    return $res;
  }
?>
