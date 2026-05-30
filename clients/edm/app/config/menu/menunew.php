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
|DATA: 14/10/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/
  include_once "../../libs/maininclude.php";
  include_once "../../libs/cla.menu.php";
  include_once "../../libs/combo.php" ;

	$acao = ($_REQUEST['acao']?$_REQUEST['acao']:'ins');

	if($acao == 'del'){
		if( menu::excluir($_REQUEST['codmenu'])){
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
		if(empty($_REQUEST['codmenu'])){
			if( $codmenu = menu::adicionar($_REQUEST)){
				javascriptalert('Operação executada com sucesso.');
			}
		}else{
			if( menu::alterar($_REQUEST)){
				javascriptalert('Operação executada com sucesso.');
			}
		}		
		?><script type="text/javascript" language="javascript">
			if(opener){
				if(opener.top.pagina)
					opener.top.pagina.refresh();
			}
			self.close();
		</script><?
	}

	if($_REQUEST['codmenu']){
		$acao = 'upd';
		$sql = "SELECT * FROM menu WHERE cod_menu = ".$_REQUEST['codmenu'];
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$dsc_menu = $row['dsc_menu'];
			$cod_status = $row['cod_status'];
			$ordem = $row['ordem'];
			mysql_free_result($result);
		}
	}?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Menu</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function validaForm(frm){
	if(!validateForm(frm)) return false
	if(!confirm("Deseja enviar os dados digitados?")){
		return false
	}
	return true
}

function numeros( n )
{
	var num = document.getElementById( n ).value ;
	var tam = num.length ;
	if ( isNaN( num ) )
	{
		tam -= 1 ;
		document.getElementById( n ).value = num.substring( 0 , tam ) ; 
	}
}
	</script>
	
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<!-- Tags HTML -->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="dados" method="post" action="menunew.php" onsubmit="return validaForm(this)">
	<input type="hidden" id="codmenu" name="codmenu" value="<?=@$_REQUEST['codmenu'];?>" />
	<input type="hidden" id="acao" name="acao" value="<?=$acao?>"/>
	<!--<input type="hidden" id="cod_status" name="cod_status" value="< ?=$cod_status?>" />-->
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Menu
		</td>
	</tr>
</table>		
<table width="100%" height="100%"  align="center" border="0" cellpadding="3" cellspacing="3" class="form">
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<tr>
		<td> &nbsp;<label for="nome">Menu:</label></td>
		<td><input type="text" name="dsc_menu" value="<?=$dsc_menu;?>"></td>
	</tr>
	<tr>
		<td> &nbsp;<label for="stat">Status:</label></td>
		<td>
			<?
				$sql = "SELECT cod_status, dsc_status from status";
				combo($sql, "cod_status", $cod_status, "", "", "");
			?>
		</td>
	</tr><?
	if ( $acao != "ins" ){ ?>
	<tr>
		<td> &nbsp;<label for="desc_ordem">Ordem:</label></td>
		<td>
			<input type="text" id="ordem" name="ordem" value="<?=$ordem;?>" size="5" maxlength="5" />
		</td>
	</tr>
	<? }?>
	
	<tr>
		<td colspan="2" align="right">&nbsp;</td>
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
