$reg = {};
$reg['r_lns']='^[a-zA-Z0-9 .\\-,_]*$';
$reg['r_n']='^[0-9]*.{1}[0-9]*$';
$reg['r_ls']='^[a-zA-Z ]*$';
$reg['r_pc']='^[0-9]{4}(([0-9]{3}){0,1})$';

$(document).ready(function() {
	$content = $('div#conteudo');
	
	if($type=='cliente')
	{
		$option='api/getCustomer.php';
		$get = { CustomerID: $id };
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
				if(data.hasOwnProperty('InvoiceNo'))
				{
					
					$invno = '<tr><td>InvoiceNo</td><td>' + data.InvoiceNo + '</td></tr>';
					$invdate = '<tr><td>InvoiceDate</td><td>' + data.InvoiceDate + '</td></tr>';
					$cid = '<tr><td>CustomerID</td><td>' + data.CustomerID  + '</td></tr>';
					$cmpname = '<tr><td>CompanyName</td><td>' + data.CompanyName  + '</td></tr>';
					$line = '<tr><td colspan=2>Line</td></tr>';
					$.each(data.Line, function(i, item) {
						
						
						$line += '<tr><td id="l'+item.LineNumber+'">Linenumber '+(i+1)+' <button class="deleteLine" id ="'+item.LineNumber+'">X</button></td><td><table border="2" id="tb">';
						$line += '<tr><td>ProductCode</td><td>'+item.ProductCode+'</td></tr>';
						$line += '<tr><td>Quantity</td><td>'+item.Quantity+'</td></tr>';
						$line += '<tr><td>CreditAmount</td><td>'+item.CreditAmount+'</td></tr>';
						
						$.each(item.Tax, function(i, item) {
							$line += '<tr><td colspan=2>Tax</td></tr>';
							$line += '<tr><td>TaxType</td><td>'+item.TaxType+'</td></tr>';
							$line += '<tr><td>TaxPercentage</td><td>'+item.TaxPercentage+'</td></tr>';							
							
						});
						$line += '</table></td></tr>';
						
						

					});
					$dt = '<tr><td>DocumentTotals</td><td><table border="2" >';
					$dt += '<tr><td>TaxPayable</td><td>' + data.DocumentTotals.TaxPayable + '</td></tr>';
					$dt += '<tr><td>NetTotal</td><td>' + data.DocumentTotals.NetTotal + '</td></tr>';
					$dt += '<tr><td>GrossTotal</td><td>' + data.DocumentTotals.GrossTotal + '</td></tr></table></td></tr>';
					$json = '<div id="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="" class="edit">Editar Fatura</a></div></th>'+$invno+$invdate+$cid+$cmpname+$line+$dt+'</table></div>';
					$content.append($json);
					$url='api/updateInvoice.php';
					

				}	
			}
			else if($option=='api/getCustomer.php'){
				if(data.hasOwnProperty('CustomerID')){		
					$cid = '<tr><td>CustomerID</td><td>' + data.CustomerID + '</td></tr>';
					$ctaxid = '<tr><td class="r_n">CustomerTaxID</td><td>' + data.CustomerTaxID  + '</td></tr>';
					$cmpname = '<tr><td class="r_lns">CompanyName</td><td>' + data.CompanyName  + '</td></tr>';
					
					$ba  = '<tr><td>BillingAddress</td><td><table border="2" >';
					$ba += '<tr><td class="r_lns">AddressDetail</td><td>' + data.BillingAddress.AddressDetail  + '</td></tr>';
					$ba += '<tr><td class="r_ls">City</td><td>' + data.BillingAddress.Cidade  + '</td></tr>';
					$ba += '<tr><td class="r_pc">PostalCode</td><td>' + data.BillingAddress.PostalCode  + '</td></tr>';
					$ba += '<tr><td class="r_ls">Country</td><td>' + data.BillingAddress.Country  + '</td></tr></table></td></tr>';
					
					
					
					$email = '<tr><td>Email</td><td>' + data.Email  + '</td></tr>';
					$json = '<div id="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="" class="edit">Editar Cliente</a></div></th>'+$cid+$ctaxid+$cmpname+$ba+$email+'</table></div>';
					$content.append($json);
					$url='api/updateCustomer.php';
					
				}
			}
			else if($option=='api/getProduct.php'){
				if(data.hasOwnProperty('ProductCode')){
					$pc = '<tr><td>ProductCode</td><td>' + data.ProductCode + '</td></tr>';
					$pd = '<tr><td class="r_lns">ProductDescription</td><td>' + data.ProductDescription   + '</td></tr>';
					$up = '<tr><td class="r_n" >UnitPrice</td><td>' + data.unitPrice  + '</td></tr>';
					$ud = '<tr><td class="r_lns" >UnitOfMeasure</td><td>' + data.unitofMeasure  + '</td></tr>';
					$json = '<div id="sums"><table border="1"><th colspan="2"><div class="open_invoice"><a href="" class="edit">Editar Produto</a></div></th>'+$pc+$pd+$up+$ud+'</table></div>';
					$content.append($json);
					$url='api/updateProduct.php';
				}
			}
			
			
		});
		$('.deleteLine').hide();
		
		
		
		
		if($type=="fatura"){
			$get_xml='<div class="pages" align="center"><ul class="nav"><li class="b">Export saft-pt[2]</li></div>';
			$('div#export').append($get_xml);
			$('div#export .pages ul li').click(function() {
				//$.post("api/xml.php", data, function( xml ) {});
				post_to_url("api/xml.php", {id: $id});
			});
			
		}
		
		$print_html='<div class="pages" align="center"><ul class="nav"><li class="b">Print</li></div>';
		$('div#print').append($print_html);
		$('div#print .pages ul li').click(function() {
			window.print();
		});
		
		
		
		
		$(document).on('click', '.edit', function(e){
			$('.deleteLine').show();
			$('div#addLines').append('<form name="log" action="api/addLine.php" method="post">');
			$('div#addLines').append('<input class="subm" name="submit" type="submit" value="Add Line"><br />');
			$('div#addLines').append('ProductCode: <input class="formpc" type="text" name="ProductCode"><br />');
			$('div#addLines').append('Quantity: <input class="formqa" type="text" name="Quantity"><br />');
			$('div#addLines').append('</form>');
			$(document).on('click', '.subm', function(e){
				
				$.post("api/addLine.php", {id:$id.split("/")[1], pc:$('.formpc').val(),qa:$('.formqa').val()}, function( data ) {
					//location.reload();
				});	
				$doc = {};
				var $rows = $("tr").not("tr th");
				$doc=getArray($rows);
				
				$.post( "api/updateInvoice.php", { CustomerID: $doc['CustomerID'], InvoiceDate: $doc['InvoiceDate']} );	
			});
			
			$(document).on('click','.deleteLine',function(){
				//$.post( "api/deleteLine.php", { fatura: $id, id: this.id} );	
				$doc = {};
				var $rows = $("tr").not("tr th");
				$doc=getArray($rows);
				
				$.post( "api/updateInvoice.php", { CustomerID: $doc['CustomerID'], InvoiceDate: $doc['InvoiceDate']} );	
				//location.reload();
			});
			
			e.preventDefault();
			$('div#print').remove();
			$ctr = 0;
			$('tr td:nth-child(2)').each(function (key, value) {
				if($(this).siblings().text()=="CompanyName")
				return false;
				if($(this).find('table').html()==null){
					if($ctr > 0){
						var html = $(this).html();
						var input = $('<input type="text" />');
						input.val(html);
						$(this).html(input);
					}
					else $ctr = 1;
				}
				
			});
			$(".edit").attr('class', 'conc');
			$(".conc").text("Concluir");
			$(document).on('click', '.conc', function(e){
				e.preventDefault();
				$doc = {};
				var $rows = $("tr").not("tr th");
				$doc=getArray($rows);
				
				if($doc)
				$.post($url, $doc, function( data ) {
					//location.reload();
				});
				else
				location.reload();
				
				
				
			});
		});
		

		
		
	});
	

	
	
	
});	


