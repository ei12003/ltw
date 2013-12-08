
<?php

header('Content-Type:application/json');
$db = new PDO('sqlite:../data/database.db');

$op = str_replace("\"","",$_GET['op']);
$field = str_replace("\"","",$_GET['field']);

if(isset($_GET['value'])){
	$value = $_GET['value'];	
	

if(!is_string($value) && $op!="range")
	$value = $value[0];
		}
$error = 0;
$list = array(); 

if(!empty($op) && !empty($field)){	

	// RANGE OPERATION 
	if($op == "range" && count($value) == 2)
	{	
		$value[0]=str_replace("\"","",$value[0]);
		$value[1]=str_replace("\"","",$value[1]);		
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=range&field=CustomerID&value[]=2&value[]=5
		if(strcmp($field,"CustomerID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerID >= '.$value[0].' AND CustomerID <='.$value[1];
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=range&field=%22CustomerTaxID%22&value[]=%2255%22&value[]=%2275%22
		else if(strcmp($field,"CustomerTaxID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerTaxID >= '.$value[0].' AND CustomerTaxID <='.$value[1];
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
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
		
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=equal&field=CustomerID&value[]=5
		if(strcmp($field,"CustomerID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerID = '.$value;
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=equal&field=CustomerTaxID&value[]=74
		else if(strcmp($field,"CustomerTaxID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerTaxID = '.$value;
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=equal&field=CompanyName&value[]=companyname2
		else if(strcmp($field,"CompanyName")==0){	
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CompanyName = \''.$value.'\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
			
		}
		
	}

	// CONTAINS OPERATION
	else if($op == "contains")
	{
		// localhost/ltw/api/searchCustomersByField.php?op=contains&field=CustomerID&value[]=9
		if(strcmp($field,"CustomerID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerID LIKE \'%'.$value.'%\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=contains&field=CustomerTaxID&value[]=3
		else if(strcmp($field,"CustomerTaxID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerTaxID LIKE \'%'.$value.'%\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=contains&field=CompanyName&value[]=company
		else if(strcmp($field,"CompanyName")==0){	
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CompanyName LIKE \'%'.$value.'%\'';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
			
		}
		
	}			
				
	// MIN OPERATION
	else if($op == "min")
		{
		// http://localhost/ltw/api/searchCustomersByField.php?op=min&field=CustomerID
		if(strcmp($field,"CustomerID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerID=(SELECT MIN(CustomerID) FROM cliente)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=min&field=CustomerTaxID
		else if(strcmp($field,"CustomerTaxID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerTaxID=(SELECT MIN(CustomerTaxID) FROM cliente)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
		}
		
		}				

	// MAX OPERATION
	else if($op == "max")
		{
		// http://localhost/ltw/api/searchCustomersByField.php?op=max&field=CustomerID
		if(strcmp($field,"CustomerID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerID=(SELECT MAX(CustomerID) FROM cliente)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchCustomersByField.php?op=max&field=CustomerTaxID
		else if(strcmp($field,"CustomerTaxID")==0){
			$query = 'SELECT CustomerID, CustomerTaxID, CompanyName FROM cliente WHERE CustomerTaxID=(SELECT MAX(CustomerTaxID) FROM cliente)';
			$rows = $db->query($query);
			foreach($rows as $row){
				$list[] = array('CustomerID' => $row['CustomerID'],'CustomerTaxID' => $row['CustomerTaxID'],'CompanyName' => $row['CompanyName']);
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