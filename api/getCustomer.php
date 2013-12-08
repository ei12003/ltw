
<?php
function getCustomer($CustomerID){
//header('Content-Type:application/json');
$db = new PDO('sqlite:../data/database.db');


if(isset($_GET['CustomerID']))
	$value = str_replace("\"","",$_GET['CustomerID']);
	
else
	$value = $CustomerID;

// http://localhost/ltw/api/searchCustomer.php?CustomerID=5
if(!empty($value)){
	$query = 'SELECT CustomerID, CustomerTaxID, Email, CompanyName, PostalCode, AddressDetail, Cidade, Country FROM cliente WHERE CustomerID = '.$value;
	$rows = $db->query($query);
	foreach($rows as $row){
		$customer = array('CustomerID' => $row['CustomerID'],
						  'CustomerTaxID' => $row['CustomerTaxID'],
						  'CompanyName' => $row['CompanyName'],
						  
						  'BillingAddress' => array(
						  'AddressDetail' => $row['AddressDetail'],
						  'Cidade' => $row['Cidade'],
						  'PostalCode' => $row['PostalCode'],
						  'Country' => $row['Country']),
						  
						  'Email' => $row['Email']);
	}


$error = array('error' => array('code' => 404, 'reason' => 'Customer not found.'));

if(empty($customer))
	return json_encode($error);
else
	return json_encode($customer);
}
}

if(isset($_GET['CustomerID']))
	echo getCustomer(null);
?>