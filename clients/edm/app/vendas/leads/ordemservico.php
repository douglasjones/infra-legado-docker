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
	include_once "../../libs/combo.php";
	include_once "../../libs/cla.os.php";

	$acao		= $_REQUEST['acao'];
	$codlead	= $_REQUEST['codlead'];
	
	if($acao=='new') {
		$acao 	= 'ins';
		$values	= os::newos($codlead);
	}
	elseif($acao=='edi') {
		$acao	= 'upd';
		$values = os::edit($_REQUEST);
	}
	elseif($acao=='ins') {
		os::insert($_REQUEST);
		
		javascriptalert('Operação realizada com sucesso.');
	}
	elseif($acao=='upd') {
		os::update($_REQUEST);

		javascriptalert('Operação realizada com sucesso.');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <!--Cabeçalho-->
    <title>Ordem de Serviço</title>
	<?	include_once "../../libs/head.php";?>
	<script language="javascript" type="text/javascript">
	function enviaform() {
		document.getElementById('formOS').submit();
	}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="formOS" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
<input id="acao" name="acao" type="hidden" value="<?=@$acao;?>" />
<table cellpadding="0" cellspacing="0" border="0" class="form">
	<thead>
		<tr>
			<th colspan="4">Ordens de Servi&ccedil;o</th>
		</tr>
		<tr>
			<td style="text-align: left; width: 25%;">
			<label for="codos">Ordem de Serviço</label>
			</td>
			<td style="text-align: right; width: 25%;">
			#<input id="codos" name="codos" type="text" size="5" value="<?=@$values['codos'];?>" />
			</td>
			<td style="text-align: left; width: 25%;">
			<label for="codproposta">N&uacute;mero da Proposta</label>
			</td>
			<td style="text-align: right; width: 25%;">
			#<input id="codproposta" name="codproposta" type="text" size="5" value="<?=@$values['codproposta'];?>" />
			.
			<input id="versaoproposta" name="versaoproposta" type="text" size="5" value="<?=@$values['versaoproposta'];?>" />
			</td>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td>
			Data:
			</td>
			<td style="text-align:right;">&nbsp;
			<input type="text" id="dataos" name="dataos" size="10" value="<?=(!empty($_REQUEST['dataos'])?date('d/m/Y', strtotime($_REQUEST['dataos'])):date('d/m/Y', strtotime($values['dataos'])));?>" maxlength="10" validate="datatype=date" />
			</td>
			<td>
			Per&iacute;odo:
			</td>
			<td style="text-align:right;">&nbsp;
			<select id="periodo" name="periodo">
				<option value="0" <?=(@$values['periodo']==0?'selected="selected"':null);?>>Manhã</option>
				<option value="1" <?=(@$values['periodo']==1?'selected="selected"':null);?>>Tarde</option>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td>
			Status:
			</td>
			<td style="text-align:right;">&nbsp;
			<select id="status" name="status">
				<option value="0" <?=(@$values['status']==0?'selected="selected"':null);?>>N&atilde;o realizado</option>
				<option value="1" <?=(@$values['status']==1?'selected="selected"':null);?>>Realizado</option>
			</select>
			</td>
			<td>
			Aç&atilde;o:
			</td>
			<td style="text-align:right;">&nbsp;
			<select id="osacao" name="osacao">
				<option value="0" <?=(@$values['osacao']==0?'selected="selected"':null);?>>Instala&ccedil;&atilde;o</option>
				<option value="1" <?=(@$values['osacao']==1?'selected="selected"':null);?>>Retirada</option>
				<option value="2" <?=(@$values['osacao']==2?'selected="selected"':null);?>>Chamado T&eacute;cnico</option>
			</select>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr style="border: 1 solid #000000;">
			<td>
			<label for="codinstalador">Instalador:</label>
			</td>
			<td style="text-align:right;">
			<?
			$sql = "SELECT codusuariointerno, Nome FROM usuariosinternos WHERE GerenteContas = 1 AND Desativado <> 1 ORDER BY Nome";
			combo($sql, "codinstalador", $values['codinstalador'], "", ' validate="required"');
			?>
			</td>
			<td>
			<label for="codconsultor">Consultor:</label>
			</td>
			<td style="text-align:right;">
			<?
			$sql = "SELECT codusuariointerno, Nome FROM usuariosinternos WHERE GerenteContas = 1 AND Desativado <> 1 ORDER BY Nome";
			combo($sql, "codconsultor", $values['codconsultor'], "", ' validate="required"');
			?>
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td>
			<label for="responsavel">Respons&aacute;vel</label>
			</td>
			<td style="text-align:right;">
			<input id="responsavel" name="responsavel" type="text" size="15" value="<?=@$values['responsavel'];?>" />
			</td>
			<td>
			<label for="respctt">Contato</label>
			</td>
			<td style="text-align:right;">
			<input id="respctt" name="respctt" type="text" size="15" value="<?=@$values['respctt'];?>" />
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td>
			<label for="serialgateway">N&uacute;mero de s&eacute;rie do gateway </label></td>
			<td style="text-align:right;">
			<input id="serialgateway" name="serialgateway" type="text" size="15" value="<?=@$values['serialgateway'];?>" />
			</td>
			<td>
			<label for="enderecoip">Endere&ccedil;o IP:</label>
			</td>
			<td style="text-align:right;">
			<input id="enderecoip" name="enderecoip" type="text" size="15" value="<?=@$values['enderecoip'];?>" />
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td>
			<label for="login">Login:</label></td>
			<td style="text-align:right;">
			<input id="login" name="login" type="text" size="15" value="<?=@$values['login'];?>" />
			</td>
			<td>
			<label for="senha">Senha</label>
			</td>
			<td style="text-align:right;">
			<input id="senha" name="senha" type="text" size="15" value="<?=@$values['senha'];?>" />
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td>
			<label for="canais">Canais Instalados:</label></td>
			<td style="text-align:right;">
			<input id="canais" name="canais" type="text" size="15" value="<?=@$values['canais'];?>" />
			</td>
			<td>
			<label for="senha">Try &amp; Buy:</label>
			</td>
			<td style="text-align:right;">
			de
			<input type="text" id="datatrybuyde" name="datatrybuyde" size="10" value="<?=(!empty($_REQUEST['datatrybuyde'])?date('d/m/Y', strtotime($_REQUEST['datatrybuyde'])):date('d/m/Y', strtotime(@$values['datatrybuyde'])));?>" maxlength="10" validate="datatype=date" /><br />
			at&eacute;
			<input type="text" id="datatrybuyate" name="datatrybuyate" size="10" value="<?=(!empty($_REQUEST['datatrybuyate'])?date('d/m/Y', strtotime($_REQUEST['datatrybuyate'])):date('d/m/Y', strtotime(@$values['datatrybuyate'])));?>" maxlength="10" validate="datatype=date" />
			</td>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<th colspan="4" style="text-align: justify;">
			<label for="descinst">Descri&ccedil;&atilde;o da instala&ccedil;&atilde;o:</label><br />
			<textarea id="descinst" name="descinst" rows="10" style=" width: 100%;"><?=@$values['descinst'];?></textarea>			
			</th>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<th colspan="4" style="text-align: justify;">
			<label for="observacoes">Observa&ccedil;&otilde;es:</label><br />
			<textarea id="observacoes" name="observacoes" rows="10" style=" width: 100%;"><?=@$values['observacoes'];?></textarea>			
			</th>
		</tr>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<th colspan="4" style="text-align: justify;">
			<label for="infuteis">Informa&ccedil;&otilde;es &Uacute;teis:</label><br />
			<textarea id="infuteis" name="infuteis" rows="10" style=" width: 100%;"><?=@$values['infuteis'];?></textarea>			
			</th>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="height: 1px; background: #000000; padding: 0px; margin: 0px; border: 0px; ">
			</td>
		</tr>
		<tr>
			<td colspan="4" style="text-align: center;">
			<input type="button" value="Salvar" onClick="enviaform();" />
			<input type="button" value="Fechar" onClick="self.close();" />
			</td>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>
