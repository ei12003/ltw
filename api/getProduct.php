
<?php

header('Content-Type:application/json');
$db = new PDO('sqlite:../data/database.db');


$value = str_replace("\"","",$_GET['ProductCode']);

// http://localhost/ltw/api/searchProduct.php?ProductCode=5
if(!empty($value)){
	$query = 'SELECT ProductCode, ProductDescription, unitPrice, unitofMeasure FROM produto WHERE ProductCode = '.$value;
	$rows = $db->query($query);
	foreach($rows as $row){
		$product = array('ProductCode' => $row['ProductCode'],
						  'ProductDescription' => $row['ProductDescription'],
						  'unitPrice' => $row['unitPrice'],
						  'unitofMeasure' => $row['unitofMeasure']);
	}


$error = array('error' => array('code' => 404, 'reason' => 'Product not found.'));

if(empty($product))
	echo json_encode($error);
else
	echo json_encode($product);
}
?>