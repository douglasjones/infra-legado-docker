<?
    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
	include_once "../../libs/datas.php";
	include_once "../../libs/cla.propostas.php";

	$codproposta = null;
	$versao = null;
	$codlead = null;
    $codagendalead = $_REQUEST['codagendalead'];

	$data = array();
	$data['dataenvio'] = null;
	$data['datacancelamento'] = null;
	$data['codusuariointerno'] = $_SESSION['codusuario'];
	$data['usuariointerno'] = $_SESSION['nomeusuario'];

	$novaversao = false;
	$modulos = array();
	$acao = "ins";

	if(!empty($_REQUEST['codproposta']))
		$codproposta = $_REQUEST['codproposta'];

	if(!empty($_REQUEST['versao']))
		$versao = $_REQUEST['versao'];

	if(!empty($_REQUEST['codlead']))
		$codlead = $_REQUEST['codlead'];

	if(!empty($_REQUEST['codproduto']))
		$data['codproduto'] = $_REQUEST['codproduto'];

	if(!empty($_REQUEST['novaversao']))
		$novaversao = true;

	$versao1 = $versao;
/*Registra nova versao de proposta*/
	if($novaversao){
		$sql = "select Max(Versao) Versao from propostas where codlead = " . mysqlnull($codlead) . " and codproposta = " . mysqlnull($codproposta);
		$result = sql_query($sql);
		$row = mysql_fetch_array($result);
		$versao1 = $row['Versao'];
		mysql_free_result($result);
		$versao1++;
	}
/*Registra o proposta*/
	if(!empty($_REQUEST['excluir'])){
		if(!empty($codproposta) && !empty($versao) && !empty($codlead)){
			if(propostas::excluir($codproposta, $versao, $codlead)){
				javascriptalert('Operação executada com sucesso!!!');
			}else{
				javascriptalert('Não foi possível excluir!!!');
			}
		}
	}
/*Cancela a proposta*/
	if(!empty($_REQUEST['cancelar'])){
		if(!empty($codproposta) && !empty($versao) && !empty($codlead)){
			if(propostas::alterar($codproposta, $versao, $codlead, array('datacancelamento' => 'SYSDATE()'))){
				javascriptalert('Operação executada com sucess!!!');
			}
		}
	}

