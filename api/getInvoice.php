
<?php
	include 'getFormattedInvoices.php';
	function getInvoice($InvoiceNo){
//header('Content-Type:application/json');

$query = 'SELECT DISTINCT fatura.InvoiceNo, fatura.InvoiceDate, fatura.CustomerID, group_concat(line.LineNumber),  group_concat(line.ProductCode), 	group_concat(line.Quantity), group_concat(produto.UnitPrice), group_concat(line.CreditAmount), group_concat(line.TaxID), fatura.TaxPayable, fatura.NetTotal, fatura.GrossTotal, cliente.CompanyName FROM fatura INNER JOIN line INNER JOIN produto INNER JOIN cliente WHERE cliente.CustomerID = fatura.CustomerID AND produto.ProductCode = line.productCode AND fatura.LineID = line.LineID';


if(isset($_GET['InvoiceNo']))
	$value = str_replace("\"","",$_GET['InvoiceNo']);
else
	$value = $InvoiceNo;


$invoice=getFormattedInvoices($query.' AND fatura.InvoiceNo = \''.$value.'\' GROUP by fatura.InvoiceNo');

$error = array('error' => array('code' => 404, 'reason' => 'Invoicex not found.'));

if(empty($invoice))
	return json_encode($error);
else
	return json_encode($invoice[0]);

}
	if(isset($_GET['InvoiceNo']))
		echo getInvoice(null);
?>