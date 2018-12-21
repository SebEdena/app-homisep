<?php
function traitementCaractereSpeciaux($mot)
{
    return htmlspecialchars($mot);
}

function sendMail(){
    require("./model/mailConfig.php");

    /* Open the try/catch block. */
    try {
        /* Set the mail sender. */
        $mail->setFrom('homisep@free.fr', "L'équipe Homisep");

        /* Add a recipient. */
        $mail->addAddress('sebastien.viguier@isep.fr', 'Sébastien Viguier');

        /* Set the subject. */
        $mail->Subject = 'Force';

        /* Set the mail message body. */
        $mail->Body = 'There is a great disturbance in the Force.';

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
