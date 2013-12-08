
<?php
	
session_start();

if($_SESSION['login']==null || $_SESSION['login']=="error" || $_SESSION['permission']!=1){}
else{
$db = new PDO('sqlite:../data/database.db');
$user = str_replace("\"","",$_POST['user']);

if(!empty($user)){
	$query = "Delete from users WHERE Username = '".$user."'";
	$result = $db->query($query);
	if($result)
		echo "success";
	else
		echo "failed";
}
}

?>