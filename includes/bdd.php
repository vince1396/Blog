<?php
	try
	{
	 	$bdd = new PDO('mysql:host=127.0.0.1;dbname=blog;charset=utf8', 'root', '6283');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
