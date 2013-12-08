
<?php

header('Content-Type:application/json');

include 'getFormattedInvoices.php';


$op = str_replace("\"","",$_GET['op']);
$field = str_replace("\"","",$_GET['field']);

if(isset($_GET['value'])){
	$value = $_GET['value'];	

if(!is_string($value) && $op!="range")
	$value = $value[0];
}
		
$error = 0;
$list = array(); 
$query = 'SELECT DISTINCT fatura.InvoiceNo, fatura.InvoiceDate, fatura.CustomerID, group_concat(line.LineNumber),  group_concat(line.ProductCode), 	group_concat(line.Quantity), group_concat(produto.UnitPrice), group_concat(line.CreditAmount), group_concat(line.TaxID), fatura.TaxPayable, fatura.NetTotal, fatura.GrossTotal, cliente.CompanyName FROM fatura INNER JOIN line INNER JOIN produto INNER JOIN cliente WHERE cliente.CustomerID = fatura.CustomerID AND produto.ProductCode = line.productCode AND fatura.LineID = line.LineID';

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
			if(!empty($m0) && !empty($m1)){
			if( ((strcmp($value[0],$m0[0])==0) && strcmp($value[1],$m1[0])==0)
					&& ($m0[1] == $m1[1]) )
			{
				$invoices=getFormattedInvoices($query.' GROUP by fatura.InvoiceNo');
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
			else{
				echo "Error: Invalid Value";
				$error = 2;
			}
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=range&field=%22InvoiceDate%22&value[]=%222013-09-23%22&value[]=%222013-09-30%22
		else if(strcmp($field,"InvoiceDate")==0){
			$list=getFormattedInvoices($query.' AND fatura.InvoiceDate >= \''.$value[0].'\' AND fatura.InvoiceDate <= \''.$value[1].'\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=range&field=%22GrossTotal%22&value[]=%223690%22&value[]=%223691%22
		else if(strcmp($field,"GrossTotal")==0){
			$list=getFormattedInvoices($query.' AND fatura.GrossTotal >= \''.$value[0].'\' AND fatura.GrossTotal <= \''.$value[1].'\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		else {
			echo "Error: Invalid Field";
		}
	}
	
	// EQUAL OPERATION
	else if($op == "equal")
	{
		if(!is_string($value)){
			$value = $value[0];
		}
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=InvoiceNo&value[]=FT%20SEQ/5
		if(strcmp($field,"InvoiceNo")==0){
			$list=getFormattedInvoices($query.' AND fatura.InvoiceNo = \''.$value.'\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=InvoiceDate&value[]=2013-06-27
		else if(strcmp($field,"InvoiceDate")==0){
			$list=getFormattedInvoices($query.' AND fatura.InvoiceDate = \''.$value.'\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=GrossTotal&value[]=3690
		else if(strcmp($field,"GrossTotal")==0){	
			$list=getFormattedInvoices($query.' AND fatura.GrossTotal = \''.$value.'\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=equal&field=CompanyName&value[]=companyname5
		else if(strcmp($field,"CompanyName")==0){
			$list=getFormattedInvoices($query.' AND cliente.CompanyName = \''.$value.'\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
	}

	// CONTAINS OPERATION
	else if($op == "contains")
	{
		if(!is_string($value)){
			$value = $value[0];
		}
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=InvoiceNo&value[]=FT%20SE
		if(strcmp($field,"InvoiceNo")==0){
			$list=getFormattedInvoices($query.' AND fatura.InvoiceNo LIKE \'%'.$value.'%\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=InvoiceDate&value[]=2013
		else if(strcmp($field,"InvoiceDate")==0){
			$list=getFormattedInvoices($query.' AND fatura.InvoiceDate LIKE \'%'.$value.'%\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=GrossTotal&value[]=3690
		else if(strcmp($field,"GrossTotal")==0){	
			$list=getFormattedInvoices($query.' AND fatura.GrossTotal LIKE \'%'.$value.'%\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
			
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=contains&field=CompanyName&value[]=companyname5
		else if(strcmp($field,"CompanyName")==0){
			$list=getFormattedInvoices($query.' AND cliente.CompanyName LIKE \'%'.$value.'%\' GROUP by fatura.InvoiceNo');
			echo json_encode($list);
		}
	}			
				
	// MIN OPERATION
	else if($op == "min")
		{
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=min&field=InvoiceNo
		if(strcmp($field,"InvoiceNo")==0){
			
			$reg = '#([^ ]+ [^/^ ]+/)([0-9]+)#';
			$invoices=getFormattedInvoices($query.' GROUP by fatura.InvoiceNo');
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
			$list=getFormattedInvoices($query.' AND fatura.InvoiceDate=(SELECT MIN(InvoiceDate) FROM fatura)');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=min&field=GrossTotal
		else if(strcmp($field,"GrossTotal")==0){	
			$list=getFormattedInvoices($query.' AND fatura.GrossTotal=(SELECT MIN(GrossTotal) FROM fatura)');
			echo json_encode($list);
			
		}
		}				

	// MAX OPERATION
	else if($op == "max")
		{
		// http://localhost/ltw/api/searchInvoicesByField.php?op=max&field=InvoiceNo
		if(strcmp($field,"InvoiceNo")==0){
			
			$reg = '#([^ ]+ [^/^ ]+/)([0-9]+)#';
			$invoices=getFormattedInvoices($query.' GROUP by fatura.InvoiceNo');
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
			$list=getFormattedInvoices($query.' AND fatura.InvoiceDate=(SELECT MAX(InvoiceDate) FROM fatura)');
			echo json_encode($list);
		}
		
		// http://localhost/ltw/api/searchInvoicesByField.php?op=max&field=GrossTotal
		else if(strcmp($field,"GrossTotal")==0){	
			$list=getFormattedInvoices($query.' AND fatura.GrossTotal=(SELECT MAX(GrossTotal) FROM fatura)');
			echo json_encode($list);
			
		}
		}				
			
				
} 



?>