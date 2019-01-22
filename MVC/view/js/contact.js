  /**
   * fonction permettant de placer un message dans la base de données
   * @param event évènement déclancheur
   */
let contactReceived = function(event){
  event.preventDefault();
  $.ajax({
      url: "index.php?control=relationClient&action=setMessage",
      type: "POST",
      dataType: "json",
      data: {
          object: $("#object").val(),
          message: $("#msg").val()
      },
      success: function(retour){
          console.log(retour);
          hideModal();
          alert("Votre demande a bien été prise en compte. Vous recevrez un mail de "
          + "confirmation ainsi que la réponse de l'administrateur sur votre boîte de messagerie associée.");
      },
      error: function(error){
          console.error(error);
          alert("Une erreur est survenue : " + error.message);
      }
  });
}

  /**
   * fonciton permttant d'afficher le modal contact
   */
function displayContact(){
    displayModal("#modalcontact");
}

$('#contactbutton').onclick = function(){
    displayContact();
};

  /**
   * fonction permettant de préparer le mail avant l'envoi par mail d'une accusé de réception
   * @param obj objet du message
   * @param demande texte du message
   * @param mail adresse mail de l'utilisateur
   * @param nom nom de l'utilisateur
   * @param prenom prénom de l'utilisateur
   */
function formMail(obj, demande, mail, nom, prenom){
  $("#labelDemande").text(obj);
  $("#objectDemande").text(demande);
  displayModal("#modalmail");

  $("#sendRep").on('click', function(event) {
    $.ajax({
        url: "index.php?control=relationAdmin&action=sendMessage",
        type: "POST",
        dataType: "json",
        data: {
            object: obj,
            message: demande,
            reponse: $("#msg").val(),
            mail: mail,
            nom : nom,
            prenom: prenom
        },
        success: function(retour){
            console.log(retour);
            hideModal();
            alert("Votre réponse a bien été prise en compte. L'utilisateur "
            + "recevra un mail de sur sa boîte de messagerie associée.");
        },
        error: function(error){
            console.error(error);
            alert("Une erreur est survenue : " + error.message);
        }
    });
    return false;
  });
}
