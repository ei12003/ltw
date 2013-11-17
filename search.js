$(document).ready(function() {
	
	$max = 5;
	$content = $('div#conteudo');
	$rb_searchtype = $("input[name='search_type']");
	$input = $('input[name="user_search"]');
	$field_header='<form action="" id="field">';
	//INVOICES
	$field_invno='<input type="radio" id="r12" name="fields" value="InvoiceNo"><label for="r12">InvoiceNo</label>';
	$field_invdate='<input type="radio" id="r13" name="fields" value="InvoiceDate"><label for="r13">InvoiceDate</label>';
	$field_invcmpname='<input type="radio" id="r14" name="fields" value="CompanyName"><label for="r14">CompanyName</label>';
	$field_invgt='<input type="radio" id="r15" name="fields" value="GrossTotal"><label for="r15">GrossTotal</label>';
	//CUSTOMERS
	$field_cid='<input type="radio" id="r12" name="fields" value="CustomerID"><label for="r12">CustomerID</label>';
	$field_ctaxid='<input type="radio" id="r13" name="fields" value="CustomerTaxID"><label for="r13">CustomerTaxID</label>';
	$field_invcmpname='<input type="radio" id="r14" name="fields" value="CompanyName"><label for="r14">CompanyName</label>';
	//PRODUCTS
	$field_pc='<input type="radio" id="r12" name="fields" value="ProductCode"><label for="r12">ProductCode</label>';
	$field_pd='<input type="radio" id="r13" name="fields" value="ProductDescription"><label for="r13">ProductDescription</label>';
	$field_up='<input type="radio" id="r14" name="fields" value="unitPrice"><label for="r14">UnitPrice</label><br>';
	$field_end='</form>';
	$op = '';
	

	
	$('.pages ul li.n').hide();
	$('.pages ul li.b').hide();
	$('.pages ul li.n').click(function() {
		changePage('+');
	});
	$('.pages ul li.b').click(function() {
		changePage('-');
	});
	
	$rb_searchtype.change(function() {
		$option = 'none';
		$('form#op').remove();
		$('form#field').remove();
		$('input[name="user_search2"]').remove();
		$('input[name="user_search"]').remove();
		$('div.sums').remove();
		hideNav();
		
		//http://localhost/ltw/api/searchCustomersByField.php?op=range&field=CustomerID&value[]=2&value[]=5
		$option='api/' + $rb_searchtype.filter(":checked").val() + '.php';
		
		//CHANGE TYPE
		if($rb_searchtype.filter(":checked").val()=='searchInvoicesByField' || 
				$rb_searchtype.filter(":checked").val()=='searchCustomersByField' || 
				$rb_searchtype.filter(":checked").val()=='searchProductsByField'){
			
			$content.append('<form action="" id="op"><input type="radio" id="r7" name="operators" value="range"><label for="r7">Range</label><input type="radio" id="r8" name="operators" value="equal"><label for="r8">Equal</label><input type="radio" id="r9" name="operators" value="contains"><label for="r9">Contains</label><br><input type="radio" id="r10" name="operators" value="min"><label for="r10">Min</label><input type="radio" id="r11" name="operators" value="max"><label for="r11">Max</label><hr noshade size=1 width="33%"><form>');
			$rb_operator=$("input[name='operators']");
			//CHANGE OPERATOR
			$rb_operator.change(function() {
				$('form#field').remove();
				$('input[name="user_search2"]').remove();
				$('input[name="user_search"]').remove();
				$('div.sums').remove();
				hideNav();
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
				//CHANGE FIELDS
				$rb_fields.change(function() {
					$('input[name="user_search2"]').remove();
					$('input[name="user_search"]').remove();
					$('div.sums').remove();
					$field = $rb_fields.filter(":checked").val();
					$input = $("input[name='user_search']");
					hideNav();
					if($op=='contains' || $op=='equal'){
						
						$content.append('<input type="text" name="user_search" size="50" />');
						$input = $('input[name="user_search"]');
						$input.on("keyup",function() {
							$('div.sums').remove();
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
						$content.append('<input type="text" name="user_search2" size="50" /><br>');
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
				$('div.sums').remove();
				
				if($input.val().length > 0){
					
					if($option=='api/getInvoice.php')
					$get = { InvoiceNo: $input.val()};
					else if($option=='api/getCustomer.php')
					$get = { CustomerID: $input.val()};
					else if($option=='api/getProduct.php')
					$get = { ProductCode: $input.val()};
					
					
					$.getJSON($option,$get, function(data) {
						
						$.each(data, function(i, item) {
							$('div.sums').remove();
							if($option!='api/getCustomer.php' && $option!='api/getProduct.php'){
								if(!data[i].hasOwnProperty('InvoiceNo')){
									if($option == 'api/getInvoice.php')									{
										//$content.append('<div class="sums">'+data[i].reason+'</div>');
									}
									
								}
								
								else{
									$.each(data[i], function(i, doc){ $gt = doc.GrossTotal });
									$invno = '<tr><td>InvoiceNo</td><td>' + data[i].InvoiceNo + '</td></tr>';
									$invdate = '<tr><td>InvoiceDate</td><td>' + data[i].InvoiceDate + '</td></tr>';
									$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
									$grosstotal = '<tr><td>GrossTotal</td><td>' + $gt + '</td></tr>';
									$json = '<div class="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="">Abrir Detalhes</a></div></th>'+$invno+$invdate+$cmpname+$grosstotal+'</table></div>';
									$content.append($json);
									$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=fatura&id="+data[i].InvoiceNo);
								}	
							}
							else if($option=='api/getCustomer.php'){
								if(!data.hasOwnProperty('CustomerID')){
									//$content.append('<div class="sums">'+data[i].reason+'</div>');
								}
								
								else{
									$cid = '<tr><td>CustomerID</td><td>' + data.CustomerID + '</td></tr>';
									$ctaxid = '<tr><td>CustomerTaxID </td><td>' + data.CustomerTaxID  + '</td></tr>';
									$cmpname = '<tr><td>CompanyName</td><td>' + data.CompanyName  + '</td></tr>';
									$json = '<div class="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="">Abrir Detalhes</a></div></th>'+$cid+$ctaxid+$cmpname+'</table></div>';
									$content.append($json);
									$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=cliente&id="+data.CustomerID);
								}
							}
							else if($option=='api/getProduct.php'){
								if(!data.hasOwnProperty('ProductCode')){
									//$content.append('<div class="sums">'+data[i].reason+'</div>');
								}
								
								else{
									$pc = '<tr><td>ProductCode</td><td>' + data.ProductCode + '</td></tr>';
									$pd = '<tr><td>ProductDescription</td><td>' + data.ProductDescription   + '</td></tr>';
									$up = '<tr><td>UnitPrice</td><td>' + data.unitPrice  + '</td></tr>';
									$json = '<div class="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="">Abrir Detalhes</a></div></th>'+$pc+$pd+$up+'</table></div>';
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
	$('.sums').remove();
	$.getJSON($option,$get, function(data) {
		
		
		$.each(data, function(i, item) {
			if(data[i].hasOwnProperty('InvoiceNo')){
				$.each(data[i], function(i, doc){ $gt = doc.GrossTotal });
				$invno = '<tr><td>InvoiceNo</td><td>' + data[i].InvoiceNo + '</td></tr>';
				$invdate = '<tr><td>InvoiceDate</td><td>' + data[i].InvoiceDate + '</td></tr>';
				$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
				$grosstotal = '<tr><td>GrossTotal</td><td>' + $gt + '</td></tr>';
				$json = '<div class="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="">Abrir Detalhes</a></div></th>'+$invno+$invdate+$cmpname+$grosstotal+'</table></div>';
				$content.append($json);
				$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=fatura&id="+data[i].InvoiceNo);
			}
			else if(data[i].hasOwnProperty('CustomerID')){
				
				$cid = '<tr><td>CustomerID</td><td>' + data[i].CustomerID + '</td></tr>';
				$ctaxid = '<tr><td>CustomerTaxID </td><td>' + data[i].CustomerTaxID  + '</td></tr>';
				$cmpname = '<tr><td>CompanyName</td><td>' + data[i].CompanyName  + '</td></tr>';
				$json = '<div class="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="">Abrir Detalhes</a></div></th>'+$cid+$ctaxid+$cmpname+'</table></div>';									
				$content.append($json);
				$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=cliente&id="+data[i].CustomerID);
			}
			else if(data[i].hasOwnProperty('ProductCode')){
				$pc = '<tr><td>ProductCode</td><td>' + data[i].ProductCode + '</td></tr>';
				$pd = '<tr><td>ProductDescription</td><td>' + data[i].ProductDescription   + '</td></tr>';
				$up = '<tr><td>UnitPrice</td><td>' + data[i].unitPrice  + '</td></tr>';
				$json = '<div class="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="">Abrir Detalhes</a></div></th>'+$pc+$pd+$up+'</table></div>';
				$content.append($json);
				$(".open_invoice a[href=\"\"]").prop("href", "open.php?type=produto&id="+data[i].ProductCode);
			}
			$(".open_invoice a[href=\"\"]").prop("href", "open.php");
			
		});
		$totalsize = $(".sums").size();
		$r1 = 1;
		$r2 = $max;
		if($totalsize>$max){
			$('.pages ul li.n').show();
			$('.pages ul li.b').show();
		}
		changePage();
	});	
	
				
	
}
function changePage($op){
	if($op=='-')
	{
		$r2-=$max;
		$r1-=$max;
		$('.pages ul li.n').show();
	}
	else if($op=='+')
	{
		$r2+=$max;
		$r1+=$max;	
		$('.pages ul li.b').show();
	}
	if($r2>=$totalsize){
		$('.pages ul li.n').hide();
	}
	if($r1==1){
		$('.pages ul li.b').hide();
	}
	
	$(".sums").each(function(index){
		if(index>=$r1-1 && index <=$r2-1)
		$(this).show();
		else
		$(this).hide();
	
	});

}
function hideNav(){
	$('.pages ul li.n').hide();
	$('.pages ul li.b').hide();
}

function get_rangedJson() {
	if($input.val().length > 0 && $input2.val().length > 0){
		$('div.sums').remove();
		hideNav();
		if($input.val().length > 0){
			$value = [];
			$value[0]=$input.val();
			$value[1]=$input2.val();
			$get = { op: $op, field: $field, value: $value };
			getJSON();
			
			
		}
		
	}
	
}