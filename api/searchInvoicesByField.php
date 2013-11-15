
<?php

header('Content-Type:application/json');

include 'getInvoices.php';

//echo $value[0] . $value[1] . count($value);
$op = str_replace("\"","",$_GET['op']);
$field = str_replace("\"","",$_GET['field']);
$value = $_GET['value'];	

$error = 0;
$list = array(); //VER SE DA PARA TIRAR

if(!empty($op) && !empty($field)){	

	// RANGE OPERATION 
	
	if( $op == "range" && count($value)!= 2 ){
		$error = 1;
		
	}
	else{	
		//http://localhost/ltw/api/searchInvoicesByField.php?op=range&field=%22invoiceno%22&value[]=%22FT%20SEQ/4%22&value[]=%22FT%20SEQ/5%22
		$value[0]=str_replace("\"","",$value[0]);
		$value[1]=str_replace("\"","",$value[1]);
			
		if(strcmp($field,"invoiceno")==0){
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
		else if(strcmp($field,"invoicedate")==0){
			
		}
		else if(strcmp($field,"grosstotal")==0){
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
	
	
} 



?>