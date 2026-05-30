<?
include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.ocorrencias.php";

//VERIFICA SE EXITE DADOS DE EMAIL TIPO CARTA DE APRESENTACAO CADASTRADO
$sql = "Select
			ep.cod_email_empresa
			,tp.cod_tipoemail
			,ep.email_texto
			,ep.anexo
		from email_empresa ep
			inner join tipo_email tp on ep.cod_tipoemail = tp.cod_tipoemail
		where tp.n_tipoemail='Carta de Apresenta��o'
		and ep.status=1";

$result = sql_query($sql);
if($row = mysql_fetch_assoc($result)){
	$cod_email_empresa = $row['cod_email_empresa'];
	$cod_tipoemail = $row['cod_tipoemail'];
	$email_texto = $row['email_texto'];	
}

if(!empty($_REQUEST['fecharocorrencia'])){
	if(!empty($_REQUEST['codocorrencialead'])){
		$codocorrencia = $_REQUEST['codocorrencialead'];
		ocorrencias::alterar($codocorrencia, array('datafechamento' => 'SYSDATE()'));
	}else{
		javascriptalert('Dados insuficientes.');
	}
	javascriptalert('Opera��o executada com sucesso.');
}

if(!empty($_REQUEST['excluir'])){
	if(!empty($_REQUEST['codocorrencialead'])){
		$codocorrencia = $_REQUEST['codocorrencialead'];
		if(ocorrencias::excluir($codocorrencia) == 1){
			javascriptalert('Opera��o executada com sucesso.');
		}
		else{
			javascriptalert('N�o � poss�vel excluir a ocorr�ncia '.$codocorrencia.".");
		}
	}else{
		javascriptalert('Dados insuficientes.');
	}
	
}

