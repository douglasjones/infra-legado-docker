<?
require "../../libs/ajax/xajax_core/xajax.inc.php"; // XAJAX
require "../../libs/funBuscarCep.php"; // Função que faz a busca do cep

$ajax = new xajax();
$ajax->registerFunction("buscaCep");

function buscaCep($cep, $endereco, $bairro, $cidade, $uf){

	//Instancia o objeto XAJAX response
	$objResponse = new xajaxResponse('ISO-8859-1');

	if(empty($cep)){
		return $objResponse;
	}

	//$cep = str_replace("-", "", $cep);

	$resultado_busca = busca_cep($cep); // Retorna um array

	// Coloca os valores dos arrays nos campos do formulário
	$objResponse->assign($endereco, "value", $resultado_busca['tipo_logradouro']." ".$resultado_busca['logradouro']);
	$objResponse->assign($bairro, "value", $resultado_busca['bairro']);
	$objResponse->assign($cidade, "value", $resultado_busca['cidade']);
	$objResponse->assign($uf, "value", $resultado_busca['uf']);

	// Retorna a resposta de XML gerada pelo objeto do xajaxResponse
	return $objResponse;
}

// Manda o ajax processar os pedidos acima
$ajax->processRequest();
include_once "../../libs/maininclude.php";
$ajax->printJavascript('../../libs/ajax/');  
include_once "../../libs/datas.php";
include_once "../../libs/cla.agendaslead.php";
include_once "../../libs/combo.php";
include_once "auditoria_cla.php";

$acao = "ins";
$lytebox = $_REQUEST['lytebox'];
$agenda['CodAgendaLead'] = null;
$agenda['CodLead'] = null;
$agenda['CodUsuarioInterno'] = $_SESSION['codusuario'];
$agenda['AgendadoPor'] = $_SESSION['nomeusuario'];
$agenda['CodTipo'] = 1;
$agenda['Tipo'] = "Prospect";
$agenda['Futuro'] = true;
	
if(!empty($_REQUEST['codlead']))
	$agenda['CodLead'] = $_REQUEST['codlead'];

if(!empty($_REQUEST['codagendalead']))
	$agenda['CodAgendaLead'] = $_REQUEST['codagendalead'];

if(!empty($_REQUEST['reagendar']))
	$reagendar = $agenda['CodAgendaLead'];

if(!empty($_REQUEST['retorno']))
	$retorno = $agenda['CodAgendaLead'];

if(!empty($_REQUEST['excluir']) && !empty($agenda['CodAgendaLead'])){
	if(agendaslead::excluir($agenda['CodAgendaLead'])){
		javascriptalert('Operação executada com sucesso!!!');
	}
}
	
