
<?php
	
session_start();

if($_SESSION['login']==null || $_SESSION['login']=="error" || $_SESSION['permission']!=1){}
else{
$db = new PDO('sqlite:../data/database.db');
$user = str_replace("\"","",$_POST['user']);
$new_perm = str_replace("\"","",$_POST['new_perm']);


if(!empty($user) && !empty($new_perm) ){
	if($new_perm=="Admin")
		$new_perm=1;
	else if($new_perm=="Editor")
		$new_perm=2;
	else if($new_perm=="Reader")
		$new_perm=3;
	
	$query = "UPDATE users SET Permission='".$new_perm."' WHERE Username = '".$user."'";
	$result = $db->query($query);
	if($_SESSION['login']==$user)
		$_SESSION['permission']=$new_perm;
	if($result)
		echo "success";
	else
		echo "failed";
}
}

?>