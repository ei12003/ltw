<!DOCTYPE html>
<html>
	<head>
		<title>Sistema de Faturação Online </title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="search.js"></script>
	</head>
	<body>
		<div id="cabecalho">
			<h1>Sistema de Faturação Online</h1>
		</div>
		<div id="menu">
			<ul>
				<li><a href="index.php">Search</a></li>
			</ul>
		</div>
		<div id="conteudo" align="center">
		
		<form action="" id="typeOfSearch">
		
			<input type="radio" id="r1" name="search_type" value="searchInvoicesByField"><label for="r1">Invoices By Field</label>
			<input type="radio" id="r2" name="search_type" value="searchCustomersByField"><label for="r2">Customers By Field</label>
			<input type="radio" id="r3" name="search_type" value="searchProductsByField"><label for="r3">Products By Field</label><br>
			<input type="radio" id="r4" name="search_type" value="getInvoice"><label for="r4">Get Invoice</label>
			<input type="radio" id="r5" name="search_type" value="getProduct"><label for="r5">Get Product</label>
			<input type="radio" id="r6" name="search_type" value="getCustomer"><label for="r6">Get Customer</label>
		</form>
		    
			<p><hr noshade size=1 width="33%"><p>
			
	
		<!--
		<form action="" id="op">
		<input type="radio" name="operators" value="range">Range<br>
		<input type="radio" name="operators" value="equal">Equal<br>
		<input type="radio" name="operators" value="contains">Contains<br>
		<input type="radio" name="operators" value="min">Min<br>
		<input type="radio" name="operators" value="max">Max<br>
		</form>
		-->
		

		
	
		
		
		
		
		
		</div>
		<div id="rodape">
			<p>Sistema de Faturação Online</p>
		</div>
	</body>
</html>
