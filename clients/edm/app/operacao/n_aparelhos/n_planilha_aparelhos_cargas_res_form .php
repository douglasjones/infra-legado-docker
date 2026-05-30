<?
include_once "../../libs/maininclude.php";
include_once "../../libs/grid.php";
include_once "../../libs/datas.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
    <!-- Cabeçalho -->
	<title></title>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="javascript">
	function abrirGrid(campo, valor){
		switch(campo){
			case 'campo':
				NewWindow("n_planilha_aparelhos_cargas_cad_form.php?pk="+valor,500,400);
				break
		}
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	$pagina = 1;
	if(isset($_REQUEST['pagina']))
		$pagina = $_REQUEST['pagina'];
	if($pagina == 0)
		$pagina = 1;

	if(isset($_REQUEST['sql'])){
		$sql = $_REQUEST['sql'];
	}else{
		$sql =" SELECT  pk,
                        date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, 
                        date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, 
                        usuario_cadastro_pk, 
                        usuario_ult_atualizacao_pk, 
                        date_format(dt_inicio, '%d/%m/%Y') dt_inicio, 
                        dt_cancelamento
                FROM n_planilha_aparelhos_cargas ";
	}
	
	pagegrid($sql, "pk", array("Cód", "", ""), array("pk", "", ""), 30, $pagina, array('pk' => 'pk'));?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
