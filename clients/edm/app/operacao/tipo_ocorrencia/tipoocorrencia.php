<?
 include_once "../../libs/maininclude.php";
	include_once "../../libs/grid.php";
	include_once "../../libs/cla.ocorrencias.php";

	
	if( isset( $_REQUEST['codtipoocorrencialead'] ) && !empty( $_REQUEST['codtipoocorrencialead'] ) && isset( $_REQUEST['acao'] ) && $_REQUEST['acao'] == 'ex' )
	{
		
		$sql= "delete from tipoocorrenciaslead where codtipoocorrencialead =".$_REQUEST['codtipoocorrencialead'];		 
	    $sql_del = mysql_query($sql);
	    javascriptalert("Operação executada com sucesso");	
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">

<?	include_once "../../libs/head.php";?>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?	$sql = "Select 
				t.codtipoocorrencialead
				,t.descricao
				,t.status
				,t.Automatica
				,t.Fechar
				,t.Minutos
                ,s.dsc_status
			,op.dsc_operador
			from tipoocorrenciaslead t
				left join empresa_operador eo on t.cod_operador = eo.cod_operador
				left join operador op on eo.cod_operador = op.cod_operador	
                inner join status s on s.cod_status = t.status_pk
			where (t.cod_operador is null  or t.cod_operador=0 or t.cod_operador in (select cod_operador from empresa_operador))
			order by t.descricao";

	$result = sql_query($sql);
	grid($result, "codtipoocorrencialead", "Código//Descrição//Mudança de Status do Lead //Gerada pelo sistema//Fechar automaticamente?//Minutos//Operador//Status ", "codtipoocorrencialead//descricao//status//Automatica//Fechar//Minutos//dsc_operador//dsc_status");
	mysql_free_result($result); ?>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
