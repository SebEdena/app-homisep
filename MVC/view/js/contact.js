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

function displayContact(){
    displayModal("#modalcontact");
}

$('#contactbutton').onclick = function(){
    displayContact();
};
