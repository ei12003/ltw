
<?php

session_start();

if(isset($_SESSION['login']) && ($_SESSION['permission']==1 || $_SESSION['permission']==2)){
$db = new PDO('sqlite:../data/database.db');

$pc=$_POST['pc'];
$qa=$_POST['qa'];
$faturaid = $_POST['id'];
print_r($_POST);
//MUDAR CREDITAMOUNT
	$query = "INSERT INTO line (LineID,ProductCode,Quantity,CreditAmount,TaxID) VALUES('".$faturaid."','".$pc."','".$qa."','3000','1')";
	$result = $db->query($query);
	if($result)
		echo "%".$db->lastInsertId();
	else
		echo "failed";

}


?>