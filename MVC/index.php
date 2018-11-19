<?php
  session_start();

  $control = isset($_GET['control'])?$_GET['control']:'connexionInitialisation';
  $action = isset($_GET['action'])?$_GET['action']:'page_connexion';

  require ('./controller/' .  $control . '.php');
  $action();

?>