if(!empty($_REQUEST['enviar'])){
	if(!empty($_REQUEST['datacadastro'])){
		if(!empty($_REQUEST['datacadastro'][0]) && !empty($_REQUEST['datacadastro'][1])){
			$_REQUEST['datacadastro'] = dataYMD($_REQUEST['datacadastro'][0]) . ' ' . $_REQUEST['datacadastro'][1];
		}else{
			$_REQUEST['datacadastro'] = null;
		}
	}
		
	//DATA RETORNO
	if(!empty($_REQUEST['dt_retorno'])){
		if(!empty($_REQUEST['dt_retorno'][0]) && !empty($_REQUEST['dt_retorno'][1])){
			$_REQUEST['dt_retorno'] = dataYMD($_REQUEST['dt_retorno'][0]) . ' ' . $_REQUEST['dt_retorno'][1];
		}else{
			$_REQUEST['dt_retorno'] = null;
		}
	}
	//DATA RETORNO
	if(!empty($_REQUEST['vencimentocontrato'])){
		if(!empty($_REQUEST['vencimentocontrato'])){
			$_REQUEST['vencimentocontrato'] = dataYMD($_REQUEST['vencimentocontrato']) ;
		}else{
			$_REQUEST['vencimentocontrato'] = null;
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
	javascriptalert('Opera��o executada com sucesso.');
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
	$sql = "SELECT o.*
					,t.Descricao TipoOcorrenciaLead
					,u.Nome UsuarioInterno 
					,ui1.nome as nome_agendadopara
			FROM ocorrenciaslead o 
			INNER JOIN tipoocorrenciaslead t ON o.CodTipoOcorrenciaLead = t.CodTipoOcorrenciaLead 
			INNER JOIN usuariosinternos u ON o.CodUsuarioInterno = u.CodUsuarioInterno 
			left join usuariosinternos ui1 on o.agendadopara = ui1.codusuariointerno
			WHERE o.CodOcorrenciaLead = " . mysqlnull($codocorrencialead);
	
$result = sql_query($sql);
	if($row = mysql_fetch_array($result)){
		$codocorrencialead = $row['CodOcorrenciaLead']; 
		$codlead = $row['CodLead'];
		$descricao = $row['Descricao'];
		$codtipoocorrencialead = $row['CodTipoOcorrenciaLead'];
		$tipoocorrencialead = $row['TipoOcorrenciaLead'];
		$datacadastro = $row['DataCadastro'];
		$datafechamento = $row['DataFechamento'];
		$codusuariointerno = $row['CodUsuarioInterno'];
		$usuariointerno = $row['UsuarioInterno'];
		$ocorrenciasuperior = $row['OcorrenciaSuperior'];
		$agendadopara = $row['agendadopara'];
		$dt_retorno = $row['dt_retorno'];
		$dsc_retorno = $row['dsc_retorno'];
		$dt_retorno_fechamento = $row['dt_retorno_fechamento'];
		$nome_agendadopara = $row['nome_agendadopara'];
		
        if(!empty($dt_retorno)){
            if(!empty($dt_retorno_fechamento)){
                $desabilita="";
            }else{
                $desabilita="disabled='disabled'";
            }  
		}
	
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


if(!empty($datafechamento)){
	if(!permissao('occamposespeciais', 'al')){
	javascriptalert('A ocorr�ncia ' . $codocorrencialead . ' esta fechada. Abra uma nova!!');
}
}

if(!(($acao == 'ins' && permissao('ocorrencias', 'ic')) || ($acao == 'upd' && permissao('ocorrencias', 'al')))){
	javascriptalert('Voc� n�o tem permiss�o para acessar esta p�gina!!!');
	exit;
}

//VERIFICA SE O USUARIO � O DE CADASTRO DA OCORRENCIA
if($_SESSION['codusuario']  == $agendadopara){

}else{
if($_SESSION['codusuario']  != $codusuariointerno){
	//VERIFICA SE O GRUPO TEM ACESSO A PERMISSAO DE EDICAO DE OUTRO USUARIO
	if(!permissao('ocorrenciaoutrousuario', 'al')){
			javascriptalert('Voc� n�o tem permiss�o para alterar ocorr�ncias de outro usu�rio!!!');
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
    <!--Cabe�alho-->
	<title>Ocorr�ncia Lead</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
<script type="text/javascript" language="javascript">
function excluirOcorrencia(){
	if(confirm('Excluir Ocorr�ncia ?'))
		return true
	return false
}
function verOcorrenciaSuperior(){
	window.location.replace('leadocorrencianew.php?codocorrencialead=<?=$ocorrenciasuperior;?>')
}
function desativar (){
	var d = document.forms.dados;
	<?if(!empty($dt_retorno)){?>
		document.getElementById('retorno').style.display = "inline";
	<?}?>
	if (d.elements.lembrete.checked==true){ 
		document.getElementById('retorno').style.display = "inline";
		d.elements.fecharagora.disabled=true;		
	}else{
		document.getElementById('retorno').style.display = "none";
		d.elements.fecharagora.disabled=false;
		//Limpa os campos de data do retorno, horario do retorno e agendado para.
 		document.forms[0].dt_retorno.value = "";
 		document.forms[0].horarioretorno.value = "";
	}
	if (d.elements.dt_retorno_fechamento.checked==true){
		d.elements.dsc_retorno.disabled=false;
		<?if($codtipoocorrencialead==5002){?>	
			d.elements.qtde_dias_retorno.disabled=false;
		<?}?>
	}else{
		d.elements.dsc_retorno.disabled=true;
		<?if($codtipoocorrencialead==5002){?>	
			d.elements.qtde_dias_retorno.disabled=true;
		<?}?>
	} 	
}
function desativar1 (){
	var d = document.forms.dados;
	if (d.elements.dt_retorno_fechamento.checked==true){
		d.elements.dsc_retorno.disabled=false;
		<?if($codtipoocorrencialead==5002){?>	
			d.elements.qtde_dias_retorno.disabled=false;
		<?}?>
		<?if($agendadopara == $codusuariointerno){?>
			d.elements.fecharagora.disabled=false;
			d.elements.descricao.disabled=false;
		<?}?>		
	}else{
		d.elements.dsc_retorno.disabled=true;
		<?if($codtipoocorrencialead==5002){?>	
			d.elements.qtde_dias_retorno.disabled=true;
		<?}?>
		d.elements.fecharagora.disabled=true;
		d.elements.descricao.disabled=true;
	} 
}
//ATIVA O EMAIL PARA O ENVIO DA CARTA DE APRESENTACAO
function ativacontato(){
	
	var d = document.forms.dados;
	if (d.elements.envia_carta.checked==true){ 
		d.elements.codcontatolead.disabled=false;
		d.elements.cod_email_empresa.disabled=false;
		
	}else{
		d.elements.codcontatolead.disabled=true;
		d.elements.cod_email_empresa.disabled=true;
	}
}

function exibe(id) {
	var d = document.forms.dados;

	if (id==5) {
		document.getElementById('seminteresse').style.display = "inline";
		d.elements.fecharagora.checked==true;
	}else{
		document.getElementById('seminteresse').style.display = "none";
		d.elements.fecharagora.checked==false;
	}
	//VERIFICA SE EXISTE OS DADOS DE CARTA DE APRESENTACAO PARA O ENVIO DO EMAIL
	<?//if(!empty($cod_email_empresa)){?>
		//ENVIO DE CARTA DE APRESENTACAO POR EMAIL
		if (id==6055) {			
			document.getElementById('enviacartaapresentacao').style.display = "inline";
			//d.elements.lembrete.disabled=true;
		}else{
			document.getElementById('enviacartaapresentacao').style.display = "none";
			//d.elements.lembrete.disabled=false;
		}
	<?//}?>
}
function valida(){
    
        
	var d = document.forms.dados;
	var combotipooc = document.getElementById("codtipoocorrencialead").value;

	/*if(document.getElementById("codtipoocorrencialead").value==""){			
		document.getElementById('codtipoocorrencialead').style.border = 'solid 3px red';
		document.getElementById('codtipoocorrencialead').focus();
		return false;
	}*/	
    
	if(d.descricao.value==""){
		document.getElementById('descricao').style.border = 'solid 3px red';
		d.descricao.focus();
		return false;
	}    
	//Quando tem retorno
	<?if(empty($dt_retorno)){?>
    
		if (d.lembrete.checked==true){ 
			if(d.dt_retorno.value==""){			
				document.getElementById('dt_retorno').style.border = 'solid 3px red';
				d.dt_retorno.focus();
				return false;
			}
			if(d.horarioretorno.value==""){			
				document.getElementById('horarioretorno').style.border = 'solid 3px red';
				d.horarioretorno.focus();
				return false;
			}	
			if(d.agendadopara.value==""){			
				document.getElementById('agendadopara').style.border = 'solid 3px red';
				d.agendadopara.focus();
				return false;
			}		
		}
		else{
			d.agendadopara.options[0].selected = true;
			d.horarioretorno.value = "";
			d.dt_retorno.value = "";
		}
	<?}?>
	//Fecha retorno
    
	<?if(!empty($dt_retorno)){?>
		if (d.dt_retorno_fechamento.checked==true){
			if(d.dsc_retorno.value==""){			
				document.getElementById('dsc_retorno').style.border = 'solid 3px red';
				d.dsc_retorno.focus();
				return false;
			}	
			<?if($codtipoocorrencialead==5002){?>	
				if(d.qtde_dias_retorno.value==""){			
					document.getElementById('qtde_dias_retorno').style.border = 'solid 3px red';
					d.qtde_dias_retorno.focus();
					return false;
				}		
			<?}?>			
			
		}
	<?}?>
	
	//valida se o motivo de sem interesse foi selecionado
	if(combotipooc== "5"){
	   <?if(empty($codtipoocorrencialead)){?>
    	if(d.codmotivolead.value==""){			
			document.getElementById('codmotivolead').style.border = 'solid 3px red';
			d.codmotivolead.focus();
			return false;
		}
        <?}?>	
        
	}
    
	//valida se o contato para o envio da carta foi seleconado
	if(combotipooc== "20"){
		if (d.envia_carta.checked==true){
			if(d.cod_email_empresa.value==""){			
				document.getElementById('cod_email_empresa').style.border = 'solid 3px red';
				d.cod_email_empresa.focus();
				return false;
			}
		}	
		if (d.envia_carta.checked==true){
			if(d.codcontatolead.value==""){			
				document.getElementById('codcontatolead').style.border = 'solid 3px red';
				d.codcontatolead.focus();
				return false;
			}
		}			

	}
    
}
</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="desativar();">
<form name="dados" method="post" action="leadocorrencianew.php" onsubmit="return valida()">
	<input type="hidden" name="codlead" value="<?=$codlead;?>" />
	<input type="hidden" name="codocorrencialead" value="<?=$codocorrencialead;?>" />
	<input type="hidden" name="codtipoocorrencialead" value="<?=$codtipoocorrencialead;?>" />
	<input type="hidden" name="cod_tipoemail" value="<?=$cod_tipoemail;?>" />
	<input type="hidden" name="anexo" value="<?=$anexo;?>" /> 	
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
		<tr>
			 <td  class="titulo"> 
				&nbsp;<?=($codocorrencialead==0?'Adicionar':'Editar');?> Ocorr�ncia
			</td>
		</tr>
	</table>		
	<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
		<tr>
          <td>
              &nbsp;
          </td>
	    </tr>
		<?	
			if(!empty($codocorrencialead)){
		?>
			<tr>
				<td>&nbsp;Codigo:</td>
				<td><?=$codocorrencialead;?></td>
			</tr>
		<?}?>
		<tr>
			<td>&nbsp;Lead:</td>
			<td><?=$razaosocial;?></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="datacadastro">Data cadastro:</label></td>
			<td>
				<?=(!empty($datacadastro)?date('d/m/Y \\s H:i:s', strtotime($datacadastro)):'');?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="datafechamento">Data fechamento:</label></td>
			<td>
				<?	
				if(empty($datafechamento)){
				?>
					&nbsp;<label for="fecharagora"><input type="checkbox" <?=$desabilita;?> name="fecharagora" id="fecharagora" value="1" />Fechar Ocorrencia</label>
				<?	
				}else{
				if($acao == 'ins' || permissao('occamposespeciais', 'al')){
				?>
					<input type="text" id="datafechamento" name="datafechamento[]" size="10" maxlength="10" value="<?=(!empty($datafechamento)?date('d/m/Y', strtotime($datafechamento)):'');?>" validate="datatype=date" />
					&nbsp;hs&nbsp;
					<input type="text" id="horariofechamento" name="datafechamento[]" size="8" maxlength="8" value="<?=(!empty($datafechamento)?date('H:i:s', strtotime($datafechamento)):'');?>" validate="datatype=time" />
				<?		
				}else{
				?>
					<?=(!empty($datafechamento)?date('d/m/Y \\s H:i:s', strtotime($datafechamento)):null);?>
				<?		}
					}
				?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;Tipo de Ocorrencia:</td>
				<td>
					<?
					if($acao == 'ins' || permissao('occamposespeciais', 'al')){
						$sql = "SELECT CodTipoOcorrenciaLead, t.Descricao FROM tipoocorrenciaslead t";
						$sql .= " where status_pk=1 and (t.cod_operador is null or t.cod_operador=0   or cod_operador in (Select cod_operador from empresa_operador) )";		
						if(!$Root){
							$sql .= " and Automatica = 0 or CodTipoOcorrenciaLead = " . mysqlnull($codtipoocorrencialead);
						}
						$sql .= " Order by t.Descricao";
					
                        combo($sql, "codtipoocorrencialead", $codtipoocorrencialead, "", "onchange='exibe(this.value)' ");
					}else{ 
					?>
						<?= $tipoocorrencialead;?>
					<?
					}
					?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;Descricao:</td>
			<td><textarea cols="40" rows="5" id="descricao" <?=$desabilita?> name="descricao" validate="required"><?=$descricao?></textarea></td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codusuariointerno">Usuario:</label></td>
			<td>
				<?	
				if(!permissao('occamposespeciais', 'al')){
				?>
					<?=$usuariointerno;?>
				<?	
				}else{
					$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($codusuariointerno) . " Order By ui.Nome";
					combo($sql, "codusuariointerno", $codusuariointerno, "", 'validate="required"');
				}?>
			</td>
		</tr>

		<?if(empty($dt_retorno)){?>		
			<tr>
				<td width="155">
					&nbsp;Agendar Retorno:
				</td>
				<td>
					<input type="Checkbox" name="lembrete" value="1" onclick="desativar(1);">
				</td>
			</tr>
		<?}?>
		<tr>
			<td colspan="2">
				<div id="retorno" style="display: none;">				
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td align="center" class="topo_grid" colspan="2" ">Retorno</td>
						</tr>
						<tr>
							<td colspan="2">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td width="155">
								&nbsp;Data e Hora Retorno:
							</td>
							<td>
								<?if(!empty($dt_retorno)){?>
									<?=(!empty($dt_retorno)?date('d/m/Y', strtotime($dt_retorno)):'');?>&nbsp;&#224;s&nbsp;
									<?=(!empty($dt_retorno)?date('H:i:s', strtotime($dt_retorno)):'');?>
								<?}else{?>
									<input type="text" id="dt_retorno" name="dt_retorno[]" size="12" maxlength="10"   onkeypress="mascara(this,datamask)" value="<?=(!empty($dt_retorno)?date('d/m/Y', strtotime($dt_retorno)):'');?>"  validate="datatype=date"/>
													&nbsp;&#224;s&nbsp;
									<input type="text" id="horarioretorno" name="dt_retorno[]" size="8"  onkeypress="return horamask2(this,event)" maxlength="8" value="<?=(!empty($dt_retorno)?date('H:i:s', strtotime($dt_retorno)):'');?>"  />
								<?}?>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp;Agendado para: 
							</td>
							<td>
								<?if(empty($agendadopara)){				
									
									
									
									$sql = "Select ui.CodUsuarioInterno,ui.Nome from usuariosinternos ui Where ui.Desativado <> 1 Or ui.CodUsuarioInterno = " . mysqlnull($agenda['AgendadoPara']) . " Order By ui.Nome";
									combo($sql, "agendadopara", $_SESSION['codusuario']," " , "");
								  }else{
								  	print $nome_agendadopara;
								  }
								?>
							</td>
						</tr>
						<?
						if(!empty($dt_retorno)){
						?>						
						<tr>
							<td>
								&nbsp;Fechar Retorno:
							</td>
							<td>
							
								<?if(empty($dt_retorno_fechamento)){
									if($agendadopara == $_SESSION['codusuario'] or (!empty($Admin)) or  (permissao('fecharetorno', 'al'))){?>
										<input type="Checkbox" name="dt_retorno_fechamento" value="1"  onclick="desativar1(1);">
									<?}?>									
								<?}else{
									print (!empty($dt_retorno_fechamento)?date('d/m/Y \�\s H:i:s', strtotime($dt_retorno_fechamento)):'');
								}?>								
							</td>
						</tr>
				
						<tr>
							<td>&nbsp;Descricao Retorno:</td>
							<td>
									<textarea cols="40" rows="5" id="dsc_retorno"  disabled="disabled"  name="dsc_retorno"><?=$dsc_retorno;?></textarea>
							</td>
						</tr>		
						<?if($codtipoocorrencialead==5002){?>
							<?
                            
                            if(!permissao('retornofollowup', 'ic')){
								
							?>
							<tr>
								<td>&nbsp;<label for="vencimentocontrato">Qtde dias proximo retorno:</label></td>
								<td>
									<input type="text" id="qtde_dias_retorno" disabled="disabled"  name="qtde_dias_retorno" size="5" maxlength="5">
								</td>
							</tr>	
						<?
							}
						}?>
						<?}?>
					</table>
				</div>
			</td>
		</tr>
          
		<!--SEM INTERESSE-->
		<tr>
			<td colspan="2">                
				<div id="seminteresse" style="display: none;">
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>		
							<td colspan="2">
								&nbsp;
							</td>			
						</tr>
						<tr>
							<td align="center" class="topo_grid" colspan="2" >Lead Sem Interesse</td>
						</tr>
						<tr>		
							<td colspan="2">
								&nbsp;
							</td>			
						</tr>	

						<tr>
							<td width="155">
								&nbsp;Motivo Sem Interesse
							</td>
							<td>
								<?	
                                                                    $sql = "Select m.* ";
                                                                    $sql .= " from motivoslead m ";
                                                                    $sql .= " Order By m.Descricao ";
                                                                    combo($sql, "codmotivolead", " ", " ", '');
								?>
							</td>
						</tr>
						<tr>
						<?
							$sql = "Select 
									l.codlead
									,DATE_FORMAT(l.VencimentoContrato, '%Y-%m-%d') as datavencimento
									,qtde_linhas
								  from leads l
								  where l.codlead=".$codlead;

								  
							    $rs = mysql_query($sql);
				                $row_rs = mysql_fetch_array($rs);
				                $dt_vencimento= $row_rs["datavencimento"];
								$qtde_linha= $row_rs["qtde_linhas"];
				                mysql_free_result($rs);
								
								if(!empty($dt_vencimento)){?>								
									<input type="hidden" name="vencimento_contrato" value="<?=$dt_vencimento;?>" />			
								<?}
						?>
							<td>&nbsp;<label for="vencimentocontrato">Vencimento do Contrato:</label></td>
							<td>
								<input type="text" id="vencimentocontrato" name="vencimentocontrato" onKeyPress="mascara(this,datamask)" maxlength="10" size="12" value="<?=(!empty($dt_vencimento)?date('d/m/Y', strtotime($dt_vencimento)):null);?>" validate="datatype=date" />
							</td>
						</tr>
						<tr>
							<td>&nbsp;<label for="vencimentocontrato">Qtde de Linhas:</label></td>
							<td>
								<input type="text" id="qtde_linhas" name="qtde_linhas" onKeyPress="mascara(this,soNumeros)" maxlength="10" size="12" value="<?=$qtde_linha;?>" />
							</td>
						</tr>	
						<tr>
							<td>&nbsp;<label for="vencimentocontrato">Operadoras contratadas:</label></td>
							<td>
								<? 
									
									$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
									$result = sql_query($sql);
									
									$i = 0;
									while($row = mysql_fetch_array($result))
									{
										(!empty($codlead)? (in_array($row['codigo'], $operadoras)? $checado='checked' : $checado='') : $checado='');
										echo "<div style='float:left; padding-right:10px;'>
											  <input type='checkbox' id='operadoras' name='operadoras[]' value='".$row["codigo"]."' ".$checado." />".$row["nome"]."
											  </div>";
										$i++;
									}
									echo "<input type='hidden' id='qtdop' name='qtdop' value='$i'>";
									mysql_free_result($result);	  
								?>
							</td>
						</tr>						
					</table>
				</div>

			</td>
		</tr>
           
		<!--Envio Carta Apresenta��o-->
		<tr>
			<td colspan="2">
				
				<div id="enviacartaapresentacao" style="display: none;">		
				
					<table width="100%" cellpadding="0" cellspacing="0">
						<tr>		
							<td colspan="2">
								&nbsp;
							</td>			
						</tr>
						<tr>
							<td align="center" class="topo_grid" colspan="2" ">Enviar Carta de Apresenta��o</td>
						</tr>
						<tr>		
							<td colspan="2">
								&nbsp;
							</td>			
						</tr>					
						<tr>
							<td width="155">
								&nbsp;Enviar Carta
							</td>
							<td>
								<input type="Checkbox" name="envia_carta" value="1"  onclick="ativacontato(1);">
							</td>
						</tr>
						<tr>
							<td width="155">
								&nbsp;Modelo
							</td>
							<td>
								<?
									$sql = "Select
										ep.cod_email_empresa
										,ep.identificacao
									from email_empresa ep
										inner join tipo_email tp on ep.cod_tipoemail = tp.cod_tipoemail
									where  ep.status=1
									order by ep.cod_email_empresa";
						
									combo($sql, "cod_email_empresa", "cod_email_empresa", " ", 'disabled="disabled"');		

								?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;<label for="contato">Endere�o de Email:</label></td>
							<td>
								<?
									$sql = "Select 
											ct.codcontatolead
											,concat(ct.nomecontato,' - ',ct.email)
											from contatoslead ct ";
									$sql .= " Where ct.codlead = ".$codlead;
									$sql .= " and ct.email is not null
											  and ct.email <>''";
 
									combo($sql, "codcontatolead", "codcontatolead", " ", 'disabled="disabled"');					
								?>
							 </td>
						</tr>											
					</table>
				</div>
			</td>
		</tr>
					
		<tr>
			<td colspan="2">
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="2" align="right">
				<input type="submit" name="enviar" value="Enviar" />
				<?	
				if((permissao('ocorrencias', 'ex') ) && !empty($codocorrencialead)){
				?>
				<input type="submit" name="excluir" value="Excluir" onclick="return excluirOcorrencia()" />
				<?	}?>
				<input type="button" name="fechar" value="Fechar" onclick="self.close()" />&nbsp;
			</td>
		</tr>
	</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
