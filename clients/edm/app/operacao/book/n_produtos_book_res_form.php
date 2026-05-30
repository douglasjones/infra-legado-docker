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
				NewWindow("n_produtos_book_cad_form.php?pk="+valor,500,400);
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
    
        $pk = $_REQUEST['pk'];
        $dt_cadastro = $_REQUEST['dt_cadastro'];
        $usuario_cadastro_pk = $_REQUEST['usuario_cadastro_pk'];
        $dt_ult_atualizacao = $_REQUEST['dt_ult_atualizacao'];
        $usuario_ult_atualizacao_pk = $_REQUEST['usuario_ult_atualizacao_pk'];
        $dt_cancelamento = $_REQUEST['dt_cancelamento'];
        $operador_pk = $_REQUEST['operador_pk'];
        $n_dsc_book = $_REQUEST['n_dsc_book'];
        $dt_inicio = $_REQUEST['dt_inicio'];
        $dt_fim = $_REQUEST['dt_fim'];
        $status_pk = $_REQUEST['status_pk'];
	if(isset($_REQUEST['sql'])){
		$sql = $_REQUEST['sql'];
	}else{
		$sql ="select npb.pk,
                       date_format(dt_cadastro, '%d/%m/%Y %H:%i:%s') dt_cadastro, 
                       date_format(dt_ult_atualizacao, '%d/%m/%Y %H:%i:%s') dt_ult_atualizacao, 
                       npb.usuario_cadastro_pk, 
                       npb.usuario_ult_atualizacao_pk, 
                       date_format(dt_cancelamento, '%d/%m/%Y %H:%i:%s') dt_cancelamento, 
                       npb.operador_pk, 
                       npb.n_dsc_book, 
                       date_format(dt_inicio, '%d/%m/%Y') dt_inicio, 
                       date_format(dt_fim, '%d/%m/%Y') dt_fim, 
                       op.dsc_operador
			  from n_produtos_book npb
              inner join operador op on npb.operador_pk = op.cod_operador";
        $sql.=" Where 1=1 "	;  
        
        if($dt_cancelamento == "2"){
		$sql.=" and npb.dt_cancelamento is not null";
	}else{
		$sql.=" and npb.dt_cancelamento is null";
	}		 			 	
	if(!empty($operador_pk)){
			$sql.=" and npb.operador_pk=".$operador_pk;
	}	 	
	
	if(!empty($n_dsc_book)){
			$sql.=" and npb.n_dsc_book like '%".$n_dsc_book."%'" ;
            
	}
}
	pagegrid($sql, "pk", array("Cód", "Descrição", "operadora","Data de inicio","Data fim"), array("pk", "n_dsc_book", "dsc_operador","dt_inicio","dt_fim"), 30, $pagina, array('pk' => 'pk'));?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
