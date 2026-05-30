<?
/*
/---------------------------------------------------\
|						    						|
|DESCRIÇÃO: PRINCIPAIS FUNÇÕES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVISÕES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 2/10/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/

  include_once "../../libs/maininclude.php";
  include_once "../../libs/cla.menu.php";
  include_once "../../libs/combo.php" ;
  
	$acao = ($_REQUEST['acao']?$_REQUEST['acao']:'ins');
	if($acao == 'del'){
		if( menu::excluir_relacionador($_REQUEST['cod_relacionador'])){
			javascriptalert('Operação executada com sucesso.');
			?><script type="text/javascript" language="javascript">
				if(opener){
					if(opener.top.pagina)
						opener.top.pagina.refresh();
				}
				self.close();
			</script><?
		}
	}
	if(!empty($_REQUEST['Enviar'])){
		if(empty($_REQUEST['codsubmenu'])){
			if( $codmenu = menu::adicionar_relacionador($_REQUEST)){
				javascriptalert('Operação executada com sucesso.');
			}
		}else{
			if( menu::alterar_relacionador($_REQUEST)){
				javascriptalert('Operação executada com sucesso.');
			}
		}		
	}
	
	if($_REQUEST['codsubmenu']){
		$acao = 'upd';
		$sql = "SELECT * FROM relacionador WHERE cod_relacionador = ".$_REQUEST['cod_relacionador'];
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result))
		{
			$cod_relacionador	= $row['cod_relacionador'];
			$dsc_relacionador	= $row['dsc_relacionador'];
			$dsc_tabela			= $row['dsc_tabela'      ];
			$status 			= $row['status'          ];
			
			mysql_free_result($result);
		}
	}
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<script language="javascript"></script></script>
	<title>Relacionador</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function validaForm(frm){
	if(!validateForm(frm)) return false
	if(!confirm("Deseja enviar os dados digitados?")){
		return false
	}
	return true
}
	</script>
	
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<!-- Tags HTML -->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="dados" method="post" action="relacionadornew.php" onsubmit="return validaForm(this)">
	<input type="hidden" id="cod_relacionador" name="cod_relacionador" value="<?=@$_REQUEST['cod_relacionador'];?>" />
	<input type="hidden" id="acao" name="acao" value="<?=$acao?>"/>
	
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Relacionador
		</td>
	</tr>
</table>		
<table width="100%" height="100%"  align="center" border="0" cellpadding="3" cellspacing="3" class="form">
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<tr>
		<td> &nbsp;<label for="dsc_submenu">Tabela:</label></td>
		<td>
		<input type="text" name="dsc_tabela" value="<?=$dsc_tabela;?>">
		</td>
	</tr>
	<tr>
		<td> &nbsp;<label for="dsc_submenu">Relacionador:</label></td>
		<td>
		<input type="text" name="dsc_relacionador" value="<?=$dsc_relacionador;?>">
		</td>
	</tr>
	<tr>
		<td> &nbsp;<label for="status">Status:</label></td>
		<td>
<?
				$sql = "SELECT cod_status , dsc_status FROM status WHERE 1" ;
				combo( $sql , "status" , $status , "" , "" , "" ) ;
?>
			
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" class="botao" name="Enviar" value="Enviar" />&nbsp;
			<input type="button" class="botao" value="Fechar" onclick="self.close();" />&nbsp;
		</td>
	</tr>
	
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

</body>
</html>
