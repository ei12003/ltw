
<?php

header('Content-Type:application/json');

include 'getInvoices.php';

/*
 * FALTA ADICIONAR COMPANYNAME AO JSON
*/
$op = str_replace("\"","",$_GET['op']);
$field = str_replace("\"","",$_GET['field']);

if(isset($_GET['value']))
	$value = $_GET['value'];	

$error = 0;
$list = array(); //VER SE DA PARA TIRAR

if(!empty($op) && !empty($field)){	

	// RANGE OPERATION 
	if($op == "range" && count($value) == 2)
	{	
		$value[0]=str_replace("\"","",$value[0]);
		$value[1]=str_replace("\"","",$value[1]);		
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=range&field=%22InvoiceNo%22&value[]=%22FT%20SEQ/4%22&value[]=%22FT%20SEQ/5%22
		if(strcmp($field,"InvoiceNo")==0){
			$reg = '#([^ ]+ [^/^ ]+/)([0-9]+)#';
			preg_match($reg,$value[0],$m0);
			preg_match($reg,$value[1],$m1);

			if( ((strcmp($value[0],$m0[0])==0) && strcmp($value[1],$m1[0])==0)
					&& ($m0[1] == $m1[1]) )
			{
				$invoices=getInvoices();
				foreach($invoices as $inv) {
					preg_match($reg,$inv['InvoiceNo'],$mvar);
					$mvar[2]=str_replace("\"","",$mvar[2]);
					if($mvar[2]>=$m0[2] && $mvar[2]<=$m1[2]){
						$list[]=$inv;
					}
				}
				//print_r($list);
				echo json_encode($list);
				
			}				
			else{
				echo "Error: Invalid Value";
				$error = 2;
			}
			
			
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=range&field=%22InvoiceDate%22&value[]=%222013-09-23%22&value[]=%222013-09-30%22
		else if(strcmp($field,"InvoiceDate")==0){
			$invoices=getInvoices();
			
			foreach($invoices as $inv){
				if(strtotime($inv['InvoiceDate'])>=strtotime($value[0]) && strtotime($inv['InvoiceDate'])<=strtotime($value[1]))
				$list[]=$inv;
			}
			//print_r($list);
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=range&field=%22GrossTotal%22&value[]=%223690%22&value[]=%223691%22
		else if(strcmp($field,"GrossTotal")==0){
			$invoices=getInvoices();
			
			foreach($invoices as $inv){
				
				if($inv['DocumentTotals']['GrossTotal']>=$value[0] && $inv['DocumentTotals']['GrossTotal']<=$value[1])
				$list[]=$inv;
			}
			//print_r($list);
			echo json_encode($list);
		}
		
		else {
			echo "Error: Invalid Field";
		}
	}
	
	// EQUAL OPERATION
	else if($op == "equal")
	{
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=InvoiceNo&value=FT%20SEQ/5
		if(strcmp($field,"InvoiceNo")==0){
			$invoices=getInvoices();
			foreach($invoices as $inv) {
				if(strcmp($inv['InvoiceNo'],$value)==0){
					$list = $inv;
					break;
				}
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=InvoiceDate&value=2013-09-27
		else if(strcmp($field,"InvoiceDate")==0){
			$invoices=getInvoices();
			
			foreach($invoices as $inv) {
				if(strtotime($inv['InvoiceDate'])==strtotime($value)){
					$list[] = $inv;					
				}
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=GrossTotal&value=3690
		else if(strcmp($field,"GrossTotal")==0){	
				$invoices=getInvoices();
			
			foreach($invoices as $inv) {
				if($inv['DocumentTotals']['GrossTotal']==$value){
					$list[] = $inv;
				}
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=CompanyName&value=companyname5
		else if(strcmp($field,"CompanyName")==0){
			$invoices=getInvoices();
			foreach($invoices as $inv) {
				if(strcmp(getCompanyName($inv['CustomerID']),$value)==0){
					$list = $inv;
				}
			}
			echo json_encode($list);
		}
	}

	// CONTAINS OPERATION
	else if($op == "contains")
	{
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=InvoiceNo&value=FT%20SE
		if(strcmp($field,"InvoiceNo")==0){
			$invoices=getInvoices();
			foreach($invoices as $inv) {
				
				if(strlen(strstr($inv['InvoiceNo'],$value))>0){
					$list[] = $inv;
				}
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=InvoiceDate&value=2013-09-27
		else if(strcmp($field,"InvoiceDate")==0){
			$invoices=getInvoices();
			
			foreach($invoices as $inv) {
				if(strlen(strstr($inv['InvoiceDate'],$value))>0){
					$list[] = $inv;					
				}
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=GrossTotal&value=3690
		else if(strcmp($field,"GrossTotal")==0){	
				$invoices=getInvoices();
			
			foreach($invoices as $inv) {
				if(strlen(strstr($inv['DocumentTotals']['GrossTotal'],$value))>0){
					$list[] = $inv;
				}
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=CompanyName&value=companyname5
		else if(strcmp($field,"CompanyName")==0){
			$invoices=getInvoices();
			foreach($invoices as $inv) {
				if(strlen(strstr(getCompanyName($inv['CustomerID']),$value))>0){
					$list[] = $inv;
				}
			}
			echo json_encode($list);
		}
	}			
				
	// MIN OPERATION
	else if($op == "min")
		{
		// http://localhost/ltw/api/searchInvoicesByField.php?op=min&field=InvoiceNo
		if(strcmp($field,"InvoiceNo")==0){
			
			$reg = '#([^ ]+ [^/^ ]+/)([0-9]+)#';
			$invoices=getInvoices();
			preg_match($reg,$invoices[0]['InvoiceNo'],$var);
			$min = $var[2];
			foreach($invoices as $inv) {
				
				preg_match($reg,$inv['InvoiceNo'],$var);
				
				if($var[2]<$min){
					 unset($list);
					 $list[] = $inv;
					 $min = $var[2];
				}
				else if($var[2]==$min)
				{
					$list[] = $inv;
				}
				
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=min&field=InvoiceDate
		else if(strcmp($field,"InvoiceDate")==0){
			$invoices=getInvoices();
			$min = strtotime($invoices[0]['InvoiceDate']);
			
			foreach($invoices as $inv) {
				if(strtotime($inv['InvoiceDate'])<$min){
					unset($list);
					$list[] = $inv;
					$min=strtotime($inv['InvoiceDate']);
				}
				else if(strtotime($inv['InvoiceDate'])==$min)
				{
					$list[] = $inv;
				}
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=min&field=GrossTotal
		else if(strcmp($field,"GrossTotal")==0){	
			$invoices=getInvoices();
			$min = $invoices[0]['DocumentTotals']['GrossTotal'];
			
			foreach($invoices as $inv) {
				if($inv['DocumentTotals']['GrossTotal']<$min){
					unset($list);
					$list[] = $inv;
					$min=$inv['DocumentTotals']['GrossTotal'];
				}
				else if($inv['DocumentTotals']['GrossTotal']==$min)
				{
					$list[] = $inv;
				}
			}
			echo json_encode($list);
			
		}
		}				

	// MAX OPERATION
	else if($op == "max")
		{
		// http://localhost/ltw/api/searchInvoicesByField.php?op=max&field=InvoiceNo
		if(strcmp($field,"InvoiceNo")==0){
			
			$reg = '#([^ ]+ [^/^ ]+/)([0-9]+)#';
			$invoices=getInvoices();
			preg_match($reg,$invoices[0]['InvoiceNo'],$var);
			$max = $var[2];
			foreach($invoices as $inv) {
				
				preg_match($reg,$inv['InvoiceNo'],$var);
				
				if($var[2]>$max){
					 unset($list);
					 $list[] = $inv;
					 $max = $var[2];
				}
				else if($var[2]==$max)
				{
					$list[] = $inv;
				}
				
			}
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=max&field=InvoiceDate
		else if(strcmp($field,"InvoiceDate")==0){
			$invoices=getInvoices();
			$max = strtotime($invoices[0]['InvoiceDate']);
			
			foreach($invoices as $inv) {
				if(strtotime($inv['InvoiceDate'])>$max){
					unset($list);
					$list[] = $inv;
					$max=strtotime($inv['InvoiceDate']);
				}
				else if(strtotime($inv['InvoiceDate'])==$max)
				{
					$list[] = $inv;
				}
			}
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=max&field=GrossTotal
		else if(strcmp($field,"GrossTotal")==0){	
			$invoices=getInvoices();
			$max = $invoices[0]['DocumentTotals']['GrossTotal'];
			
			foreach($invoices as $inv) {
				if($inv['DocumentTotals']['GrossTotal']>$max){
					unset($list);
					$list[] = $inv;
					$max=$inv['DocumentTotals']['GrossTotal'];
				}
				else if($inv['DocumentTotals']['GrossTotal']==$max)
				{
					$list[] = $inv;
				}
			}
			echo json_encode($list);
			
		}
		}				
			
				
} 



?>