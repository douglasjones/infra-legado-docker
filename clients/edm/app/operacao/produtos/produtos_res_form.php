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
$ds_produto = $_REQUEST['ds_produto'];

	$sql ="";
	$sql.="Select
				np.pk, 
				op.dsc_operador,
				npt.ds_tipo_produto,
				np.ds_produto, 
				case when np.dt_cancelamento is null then
				 'Ativo'
				 else
				 'Desativado'
				 end as status,
				DATE_FORMAT(np.dt_cadastro, '%d/%m/%Y') dt_cad,
				ui.nome
			from n_produtos np
			inner join operador op on np.operador_pk = op.cod_operador
			inner join n_produtos_tipo npt on np.produtos_tipo_pk = npt.pk
			left join usuariosinternos ui on np.usuario_cadastro_pk = ui.codusuariointerno";
	$sql.=" Where 1=1 "	;  
	
	
	if($dt_cancelamento == "2"){
		$sql.=" and np.dt_cancelamento is not null";
	}
	if ($dt_cancelamento == "1") {
		$sql.=" and np.dt_cancelamento is null";
	}		 	

	if(!empty($operador_pk)){
			$sql.=" and np.operador_pk=".$operador_pk;
	}	 	

	if(!empty($produto_tipo_pk)){
			$sql.=" and  npt.pk=".$produto_tipo_pk ;
	}	
	
	if(!empty($ds_produto)){
			$sql.=" and np.ds_produto like '%".$ds_produto."%'" ;
	}	
	
	$result = mysql_query($sql);
	
	grid($result, "pk", "Código//Operadora//Tipo Produto//Produto//DT Cadastro//Usuário Cadastro//Status", "pk//dsc_operador//ds_tipo_produto//ds_produto//dt_cad//nome//status");
	mysql_free_result($result);
?>
</body>
</html>

