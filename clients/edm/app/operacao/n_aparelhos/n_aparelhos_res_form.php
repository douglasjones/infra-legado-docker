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
$sql = "Select
		o.cod_operador operador_pk
		,o.dsc_operador
	from operador o
		inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
if(!empty($_REQUEST['operador_pk'])){			
	$sql.=" where o.cod_operador=".$_REQUEST['operador_pk'];
}		
$result = sql_query($sql);

$row = mysql_fetch_array($result);

$operador_pk = $row['operador_pk'];
$fabricante_pk = $_REQUEST['fabricante_pk'];
$ds_aparelho = $_REQUEST['ds_aparelho'];

	$sql ="";
	$sql.="Select
				nap.pk, 
				op.dsc_operador,
				npf.ds_aparelho_fabricante,
				nap.ds_aparelho, 
				case when nap.dt_cancelamento is null then
				 'Ativo'
				 else
				 'Desativado'
				 end as status,
				DATE_FORMAT(nap.dt_cadastro, '%d/%m/%Y') dt_cad,
				ui.nome
			from n_aparelhos nap
			inner join operador op on nap.operador_pk = op.cod_operador
			left join n_aparelhos_fabricantes npf on nap.fabricante_pk = npf.pk
			inner join usuariosinternos ui on nap.usuario_cadastro_pk = ui.codusuariointerno";
	$sql.=" Where 1=1 "	;  
	
	
	if($dt_cancelamento == "2"){
		$sql.=" and nap.dt_cancelamento is not null";
	}
	if ($dt_cancelamento == "1") {
		$sql.=" and nap.dt_cancelamento is null";
	}		 	

	if(!empty($operador_pk)){
			$sql.=" and nap.operador_pk=".$operador_pk;
	}	 	

	if(!empty($fabricante_pk)){
			$sql.=" and  nap.fabricante_pk=".$fabricante_pk ;
	}	
	
	if(!empty($ds_aparelho)){
			$sql.=" and nap.ds_aparelho like '%".$ds_aparelho."%'" ;
	}	
	
	$sql.=" Order by nap.ds_aparelho";
	
	$result = mysql_query($sql);
	
	grid($result, "pk", "Código//Operadora//Fabricante//Aparelho//DT Cadastro//Usuá¡rio Cadastro//Status", "pk//dsc_operador//ds_aparelho_fabricante//ds_aparelho//dt_cad//nome//status");
	mysql_free_result($result);
?>
</body>
</html>