/*	Registra a proposta	*/
	if(!empty($_REQUEST['enviar'])){
		$_REQUEST['dataestorno'] = ( !empty( $_REQUEST['dataestorno'] ) ) ? dataYMD( $_REQUEST['dataestorno'] ) : null ;

		if(!empty($_REQUEST['datacadastro']) && !empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1]))
			$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]).' '.$_REQUEST['datacadastro'][1];
		else
			$_REQUEST['datacadastro'] = 'SYSDATE()';

		if(!empty($_REQUEST['datacadastrotermo']) && !empty($_REQUEST['datacadastrotermo'][0]) && !empty($_REQUEST['datacadastrotermo'][1]))
			$_REQUEST['datacadastrotermo'] = dataYMD($_REQUEST['datacadastrotermo'][0]).' '.$_REQUEST['datacadastrotermo'][1];
		else
			$_REQUEST['datacadastrotermo'] = null;

		if(isset($_REQUEST['datacancelamento'][0]) && isset($_REQUEST['datacancelamento'][1])){
			if(empty($_REQUEST['datacancelamento'][0]) && empty($_REQUEST['datacancelamento'][1]))
				$_REQUEST['datacancelamento'] = '';
			elseif(!empty($_REQUEST['datacancelamento'][0]) && !empty($_REQUEST['datacancelamento'][1]))
				$_REQUEST['datacancelamento'] = dataYMD($_REQUEST['datacancelamento'][0]).' '.$_REQUEST['datacancelamento'][1];
			else
				$_REQUEST['datacancelamento'] = null;
		}

		

		if(!empty($codproposta) && !empty($versao) && !empty($codlead)){

			propostas::alterar($codproposta, $versao, $codlead, $_REQUEST, true);
		}else{

			propostas::adicionar($_REQUEST);
		}

		javascriptalert('Operação executada com sucesso!!!');
	}

	if(!empty($codlead) && !empty($codproposta) && !empty($versao) && !$novaversao)
		$acao = "upd";

	if(!empty($codproposta) && !empty($versao) && !empty($codlead)){
		$sql = "select p.*, SYSDATE() Agora, l.VoIP, l.RazaoSocial, l.NomeFantasia, u.Nome UsuarioInterno, pr.Nome Produto, m.Descricao Motivo from propostas p inner join leads l on p.CodLead = l.CodLead inner join usuariosinternos u on p.CodUsuarioInterno = u.CodUsuarioInterno inner join produtos pr on p.CodProduto = pr.CodProduto left join motivoslead m on p.CodMotivo = m.CodMotivoLead where p.codproposta = " . mysqlnull($codproposta) . " and p.versao = " . mysqlnull($versao) . " and p.codlead = " . mysqlnull($codlead);
		$result = sql_query($sql);
		if($data = mysql_fetch_array($result)){
			foreach(@$data as $campo => $valor):
				unset($data[$campo]);
				$campo = strtolower($campo);
				@$data[$campo] = $valor;
			endforeach;
		}
		if($novaversao){
			$data['datacadastro'] = @$data['Agora'];
			$data['datacadastrotermo'] = null;
			$data['datacancelamento'] = null;
			$data['codmotivo'] = null;
			$data['cancelamento'] = null;
			$data['dataenvio'] = null;
			$data['dataenviotermo'] = null;
			$data['datarecebimento'] = null;
			$data['dataprevisaorecebimento'] = null;
			$data['codusuariointerno'] = null;
			$data['observacao'] = null;
			$data['dataenviofirma'] = null;
			$data['datarecebimentofirma'] = null;
			$data['dataenviocontrato'] = null;
			$data['datarecebimentocontrato'] = null;
			$data['codocorrencialead'] = null;
			$data['totalproposta'] = null;
			$data['valorcontrato'] = null;
			$data['dataexperto'] = null;
			$data['experto'] = null;
			$data['status_experto'] = null;			
			/*$data['dataanalisedocumento'] = null;
			$data['datarespostadocumento'] = null;
			$data['dataretornodocumento'] = null;
			$data['dataremessadocumento'] = null;
			$data['datareanalisedocumento'] = null;
			$data['dataparovacaodocumento'] = null;
			$data['dataanalisefinanceira'] = null;
			$data['datarespostafinanceira'] = null;
			$data['dataretornofinanceira'] = null;
			$data['dataremessafinanceira'] = null;
			$data['datareanalisefinanceira'] = null;
			$data['dataaprovacaofinanceira'] = null;
			$data['dataentregaaparelho'] = null;
			$data['descexperto'] = null;
			$data['descanalisedocumento'] = null;
			$data['descrespostadocumento'] = null;
			$data['descretornodocumento'] = null;
			$data['descremessadocumento'] = null;
			$data['descreanalisedocumento'] = null;
			$data['descparovacaodocumento'] = null;
			$data['descanalisefinanceira'] = null;
			$data['descrespostafinanceira'] = null;
			$data['descretornofinanceira'] = null;
			$data['descremessafinanceira'] = null;
			$data['descreanalisefinanceira'] = null;
			$data['descaprovacaofinanceira'] = null;
			$data['descrecebimentocontrato'] = null;*/
			$data['descentregaaparelho'] = null;
			$data['dataativacao'] = null;
			$data['descativacao'] = null;
		}
		mysql_free_result($result);
		$modulos = modulosProposta($codproposta, $versao, $codlead);
	}else{
		//NOVA PROPOSTA
		//DADOS DO LEAD
		$sql = "Select RazaoSocial, NomeFantasia From leads Where CodLead = " . mysqlnull($codlead);
		$rs = sql_query($sql);
		$row = mysql_fetch_array($rs);
		@$data['razaosocial'] = $row['RazaoSocial'];
		@$data['nomefantasia'] = $row['NomeFantasia'];
		mysql_free_result($rs);
		//DADOS DO PRODUTO
		$sql = "select * from produtos where codproduto = " . mysqlnull($data['codproduto']);
		$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			@$data['produto'] = $row['Nome'];
		}
		mysql_free_result($result);
		//DADOS DOS MODULOS DA PROPOSTA
		$sql = "select * from modulosproduto where codproduto = " . mysqlnull($data['codproduto']) . " Order By Grupo, Nome, ID";
		
		$result = sql_query($sql);
		while($row = mysql_fetch_array($result)){
			$modulos[$row['ID']] = array('nome' => $row['Nome'], 'tipo' => $row['Tipo'], 'valor' => stripslashes($row['Valor']), 'valorfixo' => $row['ValorFixo'], 'obrigatorio' => $row['Obrigatorio'], 'hidden' => $row['Hidden'], 'eval' => $row['Eval'], 'grupo' => $row['Grupo']);
		}
		mysql_free_result($result);
	}
	$tmpmodulos = $modulos;
	foreach($modulos as $id => $modulo){
		$html = propostas::montarInputModulo($id);
		$modulos[$id]['html'] = $html;
		if(isset($tmpmodulos[$id])){
			$tmpmodulos[$id]['html'] = $html;
		}
	}
	if(!(($acao == 'ins' && permissao('proposta', 'ic')) || ($acao == 'upd' && permissao('proposta', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<title>Propostas</title>

<?	include_once "../../libs/head.php";?>

    <!--Código Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function fecharpropsota(){
		window.close();
	}
var modulos = Object
var nomemes = Array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro')
<?
	$i = 0;
	foreach($modulos as $id => $mdl){
		if($mdl['tipo'] != 12){?>
	modulos['<?=$id;?>'] = {
		id: '<?=$id;?>',
		nome: '<?=$mdl['nome'];?>',
		tipo: <?=$mdl['tipo'];?>,
		valor: '<?=stripslashes($mdl['valor']);?>',
		valorfixo: <?=($mdl['valorfixo'] == 1?1:0);?>,
		eval: <?=($mdl['eval'] == 1?1:0);?>,
		hidden: <?=($mdl['hidden'] == 1?1:0);?>
	}
<?			$i++;
		}
	}
?>
	function moduloValue(mdl, campo, format){
		var modulo = modulos[mdl];
		var tmp;
		var obj = document.getElementById(mdl);
		if(obj && /^modulo.*/.test(obj.name)){
			switch(modulo.tipo){
				case 1: //String
					tmp = obj.value
					break
				case 2: //Inteiro
					tmp = parseInt(obj.value)
					tmp = (isNaN(tmp)?0:tmp)
					break
				case 3: //Moeda
					tmp = parseFloat(obj.value)
					tmp = (isNaN(tmp)?0.0:tmp)
					if(format)
						tmp = 'R$ ' + formatCurrency(tmp)
					break
				case 4: //Data
					var tmp1
					tmp1.setTime(Date.parse(obj.value))
					switch(campo){
						case 'dia':
							tmp = tmp1.getDate()
							break
						case 'mes':
							tmp = tmp1.getMonth() + 1
							break
						case 'nomemes':
							tmp = nomemes[tmp1.getMonth()]
							break
						case 'ano':
							tmp = tmp1.getFullYear()
							break
					}
					break
				case 5: //Hora
					var reg = /^([0-9][0-9]):([0-9][0-9]):([0-9][0-9])$/.exec(obj.value)
					switch(campo){
						case 'hora':
							tmp = reg[1]
							break
						case 'minuto':
							tmp = reg[2]
							break
						case 'segundo':
							tmp = reg[3]
							break
					}
					break
				case 6: //Hora Curta
					var reg = /^([0-9][0-9]):([0-9][0-9])$/.exec(obj.value)
					switch(campo){
						case 'hora':
							tmp = reg[1]
							break
						case 'minuto':
							tmp = reg[2]
							break
					}
					break
				case 7: //Ponto Flutuante
					tmp = parseFloat(obj.value)
					tmp = (isNaN(tmp)?0.0:tmp)
					if(format)
						tmp = formatCurrency(tmp)
					break
				case 8: //Lista
					tmp = Array()
					for(var i = 0; i < obj.options.length; i++){
						if(obj.options[i].selected)
							tmp.push(Array(obj.options[i].value, obj.options[i].text))
					}
					switch(campo){
						case 'chave':
							tmp = tmp[0][0]
							break
						case 'valor':
							tmp = tmp[0][1]
							break
					}
					break
				case 9: //Lista Múltipla
					tmp = Array()
					for(var i = 0; i < obj.options.length; i++){
						if(obj.options[i].selected){
							switch(campo){
								case 'chave':
									tmp.push(obj.options[i].value)
									break
								case 'valor':
									tmp.push(obj.options[i].text)
									break
								default:
									tmp.push([obj.options[i].value, obj.options[i].text])
									break
							}
						}
					}
					break
			}
		}else{
			if(!modulo)
				return ""
			tmp = modulo.valor
			if(modulo.tipo == 12)
				return tmp
			if(modulo['eval'] == 1){
				tmp = tmp.replace(/(#\[([^\]|]*)(\|([^\]]*))?\])/g, '$4')
				tmp = tmp.replace(/(#([A-Za-z][A-Za-z0-9]+)(\.([A-Za-z0-9]+))?;)/g, 'moduloValue("$2", "$4", false)')
				if(/\|/g.test(tmp)){
					tmp = 'new Array(' + tmp.replace(/\|/g, ',') + ')'
					tmp = decodeHtmlEntities(tmp)
					try{
						eval('var tmp = ' + tmp)
					}catch(e){
						tmp = null
					}
					tmp = tmp.join('|')
				}else{
					tmp = decodeHtmlEntities(tmp)
					try{
						eval('var tmp = ' + tmp)
					}catch(e){
						tmp = null
					}
				}
			}
			switch(modulo.tipo){
				case 1: //String
					break
				case 2: //Inteiro
					tmp = parseInt(tmp)
					tmp = (isNaN(tmp)?0:tmp)
					break
				case 3: //Moeda
					tmp = parseFloat(tmp)
					tmp = (isNaN(tmp)?0.0:tmp)
					if(format)
						tmp = 'R$ ' + formatCurrency(tmp)
					break
				case 4: //Data
					tmp1.setTime(Date.parse(tmp))
					switch(campo){
						case 'dia':
							tmp = tmp1.getDate()
							break
						case 'mes':
							tmp = tmp1.getMonth() + 1
							break
						case 'nomemes':
							tmp = nomemes[tmp1.getMonth()]
							break
						case 'ano':
							tmp = tmp1.getFullYear()
							break
					}
					break
				case 5: //Hora
					var reg = /^([0-9][0-9]):([0-9][0-9]):([0-9][0-9])$/.exec(tmp)
					switch(campo){
						case 'hora':
							tmp = reg[1]
							break
						case 'minuto':
							tmp = reg[2]
							break
						case 'segundo':
							tmp = reg[3]
							break
					}
					break
				case 6: //Hora Curta
					var reg = /^([0-9][0-9]):([0-9][0-9])$/.exec(tmp)
					switch(campo){
						case 'hora':
							tmp = reg[1]
							break
						case 'minuto':
							tmp = reg[2]
							break
					}
					break
				case 7: //Ponto Flutuante
					tmp = parseFloat(tmp)
					tmp = (isNaN(tmp)?0.0:tmp)
					if(format)
						tmp = formatCurrency(tmp)
					break
				case 8: //Lista
					tmp1 = tmp.split('|')
					tmp = new Array()
					for(var i = 0; i < tmp1.length; i++){
						var reg = /(\*?)([^=]*)=?(.*)/.exec(tmp1[i])
						reg[3] = (reg[3] == ''?reg[2]:reg[3])
						if(reg[1] != '')
							tmp.push(Array(reg[2], reg[3]))
					}
					switch(campo){
						case 'chave':
							tmp = tmp[0][0]
							break
						case 'valor':
							tmp = tmp[0][1]
							break
					}
					break
				case 9: //Lista Múltipla
					tmp1 = tmp.split('|')
					tmp = new Array()
					for(var i = 0; i < tmp1.length; i++){
						reg = false
						while(!reg)
							reg = (/^(\*?)([^=]*)=?(.*)/g).exec(tmp1[i])
						if(reg){
							reg[3] = (reg[3] == ''?reg[2]:reg[3])
							if(reg[1] != ''){
								switch(campo){
									case 'chave':
										tmp.push(reg[2])
										break
									case 'valor':
										tmp.push(reg[3])
										break
									default:
										tmp.push(Array(reg[2], reg[3]))
										break
								}
							}
						}
					}
					break
				case 10: //Array
					tmp1 = tmp.split('|')
					tmp = new Array()
					for(var i = 0; i < tmp1.length; i++){
						var reg = /([^=]*)=?(.*)/g.exec(tmp[i])
						reg[3] = (reg[3] == ''?reg[2]:reg[3])
						switch(campo){
							case 'chave':
								tmp.push(reg[2])
								break
							case 'valor':
								tmp.push(reg[3])
								break
							default:
								tmp.push(Array(reg[2], reg[3]))
								break
						}
					}
					break
				case 11: //Valor x Quantidade
					tmp = String(tmp).split('|')
					valor = (tmp[0] != undefined?tmp[0]:null)
					qtde = document.getElementById(mdl + '.quantidade')
					if(qtde && qtde.value != undefined){
						qtde = parseInt(qtde.value)
					}else{
						qtde = (tmp[1] != undefined?tmp[1]:null)
					}
					total = valor * qtde
					if(format){
						valor = 'R$ ' + formatCurrency(valor)
						total = 'R$ ' + formatCurrency(total)
					}
					switch(campo){
						case 'valor':
							tmp = valor
							break
						case 'quantidade':
							tmp = qtde
							break
						default:
							tmp = total
							break
					}
					break
			}
		}
		return tmp
	}

	function calcularModulos(){
		for(var modulo in modulos){
			switch(modulos[modulo].tipo){
				case 11: //Valor x Quantidade
					var valor = document.getElementById(modulos[modulo].id + '.valor')
					valor.innerHTML = moduloValue(modulos[modulo].id, 'valor', true)
					var quantidade = document.getElementById(modulos[modulo].id + '.quantidade')
					try{
						quantidade.value = moduloValue(modulos[modulo].id, 'quantidade', true)
					}catch(e){
						quantidade.innerHTML = moduloValue(modulos[modulo].id, 'quantidade', true)
					}
					document.getElementById(modulos[modulo].id).innerHTML = moduloValue(modulos[modulo].id, null, true)
					break
				case 12: //HTML
					break
				default:
					if(modulos[modulo]['eval'] == 1){
						if(modulos[modulo].hidden == 1)
							var v = moduloValue(modulos[modulo].id, null, false)
						else
							var v = moduloValue(modulos[modulo].id, null, true)
						var obj = document.getElementById(modulos[modulo].id)
						try{
							obj.value = v
						}catch(e){}
						try{
							obj.innerHTML = v
						}catch(e){}
					}
					break
			}
		}
	}

	function cancelarProposta(){
		NewWindow("cancelarproposta.php?codproposta=<?=$codproposta;?>&versao=<?=$versao;?>&codlead=<?=$codlead;?>",300,150)
	}

	function termoAceite(){
		NewWindow("termonew.php?codproposta=<?=$codproposta;?>&versao=<?=$versao;?>&codlead=<?=$codlead;?>",500,250);
	}

	function validaForm(frm) {

		if(!validateForm(frm)) return false
	}

	function windowOnLoad(e){
		//calcularModulos()
	}

	function openDescWindow(objID){
		if(document.getElementById('data' + objID).value == ''){
			return true
		}
		var desc = document.getElementById('divdesc' + objID).innerHTML
		var desc = prompt('Descrição', desc)
		document.getElementById('divdesc' + objID).innerHTML = desc
		document.getElementById('desc' + objID).value = desc
		return true
	}

	function insNumeros(codlead, codproposta, versao){
		if(codlead&&codproposta&&versao){
			var load = window.open('../../vendas/propostas/numeros.php?codlead='+codlead+'&codproposta='+codproposta+'&versao='+versao,'numeros','scrollbars=yes,menubar=no,width=700,height=200,resizable=yes,toolbar=no,location=no,status=no');
		}else{
			alert('Erro: A proposta ainda não está cadastrada.');
		}
	}

	Event.observe(window, 'load', windowOnLoad)
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" onsubmit="return validaForm(this)" action="propostanew.php">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
		<input type="hidden" id="codproposta" name="codproposta" value="<?=$codproposta;?>" />
		<input type="hidden" id="versao" name="versao" value="<?=($novaversao?null:$versao);?>" />
		<input type="hidden" id="codproduto" name="codproduto" value="<?=$data['codproduto'];?>" />
		<input type="hidden" id="codusuariointerno" name="codusuariointerno" value="<?=$_SESSION['codusuario'];?>" />
        <input type="hidden" id="codagendalead" name="codagendalead" value="<?=$codagendalead;?>" />
        <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
        	<tr>
        		 <td  class="titulo">
        			&nbsp;Proposta - <?=@$data['produto'];?>
        		</td>
        	</tr>
        </table>
        <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
            <tbody>
                <tr>
                     <td>
                        &nbsp;    
                     </td>
                </tr>
                <?if($acao == 'upd' || $novaversao == 1){?>
            		<tr>
            			<td>&nbsp;Número:</td>
            			<td><?=$codproposta;?></td>
            		</tr>
            		<tr>
            			<td>&nbsp;Versão:</td>
            			<td><?=$versao1;?></td>
            		</tr>
                <?}?>
        		<tr>
        			<td>&nbsp;Razão Social:</td>
        			<td><?=@$data['razaosocial'];?></td>
        		</tr>
        		<tr>
        			<td>&nbsp;Nome Fantasia:</td>
        			<td><?=@$data['nomefantasia'];?></td>
        		</tr>
        		<tr>
        			<td>&nbsp;<label for="codusuariointerno">Usuário:</label></td>
        			<td>
                        <?if(!$Root){?>
        			     <?=$data['usuariointerno'];?>
                        <?}else{
                            $sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull(@$data['codusuariointerno']) . " Order By ui.Nome";
                            combo($sql, "codusuariointerno", @$data['codusuariointerno'], null, 'validate="required"');
                        }?>
        			</td>
        		</tr>
            </tbody>        
        </table>
        <?
            $grupos = array();
        	foreach($tmpmodulos as $id => $modulo){        	   
        		if($modulo['hidden'] == 0)
        			$grupos[$modulo['grupo']][] = $modulo;
        	}
        	foreach($grupos as $grupo => $mdls){
 z
        ?>
        <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
        	<tr>
        		 <td  class="titulo">
        			&nbsp;<?=$grupo;?>
        		</td>
        	</tr>
        </table>
        <?foreach($mdls as $modulo){?>
		  <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
				<tr>
                    <?if(empty($modulo['nome'])){?>
					   <td colspan="2" width="30%" ><?=$modulo['html'];?></td>
                    <?}else{?>
    					<td width="30%"><label for="<?=$id;?>"><?=$modulo['nome'];?></label></td>
    					<td><?=$modulo['html'];?></td>
                    <?}?>
				</tr>
		  </table>
        <?}
        }if(!empty($modulos['condicao'])){?>
            <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
            	<tr>
            		 <td  class="titulo">
            			&nbsp;Termo de Aceite
            		</td>
            	</tr>
            </table>
            <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
                <tr>
                	<td>Condição:</td>
                	<td><?=moduloValor($modulos, 'condicao' . $modulos['condicao']['valor']);?></td>
                </tr>
            </table>
        <?}?>
        </table>
        <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
        	<tr>
        		 <td  class="titulo">
        			&nbsp;Datas
        		</td>
        	</tr>
        </table>
        <table width="100%" height="100%"  align="center"  bordercolor='#c5c5c5'  border=1 cellpadding="0" cellspacing="0" class="form">
            <tr >
     			<td  width="250"><label for="datacadastro">Cadastro:</label></td>
            	<td colspan="2">
                    <?if($Root){?>
                    		<input type="text" id="datacadastro" name="datacadastro[]" size="12" onkeypress="mascara(this,datamask)" value="<?=(!empty($data['datacadastro'])?date('d/m/Y', strtotime($data['datacadastro'])):'');?>" maxlength="10" validate="datatype=date" />
                    		&nbsp;às&nbsp;<input type="text" id="horariocadastro" name="datacadastro[]" size="8" onkeypress="mascara(this,horamask)" value="<?=(!empty($data['datacadastro'])?date('H:i:s', strtotime($data['datacadastro'])):'');?>" maxlength="8" validate="datatype=time" />
                    <?}else{?>
                    		<?=(!empty($data['datacadastro'])?date('d/m/Y \à\s H:i:s', strtotime($data['datacadastro'])):'');?>
                    <?} ?>
            	</td>
            </tr>
            <tr >
     			<td><label for="numpvc">Numero de Pedido na Operadora:</label></td>
            	<td colspan="2">
                    <?if(permissao('dataproposta', 'al')){?>
                    		<input type="text" id="numpvc" name="numpvc" size="25" value="<?=(!empty($data['numpvc'])?$data['numpvc']:'');?>" maxlength="25" />
                    <?}else{?>
                    		<?=(!empty($data['numpvc'])?$data['numpvc']:'');?>
                    <?}?>
            	</td>
            </tr>
            
                <tr>
                	<td><label for="datacancelamento">Cancelamento:</label></td>
                	<td colspan="2">
                        <?if($Root){?>
                        		<input type="text" id="datacancelamento" name="datacancelamento[]" size="12" onkeypress="mascara(this,datamask)" value="<?=(!empty($data['datacancelamento'])?date('d/m/Y', strtotime($data['datacancelamento'])):'');?>" maxlength="10" validate="datatype=date" />
                        		&nbsp;às&nbsp;<input type="text" id="horariocancelamento" name="datacancelamento[]" size="8" onkeypress="mascara(this,horamask)" value="<?=(!empty($data['datacancelamento'])?date('H:i:s', strtotime($data['datacancelamento'])):'');?>" maxlength="8" validate="datatype=time" />
                        <?}else{?>
                        		<?=(!empty($data['datacancelamento'])?date('d/m/Y \à\s H:i:s', strtotime($data['datacancelamento'])):'');?>
                        <?} ?>
                	</td>
                </tr>
                <tr>
                	<td><label for="codmotivo">Motivo:</label></td>
                	<td colspan="2">
                        <?if($Root){
                        $sql = "Select m.* from motivoslead m Order By m.Descricao";
                        combo($sql,"codmotivo", @$data['codmotivo'], " ", "");?>
                        		<br />
                        		<textarea name="cancelamento" cols="30" rows="3"><?=@$data['cancelamento'];?></textarea>
                        <?}else{?>
                        		<?=@$data['motivo'];?><br />
                        		<?=@$data['cancelamento'];?>
                        <?} ?>
                	</td>
                </tr>
            <?
            //CONSTRUTOR DE DATAS
        	$sql = "Select 
        				dpo.cod_data_proposta_operador
        				,dpo.dsc_data
        				,dpo.obs_data
        				,dpo.nome_data
        			from data_proposta_operador dpo
        			inner join produtos p on dpo.cod_operador = p.cod_operador";			
        			$sql .= " where p.codproduto = ". $data['codproduto'];			
        			$sql .= " and dpo.dat_canc is null
        					  order by dpo.ordem";
	
        	$result = sql_query($sql);
        	while($row = mysql_fetch_array($result)){
        		$valor_data = '';
        		$valor_obs  = "";
        		if(!empty($data['codproposta'])){
        			$sql = "Select 
        						DATE_FORMAT(dp.valor_data,'%d/%m/%Y') as valor_data
        						,dp.valor_obs
        					from data_proposta dp";
        			$sql .= "	where dp.codproposta=".$data['codproposta'];
        			$sql .= "		and dp.versao=".$data['versao'];
        			$sql .= "		and dp.codlead=".$data['codlead'];
        			$sql .= "		and dp.nome_data='".$row['nome_data']."'";		
        			//$sql .= "		and dp.dat_canc is null ";
        			
        			$result1 = sql_query($sql);
        			$row1 = mysql_fetch_array($result1);
        			$valor_data = $row1['valor_data'];
        			$valor_obs  = $row1['valor_obs'];
        		}	
        		//SETA AS VERIAVEIS DE ACESSO AS DATAS		
        		$disabled="";	
        		$disabled1="";
        		$validate = "datatype=date";	
        		//VERIFICA SE O USARIO É CONSULTOR DE NEGOCIOS 
        		if(permissao('dataproposta', 'al')){
        			$disabled = "";
        			$validate = "datatype=date";
        		}
        		else{
        			$disabled="disabled";
        			$validate = "";	
        			//PERMISSAO DE ACESSO POR DATA
        			if(permissao($row['nome_data'],'al') == 1){
        				$disabled="";
        				$validate = "datatype=date";
        			}
        		}
        		
        		//VERIFICA SE O USARIO É CONSULTOR DE NEGOCIOS 
        		if($acao=='upd' and ($data['status_experto']==1 or $data['status_experto']==2 or $data['status_experto']==3)){
        			$disabled1="disabled";
        		}                		
                if(empty($disabled)){
        			if($row['nome_data'] == "experto" or $row['nome_data']=='pre_analise_financeira' ){
        				print "<tr>";
        				print 	"<td width=250>&nbsp;";
        				print 	"</td>";
        				print 	"<td width=100>&nbsp;";
        				print 	"</td>";
        				print 	"<td >";
        				?>
        					<label for="status_experto">Status:</label>
        					<select <?=$disabled1;?> name="status_experto" id="status_experto">
        						<option  value="" <?=(empty($data['status_experto'])?'selected="selected"':'');?>></option>
        						<option value="1" <?=(!empty($data['status_experto']) && @$data['status_experto'] == 0?'selected="selected"':'');?>>Reprovado</option>
        						<option value="2" <?=(!empty($data['status_experto']) && @$data['status_experto'] == 1?'selected="selected"':'');?>>Aprovado</option>
        						<option value="3" <?=(!empty($data['status_experto']) && @$data['status_experto'] == 2?'selected="selected"':'');?>>Submeter a análise de crédito</option>
        					</select>
        				<?	
        				print 	"</td>";
        				print 	"</td>";
        				print "</tr>";
        			}        			
        			print "<tr>";
        			print "	<td width='250'><label for=".$row['dsc_data'].">".$row['dsc_data']."</label></td>";
        			print "	<td width=100>";
        			print "  <input type=text $disabled id=".$row['nome_data']." name=".$row['nome_data']." size=12 onkeypress=mascara(this,datamask)  maxlength=10 validate=$validate value=".$valor_data." >";
                    print "	</td>";
        			if($row['obs_data']==1){
        				print "	<td  align=left>";
        				print "<textarea $disabled name=obs_".$row['nome_data']." cols='50%' rows=3>".$valor_obs."</textarea>";
        				if($row['dsc_data'] == "Entrega de Aparelhos:"){
        				?>
        					<a href="javascript:insNumeros(<?=$codlead?>,<?=($codproposta?$codproposta:'false');?>,<?=($versao?$versao:'false')?>);"><img src="../../images/cel.gif" alt="inserir numeros" height="30" border="0" style='border: 0px; padding: 1px;'></a>
        				<?		
        				}		
        				print "	</td>";
        			}else{
        				print "	<td  align=left>";
        				print "&nbsp;";
        				print "	</td>";
        			}				
        			print "  </tr>";
               }			
	       }
           if(empty($GerenteContas)){?>
            	<tr>
            		<td width="200"  align="left">Tipo Estorno:</td>
                    <td width="100">
                        &nbsp;
                    </td>
            		<td>
                		<?
                			$tipoestorno = null ;
                			if ( !empty( $data['tipoestorno'] ) )
                			{
                				$sql = "SELECT CodEstorno FROM estorno WHERE CodEstorno = " . $data['tipoestorno'] ;
                				$qry = sql_query( $sql ) ;
                				$tipoestorno = mysql_result( $qry , 0 , 0 ) ;
                			}
                	
                			$sql = "SELECT CodEstorno , DscEstorno FROM estorno" ;
                	
                			combo( $sql , "tipoestorno" , $tipoestorno,""," "," ") ;
                		?>
            		</td>
            	</tr>		
            	<tr>
            		<td><label for="dataativacao">Estorno: </label></td>
            		<td>
            		<?
            			$dataEstorno = '' ;
            			if ( !empty( $data['dataestorno'] ) )
            			{
            				$dataEstorno = explode( '-' , ( DataDMY($data['dataestorno'] ) ) ) ;
            				$dataEstorno = implode( '/' , $dataEstorno ) ;
            			}
            		?>
            			<input type="text" id="dataestorno" name="dataestorno" size="12" onkeypress="mascara(this,datamask)" value="<?= $dataEstorno ; ?>" maxlength="10" validate="datatype=date" />
            		</td>
            		<td>
            			<textarea name="descestorno" cols="25" rows="3"><?=@$data['descestorno'];?></textarea>
            			<br />R$ <input type="text" id="estorno" name="estorno" size="20" value="<?=(!empty($data['estorno'])?number_format($data['estorno'],2,',','.'):'');?>" maxlength="20" />
            		</td>
            	</tr>
                <?}	if($Admin || $Root){?>
    				<tr>
    					<td><label for="valorcontrato">Valor do Contrato:</label></td>
    					<td colspan="2">
                            <?if(empty($data['valorcontrato']) || $Root){?>
   						       R$<input type="text" name="valorcontrato" size="10" maxlength="20" value="<?=@$data['valorcontrato'];?>" validate="datatype=numeric;decimals=2" />
                            <?}else{?>
                                R$<?=number_format(@$data['valorcontrato'], 2, ',', '.');?>
                            <?}?>
    					</td>
    				</tr>
                <?	}?>		
            </table>				
            <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">	
				<tr>
					<th colspan="2"><label for="observacao">Observações:</label></th>
				</tr>
				<tr>
					<td colspan="2">
						<textarea id="observacao" name="observacao" style="width:100%" rows="20" cols="20"><?=@$data['observacao'];?></textarea>
					</td>
				</tr>
                <?if($Root){?>
    				<tr>
    					<td><label for="codocorrencialead">Ocorrência:</label></td>
    					<td><input type="text" name="codocorrencialead" size="5" maxlength="10" value="<?=@$data['codocorrencialead'];?>" validate="datatype=numeric" /></td>
    				</tr>
    				<tr>
    					<td><label for="totalproposta">Total da Proposta:</label></td>
    					<td><input type="text" name="totalproposta" size="5" maxlength="10" value="<?=@$data['totalproposta'];?>" validate="datatype=numeric;decimals=2" /></td>
    				</tr>
                <?}?>
			     <tfoot>
    				<tr>
    				  <th colspan="2">
						<input type="button" name="cancelar" value="Cancela Proposta" onclick="cancelarProposta()" />&nbsp;
    					<input type="button" name="fechar" value="Fechar" onclick="window.close()" />
    				  </th>
    				</tr>
			     </tfoot>
            </table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
