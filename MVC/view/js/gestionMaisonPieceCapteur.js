$("#house-select-gestion").on('change', recupDonneesMaisonGestion);
$("#house-select-gestion").trigger('change');

$("#house-select-gestion").on('load', recupDonneesMaisonGestion);
$("#house-select-gestion").trigger('load');

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
    {
      $("#maisonId").data("maison",$donnees);
      document.getElementById("maisonId").value = $donnees.idMaison;
      document.getElementById("maisonAdresse").value = $donnees.adresse;
      document.getElementById("maisonVille").value = $donnees.ville;
      document.getElementById("maisonCodePostal").value = $donnees.codePostal;
      openTab(document.getElementById("tabpage-Maison"));
      mediaQueryGestionMaisonPieceCapteur();
      break;
    }
    case "piece":
    {
      $("#pieceId").data("piece",$donnees);
      document.getElementById("pieceId").value = $donnees.idPiece;
      document.getElementById("pieceNom").value = $donnees.nom;
      document.getElementById("pieceMaison").value = $donnees.adresse + " - " + $donnees.codePostal + " " + $donnees.ville;
      openTab(document.getElementById("tabpage-Piece"));
      mediaQueryGestionMaisonPieceCapteur();
      break;
    }
    case "cemac":
    {
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
      break;
    }
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

