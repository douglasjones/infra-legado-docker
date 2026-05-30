<?
include_once "../../libs/maininclude.php";
include_once "../../libs/combo.php";
include_once "../../libs/cla.combo.php";
include_once "../../libs/cla.campanha.php";

$acao = $_REQUEST['acao'];
$cod_campanha = $_REQUEST['cod_campanha'];

if(!empty($cod_campanha)){
	
	//cria a classe com a campanha selecionada
	$campanha = new campanha($cod_campanha);
	
	//atribui os valores as variaveis da pagina
	$nome_campanha = $campanha->getnome_campanha();
	$dt_inicio_campanha = $campanha->getdt_inicio_campanha();
	$dt_fim_campanha = $campanha->getdt_fim_campanha();
	$descricao_campanha = $campanha->getdescricao_campanha();
	$cod_polo = $campanha->getcod_polo();
	$mailing = $campanha->getmailing();
	$codstatusclassificacaolead = $campanha->getcodstatusclassificacaolead();
	$codmotivo = $campanha->getcodmotivo();
	$dt_vencimento_contrato_de = $campanha->getdt_vencimento_contrato_de();
	$cod_operadora = $campanha->getcod_operadora();
	$codgerenteconta = $campanha->getcodgerenteconta();
	$dt_vencimento_contrato_ate = $campanha->getdt_vencimento_contrato_ate();
	
	if (!empty($dt_fim_campanha)){
		javascriptalert('Campanha Fechada. Por favor crie uma nova campanha.');
		exit(0);
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <!--Include CSS-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
<script type="text/javascript" src="campanha.js"></script>
<!--Cabeçalho-->
<title>Campanhas</title>
<?	include_once "../../libs/head.php";?>
 <!--Comandos Javascript-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="dados" method="post" action="campanha_cad_proc.php">
<input type="Hidden" name="acao">
<input type="Hidden" name="cod_campanha" value="<?= $cod_campanha;?>"> 
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Campanhas
		</td>
	</tr>
</table>        
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tr>
          <td>
		  	&nbsp;
		  </td>
    </tr>
	<tr>
		<td>
			&nbsp;<label for="n_campanha">Nome Campanha:</label>
		</td>
		<td>	
			<input type="text" id="nome_campanha" name="nome_campanha" size="60" maxlength="150" value="<?=$nome_campanha;?>" validate="required" />				  
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label for="dt_inicio">Data Início Campanha:</label>
		</td>
		<td>
			<input type="text" id="dt_inicio_campanha" name="dt_inicio_campanha" size="14" value="<?=$dt_inicio_campanha;?>" onKeyPress="mascara(this,datamask)" maxlength="10" validate="datatype=date" />
		</td>
	</tr>	
	<tr>
		<td>
			&nbsp;<label for="dt_fim">Data Fim Campanha:</label>
		</td>
		<td>
			<?= $dt_fim_campanha;?>
		</td>
	</tr>	
	<tr>
		<td>
			&nbsp;<label for="dsc">Descrição:</label>
		</td>
		<td>
			<textarea name="descricao_campanha" id="descricao_campanha" rows="5" cols="60"><?=$descricao_campanha;?></textarea>
		</td>
	</tr>	
	<tr>
		<Td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<b>Critério de Seleção da Campanha</b>
		</td>
	</tr>
	<tr>
		<Td colspan="2">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>		</td>
		<td>		
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="mailing">Mailing:</label></td>
		<td>			
			<?combo::combo_mailing($mailing_pk);?>	
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codstatusclassificacaolead">Classificação:</label></td>
		<td>
			<?php
				$sql = "select sl.CodStatusClassificacaoLead, sl.Descricao from statusclassificacaolead sl";
				combo($sql, "codstatusclassificacaolead", $codstatusclassificacaolead, " ", "");
			?>			
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="codstatusclassificacaolead">Motivo sem Interesse:</label></td>
		<td>
			<?php
				$sql = "Select codmotivo, descmotivo from motivos_sem_interesse ";
				combo($sql, "codmotivo", $codmotivo, " ", "");
			?>			
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="dt_vencimento">Vencimento do Contrato entre:</label></td>
		<td>
			<input type="text" id="dt_vencimento_contrato_de" name="dt_vencimento_contrato_de" value="<?= $dt_vencimento_contrato_de;?>" onKeyPress="mascara(this,datamask)" maxlength="10" size="14" value="" validate="datatype=date" />
			&nbsp;
			e
			&nbsp;
			<input type="text" id="dt_vencimento_contrato_ate" name="dt_vencimento_contrato_ate" value="<?= $dt_vencimento_contrato_ate;?>" onKeyPress="mascara(this,datamask)" maxlength="10" size="14" value="" validate="datatype=date" />
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="cod_operadora">Operadora:</label></td>
		<td>
			<?php
				$sql = "Select o.cod_operadora, o.dsc_operadora from operadoras o order by o.cod_operadora";
				combo($sql, "cod_operadora", $cod_operadora, " ", "");
			?>			
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
		<td>
			<?
			combo::consultor_all_cad($codgerenteconta);
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			&nbsp;
		</td>
	</tr>
</tbody>
<tfoot>
	<tr>
		<th colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<input type="Button" value="Criar Associação" onclick="criarAssociacao()">
						<input type="Button" value="Fechar Campanha" onclick="fecharCampanha()">
						<input type="Button" value="Simular Campanha" onclick="simularCampanha()">
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
				</tr>
				<tr>
					<td align="center">
						<input type="button" value="Salvar" onclick="enviar()" />&nbsp;
						<input type="button" value="Fechar" onClick="self.close();" />									
					</td>
				</tr>
			</table>
		</th>
	</tr>    
</tfoot>
</table>
</form>
</html>
<?	include_once "../../libs/desconectar.php"; ?>
