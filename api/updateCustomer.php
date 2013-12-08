<?php include_once 'getCustomer.php'; ?>
<?
session_start();
header('Content-Type:application/json');
if ((isset($_SESSION['login']) && ($_SESSION['permission']==1 || $_SESSION['permission']==2))){

	if(isset($_POST)){
	$db = new PDO('sqlite:../data/database.db');			

	//CHECK VALUES
	
	if(isset($_POST['CustomerID']))
		$query = 'Update cliente SET 
		CustomerTaxID=\''.$_POST['CustomerTaxID'].'\', 
		CompanyName=\''.$_POST['CompanyName'].'\',
		AddressDetail=\''.$_POST['BillingAddress']['AddressDetail'].'\', 
		Cidade=\''.$_POST['BillingAddress']['City'].'\', 
		PostalCode=\''.$_POST['BillingAddress']['PostalCode'].'\', 
		Country=\''.$_POST['BillingAddress']['Country'].'\', 
		Email=\''.$_POST['Email'].'\' WHERE CustomerID =\''.$_POST['CustomerID'].'\'';
	else
		$query = 'INSERT INTO cliente (CustomerTaxID,CompanyName,AddressDetail,Cidade,PostalCode,Country,Email) VALUES (\''
		.$_POST['CustomerTaxID'].'\',\''
		.$_POST['CompanyName'].'\',\''
		.$_POST['BillingAddress']['AddressDetail'].'\',\''
		.$_POST['BillingAddress']['City'].'\',\''
		.$_POST['BillingAddress']['PostalCode'].'\',\''
		.$_POST['BillingAddress']['Country'].'\',\''
		.$_POST['Email'].'\')';
	
	$result = $db->query($query);
		
	if($result)
		if(isset($_POST['CustomerID']))
			echo getCustomer($_POST['CustomerID']);
		else
			echo getCustomer($db->lastInsertId());			
	else
		echo json_encode(array('error' => array('code' => '404', 'reason' => 'Customer not found')));
	}
		
}			
?>