if($_REQUEST['enviar']=='true'){
	if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1]))
		$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]).' '.$_REQUEST['datacadastro'][1];
	if(!empty($_REQUEST['datahorario'][0]) && !empty($_REQUEST['datahorario'][1]))
		$_REQUEST['datahorario'] = dataYMD($_REQUEST['datahorario'][0]).' '.$_REQUEST['datahorario'][1];
	if(!empty($_REQUEST['datacancelamento'][0]) && !empty($_REQUEST['datacancelamento'][1]))
		$_REQUEST['datacancelamento'] = dataYMD($_REQUEST['datacancelamento'][0]).' '.$_REQUEST['datacancelamento'][1];
		else
			$_REQUEST['datacancelamento'] = 'null';
	if(!empty($_REQUEST['codreagendamento']))
		$_REQUEST['codreagendamento'] = 'null';
	if(isset($reagendar)){
		agendaslead::adicionar($_REQUEST, $reagendar);
	}elseif(isset($retorno)){
		agendaslead::adicionar($_REQUEST, null, $retorno);
	}elseif(empty($agenda['CodAgendaLead'])){
	  
		agendaslead::adicionar($_REQUEST);
	}elseif(!empty($agenda['CodAgendaLead'])){
		//CHECA SE OUVE ALTERAÇÃO NO AGENDADO PARA, SE SIM GRAVA UM LOG

		agendaslead::alterar($agenda['CodAgendaLead'], $_REQUEST);
	}else{
		javascriptalert('Erro ao executar a operação. Dados insuficientes ou inválidos!!!');
	}
    if($lytebox==1){
        echo "<script>";
        echo "parent.location.reload()";
        echo "</script>";        
    }else{
        javascriptalert('Operação executada com sucesso!!!');
    }    
}else{		
	if(!empty($agenda['CodAgendaLead'])){
		$acao = "upd";
		//Traz os dados da agenda.
		$sql = "SELECT a.*,
       s.Descricao Status,
       t.Descricao Tipo,
       u.Nome AgendadoPor,
       u1.Nome NomeAgendadoPara,
       c.NomeContato Contato,
       (a.DataHorario > SYSDATE()) Futuro
FROM agendaslead a
     LEFT JOIN statusagendamento s ON a.CodStatus = s.CodStatus
     LEFT JOIN tipoagendamento t ON a.CodTipo = t.CodTipo
     LEFT JOIN usuariosinternos u
        ON a.CodUsuarioInterno = u.CodUsuarioInterno
     LEFT JOIN usuariosinternos u1 ON a.AgendadoPara = u1.CodUsuarioInterno
     LEFT JOIN contatoslead c ON a.CodContatoLead = c.CodContatoLead";
		$sql .= " where a.CodAgendaLead = " . mysqlnull($agenda['CodAgendaLead']);
		
		$result = sql_query($sql);
		
		if(!$agenda = mysql_fetch_array($result))
	
                exit();
            $cep = $agenda ['cep'];
            $endereco = $agenda ['endereco'];
            $numero = $agenda ['numero'];
            $complemento = $agenda ['complemento'];
            $bairro = $agenda ['bairro'];
            $cidade = $agenda ['cidade'];
            $uf = $agenda ['uf'];
            $pontoref = $agenda ['pontoref'];
		mysql_free_result($result);
		
		if(isset($reagendar) or isset($retorno)){		
            
			$acao = "ins";
			$agenda['CodAgendaLead'] = null;
			$agendadopara = $agenda['CodUsuarioInterno'];//VARIAVEL DE REAGENDAMENTO COM O USUARIO ANTERIRO
			$agenda['CodUsuarioInterno'] = $_SESSION['codusuario'];				
			$agenda['AgendadoPor'] = $_SESSION['nomeusuario'];
			$agenda['DataCadastro'] = null;
			$agenda['DataHorario'] = null;
			$agenda['DataCancelamento'] = null;
			$agenda['Termino'] = null;
			$agenda['Descricao'] ;//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO
			$agenda['CodStatus'] = null;
			$agenda['Status'] = null;
			$agenda['CodOcorrenciaLead'] = null;
			$agenda['CodReagendamento'] = null;
			$agenda['Informacoes'] = null;
			$agenda['QualityService'] = null;
			$agenda['Cancelamento'] = null;
			$agenda['Futuro'] = true;
			$agenda['cod_tamanho_visita'];//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO
			$agenda['linha_nova'] ;//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO
			$agenda['linha_adicao'];//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO
			$agenda['linha_portabilidade'];//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO 
			$agenda['linha_renovacao'];//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO 
			$agenda['linha_migracao'];//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO
			$agenda['linha_transferencia'];//RETIRADO O NULL PARA SER PREENCHOD NO REAGENDAMENTO
            $cep = $agenda ['cep'];
            $endereco = $agenda ['endereco'];
            $numero = $agenda ['numero'];
            $complemento = $agenda ['complemento'];
            $bairro = $agenda ['bairro'];
            $cidade = $agenda ['cidade'];
            $uf = $agenda ['uf'];
            $pontoref = $agenda ['pontoref'];
            $operador_pk = $agenda['operador_pk'];
            echo $agenda ['auditoria'];
    	}
	}

	if(!empty($reagendar)){	
		
	}
	//Pesquisa os dados do lead.
	$sql = "";
	$sql .= "select CONCAT(l.RazaoSocial, IFNULL(CONCAT(' (', l.NomeFantasia, ')'), '')) RazaoSocial, l.CodGerenteConta ";
	$sql .= ", CONCAT(l.Endereco, IFNULL(CONCAT(', ', l.Numero), ''), IFNULL(CONCAT(' - ', l.Complemento), '')) Endereco1 ";
	$sql .= ", CONCAT(l.Bairro, IFNULL(CONCAT(' - ', l.Cidade), ''), IFNULL(CONCAT('/', l.UF), ''), IFNULL(CONCAT(' - ', l.CEP), '')) Endereco2";
	$sql .= " from leads l ";
	$sql .= " where l.CodLead = {$agenda['CodLead']}";
	$result = sql_query($sql);
	if(!$lead = mysql_fetch_array($result)){
	   echo $lead['Razaosocial'];
		javascriptalert('Erro!!!');
	}
	mysql_free_result($result);
}?>
<?	if(!(($acao == 'ins' && permissao('agenda', 'ic')) || ($acao == 'upd' && permissao('agenda', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}
	
if(!empty($_REQUEST['codlead'])){
    if(empty($_REQUEST['reagendar'])){
    	$sql = "select
    				l.endereco
    				,l.numero
    				,l.bairro
    				,l.cidade
                    ,l.cep
                    ,l.bairro
                    ,l.uf
                    ,l.PontoRef";
    			$sql .=" from leads l";
    			$sql .= " where l.codlead=".$_REQUEST['codlead'];		
    	
    		$rss = sql_query($sql);
    		if($row = mysql_fetch_array($rss)){
    			$cep = $row['cep'];
                $endereco = $row['endereco'];
                $numero = $row['numero'];
                $complemento = $row['complemento'];
                $bairro = $row['bairro'];
                $cidade = $row['cidade'];
                $uf = $row['uf'];
                $pontoref = $row['pontoref'];
    		}	
    }
}
if(!empty($_REQUEST['codlead'])){
    $leads_pk=$_REQUEST['codlead']; 
}else{
    $leads_pk=$agenda['CodLead'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
    <!--Cabeçalho-->
	<title>Agendamento</title>
	
	
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
        <script type="text/javascript" language="JavaScript" src="n_qtde_agenda.js"></script>
        <script type="text/javascript" language="JavaScript" src="agenda.js"></script>
        <script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
	<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
	<script type="text/javascript" language="javascript">
function editarInformacoes(){
	<?		
		//FUNCAO VERIFICA EMPRESA OPERADORA SE OI
		if(empresa_operador(6) == 6){	
	?>
		NewWindow('classifcacao_visita_cad_form.php?codagendalead=<?=$agenda['CodAgendaLead'];?>&codlead=<?=$agenda['CodLead'];?>&codtipo=<?=$agenda['CodTipo'];?>',750,500);
	<?}else{?>
		NewWindow('classifcacao_visita_cad_form.php?codagendalead=<?=$agenda['CodAgendaLead'];?>&codlead=<?=$agenda['CodLead'];?>&codtipo=<?=$agenda['CodTipo'];?>',750,500);
	<?}?>	
	
}
function auditar(){
	NewWindow('auditoria_cad_form.php?codagendalead=<?=$agenda['CodAgendaLead'];?>&codlead=<?=$agenda['CodLead'];?>',600,500);
}	
function editarQualityService(){
	NewWindow('leadsagendaqualityservice.php?codagendalead=<?=$agenda['CodAgendaLead'];?>',500,200);
}

function editarCancelamento(){
<?	if(@$agenda['CodStatus'] != 4){?>
	if(confirm('Confirma cancelamento da visita ?'))
<?	}?>
		NewWindow('leadsagendacancelamento.php?codagendalead=<?=$agenda['CodAgendaLead'];?>',500,200);
}

function excluirVisita(){
	if(confirm('Confirma excluir visita ?'))
		return true
	return false
}

function verAgenda(){
 var codgerenteconta = document.getElementById("gerentecontas").value;
<?	if(empty($agenda['CodAgendaLead'])){?>	
    
    NewWindow('../../vendas/agenda/agenda.php?codgerenteconta='+codgerenteconta,5000,5000);
<?	}else{?>

	NewWindow('../../vendas/agenda/agenda.php?&codgerenteconta='+codgerenteconta+'&mes=<?=date('m', strtotime($agenda['DataCadastro']));?>&ano=<?=date('Y', strtotime($agenda['DataCadastro']));?>#<?=$agenda['CodAgendaLead'];?>',5000,5000);
<?	}?>
}

function incluirContato(){
    var lytebox = '<?=$lytebox;?>';
	NewWindow('leadsagendacontatos.php?codlead=<?=$agenda['CodLead'];?>&lytebox='+lytebox,330,250);
}

//Exclui Gerente de Conta
function excluirGerente(){
	var d = document.forms[0]
	var indice = d.gerentecontas.selectedIndex
	if (indice == -1){
		alert('Selecione um item na lista!!!')
	}
	else{
		d.gerentecontas.remove(indice)
	}
}

//Inclui Gerente de Conta
function incluirGerente(){
	var strSelecionados = ""
	var d = document.forms[0]
	for(var i=0; i < d.gerentecontas.options.length; i++)
	strSelecionados += d.gerentecontas.options[i].value + ','
    
    NewWindow('leadsagendagerente.php?codgerenteconta=' + strSelecionados,360,100)
}

function pegaGerente(){
	var gerenteconta = document.getElementById('gerentecontas')
	for(var i = 0; i < gerenteconta.options.length; i++)
		gerenteconta.options[i].selected = true
}

function validaCampos(){
	if(!validateForm(document.forms[0])) return false;
	pegaGerente();
	return true;
}

function enviarFormulario(){
	var frm = $('dados');	
	var qtdop = $('qtdop');
	//var qtv = (document.getElementById("qtv").value) - 1;
	//VALIDA TAMANHO DA VISITA
	
		
	//VALIDA A CLASSIFICA;ÁO DE LINHAS
	if(frm.linha_nova.checked == false && frm.linha_adicao.checked == false && frm.linha_portabilidade.checked == false && frm.linha_renovacao.checked == false && frm.linha_migracao.checked == false && frm.linha_transferencia.checked == false){
		alert('Informe a classificação de linhas!');
		return false;
	}	
		
	if(validaCampos()){ 
		frm.enviar.value = true;
		frm.submit();
	}
	
}


</script>
    <style type="text/css">
<!--
.div_operadoras {
	background-color: #FFFFFD;
	width: 97%;
	border: 2px solid #CCFF00;
	padding-left: 5px;
	margin-left: 5px;
	height: 60px;
	overflow-y: auto;
	margin-bottom: 10px;
}
-->
    </style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <form name="dados" id="dados" method="post" action="leadsagendanew.php" onsubmit="return validaCampos(this)">
        <input type="hidden" name="codpreagendamento" value="<?=$_REQUEST['codpreagendamento']?>">
        <?if(isset($reagendar)){?>
            <input type="hidden" id="reagendar" name="reagendar" value="<?=$reagendar;?>" />
        <?}?>
        <?if(isset($retorno)){?>
            <input type="hidden" id="retorno" name="retorno" value="<?=$retorno;?>" />
        <?}?>
        <?if(isset($reagendar) || isset($retorno)){?>
            <input type="hidden" id="codagendalead" name="codagendalead" value="<?=(isset($reagendar)?$reagendar:$retorno);?>" />
        <?}else{?>
            <input type="hidden" id="codagendalead" name="codagendalead" value="<?=$agenda['CodAgendaLead'];?>" />
        <?}?>
        <input type="hidden" id="codlead" name="codlead" value="<?=$agenda['CodLead'];?>" />
        <input type="hidden" id="lytebox" name="lytebox" value="<?=$lytebox?>" />
    <table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
    	<tr>
    		 <td  class="titulo"> 
    			&nbsp;Agendamento
    		</td>
    	</tr>
    </table>
    <table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
        <tbody>
            <tr>
                 <td>&nbsp;</td>
            </tr>			
    		<?if(permissao('razaoagenda', 'dt')){?>
        		<tr>
        			<td>&nbsp;Lead:</td>        			
        			<td><?=$lead['RazaoSocial']; ?></td>        			
        		</tr>
    		<?}?>
        	<tr>
				<td align="left" valign="top">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="topo_grid">Endereço da Visita</td>				
			</tr>
            <tr>
                <td >&nbsp;<label for="cep">Cep:</label></td>
                <td align="left"><input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9" onkeyup="if(this.value.length == 9) xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" onblur="xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" value="<?=$cep;?>" onKeyPress="mascara(this,cep1)" validate="required" validate="datatype=cep"/></td>
            </tr>
            <tr>
                <td >&nbsp;<label for="endereco">Endereço:</label></td>
                <td align="left"><input type="text" id="endereco" name="endereco" size="60" maxlength="150" value="<?=$endereco;?>" validate="required" />						</td>
            </tr>
            <tr>
                <td >&nbsp;<label for="numero">Numero:</label></td>
                <td align="left"><input type="text" id="numero" name="numero" size="5" maxlength="5" onKeyPress="mascara(this,soNumeros)" value="<?=$numero;?>" validate="required" /></td>
            </tr>
            <tr>
                <td >&nbsp;<label for="complemento">Complemento:</label></td>
                <td align="left"><input type="text" id="complemento" name="complemento" size="20" value="<?=$complemento;?>"  /></td>
            </tr>
            <tr>
                <td >&nbsp;<label for="bairro">Bairro:</label></td>
                <td align="left"><input type="text" id="bairro" name="bairro" maxlength="63" size="60" value="<?=$bairro;?>" validate="required" /></td>
            </tr>
            <tr>
                <td >&nbsp;<label for="cidade">Cidade:</label></td>
                <td align="left"><input type="text" id="cidade" name="cidade" maxlength="29" size="29" value="<?=$cidade;?>" validate="required" /></td>
            </tr>
            <tr>
                <td >&nbsp;<label for="estado">Estado:</label></td>
                <td align="left">
                    <?	$sql = "select uf , nome from estados ORDER BY nome";
            	   combo($sql, "uf", $uf, "Selecione um Estado", 'validate="required"');?>
                </td>
            </tr>
            <tr>
    			<td>&nbsp;<label for="pontoref">Ponto de Refer&ecirc;ncia:</label></td>
    			<td>
    				<input type="text" id="pontoref" name="pontoref" maxlength="200" size="20" value="<?=$pontoref;?>" />
    			</td>
    		</tr>
			<tr>
				<td class="topo_grid">&nbsp;</td>
				<td bgcolor="#5982AA">&nbsp;
			</tr>		
            <tr>
    			<td>&nbsp;Contato:</td>
    			<td>
                    <?if(empty($agenda['DataCancelamento']) || $Root){
                    		$sql = "select CodContatoLead, NomeContato ";
                    		$sql .= " from contatoslead ";
                    		$sql .= " where CodLead = {$agenda['CodLead']} ";
                    		combo($sql, "codcontatolead", @$agenda['CodContatoLead'], "", " validate='required'");?>
                    		<input type="button" value="Incluir" onclick="incluirContato()" />
                    <?}else{?>
    				<?=$agenda['Contato'];?>
                    <?}?>
    			</td>
    		</tr>
            <?
            //CONSULTOR
            if(permissao('agendagerentecontas', 'dt')){?>
                <tr>
            	    <td>&nbsp;<label for="gerentecontas">Consultor:</label></td>
            		<td>
            		    
                            <?
                            $sql = "select Distinct u.CodUsuarioInterno
                                            , u.Nome
                                            , l.CodGerenteConta
                    				from usuariosinternos u 
                    					left join agendagerenteconta agc on u.CodUsuarioInterno = agc.CodGerenteConta
         		 		                left join agendaslead a on a.codagendalead = agc.codagendalead
                                        left join leads l on a.CodLead = l.CodLead    
                                     where 1";
                    		if(!empty($agenda['CodAgendaLead'])){
                    			$sql .= " and agc.CodAgendaLead = " . $agenda['CodAgendaLead'];
                    		}elseif(!empty($lead['CodGerenteConta'])){
                    			$sql .= " and u.CodUsuarioInterno = " . $lead['CodGerenteConta'];
                    		}else{
                    			$sql .= " and 0";
                    		}
                    		if(isset($reagendar))
                    			$sql .= " and agc.CodAgendaLead = " . $reagendar;
                    		if(isset($retorno))
                    			$sql .= " and agc.CodAgendaLead = " . $retorno;
                                
                            $sql .=" group by u.CodUsuarioInterno";    
                    		$result = sql_query($sql);
                           ?>
                           <select id="gerentecontas" name="gerentecontas[]" size="5" style="width:200px" multiple="multiple">
                           <? 
                    		while($row = mysql_fetch_array($result)){
                             if($row['CodUsuarioInterno']==$row['CodGerenteConta']){
                                $selected = "selected";
                             }else{                                
                                $selected = "";
                             }  
                              ?>
            						<option value="<?=$row['CodUsuarioInterno'];?>" <?=$selected;?> ><?=$row['Nome'];?></option>
                          <?}		
            	            mysql_free_result($result);
                          ?>
            		    </select><br />
                        <?if(permissao('agendagerentecontas', 'ic')){?>
            				<input type="button" value="Incluir" onclick="incluirGerente()" />&nbsp;                              
                        <?}if(permissao('agendagerentecontas', 'ex')){?>
            				<input type="Button" value="Excluir" onclick="excluirGerente()" />
                        <?}
                        ?>
            		</td>
                </tr>
            <?}?>
            <tr>
                <td>
                    &nbsp;Agendar para Operadora:
                </td>
                <td>
                    <? 
                    
                        if(permissao('agendamento_para_operadora', 'ic')){
                            $sql = "select
                                        o.cod_operador operador_pk
                                        ,o.dsc_operador
                                    from operador o";
                            $sql .="	inner join empresa_operador eo on o.cod_operador = eo.cod_operador";
                            if(!empty($_SESSION['cod_empresa'])){
                                $sql .=" where eo.cod_empresa=".$_SESSION['cod_empresa'];
                            }
                            $sql .=" group by  o.dsc_operador";
                            $result = sql_query($sql);
                            while($row = mysql_fetch_array($result)){
                                
                    ?>   
                                
                                <?=$row['dsc_operador']?><input type='radio' name='operador_pk' id='operador_pk' value='<?=$row['operador_pk'];?>' <?if($row['operador_pk']==$agenda['operador_pk']){echo "checked='checked'";}?> >&nbsp;
                    <?                                                    
                            }
                            mysql_free_result($result);
                    }
                    ?>
                    
                </td>
            </tr>            
            <tr>
                <td>&nbsp;<label for="codusuariointerno">Agendado por:</label></td>
                <td>
                    <?=$agenda['AgendadoPor'];?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;<label for="agendadopara">Agendado para Atendente:</label></td>
                <td>
                    <?
                             $sql = "select
                                  ui.CodUsuarioInterno
                                  ,ui.Nome
                                from leads l
                                left join usuariosinternos ui on l.CodAtendente = ui.CodUsuarioInterno
                                left join agendaslead a on l.CodLead = a.CodLead";
                                if(empty($agenda['AgendadoPara'])){
                                    if(!empty($_REQUEST['codlead'])){                                        
                                        $sql .= " where l.codlead=".$_REQUEST['codlead'];    
                                    }else{
                                        $sql .= " where a.codagendalead=".$_REQUEST['codagendalead'];
                                    }
                                }else{
                                    $sql .= " where ui.codusuariointerno=".$agenda['AgendadoPara'];
                                }
                                $sql .= "  group by ui.CodUsuarioInterno";

                         $result = sql_query($sql);       
    				     $agendadopara = mysql_fetch_array($result);	
                        
                		 print "<input type=hidden name='agendadopara' value=".$agendadopara['CodUsuarioInterno']." >";
         				 print $agendadopara['Nome'];       
                    ?>
                
                    
                    
                </td>
            </tr>
            <?if($acao != 'ins' && $Root){?>
                <tr>
                	<td>&nbsp;<label for="datacadastro">Data cadastro:</label></td>
                	<td>
                		<input type="text" id="datacadastro"  name="datacadastro[]" size="12" maxlength="10" onkeypress="mascara(this,datamask)" value="<?=(!empty($agenda['DataCadastro'])?date('d/m/Y', strtotime($agenda['DataCadastro'])):'');?>"  validate="datatype=date;required" />
                		&nbsp;às&nbsp;
                                <input type="text" id="horariocadastro" name="datacadastro[]" size="8" maxlength="8" onkeypress="return horamask2(this,event)" value="<?=(!empty($agenda['DataCadastro'])?date('H:i:s', strtotime($agenda['DataCadastro'])):'');?>"  validate="datatype=time;required" />
                	</td>
                </tr>
            <?}?>
			<tr>
				<td>&nbsp;<label for="datahorario">Data e horário:</label></td>
				<td>
                    <?if($agenda['Futuro'] || $acao == 'ins' || $Root){?>
					   <input type="text" id="datahorario" class="input1" name="datahorario[]" size="12" maxlength="10" onkeypress="mascara(this,datamask)" value="<?=(!empty($agenda['DataHorario'])?date('d/m/Y', strtotime($agenda['DataHorario'])):'');?>" validate="datatype=date;required" />
					   &nbsp;às&nbsp;
                                           <input type="text" id="horariovisita" class="input1" onblur="verifica_qtde()" name="datahorario[]" size="8" maxlength="5" onkeypress="return horamask2(this,event)" value="<?=(!empty($agenda['DataHorario'])?date('H:i', strtotime($agenda['DataHorario'])):'');?>"" validate="datatype=shorttime;required" />
                    <?}else{?>
						<?=(!empty($agenda['DataHorario'])?date('d/m/Y \à\s H:i', strtotime($agenda['DataHorario'])):null);?>
                    <?}?>
					&nbsp;
					<a href="javascript:verAgenda()">Visualizar Agenda</a>
				</td>
			</tr>
            <?if($acao != 'ins'){?>
                <tr>
                    <td>&nbsp;<label for="termino">Término:</label></td>
                        <td>
                            <?if($Root){?>
                                <input type="text" id="termino" name="termino" value="<?=(!empty($agenda['Termino'])?date('H:i', strtotime($agenda['Termino'])):'');?>" maxlength="5" size="8" onkeypress="mascara(this,horamask)" validate="datatype=shorttime" />
                            <?}else{?>
                                <?=(!empty($agenda['Termino'])?date('H:i', strtotime($agenda['Termino'])):null);?>
                            <?}?>
                        </td>
                </tr>
                <?if(!empty($agenda['DataCancelamento']) || $Root){?>
                    <tr>
                        <td>&nbsp;<label for="datacancelamento">Data cancelamento:</label></td>
                        <td>
                            <?if($Root){?>
                                <input type="text" id="datacancelamento" name="datacancelamento[]" size="12" onkeypress="mascara(this,datamask)" maxlength="10" value="<?=(!empty($agenda['DataCancelamento'])?date('d/m/Y', strtotime($agenda['DataCancelamento'])):null);?>" validate="datatype=date" />
                                &nbsp;às&nbsp;
                                <input type="text" id="horariocancelamento" name="datacancelamento[]" size="8" onkeypress="return horamask2(this,event)" maxlength="8" value="<?=(!empty($agenda['DataCancelamento'])?date('H:i:s', strtotime($agenda['DataCancelamento'])):'');?>" validate="datatype=time" />
                            <?}else{?>
                                <?=(!empty($agenda['DataHorario'])?date('d/m/Y \à\s H:i', strtotime($agenda['DataCancelamento'])):'');?>
                                <?}if(empty($agenda['DataCancelamento'])){?>
                                &nbsp;
                            <?}?>
                        </td>
                    </tr>
                <?}?>
				<tr>
					<td>&nbsp;<label for="codstatus">Status Agendamento:</label></td>
					<td>
                        <?if($Root){
                        		$sql = "select CodStatus, Descricao";
                        		$sql .= " from statusagendamento";
                        		$sql .= " ORDER BY Descricao";
                        		combo($sql, "codstatus", $agenda['CodStatus'], " ", "");
                        }else{?>
                            <?=$agenda['Status'];
                        }
                    	if(!empty($agenda['CodReagendamento'])){
                    		$sql = "select CodAgendaLead, DataHorario ";
                    		$sql .= "  from agendaslead ";
                    		$sql .= " where codagendalead = {$agenda['CodReagendamento']}";
                    		$result = sql_query($sql);
                    		if($row = mysql_fetch_array($result)){?>
						      <a href="LeadsAgendaNew.php?codagendalead=<?=$agenda['CodReagendamento'];?>">
                                <?if($agenda['CodStatus'] != 3){?>
						          Retorno
                                <?}?>
						          para o dia <?=date('d/m/Y \à\s H:i', strtotime($row['DataHorario']));?></a>
                            <?}
		                    mysql_free_result($result);
	                   }?>
					</td>
				</tr>
            <?}?>
                <!--<tr>               
                    <td>
                        Tamanho Visita:
                    </td>
                    <td>
                        <table cellpadding="0" cellspacing="0" border="0"  class="form">
                           <?
                            $sql = "";
                            $sql.= "select tv.pk, tv.dsc_tamanho_visita
                                    from n_tamanho_visita tv
                                    where tv.dt_cancelamento IS NULL
                                    ORDER BY tv.pk";

                            $results = sql_query($sql);
                           $qtd = 1;
                            while($row = mysql_fetch_array($results)){                             
                           ?>
                                <tr>
                                    <td >
                                        <font color="#0000cc"><? echo $row['dsc_tamanho_visita'];?></font>
                                    </td>
                                    <td>
                                        &nbsp;<input type="radio" class="input1" name="cod_tamanho_visita" <? if($agenda['cod_tamanho_visita']==$row['pk']){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?> <?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> <? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> <?}?> value="<?=$row['pk'];?>" />

                                    </td>
                                </tr>
                            <?   
                                $qtd ++;
                             }
                            echo "<input type='hidden' id='qtv' name='qtv' value='$qtd'>";
                             mysql_free_result($result);
                            ?>

                        </table>
                    </td>
                </tr>--> 
            <tr>
                <td>
                    &nbsp;
                </td>
            </tr>
                <tr>
                    <td align="center" colspan=2>
                        <table width="100%" align="left"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="15" align="left"  class="titulo">&nbsp; Informações do Lead</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <table width="100%"   align="center" border="1" cellpadding="0" cellspacing="0" class="form">
                            <tr class="grid">
                                <td>
                                    Item
                                </td>
                            <?
                                $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";

                                $result = sql_query($sql);
                                $v_coluna = "";
                                while($row = mysql_fetch_array($result)){

                            ?>
                                <td align="center">
                                    <?=$row['dsc_operadora'];?>
                                </td>   
                            <?
                                $v_coluna ++;
                                }
                                mysql_free_result($result);
                            ?>
                            </tr>  
                            <tr>
                                <td align="center">
                                    Cliente
                                </td>                                
                                <?
                                
                                
                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $v_coluna = "";
                                    $cliente_operadora_pk ="";
                                    while($row = mysql_fetch_array($result)){
                                        
                                        $sql ="";
                                        $sql.="SELECT nldc.lead_cliente
                                                FROM n_leads_dados_cliente nldc
                                               WHERE nldc.leads_pk =".$leads_pk;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];
                                        
                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $cliente_operadora_pk = $rows['lead_cliente']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <select name="<?$row['dsc_operadora']?>" id="<?$row['dsc_operadora']?>" class='formulario_select' onchange="cliente(this.value,<?=$row['cod_operadora'];?>,<?=$_REQUEST['codlead'];?>)">
                                            <option value=""></option>
                                            <option value="1" <?if($cliente_operadora_pk==1){echo "selected";}?>>Sim</option>
                                            <option value="2" <?if($cliente_operadora_pk==2){echo "selected";}?> >Não</option>
                                        </select>
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    DT da ativação
                                </td>                                
                                <?
                                   $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT DATE_FORMAT(nldc.dt_ativacao, '%d/%m/%Y') dt_ativacao
                                                FROM n_leads_dados_ativacao nldc
                                               WHERE nldc.leads_pk =".$leads_pk;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $dt_ativacao = $rows['dt_ativacao']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input class="input" value="<?=$dt_ativacao;?>" id="dt_ativacao" name="dt_ativacao" size="12" maxlength="10" onkeypress="mascara(this,datamask)"onblur="dt_ativacao_contrato(this.value,<?=$row['cod_operadora'];?>, <?=$_REQUEST['codlead'];?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    DT Venc Contrato
                                </td>                                
                                <?
                                   $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT DATE_FORMAT(nldc.dt_vencimento, '%d/%m/%Y') dt_vencimento
                                                FROM n_leads_dados_vencimento nldc
                                               WHERE nldc.leads_pk =".$leads_pk;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $dt_vencimento = $rows['dt_vencimento']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input class="input" value="<?=$dt_vencimento;?>" id="dt_vencimento" name="dt_dt_vencimento" size="12" maxlength="10" onkeypress="mascara(this,datamask)" onblur="vencimento_contrato(this.value,<?=$row['cod_operadora'];?>, <?=$_REQUEST['codlead'];?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>
                            <tr>
                                <td align="center">
                                    Qtde de linhas voz
                                </td>                                
                                <?
                                    $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT nldc.qtde_voz
                                                FROM n_leads_qtde_voz nldc
                                               WHERE nldc.leads_pk =".$leads_pk;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $qtde_voz = $rows['qtde_voz']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input type="text" class="input" value="<?=$qtde_voz;?>" id="qtde_voz" name="qtde_voz" size="3" maxlength="5" onblur="qtde_voz_lead(this.value,<?=$row['cod_operadora'];?>, <?=$_REQUEST['codlead'];?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr> 
                            <tr>
                                <td align="center">
                                    Qtde de linhas Dados
                                </td>                                
                                <?
                                   $sql = "SELECT op.cod_operadora, op.dsc_operadora, o.cod_operador
                                            FROM operadoras op
                                                 LEFT JOIN operador o ON o.dsc_operador = op.dsc_operadora
                                                 where op.cod_operadora not in(7,8,4)
                                            GROUP BY op.dsc_operadora";
                                    $result = sql_query($sql);
                                    $dt_vencimento = "";
                                    while($row = mysql_fetch_array($result)){
                                        $sql ="";
                                        $sql.="SELECT nldc.qtde_dados
                                                FROM n_leads_qtde_dados nldc
                                               WHERE nldc.leads_pk =".$leads_pk;  
                                        $sql.="  AND nldc.operadora_pk = ".$row['cod_operadora'];

                                        $results = sql_query($sql);    
                                        $rows = mysql_fetch_array($results);
                                        $qtde_dados = $rows['qtde_dados']; 
                                        mysql_free_result($results);

                                ?>
                                    <td align="center">
                                        <input type="text" class="input" value="<?=$qtde_dados;?>" id="qtde_dados" name="qtde_dados" size="3" maxlength="5" onblur="qtde_dados_lead(this.value,<?=$row['cod_operadora'];?>,<?=$_REQUEST['codlead'];?>)">
                                    </td>   
                                <?
                                    $v_coluna ++;
                                    }
                                    mysql_free_result($result);
                                ?>
                            </tr>                             
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
                
                <tr>
                    <td>&nbsp;<label for="codtipo">Tipo Agendamento:</label></td>
                    <td>
                        <?php
                            if(($agenda['Futuro'] || $Root || isset($retorno)) && !isset($reagendar)){
                                $sql = "select CodTipo, Descricao" ;
                                $sql .= " from tipoagendamento";
                                $sql .= " ORDER BY Descricao";
                                combo($sql, "codtipo", $agenda['CodTipo'], "", 'validate="required"');
                            }else{?>
                                                <input type="hidden" id="codtipo" name="codtipo" value="<?=$agenda['CodTipo'];?>" />
                                                <?=$agenda['Tipo'];?>
                            <?}?>
					</td>
				</tr>
                <tr>
                	<td>
                    	&nbsp;<label for="linhas">Linhas:</label>
                    </td>
                    <td>
                    	<table cellpadding="0" cellspacing="0"  class="form">
                        	<tr>
                            	<td>
                                	<font color="#0000cc">Linhas Novas</font>;
                                </td>
                                <td>                              
                                	&nbsp;<input type="checkbox" class="input1" name="linha_nova" 
                                	<? if($agenda['linha_nova']==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
	                    			<?}?>   value="1" />
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<font color="#0000cc">Linhas Adição</font>;
                                </td>
                                <td>
                                	&nbsp;<input type="checkbox" class="input1" name="linha_adicao" 
                                	     	<? if($agenda['linha_adicao']==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
	                    			<?}?>   value="1" />
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<font color="#0000cc">Linhas Portabilidade</font>;
                                </td>
                                <td>
									&nbsp;<input type="checkbox" class="input1" name="linha_portabilidade" 
									<? if($agenda['linha_portabilidade']==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
	                    			<?}?>   value="1" />
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<font color="#0000cc">Linhas Renovação</font>;
                                </td>
                                <td>
                                	&nbsp;<input type="checkbox" class="input1" name="linha_renovacao" 
                                    <? if($agenda['linha_renovacao']==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
	                    			<?}?>   value="1" />
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<font color="#0000cc">Linhas Migração</font>;
                                </td>
                                <td>
                                	&nbsp;<input type="checkbox" class="input1" name="linha_migracao" 
                                	<? if($agenda['linha_migracao']==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
	                    			<?}?>value="1" />
                                </td>
                            </tr>
                            <tr>
                            	<td>
                                	<font color="#0000cc">Linhas Transferência</font>;
                                </td>
                                <td>
                                	&nbsp;<input type="checkbox" class="input1" name="linha_transferencia" 
                                    <? if($agenda['linha_transferencia']==1){?> checked="checked"<? }//VERIFICA A VARIAVEL E MARCA?>
	                    			<?if($_REQUEST['acao']=='upd'){ //VERIFICA A VARIAVEL DE ACAO?> 
	                    			<? if($Root){?>  <? }else{?> disabled="disabled"<? }//VERIFICA A O USUARIO E ADM} ?> 
	                    			<?}?>   value="1" />
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
               </tr>
                <?if(!empty($_REQUEST['reagendar'])){?><!--Reagendamento motivo de reagendamento 06/02/2010-->
                <tr>
					<td>&nbsp;<label for="motivoreagendamento">Motivo Reagendamento:</label></td>
					<td><? 	$sql = "select m.cod_motivo_reagendamento,m.dsc_motivo_reagendamento" ;
							$sql .= " from motivo_reagendamento m";
							$sql .= " ORDER BY dsc_motivo_reagendamento";
							combo($sql, "cod_motivo_reagendamento", $agenda['cod_motivo_reagendamento'], "", 'validate="required"');?><br />
                            <textarea cols="50" rows="5" class="input1" name="dsc_reagendamento" validate="required"></textarea>
                    </td>
				</tr>
                <?}?>
                
                <?if($Root){?>
				<tr>
					<td>&nbsp;<label for="codocorrencialead">Ocorrência:</label></td>
					<td><input type="text" name="codocorrencialead" size="5" maxlength="10" value="<?=@$agenda['CodOcorrenciaLead'];?>" validate="datatype=numeric" /></td>
				</tr>
				<tr>
					<td>&nbsp;<label for="codreagendamento">Reagendamento:</label></td>
					<td><input type="text" name="codreagendamento" size="5" maxlength="10" value="<?=@$agenda['CodReagendamento'];?>" validate="datatype=numeric" /></td>
				</tr>
                <?}?>
				<tr>
					<th colspan="2">&nbsp;<label for="descricao">Descrição:</label></th>
				</tr>
				<tr>
					<td colspan="2" align="center"><textarea cols="55" class="input1" rows="10" id="descricao" name="descricao" style="width:98%" validate="required"><?=@$agenda['Descricao'];?></textarea></td>
				</tr>
				<tr>
					<td colspan=@>&nbsp;</td>
				</tr>
<?	if(!$agenda['Futuro'] && $agenda['CodStatus'] != 3 && !empty($agenda['CodAgendaLead'])){
		if($agenda['CodStatus'] != 4){
			$sql = "select u.Nome, o.Descricao ";
			$sql .= " from usuariosinternos u ";
			$sql .= " inner join ocorrenciaslead o on o.CodUsuarioInterno = u.CodUsuarioInterno ";
			$sql .= " where (o.CodOcorrenciaLead = " . mysqlnull($agenda['CodOcorrenciaLead']) . " Or o.OcorrenciaSuperior = " . mysqlnull($agenda['CodOcorrenciaLead']) . ") ";
			$sql .= " and o.CodTipoOcorrenciaLead = 30";
			$rs = sql_query($sql);
			$informacao = mysql_fetch_array($rs);
			if((empty($informacao) && permissao('informacaovisita', 'ic')) || (!empty($informacao) && permissao('informacaovisita', array('al', 'dt')))){?>
				<tr>
					<th>Classificação da Visita</th>
					<td>
						<?=($informacao?$informacao['Nome']:'');?>&nbsp;
<?				if((empty($informacao) && permissao('informacaovisita', 'ic')) || (!empty($informacao) && permissao('informacaovisita', 'al'))){?>
						<input type="button" value="Editar" onclick="editarInformacoes()" />
<?				}?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><?=$agenda['Informacoes'];?>
					<?=($Root && empty($agenda['Informacoes'])?'<br />Ocorrência: ' . $informacao['Descricao']:'');?>
					</td>
				</tr>
<?			}
			mysql_free_result($rs);
			$sql = "select u.Nome, o.Descricao ";
			$sql .= " from usuariosinternos u ";
			$sql .= " inner join ocorrenciaslead o on o.CodUsuarioInterno = u.CodUsuarioInterno ";
			$sql .= " where (o.CodOcorrenciaLead = " . mysqlnull($agenda['CodOcorrenciaLead']) . " Or o.OcorrenciaSuperior = " . mysqlnull($agenda['CodOcorrenciaLead']) . ") ";
			$sql .= " and o.CodTipoOcorrenciaLead = 23";
			$rs = sql_query($sql);
			$quality = mysql_fetch_array($rs);
			if((empty($quality) && permissao('qualityservice', 'ic')) || (!empty($quality) && permissao('qualityservice', array('al', 'dt')))){?>
				<tr>
					<th>Quality Call:</th>
			  <td>
						<?=($quality?$quality['Nome']:'');?>&nbsp;
<?				if((empty($quality) && permissao('qualityservice', 'ic')) || (!empty($quality) && permissao('qualityservice', 'al'))){?>
						<input type="button" value="Editar" onclick="editarQualityService()" />
<?				}?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><?=$agenda['QualityService'];?>
					<?=($Root && empty($agenda['QualityService'])?'<br />Ocorrência: ' . $quality['Descricao']:'');?></td>
				</tr>
<?			}
			mysql_free_result($rs);
		}
		$sql = "select u.Nome, o.Descricao ";
		$sql .= " from usuariosinternos u ";
		$sql .= " inner join ocorrenciaslead o on o.CodUsuarioInterno = u.CodUsuarioInterno ";
		$sql .= " where (o.CodOcorrenciaLead = " . mysqlnull($agenda['CodOcorrenciaLead']) . " Or o.OcorrenciaSuperior = " . mysqlnull($agenda['CodOcorrenciaLead']) . ") ";
		$sql .= " and o.CodTipoOcorrenciaLead = 38";
		
		$rs = sql_query($sql);
		$cancelamento = mysql_fetch_array($rs);
		mysql_free_result($rs);
		if(!empty($agenda['DataCancelamento']) && ($Root || permissao('cancelarvisita', array('al', 'dt')))){ 
			
			?>
				<tr>
					<th>Cancelamento:</th>
					<td>
						<?=($cancelamento?$cancelamento['Nome']:'');?>&nbsp;
<?			if((empty($agenda['DataCancelamento']) && permissao('cancelarvisita', 'ic')) || (!empty($agenda['DataCancelamento']) && permissao('cancelarvisita', 'al'))){?>
						<input type="button" value="Editar" onclick="editarCancelamento()" />
<?			}?>
					</td>
				</tr>
				<tr>
					<td colspan="2"><?=$agenda['Cancelamento'];?>
					<?=($Root && empty($agenda['Cancelamento'])?'<br />Ocorrência: ' . $cancelamento['Descricao']:'');?></td>
				</tr>
<?		}

	}?>
			</tbody>
			<tfoot>
<?php
		//Armazenando o Codigo do Lead
		if (!empty($_REQUEST['codlead'])) $codlead=$_REQUEST['codlead'];
		else
		{
			//Descobrindo o CodLead.
			if(!empty($_GET['codagendalead']))
			{	
				$result = sql_query("select CodLead from agendaslead where CodAgendaLead=".mysqlnull($_GET['codagendalead']));
				$codlead = mysql_result($result,0);
			}						
		}
				  
		if(!empty($codlead))  $operadoras = leads::operadoras($codlead);
		
		(empty($operadoras)? $estilo='visibility:visible;': $estilo='visibility:hidden; position: absolute;');
		
			$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
			$result = sql_query($sql);
?>
				<tr>
					<th colspan="2" align="center">

						<input type="button" name="envia" value="Enviar" onclick="enviarFormulario()" />
						<input type="hidden" name="enviar" value="false">
                        <?
                            if(empty($agenda['CodReagendamento']) && !empty($agenda['CodAgendaLead']) && $agenda['CodStatus'] != 4 && $agenda['CodStatus'] != 3){
                        		if(empty($informacao) && empty($qualityservice) && permissao('reagendarvisita', array('ic', 'al'))){
                        ?>
						          <input type="submit" name="reagendar" value="Reagendar visita" />
                        <?  
                                }
                        ?>
                        <?
                                if(empty($agenda['CodStatus']) || $agenda['CodStatus']==6 && permissao('agenda', 'al')){
                        ?>
						          <input type="button" name="cancelar" value="Cancelar visita" onclick="editarCancelamento()" />
                        <?  
                                }
                            }
                        	if(!empty($agenda['CodAgendaLead']) && ($Root || permissao('agenda', 'ex'))){
            	        ?>
						      <input type="submit" name="excluir" value="Excluir visita" onclick="return excluirVisita()" />
                        <?	
                            }
                        ?>
				        <input type="reset" name="limpar" value="Limpar" />
                        <?if($lytebox==1){?>
						  <input type="Button" value="Fechar" onclick="parent.myLytebox.end()">
                        <?}else{?>  
                        <input type="button" name="fechar" value="Fechar" onclick="window.close()" />&nbsp;
                        <?}?> 
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
