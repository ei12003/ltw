$(document).ready(function() {
	
	if($type == "produto"){
		$('#conteudo').append('<div id="edit"><div id="sums"><table border="1"><tbody><tr><th colspan="2"><div class="open_invoice"><a class="conc" href="">Concluir</a></div></th></tr><tr><td>ProductDescription</td><td><input type="text"></td></tr><tr><td>UnitPrice</td><td><input type="text"></td></tr><tr><td>UnitOfMeasure</td><td><input type="text"></td></tr></tbody></table></div></div>');
		$url='api/updateProduct.php';
	}
	else if($type == "cliente"){
		$('#conteudo').append('<div id="sums"><table border="1"><tbody><tr><th colspan="2"><div class="open_invoice"><a class="conc" href="">Concluir</a></div></th></tr><tr><td>CustomerTaxID</td><td><input type="text"></td></tr><tr><td>CompanyName</td><td><input type="text"></td></tr><tr><td>BillingAddress</td><td><table border="2"><tbody><tr><td>AddressDetail</td><td><input type="text"></td></tr><tr><td>City</td><td><input type="text"></td></tr><tr><td>PostalCode</td><td><input type="text"></td></tr><tr><td>Country</td><td><input type="text"></td></tr></tbody></table></td></tr><tr><td>Email</td><td><input type="text"></td></tr></tbody></table></div>');
		$url='api/updateCustomer.php';
	}
	else if($type == "fatura"){
		$('#conteudo').append('Lines podem ser adicionadas posteriormente. Os outros valores serão gerados automaticamente.');
		$('#conteudo').append('<div id="sums"><table border="1"><tbody><tr><th colspan="2"><div class="open_invoice"><a class="conc" href="">Concluir</a></div></th></tr><tr><td>InvoiceDate</td><td><input type="text"></td></tr><tr><td>CustomerID</td><td><input type="text"></td></tr></tbody></table></div>');
		$('#conteudo').append('<div id="addLines"><b>Add Line*</b><br>ProductCode: <input type="text" name="ProductCode" class="formpc"><br>Quantity: <input type="text" name="Quantity" class="formqa"><br></div>');
		$url='api/updateInvoice.php';
	}
	
	$(document).on('click', '.conc', function(e){		
		e.preventDefault();
		
		if($type=="fatura" && $('.formpc').val() == "" && $('.formqa').val() == "")
			alert("Add one line!");
			
			else{
		$doc = {};
		var $rows = $("tr").not("tr th");
		$doc = getArray($rows);		
		$.post("api/addLine.php", {id:-1, pc:$('.formpc').val(),qa:$('.formqa').val()}, function( linenumber ) {
			
			$doc['linenumber']=linenumber.split("%")[1];
			$.post($url, $doc, function( data ) {
				
			});
		});		

			}
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
						
						
						$temp1[$cell1] = $cell2;
						
						if($(this).is('tr:last-child') && $cell1 != "CustomerID" && $cell1 != "Email" && $cell1 != "UnitOfMeasure"){
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