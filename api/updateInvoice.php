<?php include_once 'getInvoice.php'; ?>
<?
session_start();
header('Content-Type:application/json');
if ((isset($_SESSION['login']) && ($_SESSION['permission']==1 || $_SESSION['permission']==2))){

	if(isset($_POST)){
	$db = new PDO('sqlite:../data/database.db');			

	//CHECK VALUES
	$inv_id;
	//$_POST['CustomerID']
	//$_POST['InvoiceDate']

	if(isset($_POST['InvoiceNo'])){
		$query = 'Update fatura SET 
		InvoiceDate=\''.$_POST['InvoiceDate'].'\', 
		CustomerID=\''.$_POST['CustomerID'].'\' WHERE InvoiceNo =\''.$_POST['InvoiceNo'].'\'';
		$inv_id = $_POST['InvoiceNo'];
		$result = $db->query($query);
		
	}
		
	else{
		$query = "INSERT INTO fatura (InvoiceNo,InvoiceDate,CustomerID,LineID,TaxPayable,NetTotal,GrossTotal) VALUES('FT SEQ/1','2010-09-27','1','1','690','3000','3695')";
		$result = $db->query($query);
		$inv_id = $db->lastInsertId();
		/*FAZER UPDATE DOS VALORES*/
	}
	if(isset($_POST['linenumber']))
	{
		
		$query = 'Update line SET LineID='.$inv_id.' WHERE LineNumber='.$_POST['linenumber'];
		echo "STOP".$_POST['linenumber']."OOOO";
		$result = $db->query($query);
	}
	
		//echo $inv_id;
		$query = 'Update fatura SET InvoiceNo=\'FT SEQ/'.$inv_id.'\' WHERE Num =\''.$inv_id.'\'';
		echo $query;
		$result = $db->query($query);
		
	if($result)
		if(isset($_POST['InvoiceNo']))
			echo getInvoice($_POST['InvoiceNo']);
		else
			echo getInvoice("FT SEQ/".$inv_id);			
	else
		echo json_encode(array('error' => array('code' => '404', 'reason' => 'Customer not found')));
	}
		
}
//echo json_encode($_POST);
?>