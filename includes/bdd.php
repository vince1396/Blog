<?php
	try
	{
	 	$bdd = new PDO('mysql:host=db751485039.db.1and1.com;dbname=db751485039;charset=utf8', 'dbo751485039', 'b6311963a');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
