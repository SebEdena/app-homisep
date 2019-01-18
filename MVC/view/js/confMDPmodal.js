function validate(event) {
  var mdp1 = document.getElementById("pass").value;
  var mdp2 = document.getElementById("confirm_pass").value;

  if (mdp1 != mdp2)
  {
    alert("Les mots de passe ne correspondent pas. Réessayer.");
    event.preventDefault();
    return false;
  }
  else {
    document.inscr.submit();
  }
}
