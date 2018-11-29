function validate(event) {
   var a = document.getElementById("pass").value;
   var b = document.getElementById("confirm_pass").value;
   if (a!=b)
   {
     alert("Les mots de passe ne correspondent pas. Réessayer.");
     event.preventDefault();
   }
   else {
     document.inscr.submit();
  }
}