function getArray($selected){
	var $arr = {};
	var $temp1 = {};
	var $temp2 = {};
	var $temp3 = {};
	var $line = [];
	var $temp4 = {};
	var $cell1_tmp;
	var $flag = 0;
	var $flag2 = 0;
	var $oi = {};
	var err;
	var $tax = [];
	var $tax_tmp = {};
	var $isTax = false;
	var counter=0;
	$selected.each(function(index) {
		
		if(counter==4)
		counter=0;
		$cell1 = $(this).find("td:first").text();
		$regex = $reg[$(this).find("td:first").attr('class')];
		if($cell1){
			
			if($cell1 == "Tax"){
				$isTax=true;
				$counter =0;
			}
			
			if($isTax)
			{
				if(counter==0){
					counter++;
					
				}
				else if(counter==1){
					counter++;
					$tax_tmp[$cell1]=$cell2 = $(this).find("td:nth-child(2)").text();
					
				}
				else if(counter==2){
					$tax_tmp[$cell1]=$cell2 = $(this).find("td:nth-child(2)").text();
					counter=4;
					$isTax=false;
					$tax.push($tax_tmp);
					if($(this).is('tr:last-child')){
						$flag=20;
						$temp2['Tax']=$tax;
						$tax=[];
					}
					
					
					
					
					
				}
			}
			
			if(!$isTax) {
				
				if($flag!=20){
					if($cell1 == "Line"){
						$flag2 = 1;
					}
					else if($(this).find("td:nth-child(2) table").html()==null){

						
						$cell2 = $(this).find("td:nth-child(2) input[type=\"text\"]").val();
						if(!$cell2)
						$cell2 = $(this).find("td:nth-child(2)").text();
						$match = $cell2.match($regex);
						
						if($regex!=null){
							/*if(!($regex.test($c))){
								alert("Valores mal introduzidos! ["+$cell1+"]"+$cell2.match($regex)+"|"+$cell2+"|"+$regex);
								err = true;
								return false;
							}*/
						}
						
						$temp1[$cell1] = $cell2;
						
						if($(this).is('tr:last-child') && $cell1 != "CreditAmount" && $cell1 != "Email" && $cell1 != "UnitOfMeasure"){
							$flag = 2;
						}
					}
					else{
						if($cell1 == "DocumentTotals"){				
							$temp1["Line"] = $line;
							$flag = 0;
							$flag2 = 0;
							$arr["Line"]=$line;
							$temp1 = {};
							
						}		
						var str_ar = $cell1.split(" ");
						if(str_ar[0]=="Linenumber"){
							$temp1[str_ar[0]] = str_ar[1];
							$cell1_tmp = str_ar[0];
						}
						else
						$cell1_tmp = $cell1;
						
						$flag = 1;	
					}
				}
				
				
				if($flag == 0 && $flag2 == 0){
					$.extend($arr,$arr,$temp1);
				}
				else if($flag == 1)
				$.extend($temp2,$temp2,$temp1);
				else if($flag == 2 || $flag == 20)
				{
					
					$.extend($temp2,$temp2,$temp1);
					
					if($cell1_tmp!="Linenumber")
					$temp3[$cell1_tmp] = $temp2;
					else
					$temp3 = $temp2;
					
					if($flag2==1){
						$line.push($temp3);
						
					}
					
					
					else
					$.extend($arr,$arr,$temp3);
					$flag = 0;
					$temp2 = {};				
				}
				
				
				$temp1 = {};
				$temp3 = {};
				
			}
			
			
		}
	});
	
	if(!err)
	return $arr;
	else
	return false;
}

function post_to_url(path, params) {
	method = "post";
	
	var form = document.createElement("form");
	form.setAttribute("method", method);
	form.setAttribute("action", path);

	for(var key in params) {
		if(params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);
			form.appendChild(hiddenField);
		}
	}
	document.body.appendChild(form);
	form.submit();

}