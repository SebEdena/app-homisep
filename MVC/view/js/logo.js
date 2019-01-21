  /**
   * fonction permettant de revenir vers la page d'accueil en cliquant sur le logo
   */
$(".logo").click(function(){
  window.location.replace("index.php?control=controleurGenerique&action=afficherAccueil");
});
