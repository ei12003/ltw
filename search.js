$(document).ready(function() {
	
	
	$content = $('div#conteudo');
	$rb_searchtype = $("input[name='search_type']");
	$input = $('input[name="user_search"]');
	$field_header='<form action="" id="field">';
	//INVOICES
	$field_invno='<input type="radio" name="fields" value="InvoiceNo">InvoiceNo<br>';
	$field_invdate='<input type="radio" name="fields" value="InvoiceDate">InvoiceDate<br>';
	$field_invcmpname='<input type="radio" name="fields" value="CompanyName">CompanyName <br>';
	$field_invgt='<input type="radio" name="fields" value="GrossTotal">GrossTotal<br>';
	//CUSTOMERS
	$field_cid='<input type="radio" name="fields" value="CustomerID">CustomerID<br>';
	$field_ctaxid='<input type="radio" name="fields" value="CustomerTaxID ">CustomerTaxID <br>';
	$field_invcmpname='<input type="radio" name="fields" value="CompanyName">CompanyName <br>';
	//PRODUCTS
	$field_pc='<input type="radio" name="fields" value="ProductCode">ProductCode<br>';
	$field_pd='<input type="radio" name="fields" value="ProductDescription ">ProductDescription<br>';
	$field_up='<input type="radio" name="fields" value="unitPrice">UnitPrice <br>';
	$field_end='</form>';
	$op = '';
	
	
	$rb_searchtype.change(function() {
		$option = 'none';
		$('form#op').remove();
		$('form#field').remove();
		$('input[name="user_search2"]').remove();
		$('input[name="user_search"]').remove();
		$('div#sums').remove();
		
		
		//http://localhost/ltw/api/searchCustomersByField.php?op=range&field=CustomerID&value[]=2&value[]=5
		$option='api/' + $rb_searchtype.filter(":checked").val() + '.php';
		
		//CHANGE TYPE
		if($rb_searchtype.filter(":checked").val()=='searchInvoicesByField' || 
				$rb_searchtype.filter(":checked").val()=='searchCustomersByField' || 
				$rb_searchtype.filter(":checked").val()=='searchProductsByField'){
			
			$content.append('<form action="" id="op"><input type="radio" name="operators" value="range">Range<br><input type="radio" name="operators" value="equal">Equal<br><input type="radio" name="operators" value="contains">Contains<br><input type="radio" name="operators" value="min">Min<br><input type="radio" name="operators" value="max">Max<br></form>');
			$rb_operator=$("input[name='operators']");
			//CHANGE OPERATOR
			$rb_operator.change(function() {
				$('form#field').remove();
				$('input[name="user_search2"]').remove();
				$('input[name="user_search"]').remove();
				$('div#sums').remove();
				$op = $rb_operator.filter(":checked").val();
				
				
				//SET FIELDS
				if($rb_searchtype.filter(":checked").val()=='searchInvoicesByField')
				{
					if($op=='contains' || $op=='equal'){
						$content.append($field_header+$field_invno+$field_invdate+$field_invcmpname+$field_invgt+$field_end);
					}
					else if($op=='range' || $op=='min' || $op=='max'){
						$content.append($field_header+$field_invno+$field_invdate+$field_invgt+$field_end);
					}
				}
				else if($rb_searchtype.filter(":checked").val()=='searchCustomersByField')
				{
					if($op=='contains' || $op=='equal'){
						$content.append($field_header+$field_cid+$field_ctaxid+$field_invcmpname+$field_end);
					}
					else if($op=='range' || $op=='min' || $op=='max'){
						$content.append($field_header+$field_cid+$field_ctaxid+$field_end);
					}
				}
				else if($rb_searchtype.filter(":checked").val()=='searchProductsByField')
				{
					if($op=='contains' || $op=='equal'){
						$content.append($field_header+$field_pc+$field_pd+$field_up+$field_end);
					}
					else if($op=='range' || $op=='min' || $op=='max'){
						$content.append($field_header+$field_pc+$field_up+$field_end);
					}
				}
				
				$rb_fields=$("input[name='fields']");
				
				$rb_fields.change(function() {
					$('input[name="user_search2"]').remove();
					$('input[name="user_search"]').remove();
					$('div#sums').remove();
					$field = $rb_fields.filter(":checked").val();
					$input = $("input[name='user_search']");
					
					if($op=='contains' || $op=='equal'){
						
						$content.append('<input type="text" name="user_search" size="50" />');
						$input = $('input[name="user_search"]');
						$input.on("keyup",function() {
							$('div#sums').remove();
							if($input.val().length > 0){
								$get = { op: $op, field: $field, value: $input.val() };
								getJSON();
							}
						});
					}
					else if($op=='min' || $op=='max'){
						$get = { op: $op, field: $field};
						getJSON();
					}
					else if($op=='range'){
						$content.append('<input type="text" name="user_search" size="50" />');
						$content.append('<input type="text" name="user_search2" size="50" />');
						$input2 = $("input[name='user_search2']");
						$input = $('input[name="user_search"]');
						$input.on("keyup",get_rangedJson);
						$input2.on("keyup",get_rangedJson);
						
					}
					
				});
				
			});
		}
		
		
		//GET TYPE
		/*if($rb_searchtype.filter(":checked").val()=='getInvoice'
				|| $rb_searchtype.filter(":checked").val()=='getProduct'
				|| $rb_searchtype.filter(":checked").val()=='getCustomer'
				)*/
		else
		{
			
			$content.append('<input type="text" name="user_search" size="50" />');
			$input = $('input[name="user_search"]');
			
			$input.on("keyup",function() {
				// AS VEZES REPETE SE FOR RAPIDO NO COPYPASTE
				$('div#sums').remove();
				
				if($input.val().length > 0){
					
					if($option=='api/getInvoice.php')
					$get = { InvoiceNo: $input.val()};
					else if($option=='api/getCustomer.php')
					$get = { CustomerID: $input.val()};
					else if($option=='api/getProduct.php')
					$get = { ProductCode: $input.val()};
					
					
					$.getJSON($option,$get, function(data) {
						
						$.each(data, function(i, item) {
							$('div#sums').remove();
							if($option!='api/getCustomer.php' && $option!='api/getProduct.php'){
								if(!data[i].hasOwnProperty('InvoiceNo')){
									if($option == 'api/getInvoice.php')									{
										//$content.append('<div id="sums">'+data[i].reason+'</div>');
									}
									
								}
								
								else{
									$.each(data[i], function(i, doc){ $gt = doc.GrossTotal });
									$invno = '<tr><td>InvoiceNo</td><td>' + data[i].InvoiceNo + '</td></tr>';
									$invdate = '<tr><td>InvoiceDate</td><td>' + data[i].InvoiceDate + '</td></tr>';
									$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
									$grosstotal = '<tr><td>GrossTotal</td><td>' + $gt + '</td></tr>';
									$json = '<div id="sums"><table border="1"><td colspan="2"><div class="open_invoice"><a href="">Abrir</a></div></td>'+$invno+$invdate+$cmpname+$grosstotal+'</table></div>';
									$content.append($json);
									$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=fatura&id="+data.InvoiceNo);
								}	
							}
							else if($option=='api/getCustomer.php'){
								if(!data.hasOwnProperty('CustomerID')){
									//$content.append('<div id="sums">'+data[i].reason+'</div>');
								}
								
								else{
									$cid = '<tr><td>CustomerID</td><td>' + data.CustomerID + '</td></tr>';
									$ctaxid = '<tr><td>CustomerTaxID </td><td>' + data.CustomerTaxID  + '</td></tr>';
									$cmpname = '<tr><td>CompanyName</td><td>' + data.CompanyName  + '</td></tr>';
									$json = '<div id="sums"><table border="1"><td colspan="2"><div class="open_invoice"><a href="">Abrir</a></div></td>'+$cid+$ctaxid+$cmpname+'</table></div>';
									$content.append($json);
									$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=cliente&id="+data.CustomerID);
								}
							}
							else if($option=='api/getProduct.php'){
								if(!data.hasOwnProperty('ProductCode')){
									//$content.append('<div id="sums">'+data[i].reason+'</div>');
								}
								
								else{
									$pc = '<tr><td>ProductCode</td><td>' + data.ProductCode + '</td></tr>';
									$pd = '<tr><td>ProductDescription  </td><td>' + data.ProductDescription   + '</td></tr>';
									$up = '<tr><td>UnitPrice</td><td>' + data.unitPrice  + '</td></tr>';
									$json = '<div id="sums"><table border="1"><td colspan="2"><div class="open_invoice"><a href="">Abrir</a></div></td>'+$pc+$pd+$up+'</table></div>';
									$content.append($json);
									$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=produto&id="+data.ProductCode);
								}
							}
							
							
							
						});
						
						
					});
					
					
					
					
				}
				
				
			});
			
		}
	});
});



