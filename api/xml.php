<?php
ob_start();
include_once 'getProduct.php';
include_once 'getCustomer.php';
include_once 'getInvoice.php';
 ?>
<?php
ob_clean();
header('Content-type: text/xml');


$dom=new DOMDocument();
$dom->load('../template.xml');

$invoice = json_decode(getInvoice($_POST['id']),true);
$customer = json_decode(getCustomer($invoice['CustomerID']),true);

$dom->getElementsByTagName("InvoiceNo")->item(0)->nodeValue = $invoice['InvoiceNo'];
$dom->getElementsByTagName("InvoiceDate")->item(0)->nodeValue = $invoice['InvoiceDate'];
$dom->getElementsByTagName("CustomerID")->item(0)->nodeValue = $invoice['CustomerID'];
$dom->getElementsByTagName("CustomerID")->item(1)->nodeValue = $invoice['CustomerID'];
$dom->getElementsByTagName("CompanyName")->item(1)->nodeValue = $invoice['CompanyName'];

/* LINES */
$node = $dom->getElementsByTagName('Line')->item(0);
$parent = $dom->getElementsByTagName('Invoice')->item(0);	
$parentProduct=$dom->getElementsByTagName("Product")->item(0);
$parentProduct=$dom->getElementsByTagName("Product")->item(0);
$parentMasterFiles = $dom->getElementsByTagName('MasterFiles')->item(0);	
foreach($invoice['Line'] as $line){
$product = json_decode(getProduct(1),true);
	
$newNode=$node->cloneNode(true);
$childNodes=$newNode->childNodes;
$childNodes->item(1)->nodeValue = $line['LineNumber'];
$childNodes->item(3)->nodeValue = $line['ProductCode'];

/* NEW PRODUCT . MASTERFILES*/
$newProduct=$parentProduct->cloneNode(true);
$newProduct->childNodes->item(3)->nodeValue=$line['ProductCode'];
$newProduct->childNodes->item(9)->nodeValue=$line['ProductCode'];
$parentMasterFiles->insertBefore($newProduct, $parentProduct);
$parentTax = $dom->getElementsByTagName('TaxTable')->item(0);
$tax_entry_template = $dom->getElementsByTagName('TaxTableEntry')->item(0);

/* ################## */

$childNodes->item(5)->nodeValue = $product['ProductDescription'];
$childNodes->item(7)->nodeValue = $line['Quantity'];
$childNodes->item(9)->nodeValue = $product['unitofMeasure'];
$childNodes->item(11)->nodeValue = $product['unitPrice'];
$childNodes->item(15)->nodeValue = "none";
$childNodes->item(17)->nodeValue = $line['CreditAmount'];
$tax_template = $childNodes->item(19);
/* TAXES */
	
foreach($line['Tax'] as $tax){
	$exists = 0;
	$newTax = $tax_template->cloneNode(true);
	$newTax->childNodes->item(1)->nodeValue = $tax['TaxType'];
	$newTax->childNodes->item(7)->nodeValue = $tax['TaxPercentage'];
	$newNode->insertBefore($newTax, $tax_template);
	
	/* CHECK NEW TAX . MASTERFILES*/
	foreach($dom->getElementsByTagName('TaxTableEntry') as $taxtmp){
		//echo '<p>'.$tax_entry_template->childNodes->item(0)->nodeValue.'|'.$line['TaxType'];
		
		if($taxtmp->childNodes->item(1)->nodeValue==$tax['TaxType'])
		{
			$exists = 1;
		}
	}
	if($exists == 0){
		$newtax_entry=$tax_entry_template->cloneNode(true);
		$newtax_entry->childNodes->item(1)->nodeValue=$tax['TaxType'];
		$newtax_entry->childNodes->item(7)->nodeValue="Taxa";
		$newtax_entry->childNodes->item(9)->nodeValue=$tax['TaxPercentage'];
		$parentTax->insertBefore($newtax_entry, $tax_entry_template);
	}
		
}
$newNode->removeChild($tax_template);

$parent->insertBefore($newNode, $node);
}
$parent->removeChild($node);

$dom->getElementsByTagName("TaxPayable")->item(0)->nodeValue = $invoice['DocumentTotals']['TaxPayable'];
$dom->getElementsByTagName("NetTotal")->item(0)->nodeValue = $invoice['DocumentTotals']['NetTotal'];
$dom->getElementsByTagName("GrossTotal")->item(0)->nodeValue = $invoice['DocumentTotals']['GrossTotal'];



print $dom->saveXML();

ob_flush();
?>