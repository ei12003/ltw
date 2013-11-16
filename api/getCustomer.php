
<?php

header('Content-Type:application/json');
$db = new PDO('sqlite:../data/database.db');


$value = str_replace("\"","",$_GET['CustomerID']);

// http://localhost/ltw/api/searchCustomer.php?CustomerID=5
if(!empty($value)){
	$query = 'SELECT CustomerID, CustomerTaxID, Email, CompanyName, PostalCode, AddressDetail, Country FROM cliente WHERE CustomerID = '.$value;
	$rows = $db->query($query);
	foreach($rows as $row){
		$customer = array('CustomerID' => $row['CustomerID'],
						  'CustomerTaxID' => $row['CustomerTaxID'],
						  'CompanyName' => $row['CompanyName'],
						  'AddressDetail' => $row['AddressDetail'],
						  'PostalCode' => $row['PostalCode'],
						  'Country' => $row['Country'],
						  'Email' => $row['Email']);
	}


$error = array('error' => array('code' => 404, 'reason' => 'Customer not found.'));

if(empty($customer))
	echo json_encode($error);
else
	echo json_encode($customer);
}
?>