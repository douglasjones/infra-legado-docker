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
$dt_cancelamento = $_REQUEST['dt_cancelamento'];
if(empty($operador_pk)){	
	$operador_pk = $_REQUEST['operador_pk'];
}
$produto_tipo_pk = $_REQUEST['produto_tipo_pk'];
$ds_combo = $_REQUEST['ds_combo'];

	$sql ="";
	$sql.="Select
				nc.pk,
				o.dsc_operador, 
				nc.ds_combo,
				DATE_FORMAT(nc.dt_cadastro, '%d/%m/%Y') dt_cad,
				case when nc.dt_cancelamento is null then
				 'Ativo'
				 else
				 'Desativado'
				 end as status,
				ui.nome
			from n_combos nc
				inner join operador o on nc.operador_pk = o.cod_operador 
				left join usuariosinternos ui on nc.usuario_cadastro_pk = ui.CodUsuarioInterno";
	$sql.=" Where 1=1 "	;  
	
	if($dt_cancelamento == "2"){
		$sql.=" and nc.dt_cancelamento is not null";
	}else{
		$sql.=" and nc.dt_cancelamento is null";
	}		 	

	if(!empty($operador_pk)){
			$sql.=" and nc.operador_pk=".$operador_pk;
	}	 	
	
	if(!empty($ds_combo)){
			$sql.=" and ns.ds_combo like '%".$ds_combo."%'" ;
	}	
	
	$result = mysql_query($sql);
	
	grid($result, "pk", "Código//Operadora//Produto//DT Cadastro//Usuário Cadastro//Status", "pk//dsc_operador//ds_combo//dt_cad//nome//status");
	mysql_free_result($result);
?>
</body>
</html>

