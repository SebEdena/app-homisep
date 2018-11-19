<?php

  session_start();
  require 'config.php';

  $bdd = new DB($db_name, $db_user, $db_pass, $db_host);

  require 'vue/indexVue.html'

?>
