<?php
	/*-------------------------
	Autor: Sonny MBA
	Web: kamer-center.net
	Mail: sonnymba@gmail.com
	---------------------------*/
	# connection à la base de donnée
    $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    if(!$con){
        die("Connexion impossible: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Echec de connexion: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    } 

    ini_set('display_errors', '1');
    ini_set('error_reporting', E_ALL);
?>
