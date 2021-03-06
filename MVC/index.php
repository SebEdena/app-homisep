<?php
date_default_timezone_set('Europe/Paris');

function customError()
{
    require("./view/error.tpl");
    die();
}

session_start();

$control = isset($_GET['control'])?$_GET['control']:'connexionInitialisation';
$action = isset($_GET['action'])?$_GET['action']:'page_connexion';

if(!isset($_SESSION['id']) && $control !== 'connexionInitialisation'){
    header('Location: index.php');
}

if(file_exists('./controller/' .  $control . '.php'))
{
    require ('./controller/' .  $control . '.php');
    if (function_exists($action))
    {
        $action();
    }
    else
    {
        customError();
    }
}
else
{
    customError();
}
?>
