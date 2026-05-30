<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.campanha.php";
	include_once "../../libs/grid.php";
	
?>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	
	$result = campanha::listar();
	grid($result, "cod_campanha", "Código//Nome//Descrição Campanha//Data Início Campanha//Data Fim Campanha", "cod_campanha//nome_campanha//descricao_campanha//dt_inicio_campanha//dt_fim_campanha");
	mysql_free_result($result);
?>
</body>
</html>

