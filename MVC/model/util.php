<?php
function traitementCaractereSpeciaux($mot)
{
    return htmlspecialchars($mot);
}
/*
require("./model/mailConfig.php");
require("./model/util.php");
sendMail($dest, $nom, $prenom, $subject, $body);
*/
function sendMail($dest, $nom, $prenom, $subject, $body){
    require_once("./model/mailConfig.php");

    /* Open the try/catch block. */
    try {
        /* Set the mail sender. */
        $mail->setFrom('homisep@free.fr', "L'équipe Homisep");

        /* Add a recipient. */
        $mail->addAddress($dest, $prenom.' '.$nom);
        /* Set the subject. */
        $mail->Subject = $subject;

        /* Set the mail message body. */
        $mail->Body = $body."</br></br>Cordialement,</br>L'équipe Homisep.";

        /* Finally send the mail. */
        $mail->send();
    }
    catch (Exception $e)
    {
        /* PHPMailer exception. */
        echo $e->errorMessage();
    }
    catch (\Exception $e)
    {
        /* PHP exception (note the backslash to select the global namespace Exception class). */
        echo $e->getMessage();
    }

}
?>
