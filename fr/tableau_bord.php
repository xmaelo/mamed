<?php 
function compter($table,$id, $equal){
	global $con;
	$req = "select count(*) as nbre from $table where $id='$equal'";
	//var_dump($req);
	$query=mysqli_query($con, $req);
	$rw=mysqli_fetch_array($query);
	$value=$rw['nbre'];
	return $value;
}

?>