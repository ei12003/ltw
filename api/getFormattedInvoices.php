<?php
function getFormattedInvoices($query){
				$db = new PDO('sqlite:../data/database.db');
				$rows = $db->query($query);
				$line = array();

				foreach($rows as $row) {
				
				for($i=3;$i<9;$i++)
						$row[$i] = explode(',', $row[$i]);
				
				
				for($j=0;$j<count($row[3]);$j++){
				
					$line['LineNumber']=$row[3][$j];
					$line['ProductCode']=$row[4][$j];
					$line['Quantity']=$row[5][$j];
					$line['UnitPrice']=$row[6][$j];
					$line['CreditAmount']=$row[7][$j];
					
					
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
					'CompanyName' => $row['CompanyName'],
					'Line' => $lines,
					'DocumentTotals' => array('TaxPayable' => $row['TaxPayable'],'NetTotal' => $row['NetTotal'],'GrossTotal' => $row['GrossTotal'])
					);
				
				
				$invoices[]=$invoice;
				$lines=array();

				}
				
				
				if(empty($invoices))
					return array();
				else
					return ($invoices);
				
				
		}
?>