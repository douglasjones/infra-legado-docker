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
	include_once "../../libs/cla.checklist.php";
	
	$acao		= 'edi';
	$codlead	= $_REQUEST['codlead'];
	
	if(!empty($_REQUEST['acao'])) {
		$acao 	= $_REQUEST['acao'];
	}

	if($acao=='edi') {
		$acao	= 'upd';

		$chklst = checklist::buscar($codlead);
	}
	elseif($acao=='upd') {
		checklist::editar($_REQUEST, $codlead);

		javascriptalert('Operação realizada com sucesso.', false);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">

    <!--Cabeçalho-->
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
    <!--Titulo-->
	<title>Checklist</title>
	
	<?	include_once "../../libs/head.php";?>
	
	<!--Código Javascript-->
	<script language="javascript" type="text/javascript">
	function enviaform() {
		document.getElementById('formCL').submit();
	}
	</script>
</head>
<body>
<form id="formCL" method="post" action="<?=$_SERVER['PHP_SELF'];?>">
<input id="acao" name="acao" type="hidden" value="<?=@$acao;?>" />
<input id="codlead" name="codlead" type="hidden" value="<?=@$codlead;?>" />
<table cellpadding="0" cellspacing="0" border="0" class="form" style="width: 100%;">
	<thead>
		<tr>
			<th colspan="4">CHECKLIST</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th colspan="4">RAMO DE ATIVIDADE</th>
		</tr>
		<tr>
			<td style=" width: 5%;">
			<input id="RA" name="RA" type="radio" value="Industria" <?=(@$chklst['RA']=='Industria'?'checked="checked"':null);?> />			</td>
			<td style=" width: 45%;">
			<label for="RA">Ind&uacute;stria</label>			</td>
			<td style=" width: 5%;">
			<input id="RA" name="RA" type="radio" value="PrestacaoServicos" <?=(@$chklst['RA']=='PrestacaoServicos'?'checked="checked"':null);?> />			</td>
			<td style=" width: 45%;">
			<label for="RA">Presta&ccedil;&atilde;o de Servi&ccedil;os</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="RA" name="RA" type="radio" value="Comercio" <?=(@$chklst['RA']=='Comercio'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="RA">Com&eacute;rcio</label>			</td>
			<td>
			<input id="RA" name="RA" type="radio" value="Outross" <?=(@$chklst['RA']=='Outross'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="Telefone">Outros:</label>
			<input id="RAOutros" name="RAOutros" type="text" value="<?=@$chklst['RAOutros'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">N&Uacute;MERO DE FUNCION&Aacute;RIOS</th>
		</tr>
		<tr>
			<td>
			<input id="NF" name="NF" type="radio" value="Ate25" <?=(@$chklst['NF']=='Ate25'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NF">At&eacute; 25</label>			</td>
			<td>
			<input id="NF" name="NF" type="radio" value="51a100" <?=(@$chklst['NF']=='51a100'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NF">51 a 100</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NF" name="NF" type="radio" value="26a50" <?=(@$chklst['NF']=='26a50'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NF">26 a 50</label>			</td>
			<td>
			<input id="NF" name="NF" type="radio" value="Acima100" <?=(@$chklst['NF']=='Acima100'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NF">Acima de 100</label>			</td>
		</tr>
		<tr>
			<td>			</td>
			<td>			</td>
			<td>
			<input id="NF" name="NF" type="radio" value="Quantoss" <?=(@$chklst['NF']=='Quantoss'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NF">Quantos?</label>
			<input id="NFQuantos" name="NFQuantos" type="text" value="<?=@$chklst['NFQuantos'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">A EMPRESA POSSUI FILIAIS?</th>
		</tr>
		<tr>
			<td>
			<input id="PF" name="PF" type="radio" value="0" <?=(@$chklst['PF']==0?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PF">N&atilde;o</label>			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<td>
			<input id="PF" name="PF" type="radio" value="1" <?=(@$chklst['PF']==1?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PF">Quantas?</label>
			<input id="PFQuantas" name="PFQuantas" type="text" value="<?=@$chklst['PFQuantas'];?>" />			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<th colspan="4">N&Uacute;MERO DE TRONCOS (LINHAS)</th>
		</tr>
		<tr>
			<th colspan="2">Anal&oacute;gico</th>
			<th colspan="2">Digital (E1)</th>
		</tr>
		<tr>
			<td>
			<input id="NTA" name="NTA" type="radio" value="Ate5" <?=(@$chklst['NTA']=='Ate5'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTA">At&eacute; 05</label>			</td>
			<td>
			<input id="NTD" name="NTD" type="radio" value="1" <?=(@$chklst['NTD']==1?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTD">01</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NTA" name="NTA" type="radio" value="6a10" <?=(@$chklst['NTA']=='6a10'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTA">6 a 10</label>			</td>
			<td>
			<input id="NTD" name="NTD" type="radio" value="2" <?=(@$chklst['NTD']==2?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTD">02</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NTA" name="NTA" type="radio" value="11a20" <?=(@$chklst['NTA']=='11a20'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTA">11 a 20</label>			</td>
			<td>
			<input id="NTD" name="NTD" type="radio" value="3" <?=(@$chklst['NTD']==3?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTD">03</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NTA" name="NTA" type="radio" value="Quantoss" <?=(@$chklst['NTA']=='Quantoss'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTA">Quantos?</label>
			<input id="NTAQuantos" name="NTAQuantos" type="text" value="<?=@$chklst['NTAQuantos'];?>" />			</td>
			<td>
			<input id="NTD" name="NTD" type="radio" value="Quantoss" <?=(@$chklst['NTD']=='Quantoss'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NTD">Quantos?</label>
			<input id="NTDQuantos" name="NTDQuantos" type="text" value="<?=@$chklst['NTDQuantos'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">N&Uacute;MERO DE RAMAIS INSTALADOS NO PABX</th>
		</tr>
		<tr>
			<th colspan="2">Anal&oacute;gicos</th>
			<th colspan="2">Digitais</th>
		</tr>
		<tr>
			<td>
			<input id="NRA" name="NRA" type="radio" value="Ate10" <?=(@$chklst['NRA']=='Ate10'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRA">At&eacute; 10</label>			</td>
			<td>
			<input id="NRD" name="NRD" type="radio" value="Ate5" <?=(@$chklst['NRD']=='Ate5'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRD">At&eacute; 05</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NRA" name="NRA" type="radio" value="11a20" <?=(@$chklst['NRA']=='11a20'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRA">11 a 20</label>			</td>
			<td>
			<input id="NRD" name="NRD" type="radio" value="6a10" <?=(@$chklst['NRD']=='6a10'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRD">6 a 10</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NRA" name="NRA" type="radio" value="21a30" <?=(@$chklst['NRA']=='21a30'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRA">21 a 30</label>			</td>
			<td>
			<input id="NRD" name="NRD" type="radio" value="11a20" <?=(@$chklst['NRD']=='11a20'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRD">11 a 20</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="NRA" name="NRA" type="radio" value="Quantoss" <?=(@$chklst['NRA']=='Quantoss'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRA">Quantos?</label>
			<input id="NRAQuantos" name="NRAQuantos" type="text" value="<?=@$chklst['NRAQuantos'];?>" />			</td>
			<td>
			<input id="NRD" name="NRD" type="radio" value="Quantoss" <?=(@$chklst['NRD']=='Quantoss'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="NRD">Quantos?</label>
			<input id="NRDQuantos" name="NRDQuantos" type="text" value="<?=@$chklst['NRDQuantos'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">DISPONIBILIDADE DE PORTAS DE TRONCO ANAL&Oacute;GICAS (FXS)</th>
		</tr>
		<tr>
			<td>
			<input id="DPA" name="DPA" type="radio" value="Nao" <?=(@$chklst['DPA']=='Nao'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="DPA">N&atilde;o</label>			</td>
			<td>
			<input id="DPA" name="DPA" type="radio" value="3" <?=(@$chklst['DPA']==3?'checked="checked"':null);?> />			</td>
			<td>
			<label for="DPA">03</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="DPA" name="DPA" type="radio" value="1" <?=(@$chklst['DPA']==1?'checked="checked"':null);?> />			</td>
			<td>
			<label for="DPA">01</label>			</td>
			<td>
			<input id="DPA" name="DPA" type="radio" value="Quantoss" <?=(@$chklst['DPA']=='Quantoss'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="DPA">Quantos?</label>
			<input id="DPAQuantos" name="DPAQuantos" type="text" value="<?=@$chklst['DPAQuantos'];?>" />			</td>
		</tr>
		<tr>
			<td>
			<input id="DPA" name="DPA" type="radio" value="2" <?=(@$chklst['DPA']==2?'checked="checked"':null);?> />			</td>
			<td>
			<label for="DPA">02</label>			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<th colspan="4">A EMPRESA POSSUI ACESSO A INTERNET ATRAV&Eacute;S DE</th>
		</tr>
		<tr>
			<td>
			<input id="AI" name="AI" type="radio" value="LinhaDiscada" <?=(@$chklst['AI']=='LinhaDiscada'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="AI">Linha Discada</label>			</td>
			<td>
			<input id="AI" name="AI" type="radio" value="CableModem" <?=(@$chklst['AI']=='CableModem'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="AI">Cable Modem</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="AI" name="AI" type="radio" value="ADSL" <?=(@$chklst['AI']=='ADSL'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="AI">ADSL</label>			</td>
			<td>
			<input id="AI" name="AI" type="radio" value="Outross" <?=(@$chklst['AI']=='Outross'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="AI">Outros:</label>
			<input id="AIOutros" name="AIOutros" type="text" value="<?=@$chklst['AIOutros'];?>" />			</td>
		</tr>
		<tr>
			<td>
			<input id="AI" name="AI" type="radio" value="IPDedicado" <?=(@$chklst['AI']=='IPDedicado'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="AI">IP Dedicado</label>			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<td>			</td>
			<td>
			<label for="AIBanda">Banda: </label>
			<input id="AIBanda" name="AIBanda" type="text" value="<?=@$chklst['AIBanda'];?>" /> Kb/s			</td>
			<td>			</td>
			<td>
			<label for="AICompRedeVoip">Compartilhado Rede e VoIP: </label>
			<input id="AICompRedeVoip" name="AICompRedeVoip" type="radio" value="1" <?=(@$chklst['AICompRedeVoip']==1?'checked="checked"':null);?> />
			<label for="AICompRedeVoip">Sim</label>
			&nbsp;&nbsp;
			<input id="AICompRedeVoip" name="AICompRedeVoip" type="radio" value="0" <?=(@$chklst['AICompRedeVoip']==0?'checked="checked"':null);?> />
			<label for="AICompRedeVoip">N&atilde;o</label>			</td>
		</tr>
		<tr>
			<th colspan="4">A EMPRESA POSSUI FIREWALL?</th>
		</tr>
		<tr>
			<td>
			<input id="PF" name="PFR" type="radio" value="1" <?=(@$chklst['PFR']==1?'checked="checked"':null);?>  />			</td>
			<td>
			<label for="PF">Sim</label>			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<td>
			<input id="PF" name="PFR" type="radio" value="0" <?=(@$chklst['PFR']==0?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PF">N&atilde;o</label>			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<th colspan="4">QUAL PABX A EMPRESA POSSUI?</th>
		</tr>
		<tr>
			<td>
			<input id="PABX" name="PABX" type="radio" value="Siemens" <?=(@$chklst['PABX']=='Siemens'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PABX">Siemens</label>			</td>
			<td>
			<input id="PABX" name="PABX" type="radio" value="Panasonic" <?=(@$chklst['PABX']=='Panasonic'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PABX">Panasonic</label>			</td>
		</tr>
		<tr>
			<td>
			<input id="PABX" name="PABX" type="radio" value="Alcatel" <?=(@$chklst['PABX']=='Alcatel'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PABX">Alcatel</label>			</td>
			<td>
			<input id="PABX" name="PABX" type="radio" value="Outross" <?=(@$chklst['PABX']=='Outross'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PABX">Outros:</label>
			<input id="PABXOutros" name="PABXOutros" type="text" value="<?=@$chklst['PABXOutros'];?>" />			</td>
		</tr>
		<tr>
			<td>
			<input id="PABX" name="PABX" type="radio" value="Intelbras" <?=(@$chklst['PABX']=='Intelbras'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PABX">Intelbras</label>			</td>
			<td>			</td>
			<td>			</td>
		</tr>
		<tr>
			<th colspan="4">OPERADORA DE TELEFONIA FIXA DA EMPRESA</th>
		</tr>
		<tr>
			<td>
			<input id="OF" name="OF" type="radio" value="Telefonica" <?=(@$chklst['OF']=='Telefonica'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="OF">Telefonica</label></td>
			<td>
			<input id="OF" name="OF" type="radio" value="GVT" <?=(@$chklst['OF']=='GVT'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="OF">GVT</label></td>
		</tr>
		<tr>
			<td>
			<input id="OF" name="OF" type="radio" value="Embratel" <?=(@$chklst['OF']=='Embratel'?'checked="checked"':null);?> /></td>
			<td>
			<label for="OF">Embratel</label>			</td>
			<td>
			<input id="OF" name="OF" type="radio" value="Outross" <?=(@$chklst['OF']=='Outross'?'checked="checked"':null);?> />			</td>
			<td>
			<label for="OF">Outros:</label>
			<input id="OFOutros" name="OFOutros" type="text" value="<?=@$chklst['OFOutros'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">GASTO M&Eacute;DIO MENSAL DA EMPRESA COM LIGA&Ccedil;&Otilde;ES LOCAIS FIXO/FIXO</th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<label for="GMMLLFF">Quanto?</label> R$<input id="GMMLLFF" name="GMMLLFF" type="text" value="<?=@$chklst['GMMLLFF'];?>" /></td>
			<td>&nbsp;</td>
			<td>
			</td>
		</tr>
		<tr>
			<th colspan="4">GASTO M&Eacute;DIO MENSAL DA EMPRESA COM LIGA&Ccedil;&Otilde;ES DDD</th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<label for="GMMLLDDD">Quanto?</label> R$<input id="GMMLLDDD" name="GMMLLDDD" type="text" value="<?=@$chklst['GMMLLDDD'];?>" /></td>
			<td>&nbsp;</td>
			<td>
			</td>
		</tr>
		<tr>
			<th colspan="4">GASTO M&Eacute;DIO MENSAL DA EMPRESA COM LIGA&Ccedil;&Otilde;ES DDI</th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<label for="GMMLLDDI">Quanto?</label> R$<input id="GMMLLDDI" name="GMMLLDDI" type="text" value="<?=@$chklst['GMMLLDDI'];?>" /></td>
			<td>&nbsp;</td>
			<td>
			</td>
		</tr>
		<tr>
			<th colspan="4">GASTO M&Eacute;DIO MENSAL DA EMPRESA COM LIGA&Ccedil;&Otilde;ES FIXO/CELULAR DDD</th>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
			<label for="GMMLLFC">Quanto?</label> R$<input id="GMMLLFC" name="GMMLLFC" type="text" value="<?=@$chklst['GMMLLFC'];?>" /></td>
			<td>&nbsp;</td>
			<td>
			</td>
		</tr>
		<tr>
			<th colspan="4">CUSTO DE LIGA&Ccedil;&Otilde;ES DDD</th>
		</tr>
		<tr>
			<td>
			<input id="CLDDDDentroEstado" name="CLDDDDentroEstado" type="text" size="1" value="<?=@$chklst['CLDDDDentroEstado'];?>" />			</td>
			<td>
			<label for="CLDDDDentroEstado">% Dentro do Estado</label>			</td>
			<td>			</td>
			<td>
			<label for="CLDDDDentroEstadoPM">Pre&ccedil;/Min: </label> 
			R$<input id="CLDDDDentroEstadoPM" name="CLDDDDentroEstadoPM" type="text" value="<?=@$chklst['CLDDDDentroEstadoPM'];?>" />			</td>
		</tr>
		<tr>
			<td>
			<input id="CLDDDForaEstado" name="CLDDDForaEstado" type="text" size="1" value="<?=@$chklst['CLDDDForaEstado'];?>" />			</td>
			<td>
			<label for="CLDDDForaEstado">% Fora do Estado</label>			</td>
			<td>			</td>
			<td>
			<label for="CLDDDForaEstadoPM">Pre&ccedil;/Min:</label> 
			R$<input id="CLDDDForaEstadoPM" name="CLDDDForaEstadoPM" type="text" value="<?=@$chklst['CLDDDForaEstadoPM'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">A EMPRESA UTILIZA ALGUM DOS SERVI&Ccedil;OS ABAIXO CITADOS?</th>
		</tr>
		<tr>
			<td>
			<input id="UASInterfaceCelular" name="UASInterfaceCelular" type="checkbox" value="1" <?=(@$chklst['UASInterfaceCelular']==1?'checked="checked"':null);?> />			</td>
			<td>
			<label for="UASInterfaceCelular">Interface Celular</label>			</td>
			<td>			</td>
			<td>
			<label for="UASInterfaceCelularOP">Operadora:</label> 
			<input id="UASInterfaceCelularOP" name="UASInterfaceCelularOP" type="text" value="<?=@$chklst['UASInterfaceCelularOP'];?>"  />			</td>
		</tr>
		<tr>
			<td>
			<input id="UASVoip" name="UASVoip" type="checkbox" value="1" <?=(@$chklst['UASVoip']==1?'checked="checked"':null);?> />			</td>
			<td>
			<label for="UASVoip">VoIP</label>			</td>
			<td>			</td>
			<td>
			<label for="UASVoipOP">Operadora:</label>
			<input id="UASVoipOP" name="UASVoipOP" type="text" value="<?=@$chklst['UASVoipOP'];?>" />			</td>
		</tr>
		<tr>
			<th colspan="4">POSSUI CONTRATO DE MANUTEN&Ccedil;&Atilde;O?</th>
		</tr>
		<tr>
			<td>
			<input id="PCM" name="PCM" type="radio" value="1" <?=(@$chklst['PCM']==1?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PCM">Sim</label>			</td>
			<td>			</td>
			<td>
			<label for="PCMEmpresa">Empresa:</label>
			<input id="PCMEmpresa" name="PCMEmpresa" type="text" value="<?=@$chklst['PCMEmpresa'];?>" />			</td>
		</tr>
		<tr>
			<td>
			<input id="PCM" name="PCM" type="radio" value="0" <?=(@$chklst['PCM']==0?'checked="checked"':null);?> />			</td>
			<td>
			<label for="PCM">N&atilde;o</label>			</td>
			<td>			</td>
			<td>
			<label for="PCMEstaSatisfeito">Est&aacute; Satisfeito?</label> 
			<input id="PCMEstaSatisfeito" name="PCMEstaSatisfeito" type="radio" value="1" <?=(@$chklst['PCMEstaSatisfeito']==1?'checked="checked"':null);?> />
			<label for="PCMEstaSatisfeito">Sim</label> 
			&nbsp;&nbsp;
			<input id="PCMEstaSatisfeito" name="PCMEstaSatisfeito" type="radio" value="0" <?=(@$chklst['PCMEstaSatisfeito']==0?'checked="checked"':null);?> />
			<label for="PCMEstaSatisfeito">N&atilde;o</label>			</td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align: center;">
			<input type="submit" value="Salvar" />
			<input type="button" value="Fechar" onClick="self.close();" />			</td>
		</tr>
	</tfoot>	
</table>
</form>
</body>
</html>
