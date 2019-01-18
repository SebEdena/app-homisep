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

function displayContact(){
    displayModal("#modalcontact");
}

$('#contactbutton').onclick = function(){
    displayContact();
};
