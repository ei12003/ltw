<?php
function getInvoices(){
				$db = new PDO('sqlite:../data/database.db');
				$query = 'SELECT DISTINCT fatura.InvoiceNo, fatura.InvoiceDate, fatura.CustomerID, group_concat(line.LineNumber), group_concat(line.ProductCode), group_concat(line.Quantity), group_concat(produto.UnitPrice), group_concat(line.CreditAmount),group_concat(line.TaxID), fatura.TaxPayable, fatura.NetTotal, fatura.GrossTotal FROM fatura INNER JOIN line INNER JOIN produto WHERE produto.ProductCode = line.productCode AND fatura.LineID = line.LineID GROUP by fatura.InvoiceNo';
				$rows = $db->query($query);
				$line = array();
				
				foreach($rows as $row) {
		//		print_r($row);
				for($i=3;$i<9;$i++)
						$row[$i] = explode(',', $row[$i]);
				
				
				for($j=0;$j<count($row[3]);$j++){
				
					$line['LineNumber']=$row[3][$j];
					$line['ProductCode']=$row[4][$j];
					$line['Quantity']=$row[5][$j];
					$line['UnitPrice']=$row[6][$j];
					$line['CreditAmount']=$row[7][$j];
					//echo "SUUU####>".$row[8][$j]."<#####";
					
					$query = 'SELECT tax.TaxType, tax.TaxPercentage FROM tax WHERE tax.TaxID ='.$row[8][$j];
					$taxes_t = $db->query($query)->fetchALL();
					foreach($taxes_t as $tax_t){
						$tax['TaxType']=$tax_t[0];
						$tax['TaxPercentage']=$tax_t[1];
						$taxes[]=$tax;
					}
					$line['Tax']=$taxes;
					$lines[]=$line;
					
					$line=array();
					$taxes=array();
				}
				
				
				
				
				$invoice = array(
					'InvoiceNo' => $row['InvoiceNo'],
					'InvoiceDate' => $row['InvoiceDate'],
					'CustomerID' => $row['CustomerID'],
					'Line' => $lines,
					'DocumentTotals' => array('TaxPayable' => $row['TaxPayable'],'NetTotal' => $row['NetTotal'],'GrossTotal' => $row['GrossTotal'])
					);
					
				$invoices[]=$invoice;
				$lines=array();

				}
				//return json_encode($invoices);
				return ($invoices);
		}
?>