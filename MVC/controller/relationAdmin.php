<?php
  function deconnexion()
  {
    session_destroy();
    require("./view/indexVue.tpl");
  }
?>
