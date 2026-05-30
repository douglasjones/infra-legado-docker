<?
ini_set("allow_url_fopen", 1);
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.email.php";
include_once "../../libs/cla.ocorrencias.php";
include_once "../../libs/cla.propostas.php";

if(!empty($_REQUEST['enviar'])){
	$continput = 0;
	$codproposta = 0;
	$versao = 0;
	$codlead = 0;
	$style = null;
	$modelo = null;
	$modulos = null;
	$variavel = array();
	$cod_proposta = $_REQUEST['codproposta'];
	$versao = $_REQUEST['versao'];	
	$cod_lead = $_REQUEST['codlead'];		
		$sql = "Select
				ep.cod_tipoemail
			from email_empresa ep";

	$result = sql_query($sql);
	if($row = mysql_fetch_assoc($result)){
		$cod_tipoemail = $row['cod_tipoemail'];
	}
	if (!empty($_REQUEST['codproposta']) && !empty($_REQUEST['versao']) && !empty($_REQUEST['codlead'])){
		$codproposta = $_REQUEST['codproposta'];
		$versao = $_REQUEST['versao'];
		$codlead = $_REQUEST['codlead'];
	}
	if (!empty($codproposta) && !empty($versao) && !empty($codlead)){
		$result = sql_query("SELECT * FROM propostas WHERE CodProposta = " . mysqlnull($codproposta) , " AND Versao = ".mysqlnull($versao) . " AND CodLead = " . mysqlnull($codlead));
		$proposta = mysql_fetch_assoc($result);
		foreach($proposta as $campo => $valor){
			$variavel['proposta'][strtolower($campo)] = $valor;
		}
		mysql_free_result($result);
		$result = sql_query("SELECT * FROM leads WHERE CodLead = " . mysqlnull($codlead));
		$lead = mysql_fetch_assoc($result);
		foreach($lead as $campo => $valor){
			$variavel['lead'][strtolower($campo)] = $valor;
		}
		mysql_free_result($result);
		$result = sql_query("SELECT m.Style, m.Modelo, p.Nome,p.codproduto FROM produtos p INNER JOIN modelos m ON p.CodModelo = m.CodModelo WHERE p.CodProduto = " . mysqlnull($proposta['CodProduto']));
		if($row = mysql_fetch_assoc($result)){
			$style = stripslashes($row['Style']);
			$modelo = stripslashes($row['Modelo']);
			$nomeproduto = $row['Nome'];
			$variavel['produto']['nome'] = $nomeproduto;
			$nomeproduto = $row['codproduto'];
		}
		mysql_free_result($result);
		$result = sql_query("SELECT * FROM modulosproposta WHERE CodProposta = " . mysqlnull($codproposta) . " AND Versao = ".mysqlnull($versao) . " AND CodLead = " . mysqlnull($codlead));
		while($row = mysql_fetch_assoc($result)){
			foreach($row as $campo => $valor){
				$row[strtolower($campo)] = $valor;
			}
			$modulos[$row['id']] = $row;
		}
		mysql_free_result($result);
		$tmpmodulos = $modulos;
		foreach($modulos as $id => $modulo){
			$html = propostas::montarHTMLModulo($id);
			$modulos[$id]['html'] = $html;
			if(isset($tmpmodulos[$id]))
				$tmpmodulos[$id]['html'] = $html;
		}
	}
	if(isset($_REQUEST['modelo'])){
		$modelo = stripslashes($_REQUEST['modelo']);
	}
	if(isset($_REQUEST['visimp'])){
		propostas::SalvarCampos();
	}
	
	$modelo = propostas::parseString($modelo, true);
	
   	//CRIA O ARQUIVO COM O NOME DA EQUIPE
  	$cria = fopen($cod_lead. ".html", "w+");
	
   	//ESCREVE NO ARQUIVO O CABEÇALHO
	fwrite($cria, 'Teste de Envio'.chr(13) . chr(10));	
	
	//ESCREVE AS LINHAS DA AGENDA
   	fwrite($cria, $modelo .chr(13) . chr(10));
	
	//FECHA O ARQUIVO
	fclose($cria);

	$arrLinhas  = file($cod_lead.".html");
	for($i = 0; $i < count($arrLinhas); $i++){
		$headers.=$arrLinhas[$i];
	}
	$headers;

	//DESCRICAO OCORRENCIA
	$descricao = "  Proposta ".$_REQUEST['codproposta'];			
	$descricao .= "  Versao ".$_REQUEST['versao'];
	$descricao .= " ".date('d/m/Y \à\s H:i:s');
	$descricao .= "  Envio para o E-mail ".$email;
	
	email::envia_email($cod_tipoemail,$_REQUEST['codlead'],$_REQUEST['codcontatolead'],$headers,$descricao);
	
	//INSERE OS PARAMETROS DE DATA E OBSERVACAO NA TABELA RELACIONAL A PROPOSTA	
	$sql = "Select 
		dpo.cod_data_proposta_operador
		,dpo.dsc_data
		,dpo.obs_data
		,dpo.nome_data
		,dpo.codtipoocorrencialead
		,p.cod_operador
	from data_proposta_operador dpo
	inner join produtos p on dpo.cod_operador = p.cod_operador";			
	$sql .= " where p.codproduto = ". $nomeproduto;			
	$sql .= " and dpo.dat_canc is null";
	$result = sql_query($sql);
	if($row = mysql_fetch_assoc($result)){
		$cod_data_proposta_operador = $row['cod_data_proposta_operador'];
	}
	$sql = "delete from data_proposta where codproposta=$cod_proposta and versao=$versao and codlead=$cod_lead and nome_data='envio_lead'";
	sql_query($sql);
	
	$data_envio = date('Y-m-d');
	
 	$sql = sqlinsert('data_proposta', array('codproposta' => $cod_proposta,'versao' => $versao,'codlead' => $cod_lead,'nome_data' => 'envio_lead','valor_data' => $data_envio,'cod_data_proposta_operador' => $cod_data_proposta_operador));
	sql_query($sql);

	//ALTERA STATUS CLASSIFICACAO LEAD
	$sql = "Select
				t.status 
			from email_empresa ep
			inner join tipoocorrenciaslead t on ep.codtipoocorrencialead = t.codtipoocorrencialead
			where ep.cod_tipoemail= ".$cod_tipoemail;
	
	$result1 = sql_query($sql);	
	$rows = mysql_fetch_array($result1);
	
	$sql = sqlupdate('leads', array('codstatusclassificacaolead' => $rows['status']), 'codlead = ' . $cod_lead);
	sql_query($sql);
	
	//EXCLUI O ARQUIVO HTML DA PROPOSTA
	unlink($cod_lead.".html");
?>
	<script>
		//alert('Email enviado com sucesso');
		//window.close();
	</script>
<?
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type: text/html; charset=ISO-8859-1" />
	<title>Pesquisar Leads</title>
	<!--Include CSS-->
	<script type="text/javascript" language="javascript" src="../../extras/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../../extras/public.js"></script>
	<script type="text/javascript" language="javascript" src="../../extras/formvalidate.js"></script>	
<?	include_once "../../libs/head.php";?>
<script>
	function init(){
<?	if(isset($_REQUEST['imprimir']) && !empty($_REQUEST['imprimir'])){?>
		window.print()
<?	}?>
	}

	function alteraImagem(element, path){
		element = document.getElementById(element)
		element.src = '.' + path
	}
	Event.observe(window, 'load', init)
</script>
	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
<form name="dados" method="post">
<input type="hidden" id="codlead" name="codlead" value="<?=$_REQUEST['codlead'];?>" />
<input type="hidden" id="codproposta" name="codproposta" value="<?=$_REQUEST['codproposta'];?>" />
<input type="hidden" id="versao" name="versao" value="<?=$_REQUEST['versao'];?>" />
<input type="hidden" id="versao" name="visimp" value="Visualizar Impressão" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		<td  class="titulo">
			Contato
		</td>
	</tr>
</table>
<table class="form" width="100%"  border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="ddd_fone">Contato:</label></td>
			<td>
				<?
					$sql = "Select 
							ct.codcontatolead
							,concat(ct.nomecontato,' - ',ct.email)
							from contatoslead ct ";
					$sql .= " Where ct.codlead = ".$_REQUEST['codlead'];
					$sql .= " and ct.email is not null
							  and ct.email <>''";
					combo($sql, "codcontatolead", "codcontatolead", "", "");					
				?>
				
			</td>
		</tr>

		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="Enviar"  name="enviar"/>&nbsp;
				<input type="button" name="fechar" value="Fechar" onclick="window.close()" />&nbsp;
			</td>
		</tr>

</table>
</form>
</html>

