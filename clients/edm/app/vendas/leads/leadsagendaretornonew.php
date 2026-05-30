<?
 /*
/---------------------------------------------------\
|						    						|
|DESCRI&#199;&#195;O: PRINCIPAIS FUN&#199;&#213;ES DO SISTEMA EM PHP    |
|						    						|
|					     	    					|
|REVIS&#213;ES:					    					|
|						    						|
|						    						| 
|DESESENVOLVIDO POR: DOUGLAS JONES LOPES	    	|
|						    						|
|DATA: 24/09/2008	     			    			|
\___________________G_E_P_R_O_S_____________________/
*/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.agendaretorno.php";
	include_once "../../libs/combo.php";
	
	$acao = "ins";
	
	$agenda['CodAgendaRetorno'] = null;
	$agenda['CodLead'] = null;
	$agenda['CodUsuarioInterno'] = $_SESSION['codusuario'];
	$agenda['UsuarioInterno'] = $NomeUsuario;
	$agenda['AgendadoPara'] = $_SESSION['codusuario'];
	$agenda['NomeAgendadoPara'] = $NomeUsuario;
	$agenda['Futuro'] = true;
	
	if(!empty($_REQUEST['codlead']))
		$agenda['CodLead'] = $_REQUEST['codlead'];
	
	if(!empty($_REQUEST['codagendaretorno']))
		$agenda['CodAgendaRetorno'] = $_REQUEST['codagendaretorno'];
	
	if(!empty($_REQUEST['reagendar']))
		$reagendar = $agenda['CodAgendaRetorno'];

	if(!empty($_REQUEST['visita'])){
		if(!empty($agenda['CodAgendaRetorno'])){
			$sql = "Select * From agendaretorno Where CodAgendaRetorno = " . mysqlnull($agenda['CodAgendaRetorno']);
			$rs = sql_query($sql);
			$row = mysql_fetch_array($rs);
			mysql_free_result($rs);
			ocorrencias::alterar($row['CodOcorrenciaLead'], array('datafechamento' => 'SYSDATE()'));?>
		<script type="text/javascript" language="javascript" src="../../extras/public.js"></script>
		<script type="text/javascript" language="javascript">
			NewWindow("leadsagendanew.php?acao=ins&codlead=<?=$agenda['CodLead'];?>",590,560)
			if(opener)
				opener.location.reload()
			window.close()
		</script>
<?		}
	}
	
	if(!empty($_REQUEST['retornado'])){
		if(!empty($agenda['CodAgendaRetorno'])){
			$sql = "Select * From agendaretorno Where CodAgendaRetorno = " . mysqlnull($agenda['CodAgendaRetorno']);
			$rs = sql_query($sql);
			$row = mysql_fetch_array($rs);
			mysql_free_result($rs);
			$codocorrencialead = $row['CodOcorrenciaLead'];
			ocorrencias::alterar($row['CodOcorrenciaLead'], array('datafechamento' => 'SYSDATE()'));?>
		<script type="text/javascript" language="javascript" src="../../extras/public.js"></script>
		<script type="text/javascript" language="javascript">
			NewWindow("leadocorrencianew.php?codlead=<?=$agenda['CodLead'];?>&ocorrenciasuperior=<?$agenda['CodOcorrenciaLead'];?>",500,280)
			if(opener)
				opener.location.reload()
			window.close()
		</script>
<?		}
	}
	
	if(!empty($_REQUEST['excluir']))
		if(!empty($agenda['CodAgendaRetorno']))
			if(agendaretorno::excluir($agenda['CodAgendaRetorno']))
				javascriptalert('Opera&#231;&#227;o executada com sucesso!!!');
	
	if(!empty($_REQUEST['enviar'])){
		if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1]))
			$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]) . ' ' . $_REQUEST['datacadastro'][1];
		if(!empty($_REQUEST['dataretorno'][0])  && !empty($_REQUEST['dataretorno'][1]))
			$_REQUEST['dataretorno'] = dataYMD($_REQUEST['dataretorno'][0]) . ' ' . $_REQUEST['dataretorno'][1];
		if(!empty($_REQUEST['dataretornado'][0]) && !empty($_REQUEST['dataretornado'][1]))
			$_REQUEST['dataretornado'] = dataYMD($_REQUEST['dataretornado'][0]) . ' ' . $_REQUEST['dataretornado'][1];
			else
				$_REQUEST['dataretornado'] = 'null';
		if(!empty($_REQUEST['codocorrencialead']))
			$_REQUEST['codocorrencialead'] = null;
		if(!empty($reagendar)){
			agendaretorno::adicionar($_REQUEST, $reagendar , 'agendaretorno');
		}elseif(empty($agenda['CodAgendaRetorno'])){
			agendaretorno::adicionar($_REQUEST , null , 'agendaretorno');
		}elseif(!empty($agenda['CodAgendaRetorno'])){
			agendaretorno::alterar($agenda['CodAgendaRetorno'], $_REQUEST);
		}else{
			javascriptalert('Erro ao executar a opera&#231;&#227;o. Dados insuficientes ou inv&#225;lidos!!!');
		}
		javascriptalert('Operação executada com sucesso!!!');
	}else{
		if(!empty($agenda['CodAgendaRetorno'])){
			$acao = "upd";
			//Traz os dados da agenda.
			$sql = "select a.*, o.DataFechamento DataRetornado, u.Nome UsuarioInterno, u1.Nome NomeAgendadoPara, (a.DataRetorno > SYSDATE()) Futuro ";
			$sql .= " from agendaretorno a";
			$sql .= " left join usuariosinternos u on a.CodUsuarioInterno = u.CodUsuarioInterno";
			$sql .= " left join usuariosinternos u1 on a.AgendadoPara = u1.CodUsuarioInterno";
			$sql .= " left join ocorrenciaslead o on a.CodOcorrenciaLead = o.CodOcorrenciaLead";
			$sql .= " where a.CodAgendaRetorno = " . mysqlnull($agenda['CodAgendaRetorno']);
			$result = sql_query($sql);
			if(!$agenda = mysql_fetch_array($result)){
				exit();
			}
			mysql_free_result($result);
			if(!empty($reagendar)){
				$acao = "ins";
				$agenda['CodAgendaRetorno'] = null;
				$agenda['CodUsuarioInterno'] = $_SESSION['codusuario'];
				$agenda['UsuarioInterno'] = $NomeUsuario;
				$agenda['DataCadastro'] = null;
				$agenda['DataRetorno'] = null;
				$agenda['DataRetornado'] = null;
				$agenda['Descricao'] = null;
				$agenda['CodOcorrenciaLead'] = null;
				$agenda['Futuro'] = true;
			}
		}
		//Pesquisa os dados do lead.
		$sql = "Select CONCAT(l.RazaoSocial, IFNULL(CONCAT(' (', l.NomeFantasia, ')'), '')) RazaoSocial, l.CodGerenteConta ";
		$sql .= ", CONCAT(l.Endereco, IFNULL(CONCAT(', ', l.Numero), ''), IFNULL(CONCAT(' - ', l.Complemento), '')) Endereco1 ";
		$sql .= ", CONCAT(l.Bairro, IFNULL(CONCAT(' - ', l.Cidade), ''), IFNULL(CONCAT('/', l.UF), ''), IFNULL(CONCAT(' - ', l.CEP), '')) Endereco2";
		$sql .= " From leads l ";
		$sql .= " where l.CodLead = " . mysqlnull($agenda['CodLead']);
		$result = sql_query($sql);
		if(!$lead = mysql_fetch_array($result)){
			exit;
		}
		mysql_free_result($result);
	}
	if(!(($acao == 'ins' && permissao('agendaretorno', 'ic')) || ($acao == 'upd' && permissao('agendaretorno', 'al')))){
		javascriptalert('Voc&#234; n&#227;o tem permiss&#227;o para acessar esta p&#225;gina!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
    <!--Cabe&#231;alho-->
	<title>Agendar Retorno</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
function excluirRetorno(){
	if(confirm('Confirma excluir Retorno ?'))
		return true
	return false
}

function validaCampos(){
	if(!validateForm(document.forms[0])) return false
	return true
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" action="leadsagendaretornonew.php" onSubmit="return validaCampos(this)">
<?	if(isset($reagendar)){?>
		<input type="hidden" id="reagendar" name="reagendar" value="<?=$reagendar;?>" />
<?	}?>
<?	if(isset($reagendar)){?>
		<input type="hidden" id="codagendaretorno" name="codagendaretorno" value="<?=$reagendar;?>" />
<?	}else{?>
		<input type="hidden" id="codagendaretorno" name="codagendaretorno" value="<?=$agenda['CodAgendaRetorno'];?>" />
<?	}?>
		<input type="hidden" id="codlead" name="codlead" value="<?=$agenda['CodLead'];?>" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Agendamento de Retorno
		</td>
	</tr>
</table>			
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">

			<tbody>
				<tr>
          <td>&nbsp;
              
          </td>
    </tr>
<?	if(!empty($agenda['CodAgendaRetorno'])){?>
				<tr>
					<td>&nbsp;C&#243;digo:</td>
					<td><?=$agenda['CodAgendaRetorno'];?></td>
				</tr>
<?	}?>
				<tr>
					<td>&nbsp;Lead:</td>
					<td><?=$lead['RazaoSocial'];?></td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codusuariointerno">Agendado por:</label></td>
					<td>
<?	if(!$Root){?>
						<?=$agenda['UsuarioInterno'];?>
<?	}else{
		$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($agenda['CodUsuarioInterno']) . " Order By ui.Nome";
		combo($sql, "codusuariointerno", $agenda['CodUsuarioInterno'], null, 'validate="required"');
	}?>
					</td>
				</tr>
				<tr>
					<td>&nbsp;<label for="agendadopara">Agendado para:</label></td>
					<td>
<?	if(($acao == 'upd' && !$agenda['Futuro']) || !$Root){
		$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($agenda['AgendadoPara']) . " Order By ui.Nome";
		combo($sql, "agendadopara", $agenda['AgendadoPara'], null, 'validate="required"');
	}else{?>
						<?=$agenda['NomeAgendadoPara'];?>
<?	}?>
					</td>
				</tr>
<?	if($acao != 'ins' && $Root){?>
				<tr>
					<td>&nbsp;<label for="datacadastro">Data cadastro:</label></td>
					<td>
						<input type="text" id="datacadastro" name="datacadastro[]" size="12" maxlength="10" onkeypress="mascara(this,datamask)" value="<?=(!empty($agenda['DataCadastro'])?date('d/m/Y', strtotime($agenda['DataCadastro'])):'');?>" validate="datatype=date;required" />
						&nbsp;&#224;s&nbsp;
						<input type="text" id="horariocadastro" name="datacadastro[]" size="8" onkeypress="return horamask2(this,event)" maxlength="8" value="<?=(!empty($agenda['DataCadastro'])?date('H:i:s', strtotime($agenda['DataCadastro'])):'');?>" validate="datatype=time;required" />
					</td>
				</tr>
<?	}?>
				<tr>
					<td>&nbsp;<label for="dataretorno">Data e hor&#225;rio:</label></td>
					<td>
<?	if($agenda['Futuro'] || $acao == 'ins' || $Root){?>
						<input type="text" id="dataretorno" name="dataretorno[]" size="12" onkeypress="mascara(this,datamask)" maxlength="10" value="<?=(!empty($agenda['DataRetorno'])?date('d/m/Y', strtotime($agenda['DataRetorno'])):'');?>" validate="datatype=date;required" />
						&nbsp;&#224;s&nbsp;
						<input type="text" id="horariovisita" name="dataretorno[]" size="8" onkeypress="return horamask2(this,event)" maxlength="5" value="<?=(!empty($agenda['DataRetorno'])?date('H:i', strtotime($agenda['DataRetorno'])):'');?>" validate="datatype=shorttime;required" />
<?	}else{?>
						<?=(!empty($agenda['DataRetorno'])?date('d/m/Y \&#224;\s H:i', strtotime($agenda['DataRetorno'])):null);?>
<?	}?>
					</td>
				</tr>
<?	if($Root){?>
				<tr>
					<td>&nbsp;<label for="codocorrencialead">Ocorr&#234;ncia:</label></td>
					<td><input type="text" name="codocorrencialead" size="5" maxlength="10" value="<?=@$agenda['CodOcorrenciaLead'];?>" validate="datatype=numeric" /></td>
				</tr>
<?	}?>
				<tr>
					<th colspan="2">&nbsp;<label for="descricao">Descri&#231;&#227;o:</label></th>
				</tr>
				<tr>
					<td colspan="2" align="center"><textarea cols="55" rows="5" id="descricao" name="descricao" style="width:98%"><?=@$agenda['Descricao'];?></textarea></td>
				</tr>
			</tbody>
			<tfoot>
					<tr>
			<td colspan="2">&nbsp;
				
			</td>
		</tr>
				<tr>
					<th  colspan="2" align="right">
						<input type="submit" name="enviar" value="Salvar" />
<?	if(empty($agenda['DataRetornado'])  && !empty($agenda['CodAgendaRetorno'])){
		if(permissao('agendaretorno', array('al', 'ic'))){?>
						<input type="submit" name="reagendar" value="Novo Retorno" />
<?		}
		if(permissao('agenda', 'ic')){?>
						<input type="submit" name="visita" value="Agendar Visita" />
<?		}
		if(permissao('agendaretorno', 'ic')){?>
						<input type="submit" name="retornado" value="Retorno" />
<?		}
	}
	if($Root && !empty($agenda['CodAgendaRetorno'])){?>
						<input type="submit" name="excluir" value="Excluir" onClick="return excluirRetorno()" />
<?	}?>
						<input type="button" name="fechar" value="Fechar" onClick="window.close()" />&nbsp;
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>