<?php include_once 'getProduct.php'; ?>
<?
session_start();
header('Content-Type:application/json');
if ((isset($_SESSION['login']) && ($_SESSION['permission']==1 || $_SESSION['permission']==2))){

	if(isset($_POST)){
	$db = new PDO('sqlite:../data/database.db');			

	//CHECK VALUES
	
	if(isset($_POST['ProductCode']))
		$query = 'Update produto SET 
		ProductDescription=\''.$_POST['ProductDescription'].'\', 
		unitPrice=\''.$_POST['UnitPrice'].'\', 
		unitofMeasure=\''.$_POST['UnitOfMeasure'].'\' WHERE ProductCode =\''.$_POST['ProductCode'].'\'';
	else
		$query = 'INSERT INTO produto (ProductDescription,unitPrice,unitofMeasure) VALUES (\''
		.$_POST['ProductDescription'].'\',\''
		.$_POST['UnitPrice'].'\',\''
		.$_POST['UnitOfMeasure'].'\')';
	
	$result = $db->query($query);
		
	if($result)
		if(isset($_POST['ProductCode']))
			echo getProduct($_POST['ProductCode']);
		else
			echo getProduct($db->lastInsertId());			
	else
		echo json_encode(array('error' => array('code' => '404', 'reason' => 'Product not found')));
	}
}

?>