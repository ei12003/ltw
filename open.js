$(document).ready(function() {
	$content = $('div#conteudo');
	
	if($type=='cliente')
	{
		$option='api/getCustomer.php';
		$get = { CustomerID: $id};
	}
	else if($type=='fatura'){
		$option='api/getInvoice.php';
		$get = { InvoiceNo: $id};
	}
	else if($type=='produto'){
		$option='api/getProduct.php';
		$get = { ProductCode: $id};
	}
	
	$.getJSON($option,$get, function(data) {
		
		$.each(data, function(i, item) {
		$content.empty();	
			if($option == 'api/getInvoice.php'){
				if(data[i].hasOwnProperty('InvoiceNo'))
				{
					//TIRAR ISTO DOS OUTROS
					//$.each(data[i], function(i, doc){ $gt = doc.GrossTotal });
					$invno = '<tr><td>InvoiceNo</td><td>' + data[i].InvoiceNo + '</td></tr>';
					$invdate = '<tr><td>InvoiceDate</td><td>' + data[i].InvoiceDate + '</td></tr>';
					$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
					$grosstotal = '<tr><td>GrossTotal</td><td>' + data[i].DocumentTotals.GrossTotal + '</td></tr>';
					$json = '<div id="sums"><table border="1">'+$invno+$invdate+$cmpname+$grosstotal+'</table></div>';
					$content.append($json);
					
				}	
			}
			else if($option=='api/getCustomer.php'){
				if(data.hasOwnProperty('CustomerID')){		
					$cid = '<tr><td>CustomerID</td><td>' + data.CustomerID + '</td></tr>';
					$ctaxid = '<tr><td>CustomerTaxID </td><td>' + data.CustomerTaxID  + '</td></tr>';
					$cmpname = '<tr><td>CompanyName</td><td>' + data.CompanyName  + '</td></tr>';
						
					$ad = '<tr><td>AddressDetail</td><td>' + data.BillingAddress.AddressDetail  + '</td></tr>';
					$ci = '<tr><td>City</td><td>' + data.BillingAddress.Cidade  + '</td></tr>';
					$pc = '<tr><td>PostalCode</td><td>' + data.BillingAddress.PostalCode  + '</td></tr>';
					$countc = '<tr><td>Country</td><td>' + data.BillingAddress.Country  + '</td></tr>';
					$email = '<tr><td>Email</td><td>' + data.Email  + '</td></tr>';
					$json = '<div id="sums"><table border="1">'+$cid+$ctaxid+$cmpname+$ad+$ci+$pc+$countc+$email+'</table></div>';
					$content.append($json);
					
				}
			}
			else if($option=='api/getProduct.php'){
				if(data.hasOwnProperty('ProductCode')){
					$pc = '<tr><td>ProductCode</td><td>' + data.ProductCode + '</td></tr>';
					$pd = '<tr><td>ProductDescription  </td><td>' + data.ProductDescription   + '</td></tr>';
					$up = '<tr><td>UnitPrice</td><td>' + data.unitPrice  + '</td></tr>';
					$ud = '<tr><td>UnitOfMeasure</td><td>' + data.unitofMeasure  + '</td></tr>';
					$json = '<div id="sums"><table border="1">'+$pc+$pd+$up+$ud+'</table></div>';
					$content.append($json);
					
				}
			}
			
			
			
		});
		
		
	});
	

	
});	

