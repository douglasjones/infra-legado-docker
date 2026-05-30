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
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/

    include_once "../../libs/maininclude.php";
    include_once "../../libs/cla.combo.php";
	include_once "../../libs/cla.grupomenu.php";
	$codgrupousuariointerno = null;
	$nome = null;
	$acao = "ins";

	if (!empty($_REQUEST['codgrupousuariointerno'])){
		$codgrupousuariointerno = $_REQUEST['codgrupousuariointerno'];
		$acao = "upd";

		//Faz a pesquisa no banco de dados.
		$sql = "select * ";
		$sql .= "  from gruposusuariosinternos ";
		$sql .= " where codgrupousuariointerno = " . mysqlnull($codgrupousuariointerno);
		$result = sql_query($sql);
		while($row = mysql_fetch_array($result)){
			$nome = $row['Nome'];
			$gerente = $row['CodGerente'];
		}
		mysql_free_result($result);
	}
	if(!empty($_REQUEST['Enviar'])){
		if($codgrupousuariointerno = grupomenu::adicionar($_REQUEST)){
			javascriptalert('Operação executada com sucesso!!!', false, false);
			?>
				<script>
					window.close();
				</script>
			<?
		}
	}
	if(!(($acao == 'ins' && permissao('grupos', 'ic')) || ($acao == 'upd' && permissao('grupos', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    
    <!--Cabeçalho-->
	<title>Grupos Usuários Internos</title>
	
	
<?	include_once "../../libs/head.php";?>

    <!-- Código Javascript -->
	<script type="text/javascript" language="javascript">
	function validaForm(frm)
	{
		if(!validateForm(frm)) return false
		selecionar()
		if(document.dados.nome.value == ''){
			alert('Nome deve ser especificado')
			document.dados.focus()
			return false
		}
		return true
	}

	function CheckAll(valor, tipo){
		var ic, al, ex, cs, dt
		var objs = document.getElementsByTagName('input')
		for(var i = 0; i < objs.length; i++){
			if(tipo.test(objs[i].name))
				objs[i].checked = valor
		}
		
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="post" action="grupomenunew.php" onsubmit="return validaForm(this)">
<input type="hidden" name="codgrupousuariointerno" value="<?=$codgrupousuariointerno;?>" />
<input type="hidden" name="acao" value="<?=$acao?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Grupos de Usuários
		</td>
	</tr>
</table>
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
   	<tr>
          <td>&nbsp;
              
          </td>
    </tr>
	<tbody>
		<tr>
			<td> &nbsp;Nome:</td>
			<td><input type="text" name="nome" value="<?=$nome;?>" maxlength="255" size="50" validate="required" /></td>
		</tr>
		
		<tr>
			<td colspan="2">
				<table cellpadding="0" border="0" cellspacing="0" class="form" align="center">
									<tbody>&nbsp;
<?	$sql = "Select m.cod_menu,m.dsc_menu";
	$sql .= " from menu m ";
	$sql .= " where m.cod_status=1";
	
	$result = sql_query($sql);
	while($row = mysql_fetch_array($result)){
		
		$sql = "Select gm.cod_menu,gm.codgrupousuariointerno,gm.acessar";
		$sql .= "  from grupo_menu gm";
		$sql .= " where codgrupousuariointerno = " . mysqlnull($codgrupousuariointerno);
		$sql .= " and cod_menu = " . mysqlnull($row['cod_menu']);
		
		$result1 = sql_query($sql);
		$ac = 0;

		while($row1 = mysql_fetch_array($result1)){
			$ac = $row1['acessar'];
			
		}
		mysql_free_result($result1);?>
								<tr>
									<td><?=$row['dsc_menu'];?></td>
									<td>
									<input type="hidden" name="cod_menu[]" value="<?=$row['cod_menu'];?>">
									<input type="checkbox" name="ac[]" <?=($ac != 0?'checked="checked"':null);?> value="<?=$row['cod_menu'];?> "></td>
								</tr>
<?	}
	mysql_free_result($result);?>
							</tbody>
							<tfoot>
									<tr>
			<td colspan="2" align="right">&nbsp;
				
			</td>
		</tr>
								<tr>
									<td colspan="6" align="center">
										<input type="button" class="botao" value="Selecionar Tudo" onclick="javascript:CheckAll(true, /(ic|al|ex|cs|dt)[0-9]+/)" />
										<input type="reset" class="botao" value="Reset" />
										<input type="button" class="botao" value="Limpa Tudo" onclick="javascript:CheckAll(false, /(ic|al|ex|cs|dt)[0-9]+/)" />&nbsp;
									</td>
								</tr>
							</tfoot>
						</table>
					</td>
				</tr>
			</tbody>
		<tr>
			<td colspan="2" align="right">&nbsp;
				
			</td>
		</tr>
				<tr>
					<td colspan="2" align="center">
						<input type="submit" class="botao" name="Enviar" value="Enviar" />
						<input type="button" class="botao" value="Fechar" onclick="self.close()" />&nbsp;
					</td>
				</tr>

		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
