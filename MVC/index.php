<?php
  session_start();

  $control = isset($_GET['control'])?$_GET['control']:'page_routing';
  $action = isset($_GET['action'])?$_GET['action']:'page_connexion';

  require ('./controleur/' .  $control . '.php');
  $action();

?>
