<?php
	/**
	 * fichier contenant les configurations pour se connecter à la base de données
	 */
	$db_host = 'mysql:host=localhost:3306;dbname=homisep;charset=utf8';
	$db_pass = 'root';
	$db_user = 'root';

	$database = new PDO($db_host,$db_user, $db_pass);
	$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