function getJSON(){
	$.getJSON($option,$get, function(data) {
									$('div#sums').remove();
									$.each(data, function(i, item) {
										if(data[i].hasOwnProperty('InvoiceNo')){
											$.each(data[i], function(i, doc){ $gt = doc.GrossTotal });
											$invno = '<tr><td>InvoiceNo</td><td>' + data[i].InvoiceNo + '</td></tr>';
											$invdate = '<tr><td>InvoiceDate</td><td>' + data[i].InvoiceDate + '</td></tr>';
											$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
											$grosstotal = '<tr><td>GrossTotal</td><td>' + $gt + '</td></tr>';
											$json = '<div id="sums"><table border="1"><td colspan="2"><div class="open_invoice"><a href="">Abrir</a></div></td>'+$invno+$invdate+$cmpname+$grosstotal+'</table></div>';
											$content.append($json);
											$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=fatura&id="+data[i].InvoiceNo);
										}
										else if(data[i].hasOwnProperty('CustomerID')){
											$cid = '<tr><td>CustomerID</td><td>' + data[i].CustomerID + '</td></tr>';
											$ctaxid = '<tr><td>CustomerTaxID </td><td>' + data[i].CustomerTaxID  + '</td></tr>';
											$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
											$json = '<div id="sums"><table border="1"><td colspan="2"><div class="open_invoice"><a href="">Abrir</a></div></td>'+$cid+$ctaxid+$cmpname+'</table></div>';									
											$content.append($json);
											$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=cliente&id="+data[i].CustomerID);
										}
										else if(data[i].hasOwnProperty('ProductCode')){
											$pc = '<tr><td>ProductCode</td><td>' + data[i].ProductCode + '</td></tr>';
											$pd = '<tr><td>ProductDescription  </td><td>' + data[i].ProductDescription   + '</td></tr>';
											$up = '<tr><td>UnitPrice</td><td>' + data[i].unitPrice  + '</td></tr>';
											$json = '<div id="sums"><table border="1"><td colspan="2"><div class="open_invoice"><a href="">Abrir</a></div></td>'+$pc+$pd+$up+'</table></div>';
											$content.append($json);
											$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=produto&id="+data.ProductCode);
										}
										$(".open_invoice a[href=\"\"]").prop("href", "open.php");
										
									});
								});	
}

function get_rangedJson() {
	if($input.val().length > 0 && $input2.val().length > 0){
							$('div#sums').remove();

							if($input.val().length > 0){
								$value = [];
								$value[0]=$input.val();
								$value[1]=$input2.val();
								$get = { op: $op, field: $field, value: $value };
								getJSON();
								
							}
							
							}
							
						}