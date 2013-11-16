
<?php
header('Content-Type:application/json');
include 'getFormattedInvoices.php';
$query = 'SELECT DISTINCT fatura.InvoiceNo, fatura.InvoiceDate, fatura.CustomerID, group_concat(line.LineNumber),  group_concat(line.ProductCode), 	group_concat(line.Quantity), group_concat(produto.UnitPrice), group_concat(line.CreditAmount), group_concat(line.TaxID), fatura.TaxPayable, fatura.NetTotal, fatura.GrossTotal, cliente.CompanyName FROM fatura INNER JOIN line INNER JOIN produto INNER JOIN cliente WHERE cliente.CustomerID = fatura.CustomerID AND produto.ProductCode = line.productCode AND fatura.LineID = line.LineID';
$value = str_replace("\"","",$_GET['InvoiceNo']);
$invoice=getFormattedInvoices($query.' AND fatura.InvoiceNo = \''.$value.'\' GROUP by fatura.InvoiceNo');


$error = array('error' => array('code' => 404, 'reason' => 'Invoice not found.'));

if(empty($invoice))
	echo json_encode($error);
else
	echo json_encode($invoice);


?>