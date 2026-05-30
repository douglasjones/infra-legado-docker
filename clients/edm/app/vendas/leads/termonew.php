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
	include_once "../../libs/datas.php";

	$codproposta = null;
	$versao = null;
	$codlead = null;
	$data = array();

	$condicoes = array();
	$condicao = null;
	$dataenvio = null;

	if(!empty($_REQUEST['codproposta']))
		$codproposta = $_REQUEST['codproposta'];

	if(!empty($_REQUEST['versao']))
		$versao = $_REQUEST['versao'];

	if(!empty($_REQUEST['codlead']))
		$codlead = $_REQUEST['codlead'];

	if(!empty($_REQUEST['condicao']))
		$condicao = $_REQUEST['condicao'];

	$sql = "select p.*, SYSDATE() Agora, l.RazaoSocial, l.NomeFantasia, u.Nome UsuarioInterno, pr.Nome Produto, m.Descricao Motivo ";
	$sql .= " from propostas p ";
	$sql .= " inner join leads l on p.CodLead = l.CodLead ";
	$sql .= " inner join usuariosinternos u on p.CodUsuarioInterno = u.CodUsuarioInterno ";
	$sql .= " inner join produtos pr on p.CodProduto = pr.CodProduto ";
	$sql .= " left join motivoslead m on p.CodMotivo = m.CodMotivoLead ";
	$sql .= " where p.codproposta = " . mysqlnull($codproposta) . " and p.versao = " . mysqlnull($versao) . " and p.codlead = " . mysqlnull($codlead);
	$result = sql_query($sql);
	if($data = mysql_fetch_array($result)){
		foreach(@$data as $campo => $valor):
			unset($data[$campo]);
			$campo = strtolower($campo);
			@$data[$campo] = $valor;
		endforeach;
	}
	mysql_free_result($result);

	$modulos = modulosProposta($codproposta, $versao, $codlead);
	$tmpmodulos = $modulos;
	
	foreach($modulos as $id => $modulo){
		if($modulo['grupo'] == 'termo'){
			$reg = array();
			if(preg_match('/^condicao([0-9])$/', $id, $reg)){
				$condicoes[$reg[1]] = $id;
			}
			if($id == 'condicao'){
				$condicao = $modulo['valor'];
			}
			if($id == 'dataenvio'){
				$dataenvio = $modulo['valor'];
			}
		}
	}

	if(!empty($_REQUEST['enviar'])){
		if(empty($_REQUEST['condicao'])){
			javascriptalert("Selecione a condição.", false, false);
		}
		if($_REQUEST['condicao'] <> $condicao){
			$sql = "Update modulosproposta set valor = " . mysqlnull($_REQUEST['condicao']) . " Where CodProposta = " . mysqlnull($codproposta) . " And ID = 'condicao' And Versao = " . mysqlnull($versao) . " And CodLead = " . mysqlnull($codlead) . " And Grupo = 'termo'";
			sql_query($sql);
			$sql = "Update propostas set DataCadastroTermo = NOW() Where CodProposta = " . mysqlnull($codproposta) . " And Versao = " . mysqlnull($versao) . " And CodLead = " . mysqlnull($codlead);
			sql_query($sql);
		}?>
<?	include_once "../../libs/head.php";?>
<script type="text/javascript" language="javascript">
	NewWindow('propostaimp.php?codproposta=<?=$codproposta;?>&versao=<?=$versao;?>&codlead=<?=$codlead;?>', 800, 600);
	self.close();
</script>
<?		exit;
	}
	
	if(!permissao('termoaceite', 'ic')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<title>Termo de Aceite</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
	function validaForm(frm) {
		if(!validateForm(frm)) return false
	}

	function windowOnLoad(e){
	}

	Event.observe(window, 'load', windowOnLoad)
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" onsubmit="return validaForm(this)" action="termonew.php">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
		<input type="hidden" id="codproposta" name="codproposta" value="<?=$codproposta;?>" />
		<input type="hidden" id="versao" name="versao" value="<?=$versao;?>" />
		<table class="form">
			<thead>
				<tr>
					<th colspan="2">Termo de Aceite - Proposta <?=$codproposta;?>.<?=$versao;?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Razão Social:</td>
					<td><?=@$data['razaosocial'];?></td>
				</tr>
				<tr>
					<td>Nome Fantasia:</td>
					<td><?=@$data['nomefantasia'];?></td>
				</tr>
				<tr>
					<th colspan="2">Condições:</th>
				</tr>
				<tr>
					<td>
						<input type="radio" id="condicao0" name="condicao" <?=($condicao == ''?'checked="checked"':'');?> value="Nenhuma condição" />
					</td>
					<td>
						<label for="condicao0">Nenhuma condição</label>
					</td>
				</tr>
<?	foreach($condicoes as $cont => $modulo):
		$tmp = moduloValor($modulos, $modulo);?>
				<tr>
					<td>
						<input type="radio" id="condicao<?=$cont;?>" name="condicao" <?=($cont == $condicao?'checked="checked"':'');?> value="<?=$cont;?>" />
					</td>
					<td>
						<label for="condicao<?=$cont;?>"><?=$tmp;?></label>
					</td>
				</tr>
<?	endforeach?>
			</tbody>
			<tfoot>
				<tr>
				  <th colspan="2">
					<input type="submit" name="enviar" value="Salvar" />&nbsp;
					<input type="button" name="fechar" value="Fechar" onclick="window.close()" />
				  </th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
