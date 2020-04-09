<?php 
$r = $_GET['h'];

require_once("../php/config.php");

$Model = new Model;
$dados = $Model->hash($r);

$r = $dados;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Contato do site</title>
</head>
<body>
<div style="width: 640px; font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
	<h1>Mensagem de contato do site.</h1>
	<div>
	<p>
		Nome: <?php echo $r->nome; ?> <br>
		Telefone: <?php echo $r->telefone; ?> <br>
		E-mail: <?php echo $r->email; ?> <br>
		Mensagem: <?php echo $r->mensagem; ?> <br>
	</p>
  </div>
</div>
</body>
</html>
