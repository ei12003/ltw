
<?php

session_start();

if(isset($_SESSION['login']) && ($_SESSION['permission']==1 || $_SESSION['permission']==2)){
$db = new PDO('sqlite:../data/database.db');

$id=$_POST['id'];
$faturaid=$_POST['fatura'];


	$query = "Delete from line WHERE LineNumber ='".$id."'";
	
	$result = $db->query($query);
	if($result)
		echo "success";
	else
		echo "failed";

}


?>