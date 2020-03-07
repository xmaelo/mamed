<?php 
	session_start();

	
	if (isset($_POST['catFrench'])) {
		
	
	$lang="Fr";
	$_SESSION['lang']=$lang;

	}
	elseif(isset($_POST['catAll']))
	{
		$lang="Deutch";
		$_SESSION['lang']=$lang;
	}
	else {
	$lang="Deutch";
	$_SESSION['lang']=$lang;
	}
	
	header('location:accueil.php');
 ?>