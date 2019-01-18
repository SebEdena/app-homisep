<?php
function traitementCaractereSpeciaux($mot)
{
    return htmlspecialchars($mot);
}
/*
require("./model/mailConfig.php");
require("./model/util.php");
sendMail();
*/
function sendMail(){
    require("./model/mailConfig.php");

    /* Open the try/catch block. */
    try {
        /* Set the mail sender. */
        $mail->setFrom('homisep@free.fr', "L'équipe Homisep");

        /* Add a recipient. */
        $mail->addAddress('pierre.verbe@isep.fr', 'Pierre Verbe');
        $mail->addAddress('pablo.grana@isep.fr', 'Pablo Grana');
        /* Set the subject. */
        $mail->Subject = 'On voulait tester phpMailer désolé du spam';

        /* Set the mail message body. */
        $mail->Body = 'TROLL By Laurent Yu';

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
