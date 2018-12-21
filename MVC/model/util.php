<?php
function traitementCaractereSpeciaux($mot)
{
    return htmlspecialchars($mot);
}

function sendMail(){
    //use PHPMailer\PHPMailer\PHPMailer;
    require("./model/mailConfig.php");

    /* Open the try/catch block. */
    try {
        /* Set the mail sender. */
        $mail->setFrom('sebedena@live.fr', 'Darth Vader');

        /* Add a recipient. */
        $mail->addAddress('viguier.sebastien@orange.fr', 'Emperor');

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
