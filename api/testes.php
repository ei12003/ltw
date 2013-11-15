<?php
	header('Content-Type:application/json');

//FT SEQ/1	
//$reg = '/[^ ]+ [^/^ ]+/[0-9]+/';
//$str = "FT SEQ/1";
//$reg = '#([^ ]+ [^/^ ]+/)([0-9]+)#';
/*$str = "FT SEQ/1";
$str = "FT SEQ/1";
preg_match($reg,$str, $matches);

print_r($matches);*/
/*	function sqlite_regExp($sql)
{
    $db = new PDO('sqlite:database.db');
	
    if($db->sqliteCreateFunction("regexp", "preg_match", 2) === FALSE) exit("Failed creating function!");
    if($res = $db->query($sql)->fetchAll()){ return $res; }
    else return false;
}

$oi = array();
// calling our function / sort matches
if($rows = sqlite_regExp("SELECT InvoiceNo FROM fatura WHERE regexp('#FT SEQ/([0-9])+#', InvoiceNo)")){
    foreach($rows as $row){
	preg_match($reg,$row[0],$match);
	if($match[2]>2)
	array_push($oi,$row);
	}
	print_r($oi);
}*//*
$db = new PDO('sqlite:database.db');
$query = 'SELECT * from fatura';
$rows = $db->query($query);
foreach($rows as $row){
	preg_match($reg,$row[0],$match);
	if($match[2]>2)
	array_push($oi,$row);
	}
	print_r($oi);
		preg_match("#([0-9]+)#","123123",$m0);
		print_r($m0);*/
		 include 'getInvoices.php';
		print_r( getInvoices());
				
		
			//	print_r($invoices[0]);
			

?>
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	