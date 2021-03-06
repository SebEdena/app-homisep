$("#house-select-gestion").on('change', recupDonneesMaisonGestion);
$("#house-select-gestion").trigger('change');

$("#house-select-gestion").on('load', recupDonneesMaisonGestion);
$("#house-select-gestion").trigger('load');

$("#house-select-gestion").on('click', recupDonneesMaisonGestion);
$("#house-select-gestion").trigger('click');

  /**
   * fonction permettant de charger les sélecteurs des maisons, des pièces et des CeMacs
   * @param event évènement déclancheur
   */
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
  eraseFunction("piece");
  eraseFunction("cemac");
  recupererOptionsMaison(0);
  recupererOptionsPiece(0);
  recupererOptionsTypeCemac(0);
}

  /**
   * fonciton permettant de créer les options dans le sélecteur
   * @param pieces données des pièces
   */
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

  /**
   * fonction permettant de créer les options dans le sélecteur
   * @param cemacs données des CeMacs
   */
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

  /**
   * fonction permettant de charger les sélecteurs des pièces et des CeMacs
   * @param event évènement déclancheur
   */
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
  eraseFunction("cemac");
}

  /**
   * fonction permettant de charger les sélecteurs des CeMacs
   * @param event évènement déclancheur
   */
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

  /**
   * fonction permettant d'afficher les informations dans la fenêtre de formulaire à droite
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit placer les données
   * @param $donnees données présentes
   */
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
      if($donnees.maisonPrincipale == 1)
      {
        $("#maisonPrincipale").prop('checked', true);
      }
      else
      {
        $("#maisonPrincipale").prop('checked', false);
      }
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
      $("#pieceMaison").html("<option value=" + $donnees.idMaison + ">" + $donnees.adresse + " - " + $donnees.codePostal + " " + $donnees.ville + "</option>");
      recupererOptionsMaison($donnees.idMaison);
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
      $("#typeCemac").html("<option value=" + $donnees.idTypeCapteur + ">" + $donnees.type + " - " + $donnees.libelleGroupBy + "</option>");
      recupererOptionsTypeCemac($donnees.idTypeCapteur);
      $("#pieceCemac").html("<option value=" + $donnees.idPiece + ">" + $donnees.nom + "</option>");
      recupererOptionsPiece($donnees.idPiece);
      openTab(document.getElementById("tabpage-Cemac"));
      mediaQueryGestionMaisonPieceCapteur();
      break;
    }
  }
}

  /**
   * fonction permettant d'adapteur les sélecteurs en fonction de la taille de l'écran
   */
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

  /**
   * fonciton permettant d'effacer les données du formulaire
   * @param $string chaine de caractère permttant de définir dans quelle infobulle on doit effacer les données
   */
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
      $("#maisonPrincipale").prop('checked',false);
      break;
    }
    case "piece":
    {
      console.log($("#pieceId").data("piece"));
      document.getElementById("pieceId").value = "";
      document.getElementById("pieceNom").value = "";
      break;
    }
    case "cemac":
    {
      console.log($("#cemacId").data("cemac"));
      document.getElementById("cemacId").value = "";
      document.getElementById("numSerieCemac").value = "";
      document.getElementById("statusCemac").value = "";
      break;
    }
  }
}

  /**
   * fonction permettant de récupérer les informations effacées de l'infobulle
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit placer les données
   */
function backFunction($string)
{
  console.log($("#"+$string+"Id").data(""+$string+""));
  afficherInformation($string,$("#"+$string+"Id").data(""+$string+""));
}

  /**
   * fonction permettant de récupérer de savoir si l'utilisateur souhaite créer une nouvelle entité ou modifier une entité
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit récupérer les données
   */
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

  /**
   * fonction permettant de créer une nouvelle entité dans la base de données
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit récupérer les données
   */
