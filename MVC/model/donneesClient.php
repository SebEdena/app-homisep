<?php

  function getClients()
  {
      require('./model/config.php');
      require_once('./model/classes/client.php');
      $query = $database -> prepare('select * from client');

      $query -> execute();

      $res = $query->fetchAll(PDO::FETCH_CLASS, 'Client');
      return $res;
  }
?>
