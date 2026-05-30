<?  
//===========================================================FUNÇÃO BUSCA CEO==============================================================
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

	$cep = str_replace("-", "", $cep);

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
include_once "../../libs/combo.php";

$ajax->printJavascript('../../libs/ajax/');
//======================================================================================================================
include_once "../../libs/cla.config_empresa.php";
//include_once "../../libs/cla.agendaslead.php";


$acao = "ins";
if(!(($acao == 'ins' && permissao('config_empresa', 'ic')) || ($acao == 'upd' && permissao('config_empresa', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

if(!empty($_REQUEST['Salvar'])){
	
	$value = config_empresa::dados_empresa($_REQUEST);
	$cod_empresa = $value['cod_empresa'];
	$cod_operador = $value['cod_operador'];

	javascriptalert('Operação executada com sucesso!!!' , false );
}else{
	$cod_empresa = $_REQUEST['cod_empresa'];
	$cod_operador = $_REQUEST['cod_operador'];
    $acao = $_REQUEST['acao'];
}

if (!empty($cod_empresa)){
	$sql = "Select
		e.cod_empresa
		,e.cod_polo
		,e.razao_social
		,e.nome_fantasia
		,e.cnpj
		,e.site
		,e.email
		,e.ddd
		,e.tel
		,e.ddd_fax
		,e.fax
		,e.cep
		,e.endereco
		,e.numero
		,e.complemento
		,e.bairro
		,e.cidade
		,e.uf
		,e.cod_tipo_empresa
		,e.url_logo
		,e.largura
		,e.altura
        ,e.origem_email_agendamento_pk
        ,e.enviar_agenda_email_pk
        ,e.agenda_email
        ,e.origem_email_proposta_pk
        ,e.enviar_proposta_email_pk
        ,e.proposta_email
	from empresa e
	where e.cod_empresa=".$cod_empresa;
	$result = sql_query($sql);
		if($row = mysql_fetch_array($result)){
			array_merge($row, $_REQUEST);
			$_REQUEST = $row;
		}		
	mysql_free_result($result);
}

?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title>Config Cliente</title>
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" src="../../extras/micoxUpload.js"></script>
    <script type="text/javascript" language="javascript">	
	//VERIFICA OS DADOS OBRIGATORIOS DA EMPRESA A SEREM PREENCHIDOS
	function salvaempresa(){	
		var d = document.forms[0];	
		if (d.razao_social.value==""){
			alert('Razão Social não foi preenchido !');
			d.razao_social.focus();
			return false;
		}
		if (d.nome_fantasia.value==""){
			alert('Nome Fantaisa não foi preenchido !');
			d.nome_fantasia.focus();
			return false;
		}
		if (d.email.value==""){
			alert('E-mail não foi preenchido !');
			d.email.focus();
			return false;
		}
		if (d.tel.value==""){
			alert('Telefone não foi preenchido !');
			d.tel.focus();
			return false;
		}
		if (d.endereco.value=="" && d.numero.value=="" ){
			alert('Logradouro não foi preenchido !');
			return false;
		}				
	}
	function  seleciona_operador(){
		document.operador.submit();
	}
	//CANCELA A DATA DA PROPOSTA
	function cancela_data(){
		if( confirm( "Deseja excluir o registro selecionado?" ) ){
			var d = document.forms[5];	
			d.desativar.value = 'del';
			d.submit();		
		}
		return false;
	}
	
	function cpfoucnpj(ooo){
		valor = document.getElementById('cnpj_cpf').value;
		if (ooo == 1){
			document.getElementById('cpq').innerHTML = '<input type="text" id="cnpj_cpf" name="cnpj_cpf" size="22" maxlength="18" onkeypress="mascara(this,cnpj)" value="'+valor+'" validate="datatype=cnpj_cpf" /> <input type="radio" name="cqpq" value="cnpj" onclick="cpfoucnpj(1)" checked>CNPJ<input type="radio" name="cqpq" value="cpf" onclick="cpfoucnpj(2)">CPF';
		}else if(ooo == 2){
			document.getElementById('cpq').innerHTML = '<input type="text" id="cnpj_cpf" name="cnpj_cpf" size="22" maxlength="14" onkeypress="mascara(this,cpf)" value="'+valor+'" validate="datatype=cnpj_cpf" /> <input type="radio" name="cqpq" value="cnpj" onclick="cpfoucnpj(1)">CNPJ<input type="radio" name="cqpq" value="cpf" onclick="cpfoucnpj(2)" checked>CPF';
		}
	}
	function selecionarImagem(){
		var div = $('divImagem');
		div.innerHTML = "Carregando..."
		div.style.display = "block";
		var pars = 'cod=1';
		new Ajax.Updater('divImagem', 'imagemajax.php', { method: 'post', parameters: pars } );

	}
	function enviarImagem(){
		
		var div = $('divImagem');
		div.innerHTML = "Carregando..."
		div.style.display = "block";
		var pars = 'cod=2';
		new Ajax.Updater('divImagem', 'imagemajax.php', { method: 'post', parameters: pars } );

	}
	function fecharAjax(){
		var div = $('divImagem');
		div.style.display = "none";
	}
	function trocarImagem(){
		img = $('Image');
		imgm = $('Imagem');
		newImg = $('Imagem_new');
		imgm.value = newImg.value;
		img.src = '../../images/logo/' + newImg.value;
		showImg();
		fecharAjax();
	}
	function fazerUpload(){
		var upaForm = $('upaImg');
		micoxUpload(upaForm,'upa.php','recebe_up_basico','Carregando...','Erro ao carregar');
		fecharAjax();
	}
	function showImg(){
		var div = $('ImageDiv');
		div.style.display = "block";
	}
</script>
<!--Include CSS-->
<link rel="stylesheet" href="../../extras/relatorio.css" type="text/css">
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<fieldset> 	
	<legend>&nbsp;Dados cadastrais da empresa</legend>
	<form name="dados" method="post"  onsubmit="return salvaempresa(this);">
	<input type="Hidden" name="acao" value="<?=$acao?>">
	<input type="Hidden" name="config" value="1">
		<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
			<tr>
				  <td width=200>&nbsp;<label for="cod_polo">Polo:</label></td>
				   <td align="left">
					   <?	$sql = "Select
								p.cod_polo
								,p.n_polo
							from polo p 
							where p.dat_canc is null";
							combo($sql, "cod_polo", @$_REQUEST['cod_polo'], "", "");
						?>
				  </td>
			</tr>
			<tr>
				<td>&nbsp;<label for="razao_social">Razão Social:</label></td>
				<td>
					<input type="text" id="razao_social" name="razao_social" maxlength="50" size="50" value="<?=@$_REQUEST['razao_social'];?>" validate="required" />
				</td>
			</tr>
			<tr>
				<td>&nbsp;<label for="nome_fantasia">Nome Fantasia:</label></td>
				<td>
					<input type="text" id="nome_fantasia" name="nome_fantasia" maxlength="50" size="50" value="<?=@$_REQUEST['nome_fantasia'];?>" validate="required" />
				</td>
			</tr>
				<tr>
				<td>&nbsp;<label for="cnpj_cpf">CNPJ:</label></td>
				<td>
				<div id="cpq" style="position:inline"><input type="text" id="cnpj_cpf" name="cnpj_cpf" size="22" maxlength="18" value="<?=@$_REQUEST['cnpj'];?>" onKeyPress="mascara(this,cnpj)" validate="datatype=cnpj_cpf" /> <input type="radio" name="cqpq" value="cnpj" onClick="cpfoucnpj(1)" checked>CNPJ</div>					
				</td>
			</tr>	
				<tr>
				<td>&nbsp;<label for="site">Site:</label></td>
				<td>
					<input type="text" id="site" name="site" size="40" maxlength="150" o value="<?=@$_REQUEST['site'];?>" />					
				</td>
			</tr>	
				<tr>
				<td>&nbsp;<label for="email">E-mail:</label></td>
				<td>
					<input type="text" id="email" name="email" size="40" maxlength="150" " value="<?=@$_REQUEST['email'];?>" />					
				</td>
			</tr>	
			<tr>
				<td>&nbsp;<label for="ddd">Telefone:</label></td>
				<td>
					(
					<input type="text" id="ddd" name="ddd" size="2" maxlength="2" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['ddd'];?>" validate="required;regexp=/^\d{2}$/" />
					)&nbsp;<input type="text" id="tel" name="tel" maxlength="9" size="10" onKeyPress="mascara(this,telefone1)" value="<?=@$_REQUEST['tel'];?>" validate="required;regexp=/^\d{4}-\d{4}$/" />					
				</td>
			</tr>
			<tr>
				<td>&nbsp;<label for="dddfax">Fax:</label></td>
				<td>
					(
					<input type="text" size="2" maxlength="2" id="dddfax" name="dddfax" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['ddd_fax'];?>" validate="regexp=/^\d{2}$/" />
					)&nbsp;<input type="text" id="fax" name="fax" maxlength="9" size="10" onKeyPress="mascara(this,telefone1)" value="<?=@$_REQUEST['fax'];?>" validate="regexp=/^\d{4}-\d{4}$/" />					
				</td>
			</tr>
			<tr>
			   	<td >&nbsp;<label for="cep">Cep:</label></td>
			   	<td align="left">
					<input name="cep" type="text" class="forms" id="cep" size="11" maxlength="9" onkeyup="if(this.value.length == 9) xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" onblur="xajax_buscaCep(this.value, 'endereco', 'bairro', 'cidade', 'uf');" value="<?=@$_REQUEST['cep'];?>" onKeyPress="mascara(this,cep1)"  validate="datatype=cep"/>
				</td>
			</tr>
			<tr>
			   	<td >&nbsp;<label for="endereco">Endereço:</label></td>
			   	<td align="left"><input type="text" id="endereco" name="endereco" size="80" maxlength="150" value="<?=@$_REQUEST['endereco'];?>" />						</td>
			</tr>
			<tr>
			   	<td >&nbsp;<label for="numero">Numero:</label></td>
			   	<td align="left"><input type="text" id="numero" name="numero" size="5" maxlength="5" onKeyPress="mascara(this,soNumeros)" value="<?=@$_REQUEST['numero'];?>" /></td>
			</tr>
			<tr>
			  	<td >&nbsp;<label for="complemento">Complemento:</label></td>
			   	<td align="left"><input type="text" id="complemento" name="complemento" size="100" value="<?=@$_REQUEST['complemento'];?>" /></td>
			</tr>
			<tr>
			  	<td >&nbsp;<label for="bairro">Bairro:</label></td>
			   	<td align="left"><input type="text" id="bairro" name="bairro" maxlength="20" size="22" value="<?=@$_REQUEST['bairro'];?>" /></td>
			</tr>
			<tr>
			  	<td >&nbsp;<label for="cidade">Cidade:</label></td>
			   	<td align="left"><input type="text" id="cidade" name="cidade" maxlength="20" size="22" value="<?=@$_REQUEST['cidade'];?>" /></td>
			</tr>
			<tr>
			  	<td >&nbsp;<label for="estado">Estado:</label></td>
			   	<td align="left">
			   		<?	$sql = "Select uf , nome from estados order by nome";
					combo($sql, "uf", @$_REQUEST['uf'], "Selecione um Estado", "");?>
			  	</td>
			</tr>
			<tr>
			  	<td >&nbsp;<label for="cod_tipo_empresa">Tipo Empresa</label></td>
			   	<td align="left">
				    <?	$sql = "Select 
							te.cod_tipo_empresa
							,te.dsc_tipo_empresa
						from tipo_empresa te
							where te.dat_canc is null";
						if(@$_REQUEST['cod_tipo_empresa']!=1){
						$sql .= " and te.cod_tipo_empresa not in (1)";
						}
						combo($sql, "cod_tipo_empresa", @$_REQUEST['cod_tipo_empresa'], "", "");?>
			  	</td>
			</tr>
            <tr>
                <td>
                    &nbsp;<label for="enviar_agenda_email_pk">Enviar email de agendamento ?</label>
                </td>
                <td>
                    <select name="enviar_agenda_email_pk" id="enviar_agenda_email_pk">
                        <option value="1" <?if($row['enviar_agenda_email_pk']==1){ echo "selected";}?>>Sim</option>
                        <option value="2" <?if($row['enviar_agenda_email_pk']==2){ echo "selected";}?>>Não</option>
                    </select>
                </td>    
            </tr>
            <tr>
                <td>
                    &nbsp;<label for="origem_email_agendamento_pk">Email de saida ser do Consultor ?</label>
                </td>
                <td>
                    <select name="origem_email_agendamento_pk" id="origem_email_agendamento_pk">
                        <option value="1" <?if($row['origem_email_agendamento_pk']==1){ echo "selected";}?>>Sim</option>
                        <option value="2" <?if($row['origem_email_agendamento_pk']==2){ echo "selected";}?>>Não</option>
                    </select>
                </td>    
            </tr>
            <tr>
				<td>&nbsp;<label for="agenda_email">Email de saida agendamento:</label></td>
				<td>
					<input type="text" id="agenda_email" name="agenda_email" maxlength="50" size="50" value="<?=$row['agenda_email'];?>" validate="required" />
				</td>
			</tr>
            <tr>
                <td>
                    &nbsp;<label for='enviar_proposta_email_pk'>Enviar proposta ?</label>
                </td>
                <td>
                    <select name='enviar_proposta_email_pk' id='enviar_proposta_email_pk'>
                        <option value="1" <?if($row['enviar_proposta_email_pk']==1){ echo "selcted";}?>>Sim</option>
                        <option value='2' <?if($row['enviar_proposta_email_pk']==2){ echo "selected";}?>>Não</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;<label for ='origem_email_proposta_pk'>Email de saida ser do Consultor  ?</label>
                </td>
                <td>
                    <select name='origem_email_proposta_pk' id='origem_email_proposta_pk'>
                        <option value='1' <?if($row['origem_email_proposta_pk']==1){ echo "selected";}?>>Sim</option>
                        <option value='2' <?if($row['origem_email_proposta_pk']==2){ echo "selected";}?>>Não</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    &nbsp;<label for='proposta_email'>Email de saida Proposta</label>
                </td>
                <td>
                    <input type='text' id='proposta_email' name='proposta_email' maxlength="50" size="50" value="<?=$row['proposta_email'];?>" validate='required'
                </td>
            </tr>
			<tr>
				<td colspan="2" align="right">
					<input type="Submit" value="Salvar" name="Salvar" />&nbsp;
				</td>
			</tr>								
		</table>
	</form>
</fieldset> 
<?

if(!empty($cod_empresa) && @$_REQUEST['cod_tipo_empresa']==1){
?>
<fieldset> 	
	<legend>&nbsp;Logo da Empresa</legend>	
	<form name="dados" method="post"  >
	<input type="Hidden" name="config" value="2">
	<input type="Hidden" name="nome_imagem" value="logo.png">
	<input type="Hidden" name="cod_empresa" value="<?=$cod_empresa?>">
	<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
		<tr>
			<td width=200>&nbsp;<label for="imagem">Imagem:</label></td>
			<td  align="left"><img src="../../images/logo/logo.png" width="200"/></td>
		</tr>		

		<tr>
			<td width=200>&nbsp;<label for="imagem">Tamanho da Imagem:</label></td>
			<td align="left">
				Largura&nbsp;<input type="text" name="largura" maxlength="4" value="<?=@$_REQUEST['largura']?>" size="4">
				&nbsp;Altura&nbsp;<input type="text" name="altura" maxlength="4" value="<?=@$_REQUEST['altura']?>" size="4">
			</td>
		</tr>	
		<tr>
			<td width=200>&nbsp;<label for="imagem">Controle de Imagem:</label></td>
			<td align="left">
				<input type="button" value="Enviar Imagem" onclick="enviarImagem();">
				<!--<input type="button" value="Trocar Imagem" onclick="selecionarImagem();">-->
			</td>
		</tr>	
		<tr>
			<th colspan="2" align="right">
				<input type="Submit" value="Salvar" name="Salvar" />&nbsp;
			</th>
		</tr>
	</table>
	</form>
</fieldset>
<?
}
if(!empty($cod_empresa)){
?>
<fieldset> 	
	<legend>&nbsp;Config Operador Empresa</legend>
	<form name="dados" method="post"  >
	<input type="Hidden" name="config" value="3">
	<input type="Hidden" name="cod_empresa" value="<?=$cod_empresa?>">

	<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
		<tr>
		     <td  width=200>&nbsp;<label for="operador">Operador:</label></td>
		      <td align="left">
		      	<?
					$sql = "Select 
								o.cod_operador
								,o.dsc_operador
							from operador o
							order by o.cod_operador";
					
					$result = sql_query($sql);
					while($row = mysql_fetch_array($result)){
						$sql = "Select
									ep.cod_operador
								from empresa_operador ep";
								
						$sql .= " where ep.cod_empresa=".$cod_empresa;
						$sql .= " and ep.cod_operador=".$row['cod_operador'];
						$sql .= " order by ep.cod_operador";						
						$result1 = sql_query($sql);
						$row1 = mysql_fetch_array($result1);	
						if(!empty($row1['cod_operador'])){
							$cod_empresa_operador = $row1['cod_operador']; 		
						}
						$check="";				
						if($row['cod_operador']== $row1['cod_operador']){ 
							$check="checked";
						};
						print $row['dsc_operador']."&nbsp;<input type=Checkbox value=".$row['cod_operador']." name='operador[".$row["cod_operador"]."]' ".$check." >&nbsp;&nbsp;";
					} 
				?>
		     </td>	
			 <tr>
			<th colspan="2" align="right">
				<input type="Submit" value="Salvar" name="Salvar" />&nbsp;
			</th>
		</tr>
	</table>
	</form>
</fieldset> 
<?}
if(!empty($cod_empresa_operador)){
?>
<fieldset> 	
	<legend>&nbsp;Config Datas Proposta Operador</legend>
	<table width="100%"   align="center" border="0" cellpadding="0" cellspacing="0" class="form">
		<form name="operador" method="post" onchnge=>
		<input type="Hidden" name="cod_empresa" value="<?=$cod_empresa?>">
		<tr>
		   <td  width=200>&nbsp;<label for="operador">Operador:</label></td>
		   <td  width=800 align="left">
		    	<?
				$sql = "Select 
							o.cod_operador
							,o.dsc_operador
						from operador o
						inner join empresa_operador eo on o.cod_operador = eo.cod_operador";								
				$sql .= " where eo.cod_empresa=".$cod_empresa;
				$sql .= " order by eo.cod_operador";						
				combo($sql, "cod_operador", $cod_operador, " ", " onchange=seleciona_operador(this.value)");
				?>
		   </td>	

		</tr>
		</form>

		<tr>
			<td colspan="3">
				<table width="100%"   border="1" cellpadding="0" cellspacing="0">
					<tr>
					 	<td align="center">
							Label da Data
						</td>
						 <td align="center">
							Campo da Data
						</td>
						<td align="center">
							Campo Obs
						</td>
						<td align="center">
							Tipo Ocorrencia
						</td>
						<td align="center">
							Ordem
						</td>
						<td align="center">						
							&nbsp;
						</td>
					</tr>	

					<?
						if(!empty($cod_operador)){
							$sql = "select  
								dpo.cod_data_proposta_operador
								,dpo.dsc_data
								,dpo.obs_data
								,dpo.ordem
								,dpo.nome_data
								,dpo.codtipoocorrencialead
								,dpo.dat_canc
							from data_proposta_operador dpo
							where dpo.cod_operador=".$cod_operador;
							$sql.=" order by dpo.ordem";
							$ordem = 1;
							$result = sql_query($sql);
								while($row = mysql_fetch_array($result)){
								$ordem = $ordem + 1;
								$disabled = "";
								if(!empty($row['dat_canc'])){
									$disabled="disabled";
								}
								?>
								<form name="dataproposta" method="post">							
								<input type="Hidden" name="Salvar" value="Salvar">
								<input type="Hidden" name="config" value="4">
								<input type="Hidden" name="cod_empresa" value="<?=$cod_empresa?>">
								<input type="Hidden" name="cod_operador" value="<?=$cod_operador?>">
								<input type="Hidden" name="cod_data_proposta_operador" value="<?=$row['cod_data_proposta_operador']?>">
								<input type="Hidden" name="desativar" >
								<tr>
							 	<td align="center">
										<input type="Text" name="dsc_data" size="30" maxlength="80" <?=$disabled?> value="<?=$row['dsc_data']?> ">
									</td>
									 <td align="center">
										<input type="Text" name="nome_data" size="30" maxlength="80" <?=$disabled?> value="<?=$row['nome_data']?>">
									</td>
									<td align="center">
										<? $checkd1="";
										   $checkd2="";
										if($row['obs_data']==0){
											$checkd1 = "checked";										
										  }else{ 
										  	$checkd2 = "checked";					
											
										  }
										 
										?>
										Sim&nbsp;<input type="radio" name="obs_data" <?=$disabled?> value="0" <?=$checkd1?>>&nbsp;Não&nbsp;<input type="radio" name="obs_data" <?=$disabled?> value="1" <?=$checkd2?>>
									</td>
									<td align="center">
										
										<?
											$sql = "select
												t.codtipoocorrencialead
												,case t.status when  '' then
													t.descricao
												else
													concat(t.descricao,' - ',scl.descricao) 
												end a
												,o.dsc_operador
												,scl.descricao
												from tipoocorrenciaslead t
												left join empresa_operador eo on t.cod_operador = eo.cod_operador
												left join operador o on eo.cod_operador = o. cod_operador
												left join statusclassificacaolead scl on t.status = scl.CodStatusClassificacaoLead";
												
												combo($sql, "codtipoocorrencialead", $row['codtipoocorrencialead'], "", $disabled);
										?>
									</td>
									<td align="center">
										<input type="text" size=3 name="ordem" maxlength="2" <?=$disabled?> value="<?=$row['ordem']?>"	>
									</td>
									<td align="center">

										<input type="image" name="btnsalvar" alt="Salvar" value="Salvar" src="../../images/salvar.png" width="20"  border="0" onClick="document.dados.submit()">   
										<?
											if(empty($disabled)){;
										?>
											<input type="image" name="btnsalvar" alt="Cancelar"  value="Cancelar" src="../../images/lixeira.png"  width="20"  border="0" onClick="cancela_data()"> 
										<?
											}
										?>
									<!--<input type="Submit" value="Edtar" name="Salvar" />&nbsp;<input type="Submit" value="Desatv" name="Salvar" />&nbsp;		-->
									</td>
								</tr>
								</form>
							<?}?>
							<form name="dados" method="post" onchnge=>
								<input type="Hidden" name="config" value="5">
								<input type="Hidden" name="cod_empresa" value="<?=$cod_empresa?>">
								<input type="Hidden" name="cod_operador" value="<?=$cod_operador?>">								
							<tr>
							 	<td align="center">
									<input type="Text" name="dsc_data" size="30" maxlength="80" value="<?=$row['dsc_data']?>">
								</td>
								 <td align="center">
									<input type="Text" name="nome_data" size="30" maxlength="80" value="<?=$row['nome_data']?>">
								</td>
								<td align="center">
									Sim&nbsp;<input type="radio" name="obs_data" value="0" checked>&nbsp;Não&nbsp;<input type="radio" name="obs_data" value="1">
								</td>
								<td align="center">
									
									<?
										$sql = "select
											t.codtipoocorrencialead
											,case t.status when  '' then
												t.descricao
											else
												concat(t.descricao,' - ',scl.descricao) 
											end a
											,o.dsc_operador
											,scl.descricao
											from tipoocorrenciaslead t
											left join empresa_operador eo on t.cod_operador = eo.cod_operador
											left join operador o on eo.cod_operador = o. cod_operador
											left join statusclassificacaolead scl on t.status = scl.CodStatusClassificacaoLead											
											where (t.cod_operador is null  or t.cod_operador in (select cod_operador from empresa_operador))";
											combo($sql, "codtipoocorrencialead", $row['codtipoocorrencialead'], " ", "");
										;
									?>
								</td>
								<td align="center">
									<input type="text" size=3 name="ordem" maxlength="3" value="<?=$ordem?>"	>
								</td>
								<td align="center">
									<input type="Submit" value="Incluir" name="Salvar" />&nbsp;		
								</td>
							</tr>
							</form>
					<?
						}
					?>
				</table>
			</td>
		</tr>			
	</table>
	</form>
</fieldset>
<?}?>

<div id="divImagem" style="display:none; position:absolute; top:320px; left: 300px; background-color:#f5f5f5">
</div>
<div id="recebe_up_basico">&nbsp;</div>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
