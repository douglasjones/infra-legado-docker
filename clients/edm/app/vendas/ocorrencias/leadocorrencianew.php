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
	include_once "../../libs/datas.php";
	include_once "../../libs/combo.php";
	include_once "../../libs/cla.ocorrencias.php";

	if(!empty($_REQUEST['fecharocorrencia'])){
		if(!empty($_REQUEST['codocorrencialead'])){
			$codocorrencia = $_REQUEST['codocorrencialead'];
			ocorrencias::alterar($codocorrencia, array('datafechamento' => 'SYSDATE()'));
		}else{
			javascriptalert('Dados insuficientes.');
		}
		javascriptalert('Operação executada com sucesso.');
	}

	if(!empty($_REQUEST['excluir'])){
		if(!empty($_REQUEST['codocorrencialead'])){
			$codocorrencia = $_REQUEST['codocorrencialead'];
			ocorrencias::excluir($codocorrencia);
		}else{
			javascriptalert('Dados insuficientes.');
		}
		javascriptalert('Operação executada com sucesso.');
	}

	if(!empty($_REQUEST['enviar'])){
		if(!empty($_REQUEST['datacadastro'])){
			if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1])){
				$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]) . ' ' . $_REQUEST['datacadastro'][1];
			}else{
				$_REQUEST['datacadastro'] = null;
			}
		}
		if(!empty($_REQUEST['datafechamento'])){
			if(!empty($_REQUEST['datafechamento'][0]) && !empty($_REQUEST['datafechamento'][1])){
				$_REQUEST['datafechamento'] = dataYMD($_REQUEST['datafechamento'][0]) . ' ' . $_REQUEST['datafechamento'][1];
			}else{
				$_REQUEST['datafechamento'] = null;
			}
		}
		if(!empty($_REQUEST['codocorrencialead'])){
			$codocorrencia = $_REQUEST['codocorrencialead'];
			ocorrencias::alterar($codocorrencia, $_REQUEST);
		}else{
			$codocorrencialead = ocorrencias::adicionar($_REQUEST);
		}
		javascriptalert('Operação executada com sucesso.');
	}

	
	$acao = 'ins';
	$codocorrencialead = null;
	$codlead = null;
	$descricao = null;
	$codtipoocorrencialead = null;
	$tipoocorrencialead = null;
	$datacadastro = null;
	$datafechamento = null;
	$codusuariointerno = $_SESSION['codusuario'];
	$usuariointerno = $_SESSION['nomeusuario'];
	$ocorrenciasuperior = null;

	$razaosocial = null;

	if(!empty($_REQUEST['codtipoocorrencialead']))
		$codtipoocorrencialead = $_REQUEST['codtipoocorrencialead'];

	if(!empty($_REQUEST['ocorrenciasuperior']))
		$ocorrenciasuperior = $_REQUEST['ocorrenciasuperior'];

	if(!empty($_REQUEST['ocorrenciasuperior']))
		$ocorrenciasuperior = $_REQUEST['ocorrenciasuperior'];

	if(!empty($_REQUEST['codlead']))
		$codlead = $_REQUEST['codlead'];
	
	if(!empty($_REQUEST['codocorrencialead'])){
		$acao = 'upd';
		$codocorrencialead = $_REQUEST['codocorrencialead'];
		$sql = "SELECT o.*, t.Descricao TipoOcorrenciaLead, u.Nome UsuarioInterno FROM ocorrenciaslead o INNER JOIN tipoocorrenciaslead t ON o.CodTipoOcorrenciaLead = t.CodTipoOcorrenciaLead INNER JOIN usuariosinternos u ON o.CodUsuarioInterno = u.CodUsuarioInterno WHERE o.CodOcorrenciaLead = " . mysqlnull($codocorrencialead);
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			$codlead = $row['CodLead'];
			$descricao = $row['Descricao'];
			$codtipoocorrencialead = $row['CodTipoOcorrenciaLead'];
			$tipoocorrencialead = $row['TipoOcorrenciaLead'];
			$datacadastro = $row['DataCadastro'];
			$datafechamento = $row['DataFechamento'];
			$codusuariointerno = $row['CodUsuarioInterno'];
			$usuariointerno = $row['UsuarioInterno'];
			$ocorrenciasuperior = $row['OcorrenciaSuperior'];
		}else{
			$codocorrencialead = 0;
		}
		mysql_free_result($result);
	}
	
	$sql = "SELECT RazaoSocial FROM leads WHERE CodLead = " . mysqlnull($codlead);
	$result = sql_query($sql);
	if($row = mysql_fetch_array($result))
		$razaosocial = $row['RazaoSocial'];
	mysql_free_result($result);
	
	$result = sql_query("SELECT * FROM agendaretorno WHERE CodOcorrenciaLead = " . mysqlnull($codocorrencialead));
	$retorno = mysql_num_rows($result) > 0;
	mysql_free_result($result);

	if(!empty($datafechamento) && !$Root){
		javascriptalert('A ocorrência ' . $codocorrencialead . ' esta fechada. Abra uma nova!!');
	}
	if(!(($acao == 'ins' && permissao('ocorrencias', 'ic')) || ($acao == 'upd' && permissao('ocorrencias', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	if($acao == 'upd' && !($Admin || $Root || !$retorno) && $codusuariointerno != $_SESSION['codusuario'] && !permissao('ocorrenciaoutrousuario', 'al')){
		javascriptalert('Você não tem permissão para alterar ocorrências de outro usuário!!!');
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
   <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Ocorrência Lead</title>
<?	include_once "libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="javascript">
function excluirOcorrencia(){
	if(confirm('Excluir Ocorrência ?'))
		return true
	return false
}

function verOcorrenciaSuperior(){
	window.location.replace('LeadOcorrenciaNew.php?codocorrencialead=<?=$ocorrenciasuperior;?>')
}
	</script>
</head>
    <!--HTML-->
    <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" action="LeadOcorrenciaNew.php" onsubmit="return validateForm(this)">
		<input type="hidden" name="codlead" value="<?=$codlead;?>" />
		<input type="hidden" name="codocorrencialead" value="<?=$codocorrencialead;?>" />
		<table border="0" cellpadding="0" cellspacing="0" class="form">
			<thead>
				<tr>
					<th colspan="3"><?=($codocorrencialead==0?'Adicionar':'Editar');?> Ocorrência</th>
				</tr>
			</thead>
			<tbody>
<?	if(!empty($codocorrencialead)){?>
				<tr>
					<td>Código:</td>
					<td><?=$codocorrencialead;?></td>
				</tr>
<?	}?>
				<tr>
					<td>Lead:</td>
					<td><?=$razaosocial;?></td>
				</tr>
<?	if($acao == 'ins' || $Root){?>
				<tr>
					<td><label for="datacadastro">Data cadastro:</label></td>
					<td>
<?		if($Root){?>
						<input type="text" id="datacadastro" name="datacadastro[]" size="10" maxlength="10" value="<?=(!empty($datacadastro)?date('d/m/Y', strtotime($datacadastro)):null);?>" validate="datatype=date" />
						&nbsp;às&nbsp;
						<input type="text" id="horariocadastro" name="datacadastro[]" size="8" maxlength="8" value="<?=(!empty($datacadastro)?date('H:i:s', strtotime($datacadastro)):'');?>" validate="datatype=time" />
<?		}else{?>
						<?=(!empty($datacadastro)?date('d/m/Y \à\s H:i:s', strtotime($datacadastro)):'');?>
<?		}?>
					</td>
				</tr>
<?	}?>
				<tr>
					<td><label for="datafechamento">Data fechamento:</label></td>
					<td>
<?	if(empty($datafechamento)){?>
						<label for="fecharagora"><input type="checkbox" name="fecharagora" id="fecharagora" value="1" />Fechar Ocorrência</label>
<?	}else{
		if($Root){?>
						<input type="text" id="datafechamento" name="datafechamento[]" size="10" maxlength="10" value="<?=(!empty($datafechamento)?date('d/m/Y', strtotime($datafechamento)):'');?>" validate="datatype=date" />
						&nbsp;às&nbsp;
						<input type="text" id="horariofechamento" name="datafechamento[]" size="8" maxlength="8" value="<?=(!empty($datafechamento)?date('H:i:s', strtotime($datafechamento)):'');?>" validate="datatype=time" />
<?		}else{?>
						<?=(!empty($datafechamento)?date('d/m/Y \à\s H:i:s', strtotime($datafechamento)):null);?>
<?		}
	}?>
					</td>
				</tr>
				<tr>
					<td>Tipo de Ocorrência:</td>
					<td>
<?	if($acao == 'ins' || $Root){
		$sql = "SELECT CodTipoOcorrenciaLead, Descricao FROM tipoocorrenciaslead ";
		if(!$Root){
			$sql .= " Where Automatica = 0 or CodTipoOcorrenciaLead = " . mysqlnull($codtipoocorrencialead);
		}
		$sql .= " Order by Descricao";
		combo($sql, "codtipoocorrencialead", $codtipoocorrencialead, "", " validate='required'");
	}else{?>
						<?=$tipoocorrencialead;?>
<?	}?>
					</td>
				</tr>
				<tr>
					<td>Descrição:</td>
					<td><textarea cols="40" rows="5" id="descricao" name="descricao" validate="required"><?=$descricao?></textarea></td>
				</tr>
				<tr>
					<td><label for="codusuariointerno">Usuário:</label></td>
					<td>
<?	if(!$Root){?>
						<?=$usuariointerno;?>
<?	}else{
		$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($codusuariointerno) . " Order By ui.Nome";
		combo($sql, "codusuariointerno", $codusuariointerno, "", 'validate="required"');
	}?>
					</td>
				</tr>
<?	if($Root){?>
				<tr>
					<td><label for="ocorrenciasuperior">Ocorrência Superior:</label></td>
					<td>
						<input type="text" id="ocorrenciasuperior" name="ocorrenciasuperior" size="5" value="<?=$ocorrenciasuperior;?>" validate="datatype=numeric" />
<?		if(!empty($ocorrenciasuperior)){?>
						<input type="button" name="verocorrenciasuperior" value="Ver Ocorrência Superior" onclick="verOcorrenciaSuperior()" />
<?		}?>
					</td>
				</tr>
<?	}else{?>
				<input type="hidden" name="ocorrenciasuperior" value="<?=$ocorrenciasuperior;?>" />
<?	}?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">
						<input type="submit" name="enviar" value="Enviar" />
<?	if((permissao('ocorrencias', 'ex') || $Root) && !empty($codocorrencialead)){?>
						<input type="submit" name="excluir" value="Excluir" onclick="return excluirOcorrencia()" />
<?	}?>
						<input type="button" name="fechar" value="Fechar" onclick="self.close()" />
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
