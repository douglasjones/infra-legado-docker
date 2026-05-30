<?

    include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.propostas.php";

	
	$continput = 0;
	$codproposta = 0;
	$versao = 0;
	$codlead = 0;
	$style = null;
	$modelo = null;
	$modulos = null;
	$variavel = array();
	if (!empty($_REQUEST['codproposta']) && !empty($_REQUEST['versao']) && !empty($_REQUEST['codlead'])){
		$codproposta = $_REQUEST['codproposta'];
		$versao = $_REQUEST['versao'];
		$codlead = $_REQUEST['codlead'];
	}
	if (!empty($codproposta) && !empty($versao) && !empty($codlead)){
		$result = sql_query("SELECT p.CodProposta
									,p.Versao
									,p.CodLead
									,p.DataCadastro
									,p.DataCancelamento
									,p.CodMotivo
									,p.Cancelamento
									,p.DataEnvio
									,p.DataCadastroTermo
									,p.DataEnvioTermo
									,p.DataRecebimento
									,p.DataPrevisaoRecebimento
									,p.CodUsuarioInterno
									,p.Observacao as decricao
									,p.CodProduto
									,p.DataEnvioFirma
									,p.DataRecebimentoFirma
									,p.DataEnvioContrato
									,p.DataRecebimentoContrato
									,p.CodOcorrenciaLead
									,p.TotalProposta
									,p.ValorContrato
									,p.DataExperto
									,p.Experto
									,p.DataAnaliseDocumento
									,p.DataRespostaDocumento
									,p.DataRetornoDocumento
									,p.DataRemessaDocumento
									,p.DataReanaliseDocumento
									,p.DataAprovacaoDocumento
									,p.DataAnaliseFinanceira
									,p.DataRespostaFinanceira
									,p.DataRetornoFinanceira
									,p.DataRemessaFinanceira
									,p.DataReanaliseFinanceira
									,p.DataAprovacaoFinanceira
									,p.DataEntregaAparelho
									,p.DescExperto
									,p.DescAnaliseDocumento
									,p.DescRespostaDocumento
									,p.DescRetornoDocumento
									,p.DescRemessaDocumento
									,p.DescReanaliseDocumento
									,p.DescAprovacaoDocumento
									,p.DescAnaliseFinanceira
									,p.DescRespostaFinanceira
									,p.DescRetornoFinanceira
									,p.DescRemessaFinanceira
									,p.DescReanaliseFinanceira
									,p.DescAprovacaoFinanceira
									,p.DescRecebimentoContrato
									,p.DescEntregaAparelho
									,p.DataAtivacao
									,p.DescAtivacao
									,p.DataEstorno
									,p.DescEstorno
									,p.NumPVC
									,p.Estorno
									,p.TipoEstorno
									,p.status_experto
								 FROM propostas p WHERE p.CodProposta = " . mysqlnull($codproposta) . " AND Versao = ".mysqlnull($versao) . " AND CodLead = " . mysqlnull($codlead));
		$proposta = mysql_fetch_assoc($result);
		foreach($proposta as $campo => $valor){
			$variavel['proposta'][strtolower($campo)] = $valor;
		}
		mysql_free_result($result);
		$result = sql_query("SELECT l.CodLead
									,l.RazaoSocial
									,l.NomeFantasia
									,l.CNPJ_CPF
									,l.IE
									,l.InscricaoMunicipal
									,l.Site
									,l.ddd
									,l.tel
									,l.dddfax
									,l.fax
									,l.Endereco
									,l.Numero
									,l.Complemento
									,l.Bairro
									,l.Cep
									,l.cidade
									,l.uf									
									,ui.nome consultor_nome	
									,ui.ddd_tel consultor_dddtel
									,ui.tel consultor_tel
									,ui.email consultor_email
							 FROM leads l 
							 left join usuariosinternos ui on l.codgerenteconta = ui.codusuariointerno
							 WHERE l.CodLead = " . mysqlnull($codlead));
		$lead = mysql_fetch_assoc($result);
		foreach($lead as $campo => $valor){
			$variavel['lead'][strtolower($campo)] = $valor;
		}
		mysql_free_result($result);
		$result = sql_query("SELECT m.Style, m.Modelo, p.Nome FROM produtos p INNER JOIN modelos m ON p.CodModelo = m.CodModelo WHERE p.CodProduto = " . mysqlnull($proposta['CodProduto']));
		if($row = mysql_fetch_assoc($result)){
			$style = stripslashes($row['Style']);
			$modelo = stripslashes($row['Modelo']);
			$nomeproduto = $row['Nome'];
			$variavel['produto']['nome'] = $nomeproduto;
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
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Cabeçalho-->
	<title><?=$variavel['lead']['razaosocial'] . ' - ' . $nomeproduto;?></title>
	<style type="text/css" media="screen, print">
	<?=$style;?>
	</style>
	<script type="text/javascript" language="javascript" src="../../extras/prototype.js"></script>
	<script type="text/javascript" language="javascript" src="../../extras/public.js"></script>
	<script type="text/javascript" language="javascript" src="../../extras/formvalidate.js"></script>

    <!--Comandos Javascript-->
    <script type="text/javascript" language="javascript">
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
    <link rel="stylesheet" href="../../extras/public1.css" type="text/css">
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form action="propostaimp.php" method="post" onsubmit="return validateForm(this)">
		<input type="hidden" name="codproposta" value="<?=$codproposta;?>" />
		<input type="hidden" name="versao" value="<?=$versao;?>" />
		<input type="hidden" name="codlead" value="<?=$codlead;?>" />
<?	if(!isset($_REQUEST['visimp']) && !isset($_REQUEST['editar']) && !isset($_REQUEST['imprimir'])){?>
		<input type="submit" name="visimp" value="Visualizar Impressão" />
		<br />
<?	}elseif(isset($_REQUEST['visimp'])){
		if($Admin){?>
		<input type="submit" name="editar" value="Editar" />
<?		}?>
		<input type="button" value="Voltar" onclick="window.history.back()" />
		<input type="submit" id="imprimir" name="imprimir" value="Imprimir" />
		<br />
<?	}elseif(isset($_REQUEST['editar'])){?>
		<input type="submit" name="visimp" value="Salvar" />
		<br />
<?	}
	if(isset($_REQUEST['editar'])){?>
	<textarea name="modelo" style="width:100%" rows="30"><?=htmlentities($modelo);?></textarea>
<?	}else{
		if(isset($_REQUEST['visimp'])){?>
		<input type="hidden" name="modelo" value="<?=htmlentities($modelo);?>" />
<?		}
		echo $modelo;
	}?>
<?	if(!isset($_REQUEST['visimp']) && !isset($_REQUEST['editar']) && !isset($_REQUEST['imprimir'])){?>
		<input type="submit" name="visimp" value="Visualizar Impressão" />
		<br />
<?	}elseif(isset($_REQUEST['visimp'])){?>
<?		if($Admin){?>
		<input type="submit" name="editar" value="Editar" />
<?		}?>
		<input type="button" value="Voltar" onclick="window.history.back()" />
		<input type="submit" id="imprimir" name="imprimir" value="Imprimir" />
		<br />
<?	}elseif(isset($_REQUEST['editar'])){?>
		<input type="submit" name="visimp" value="Salvar" />
<?	}?>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
