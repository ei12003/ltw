<?php include_once './header.php'; ?>

		<div id="conteudo" align="center">
		
		<form action="" id="typeOfSearch">
		
			<input type="radio" id="r1" name="search_type" value="searchInvoicesByField"><label for="r1">Invoices By Field</label>
			<input type="radio" id="r2" name="search_type" value="searchCustomersByField"><label for="r2">Customers By Field</label>
			<input type="radio" id="r3" name="search_type" value="searchProductsByField"><label for="r3">Products By Field</label><br>
			<input type="radio" id="r4" name="search_type" value="getInvoice"><label for="r4">Get Invoice</label>
			<input type="radio" id="r5" name="search_type" value="getProduct"><label for="r5">Get Product</label>
			<input type="radio" id="r6" name="search_type" value="getCustomer"><label for="r6">Get Customer</label>
		</form>
		
			<hr noshade size=1 width="33%">
		</div>
		
		<div class="pages" align="center">
			<ul class="nav">
				<li class="b">Back</li>
				<li class="n">Next</li>
			</ul>
		</div>
		
<?php include_once 'footer.php'; ?>