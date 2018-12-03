function validate(event) {
    var a = document.getElementById("pass").value;
    var b = document.getElementById("confirm_pass").value;
    if (a!=b)
    {
        event.preventDefault();
        alert("Les mots de passe ne correspondent pas. Réessayer.");
        return false;
    }
    return true;
}
