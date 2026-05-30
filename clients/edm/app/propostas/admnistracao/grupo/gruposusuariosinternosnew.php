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
			$horarioini = $row["horarioini"];
			$horariofim = $row["horariofim"];
			$ip = $row["ip"];
		}
		mysql_free_result($result);
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
<form name="dados" method="post" action="gruposusuariosinternoscad.php" onsubmit="return validaForm(this)">
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
		<tr>
			<td> &nbsp;Nome:</td>
			<td><input type="text" name="nome" value="<?=$nome;?>" maxlength="255" size="50" validate="required" /></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="gerente">Gerente:<br>(Só Tlmkt)</label></td>
			<td valign="top">
			<?	
			$sql = "Select codusuariointerno AS gerente, Nome, Desativado from usuariosinternos order by Desativado, Nome;";
			$tipos[0]['valor'] = '-1';
			$tipos[1]['valor'] = 1;
			$tipos[0]['style'] = 'color:#009900';
			$tipos[1]['style'] = 'color:#990000';
			$tipos['max'] = 2;
			combo_tipos($sql, "gerente", $tipos, $gerente, " ", null);
			?>
			</td>
		</tr>
		<tr>
			<td>Hr Acesso: </td>
			<td>
				<input type="text" id="horarioini" onkeypress="return horamask(this)"  name="horarioini" value="<?=$horarioini;?>" size="10" validate="datatype=time;required"  />
				&nbsp;até&nbsp;
				<input type="text" id="horariofim" onkeypress="return horamask(this)" name="horariofim" value="<?=$horariofim;?>" size="10" validate="datatype=time;required"  />
			</td>
		</tr>
		<tr>
			<td>IP: </td>
			<td>
				<input type="text" id="ip" name="ip" value="<?=$ip;?>"  />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<table cellpadding="0" border="0" cellspacing="0" class="form" align="center">
					<thead>
						<tr>
							<td>Paginas</td>
							<td><input type="checkbox" onclick="javascript:CheckAll(this.checked, /(ic)[0-9]+/)" />IC</td>
							<td><input type="checkbox" onclick="javascript:CheckAll(this.checked, /(al)[0-9]+/)" />AL</td>
							<td><input type="checkbox" onclick="javascript:CheckAll(this.checked, /(ex)[0-9]+/)" />EX</td>
							<td><input type="checkbox" onclick="javascript:CheckAll(this.checked, /(cs)[0-9]+/)" />CS</td>
							<td><input type="checkbox" onclick="javascript:CheckAll(this.checked, /(dt)[0-9]+/)" />DT</td>
						</tr>
					</thead>
					<tbody>&nbsp;
					<?	
						$sql = "select * ";
						$sql .= "  from paginas ";
						$sql .= "  order by descricao";
						$result = sql_query($sql);
						while($row = mysql_fetch_array($result)){
							$sql = "select * from gruposusuariosinternos_paginas ";
							$sql .= " where codgrupousuariointerno = " . mysqlnull($codgrupousuariointerno);
							$sql .= " and codpagina = " . mysqlnull($row['CodPagina']);
							$result1 = sql_query($sql);
							$ic = 0;
							$al = 0;
							$ex = 0;
							$cs = 0;
							$dt = 0;
							while($row1 = mysql_fetch_array($result1)){
								$ic = $row1['IC'];
								$al = $row1['AL'];
								$ex = $row1['EX'];
								$cs = $row1['CS'];
								$dt = $row1['DT'];
							}
							mysql_free_result($result1);
					?>
								<tr>
									<td><?=$row['Descricao'];?></td>
									<td><input type="checkbox" name="ic<?=$row['CodPagina'];?>" value="1" <?=($ic != 0?'checked="checked"':null);?> /></td>
									<td><input type="checkbox" name="al<?=$row['CodPagina'];?>" value="1" <?=($al != 0?'checked="checked"':null);?> /></td>
									<td><input type="checkbox" name="ex<?=$row['CodPagina'];?>" value="1" <?=($ex != 0?'checked="checked"':null);?> /></td>
									<td><input type="checkbox" name="cs<?=$row['CodPagina'];?>" value="1" <?=($cs != 0?'checked="checked"':null);?> /></td>
									<td><input type="checkbox" name="dt<?=$row['CodPagina'];?>" value="1" <?=($dt != 0?'checked="checked"':null);?> /></td>
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
						<input type="submit" class="botao" value="Enviar" />
						<input type="button" class="botao" value="Fechar" onclick="self.close()" />&nbsp;
					</td>
				</tr>

		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
