
<?php

header('Content-Type:application/json');
$db = new PDO('sqlite:../data/database.db');

$op = str_replace("\"","",$_GET['op']);
$field = str_replace("\"","",$_GET['field']);

if(isset($_GET['value']))
	$value = $_GET['value'];	
if(!is_string($value) && $op!="range")
	$value = $value[0];
		
$error = 0;
$list = array(); //VER SE DA PARA TIRAR

if(!empty($op) && !empty($field)){	

	// RANGE OPERATION 
	if($op == "range" && count($value) == 2)
	{	
		$value[0]=str_replace("\"","",$value[0]);
		$value[1]=str_replace("\"","",$value[1]);		
		
		// http://localhost/ltw/api/searchProductsByField.php?op=range&field=ProductCode&value[]=2&value[]=5
		if(strcmp($field,"ProductCode")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductCode >= '.$value[0].' AND ProductCode <='.$value[1];
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=range&field=%22unitPrice%22&value[]=%22150%22&value[]=%227500%22
		else if(strcmp($field,"unitPrice")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE unitPrice >= '.$value[0].' AND unitPrice <='.$value[1];
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		else {
			echo "Error: Invalid Field";
		}
	}
	
	// EQUAL OPERATION
	else if($op == "equal")
	{
		// http://localhost/ltw/api/searchProductsByField.php?op=equal&field=ProductCode&value=5
		if(strcmp($field,"ProductCode")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductCode = '.$value;
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=equal&field=unitPrice&value=32.5
		else if(strcmp($field,"unitPrice")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE unitPrice = '.$value;
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=equal&field=ProductDescription&value=produto19
		else if(strcmp($field,"ProductDescription")==0){	
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductDescription = \''.$value.'\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
			
		}
		
	}

	// CONTAINS OPERATION
	else if($op == "contains")
	{
		// localhost/ltw/api/searchProductsByField.php?op=contains&field=ProductCode&value=9
		if(strcmp($field,"ProductCode")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductCode LIKE \'%'.$value.'%\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=contains&field=unitPrice&value=3
		else if(strcmp($field,"unitPrice")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE unitPrice LIKE \'%'.$value.'%\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=contains&field=ProductDescription&value=9
		else if(strcmp($field,"ProductDescription")==0){	
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductDescription LIKE \'%'.$value.'%\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
			
		}
		
	}			
				
	// MIN OPERATION
	else if($op == "min")
		{
		// http://localhost/ltw/api/searchProductsByField.php?op=min&field=ProductCode
		if(strcmp($field,"ProductCode")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductCode=(SELECT MIN(ProductCode) FROM produto)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=min&field=unitPrice
		else if(strcmp($field,"unitPrice")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE unitPrice=(SELECT MIN(unitPrice) FROM produto)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		}				

	// MAX OPERATION
	else if($op == "max")
		{
		// http://localhost/ltw/api/searchProductsByField.php?op=max&field=ProductCode
		if(strcmp($field,"ProductCode")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE ProductCode=(SELECT MAX(ProductCode) FROM produto)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchProductsByField.php?op=max&field=unitPrice
		else if(strcmp($field,"unitPrice")==0){
			$query = 'SELECT ProductCode, unitPrice, ProductDescription FROM produto WHERE unitPrice=(SELECT MAX(unitPrice) FROM produto)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('ProductCode' => $row['ProductCode'],'unitPrice' => $row['unitPrice'],'ProductDescription' => $row['ProductDescription']);
			}
			echo json_encode($list);
		}
		
		}				

	else
	{
		echo "Invalid operation.";
	}
	} 



?>