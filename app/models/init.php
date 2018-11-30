<?php

function	init()
{
	try
	{
		$bdd = new PDO('mysql:host=mysql:3306;dbname=camagru;charset=utf8',
			'root', 'rootpass',
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		die("Erreur : " . $e->getMessage());
	}
	return ($bdd);
}
