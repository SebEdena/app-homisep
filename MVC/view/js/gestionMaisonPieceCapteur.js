$("#house-select-gestion").on('change', recupDonneesMaisonGestion);
$("#house-select-gestion").trigger('change');

function recupDonneesMaisonGestion(event)
{
  let idMaison = parseInt(event.target.value);
  if(isNaN(idMaison))
  {
    return;
  }
  console.log(idMaison);

  $.ajax({
      url: "index.php?control=relationClient&action=getInfoMaison",
      type: "POST",
      dataType: "json",
      data: {
          idMaison: idMaison
      },
      success: function(retour){
          console.log(retour[0]);
          afficherInformation("maison",retour[0]);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });

  $.ajax({
      url: "index.php?control=relationClient&action=getDonneesMaison",
      type: "POST",
      dataType: "json",
      data: {
          idMaison: idMaison
      },
      success: function(retour){
          console.log(retour);
          buildPieceGestion(retour.pieces);
          buildCapteurGestion(retour.cemacs);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

function buildPieceGestion(pieces)
{
  if(pieces.length === 0)
  {
    $("#piece").html("<h2>Pas de pièce.</h2>");
  }
  else
  {
    let htmlPiece ="<select id='piece-select-gestion' size=10>";
    for(piece of pieces)
    {
      htmlPiece += "<option value='" + piece.id + "'>" + piece.nom + "</option>";
    }
    htmlPiece += "</select>";
    $("#piece").html(htmlPiece);
    $("#piece-select-gestion").on('change', recupDonneesPieceGestion);
    $("#piece-select-gestion").trigger('change');
  }
}

function buildCapteurGestion(cemacs)
{
  if(cemacs.length === 0)
  {
    $("#cemac").html("<h2>Pas de capteur.</h2>");
  }
  else
  {
    let htmlCemac ="<select id='cemac-select-gestion' size=10>";
    for(cemac of cemacs)
    {
      htmlCemac += "<option value='" + cemac.id + "'>" + cemac.numeroSerie + " - " + cemac.typeCapteur.type + " " + cemac.typeCapteur.libelleGroupBy + "</option>";
    }
    htmlCemac += "</select>";
    $("#cemac").html(htmlCemac);
    $("#cemac-select-gestion").on('change', recupDonneesCapteurGestion);
    $("#cemac-select-gestion").trigger('change');
    mediaQueryGestionMaisonPieceCapteur();
  }
}

function recupDonneesPieceGestion(event)
{
  let idPiece = parseInt(event.target.value);
  if(isNaN(idPiece))
  {
    return;
  }
  console.log(idPiece);

  $.ajax({
      url: "index.php?control=relationClient&action=getInfoPiece",
      type: "POST",
      dataType: "json",
      data: {
          idPiece: idPiece
      },
      success: function(retour){
          console.log(retour);
          afficherInformation("piece",retour[0]);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });

  $.ajax({
      url: "index.php?control=relationClient&action=getDonneesPiece",
      type: "POST",
      dataType: "json",
      data: {
          idPiece: idPiece
      },
      success: function(retour){
          console.log(retour);
          buildCapteurGestion(retour.cemacs);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

function recupDonneesCapteurGestion(event)
{
  let idCapteur = parseInt(event.target.value);
  if(isNaN(idCapteur))
  {
    return;
  }
  console.log(idCapteur);

  $.ajax({
      url: "index.php?control=relationClient&action=getInfoCapteur",
      type: "POST",
      dataType: "json",
      data: {
          idCapteur: idCapteur
      },
      success: function(retour){
          console.log(retour);
          afficherInformation("cemac",retour[0]);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

function afficherInformation($string,$donnees)
{
  switch ($string) {
    case "maison":
      $("#maisonId").data("maison",$donnees);
      document.getElementById("maisonId").value = $donnees.idMaison;
      document.getElementById("maisonAdresse").value = $donnees.adresse;
      document.getElementById("maisonVille").value = $donnees.ville;
      document.getElementById("maisonCodePostal").value = $donnees.codePostal;
      openTab(document.getElementById("tabpage-Maison"));
      mediaQueryGestionMaisonPieceCapteur();
      break;
    case "piece":
      $("#pieceId").data("piece",$donnees);
      document.getElementById("pieceId").value = $donnees.idPiece;
      document.getElementById("pieceNom").value = $donnees.nom;
      document.getElementById("pieceMaison").value = $donnees.adresse + " - " + $donnees.codePostal + " " + $donnees.ville;
      openTab(document.getElementById("tabpage-Piece"));
      mediaQueryGestionMaisonPieceCapteur();
      break;
    case "cemac":
      $("#cemacId").data("cemac",$donnees);
      document.getElementById("cemacId").value = $donnees.idCemac;
      document.getElementById("numSerieCemac").value = $donnees.numeroSerie;
      if($donnees.statut == 0)
      {
        document.getElementById("statusCemac").value = "Hors service";
      }
      else
      {
        document.getElementById("statusCemac").value = "En service";
      }
      document.getElementById("typeCemac").value = $donnees.type;
      document.getElementById("property").value = $donnees.libelleGroupBy;
      document.getElementById("pieceCemac").value = $donnees.nom;
      openTab(document.getElementById("tabpage-Cemac"));
      mediaQueryGestionMaisonPieceCapteur();
    default:
      break;
  }
}

function mediaQueryGestionMaisonPieceCapteur()
{
  try
  {
    if ($(window).width() < 850)
    {
      document.getElementById("piece-select-gestion").size = 1;
      document.getElementById("cemac-select-gestion").size = 1;
    }
    else
    {
      document.getElementById("piece-select-gestion").size = 10;
      document.getElementById("cemac-select-gestion").size = 10;
    }
  }
  catch(error)
  {

  }
}

function deleteFunction($string)
{
  switch ($string)
  {
    case "maison":
      console.log($("#maisonId").data("maison"));
      document.getElementById("maisonId").value = "";
      document.getElementById("maisonAdresse").value = "";
      document.getElementById("maisonVille").value = "";
      document.getElementById("maisonCodePostal").value = "";
      break;
    case "piece":
      console.log($("#pieceId").data("piece"));
      document.getElementById("pieceId").value = "";
      document.getElementById("pieceNom").value = "";
      document.getElementById("pieceMaison").value = "";
      break;
    case "cemac":
      console.log($("#cemacId").data("cemac"));
      document.getElementById("cemacId").value = "";
      document.getElementById("numSerieCemac").value = "";
      document.getElementById("statusCemac").value = "";
      document.getElementById("typeCemac").value = "";
      document.getElementById("property").value = "";
      document.getElementById("pieceCemac").value = "";
      break;
  }
}

function backFunction($string)
{
  console.log($("#"+$string+"Id").data(""+$string+""));
  afficherInformation($string,$("#"+$string+"Id").data(""+$string+""));
}

function validateFunction($string)
{
  switch($string)
  {
    case "maison":
    break;
    case "piece":
    break;
    case "cemac":
    break;
  }
}

$(window).resize(function() {
    mediaQueryGestionMaisonPieceCapteur();
});
