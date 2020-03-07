<?php 

 $db = new PDO('mysql:host=localhost;dbname=ionic', 'mamed_db', 'admin#2018');

 header("Access-Control-Allow-Origin: *");

	 if($_SERVER['REQUEST_METHOD'] !== 'POST') {
	 	echo json_encode(array('status' => false));
	 	exit;
	 }

	 $postdata = file_get_contents("php://input");
	
	 $data = json_decode($postdata, true);

	 $data['email'];


 ?>

