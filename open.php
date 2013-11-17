<!DOCTYPE html>
<html>
	<head>
		<title>Sistema de Faturação Online </title>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="open.css">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="open.js"></script>
	</head>
	<body>
	
		<div id="cabecalho">
			<h1>Sistema de Faturação Online</h1>
		</div>
		<script type="text/javascript">
			var $type = <?php echo '\''.$_GET['type'].'\''; ?>;
			var $id = <?php echo '\''.$_GET['id'].'\''; ?>;
		</script>
		<div id="menu">
			<ul>
				<li><a href="index.php">Search</a></li>
			</ul>
		</div>
		<div id="print">
		</div>
		<div id="conteudo">


		</div>
		<div id="print">
		</div>
		<div id="rodape">
			<p>Sistema de Faturação Online</p>
		</div>
	</body>
</html>