function eraseFunction($string)
{
  switch ($string)
  {
    case "maison":
    {
      console.log($("#maisonId").data("maison"));
      document.getElementById("maisonId").value = "";
      document.getElementById("maisonAdresse").value = "";
      document.getElementById("maisonVille").value = "";
      document.getElementById("maisonCodePostal").value = "";
      break;
    }
    case "piece":
    {
      console.log($("#pieceId").data("piece"));
      document.getElementById("pieceId").value = "";
      document.getElementById("pieceNom").value = "";
      document.getElementById("pieceMaison").value = "";
      break;
    }
    case "cemac":
    {
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
}

function backFunction($string)
{
  console.log($("#"+$string+"Id").data(""+$string+""));
  afficherInformation($string,$("#"+$string+"Id").data(""+$string+""));
}

function validateFunction($string)
{
  if($("#"+$string+"Id").val() == "")
  {
    nouveauFunction($string);
  }
  else
  {
    modifierFunction($string);
  }
}

function nouveauFunction($string)
{
  switch($string)
  {
    case "maison":
    {
      if(verifierChamp($string))
      {
        if(confirm("Voulez vous créer une nouvelle maison se situant au " + $("#maisonAdresse").val() + " dans la ville de " + $("#maisonVille").val()))
        {
          $.ajax({
              url: "index.php?control=relationClient&action=creerNouvelleMaison",
              type: "POST",
              dataType: "json",
              data: {
                adresse : $("#maisonAdresse").val(),
                ville : $("#maisonVille").val(),
                codePostal : $("#maisonCodePostal").val()
              },
              success: function(retour){
                  //console.log(retour);
                  if(retour)
                  {
                    alert("La maison a été créée");
                    reloadMaison();
                  }
                  else
                  {
                    alert("La maison n'a pas été créée");
                  }
              },
              error: function(error){
                  console.error(error);
                  alert("Une erreur est survenue : " + error.message);
              }
          });
        }
      }
      break;
    }
    case "piece":
    {
      if(confirm("Voulez vous créer une nouvelle pièce se nommant " + $("#pieceNom").val() + " dans la maison"))
      {
        $.ajax({
            url: "index.php?control=relationClient&action=creerNouvellePiece",
            type: "POST",
            dataType: "json",
            data: {
              nom : $("#pieceNom").val(),
              idMaison : $("#house-select-gestion").val()
            },
            success: function(retour){
                //console.log(retour);
                if(retour)
                {
                  alert("La pièce a été créée");
                  reloadPiece();
                }
                else
                {
                  alert("La pièce n'a pas été créée");
                }
            },
            error: function(error){
                console.error(error);
                alert("Une erreur est survenue : " + error.message);
            }
        });
      }
      break;
    }
    case "cemac":
    {
      console.log("no implemented nouveau cemac");
      break;
    }
  }
}

function modifierFunction($string)
{
  switch($string)
  {
    case "maison":
    {
      if(verifierChamp($string))
      {
        if(confirm("Voulez vous modifier l'adresse de la maison pour : " + $("#maisonAdresse").val() + " dans la ville de " + $("#maisonVille").val()))
        {
          $.ajax({
              url: "index.php?control=relationClient&action=modifierMaison",
              type: "POST",
              dataType: "json",
              data: {
                id : $("#maisonId").val(),
                adresse : $("#maisonAdresse").val(),
                ville : $("#maisonVille").val(),
                codePostal : $("#maisonCodePostal").val()
              },
              success: function(retour){
                  //console.log(retour);
                  if(retour)
                  {
                    alert("La maison a été modifiée");
                    reloadMaison();
                  }
                  else
                  {
                    alert("La maison n'a pas été modifiée");
                  }
              },
              error: function(error){
                  console.error(error);
                  alert("Une erreur est survenue : " + error.message);
              }
          });
        }
      }
      break;
    }
    case "piece":
    {
      if(confirm("Voulez vous modifier la pièce en " + $("#pieceNom").val()))
      {
        $.ajax({
            url: "index.php?control=relationClient&action=modifierPiece",
            type: "POST",
            dataType: "json",
            data: {
              id : $("#pieceId").val(),
              nom : $("#pieceNom").val(),
            },
            success: function(retour){
                //console.log(retour);
                if(retour)
                {
                  alert("La piece a été modifiée");
                  reloadPiece();
                }
                else
                {
                  alert("La piece n'a pas été modifiée");
                }
            },
            error: function(error){
                console.error(error);
                alert("Une erreur est survenue : " + error.message);
            }
        });
      }
      break;
    }
    case "cemac":
    {
      console.log("no implemented modifier cemac");
      break;
    }
  }
}

function deleteFunction($string)
{
  switch($string)
  {
    case "maison":
    {
      if(confirm("Voulez vous supprimer la maison se situant au " + $("#maisonAdresse").val() + " dans la ville de " + $("#maisonVille").val()))
      console.log($("#maisonId").val());
      {
        $.ajax({
            url: "index.php?control=relationClient&action=supprimerMaison",
            type: "POST",
            dataType: "json",
            data: {
              id : $("#maisonId").val()
            },
            success: function(retour){
                //console.log(retour);
                if(retour)
                {
                  alert("La maison a été supprimée");
                  reloadMaison();
                  eraseFunction("maison");
                }
                else
                {
                  alert("La maison n'a pas été supprimée");
                }
            },
            error: function(error){
                console.error(error);
                alert("Une erreur est survenue : " + error.message);
            }
        });
      }
      break;
    }
    case "piece":
    {
      if(confirm("Voulez vous supprimer la pièce " + $("#pieceNom").val()))
      console.log($("#pieceId").val());
      {
        $.ajax({
            url: "index.php?control=relationClient&action=supprimerPiece",
            type: "POST",
            dataType: "json",
            data: {
              id : $("#pieceId").val()
            },
            success: function(retour){
                //console.log(retour);
                if(retour)
                {
                  alert("La pièce a été supprimée");
                  reloadPiece();
                  eraseFunction("piece");
                }
                else
                {
                  alert("La pièce n'a pas été supprimée");
                }
            },
            error: function(error){
                console.error(error);
                alert("Une erreur est survenue : " + error.message);
            }
        });
      }
      break;
    }
    case "cemac":
    {
      console.log("no implemented supprimer cemac");
      break;
    }
  }
}

function hideMessage()
{
  $("#message").css("display","none");
}

$(window).resize(function() {
    mediaQueryGestionMaisonPieceCapteur();
});

function reloadMaison()
{
  $.ajax({
      url: "index.php?control=relationClient&action=reloadMaison",
      type: "POST",
      dataType: "json",
      success: function(retour){
          console.log(retour.maison);
          let buildHtml = "";
          for(maison of retour.maison)
          {
            buildHtml += "<option value='"+maison.idMaison+"'>"+ maison.adresse + " - " + maison.ville + " - " + maison.codePostal + "</option>";
          }
          $("#house-select-gestion").html(buildHtml);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

function reloadPiece()
{
  $.ajax({
      url: "index.php?control=relationClient&action=reloadPiece",
      type: "POST",
      dataType: "json",
      data : {
        idMaison : $("#house-select-gestion").val()
      },
      success: function(retour){
          console.log(retour.piece);
          let buildHtml = "";
          for(piece of retour.piece)
          {
            console.log(piece);
            buildHtml += "<option value='"+piece.idPiece+"'>"+ piece.nom + "</option>";
          }
          $("#piece-select-gestion").append(buildHtml);
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

function verifierChamp($string)
{
  switch($string)
  {
    case "maison" :
    {
      if(document.getElementById("maisonAdresse").value == "" ||
      document.getElementById("maisonVille").value == "" ||
      document.getElementById("maisonCodePostal").value == "")
      {
        alert("Veuillez remplir les champs vides");
        return false;
      }
      else
      {
        return true;
      }
    }
    case "piece" :
    {
      if(document.getElementById("pieceNom").value == "")
      {
        return false;
      }
      else
      {
        return true;
      }
    }
    case "capteur" :
    {
      console.log("no implemented supprimer cemac");
      return null;
    }
  }
}