function nouveauFunction($string)
{
  if(verifierChamp($string))
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
                  codePostal : $("#maisonCodePostal").val(),
                  maisonPrincipale : document.getElementById("maisonPrincipale").checked
                },
                success: function(retour){
                    //console.log(retour);
                    if(retour)
                    {
                      alert("La maison a été créée");
                      reloadMaison();
                      reloadPiece();
                      reloadCemac();
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
                idMaison : $("#pieceMaison").val()
              },
              success: function(retour){
                  //console.log(retour);
                  if(retour)
                  {
                    alert("La pièce a été créée");
                    reloadPiece();
                    reloadCemac();
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
        if(confirm("Voulez vous créer un nouveau CeMac avec comme numéro de série : " + $("#numSerieCemac").val()))
        {
          $.ajax({
              url: "index.php?control=relationClient&action=creerNouveauCemac",
              type: "POST",
              dataType: "json",
              data: {
                idPiece : $("#pieceCemac").val(),
                numSerieCemac : $("#numSerieCemac").val(),
                typeCemac : $("#typeCemac").val()
              },
              success: function(retour){
                  //console.log(retour);
                  if(retour)
                  {
                    alert("Le CeMac a été créé");
                    reloadCemac();
                  }
                  else
                  {
                    alert("Le CeMac n'a pas été créé");
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
    }
  }
}

  /**
   * fonction permettant de modifier une entité dans la base de données
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit récupérer les données
   */
function modifierFunction($string)
{
  if(verifierChamp($string))
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
                  codePostal : $("#maisonCodePostal").val(),
                  maisonPrincipale : document.getElementById("maisonPrincipale").checked
                },
                success: function(retour){
                    //console.log(retour);
                    if(retour)
                    {
                      alert("La maison a été modifiée");
                      reloadMaison();
                      reloadPiece();
                      reloadCemac();
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
                idMaison : $("#pieceMaison").val()
              },
              success: function(retour){
                  //console.log(retour);
                  if(retour)
                  {
                    alert("La piece a été modifiée");
                    reloadPiece();
                    reloadCemac();
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
        if(confirm("Voulez vous modifier le cemac ?"))
        {
          $.ajax({
              url: "index.php?control=relationClient&action=modifierCemac",
              type: "POST",
              dataType: "json",
              data: {
                id : $("#cemacId").val(),
                numSerieCemac : $("#numSerieCemac").val(),
                typeCemac : $("#typeCemac").val(),
                idPiece : $("#pieceCemac").val()
              },
              success: function(retour){
                  //console.log(retour);
                  if(retour)
                  {
                    alert("Le Cemac a été modifié");
                    reloadCemac();
                  }
                  else
                  {
                    alert("Le Cemac n'a pas été modifié");
                  }
              },
              error: function(error){
                  console.error(error);
                  alert("Une erreur est survenue : " + error.message);
              }
          });
        }
      }
    }
  }
}

  /**
   * fonction permttant de récupérer les types de capteur sauf celui qui est présent dans l'infobulle
   * @param $idTypeCapteur identifiant du type de capteur déjà présent dans l'infobulle
   */
function recupererOptionsTypeCemac($idTypeCapteur)
{
  console.log($idTypeCapteur);
  $.ajax({
      url: "index.php?control=relationClient&action=recupererTypeCapteur",
      type: "POST",
      dataType: "json",
      data: {
        id : $idTypeCapteur
      },
      success: function(retour){
          console.log(retour);
          if(retour)
          {
            if($idTypeCapteur == 0)
            {
              let html = "";
              for(type of retour)
              {
                html += ("<option value="+ type.idTypeCapteur + ">" + type.type + " - " + type.libelleGroupBy + "</option>");
              }
              $("#typeCemac").html(html);
            }
            else {
              for(type of retour)
              {
                $("#typeCemac").append("<option value="+ type.idTypeCapteur + ">" + type.type + " - " + type.libelleGroupBy + "</option>");
              }
            }
          }
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

  /**
   * fonction permttant de récupérer les pièces sauf celle qui est présente dans l'infobulle
   * @param $idPiece identifiant de la pièce déjà présente dans l'infobulle
   */
function recupererOptionsPiece($idPiece)
{
  console.log($idPiece);
  $.ajax({
      url: "index.php?control=relationClient&action=recupererOptionsPiece",
      type: "POST",
      dataType: "json",
      data: {
        idMaison : $("#house-select-gestion").val(),
        idPiece : $idPiece
      },
      success: function(retour){
          console.log(retour);
          if(retour)
          {
            if($idPiece == 0)
            {
              let html = "";
              for(piece of retour)
              {
                html += ("<option value="+ piece.idPiece + ">" + piece.nom + "</option>");
              }
              $("#pieceCemac").html(html);
            }
            else
            {
              for(piece of retour)
              {
                $("#pieceCemac").append("<option value="+ piece.idPiece + ">" + piece.nom + "</option>");
              }
            }
          }
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

  /**
   * fonction permttant de récupérer les maisons sauf celle qui est présente dans l'infobulle
   * @param $idMaison identifiant de la maison déjà présente dans l'infobulle
   */
function recupererOptionsMaison($idMaison)
{
  console.log();
  $.ajax({
      url: "index.php?control=relationClient&action=recupererOptionsMaison",
      type: "POST",
      dataType: "json",
      data: {
        idMaison : $idMaison
      },
      success: function(retour){
          console.log(retour);
          if(retour)
          {
            if($idMaison == 0)
            {
              let html = "";
              for(maison of retour)
              {
                html += ("<option value="+ maison.idMaison + ">" + maison.adresse + " " + maison.ville + " " + maison.codePostal + "</option>");
              }
              $("#pieceMaison").html(html);
            }
            else {
              $("#pieceMaison").append("<option value="+ maison.idMaison + ">" + maison.adresse + " " + maison.ville + " " + maison.codePostal + "</option>");
            }
          }
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

  /**
   * fonction permettant de supprimer une entité dans la base de données
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit récupérer les données
   */
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
                  reloadPiece();
                  reloadCemac();
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
                  reloadCemac();
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
      if(confirm("Voulez vous supprimer le Cemac " + $("#numSerieCemac").val()))
      console.log($("#pieceId").val());
      {
        $.ajax({
            url: "index.php?control=relationClient&action=supprimerCemac",
            type: "POST",
            dataType: "json",
            data: {
              id : $("#cemacId").val()
            },
            success: function(retour){
                //console.log(retour);
                if(retour)
                {
                  alert("Le Cemac a été supprimé");
                  reloadCemac();
                  eraseFunction("cemac");
                }
                else
                {
                  alert("Le Cemac n'a pas été supprimé");
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
  }
}

function hideMessage()
{
  $("#message").css("display","none");
}

$(window).resize(function() {
    mediaQueryGestionMaisonPieceCapteur();
});

  /**
   * fonction permettant de récupérer les maisons pour le sélecteur
   */
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

  /**
   * fonction permettant de récupérer les pièces pour le sélecteur
   */
function reloadPiece()
{
  if(($("#house-select-gestion").prop("selectedIndex", 0).val()) === undefined){
    return;
  }
  else {
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
            $("#piece-select-gestion").html(buildHtml);
        },
        error: function(error){
            console.error(error);
            alert("Une erreur est survenue : " + error.message);
        }
    });
  }
}

  /**
   * fonction permettant de récupérer les CeMacs pour le sélecteur
   */
function reloadCemac()
{
  if(($("#piece-select-gestion").prop("selectedIndex", 0).val()) === undefined)
  {
    return;
  }
  else {
    $("#cemac-select-gestion").html("");
    if($("#piece-select-gestion").val() === null)
    {
      $("#piece-select-gestion option").each(function(index)
      {
          if($("#piece-select-gestion").prop("selectedIndex", index).val() !== undefined)
          {
            callReloadCemacAjax($("#piece-select-gestion").prop("selectedIndex", index).val());
          }
      });
    }
    else
    {
      callReloadCemacAjax($("#piece-select-gestion").val());
    }
  }
}

  /**
   * fonction permttant de récupérer les CeMacs et de le placer dans le sélecteur
   * @param $value identifiant du cemac
   */
function callReloadCemacAjax($value)
{
  $.ajax({
      url: "index.php?control=relationClient&action=reloadCemac",
      type: "POST",
      dataType: "json",
      data: {
        id : $value
      },
      success: function(retour){
          console.log(retour);
          if(retour)
          {
            let buildHtml = "";
            for(cemac of retour.cemac)
            {
              console.log(cemac);
              buildHtml += "<option value='"+cemac.idCemac+"'>"+ cemac.numeroSerie + " - " + cemac.type + " " + cemac.libelleGroupBy + "</option>";
            }
            $("#cemac-select-gestion").append(buildHtml);
          }
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

  /**
   * fonction permettant de vérifier les champs de l'infobulle
   * @param $string chaine de caractère permettant de définir dans quelle infobulle on doit placer les données
   */
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
      if(document.getElementById("pieceNom").value == "" || document.getElementById("pieceMaison").value == "")
      {
        alert("Veuillez remplir le champ Nom");
        return false;
      }
      else
      {
        return true;
      }
    }
    case "cemac" :
    {
      if(document.getElementById("numSerieCemac").value == "" || document.getElementById("typeCemac").value == "" || document.getElementById("pieceCemac").value == "")
      {
        alert("Veuillez remplir le champ numéro de série et choissisez une pièce");
        return false;
      }
      else
      {
        return true;
      }
    }
  }
}
