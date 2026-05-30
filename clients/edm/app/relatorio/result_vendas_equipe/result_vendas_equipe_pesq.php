<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo_relatorios.php";
$codusuario = $_SESSION['codusuario'];
$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
@$equipe = mysql_result($result,0);
@mysql_free_result($result);

$acao = $_REQUEST['acao'];
/*
if(!(($acao == 'cs' && permissao('reltargetlead0pesq.php', 'cs')) || ($acao == 'upd' && permissao('reltargetlead0pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
*/
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Relatório Carteria Consultor</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="javascript">
	function enviar(){
    	var frm = document.forms[0]
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <form name="dados" method="get" action="result_vendas_equipe_res.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
    <tr>
		<th class="titulo">Resultado de Vendas Equipe</th>
	</tr>
</table>
<table border="0" cellpadding="3" cellspacing="3" class="form" width="100%">
	<tbody>
		<tr>
    		<td>
				<label  for="datacadastro">Polo:</label>
			</td>
			<td>
			<?//COMBO DE POLO
			combo::polo($_SESSION['cod_polo']);
			?>
			</td>
		</tr>
        <tr>
			<td><label for="codequipe">Equipe:</label></td>
			<td>
                <?combo::equipe(@$equipe);?>
			</td>
		</tr>
		<tr>
			<td><label for="codgerenteconta">Consultor:</label></td>
			<td>
			<?	combo::consultor_equipe($_SESSION['codusuario']); ?>
			</td>
		</tr>
		<tr>
			<td valign="top">Operadora:</td>
			<td>
				<?php 				
				$sql="select op.cod_operadora codigo, op.dsc_operadora nome from operadoras op";
				combo($sql,"cod_operadora", "", " ", "");	
				?>
			</td>
		</tr>
		<tr>
			<td><label for="mailing">Mailing:</label></td>
			<td>
			<?combo::combo_mailing($mailing_pk);?>
			</td>
		</tr>
        <tr>
			<td><label for="datarecebimentopedido">DT Período :</&nbsp;<label></td>
			<td>
				&nbsp;<label for="dt_periodo_de">de&nbsp;</&nbsp;<label>
				<input type="text" id="dt_periodo_de" name="dt_periodo_de" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dtrecebpedidoate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dt_periodo_ate" name="dt_periodo_ate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>	
        
	</tbody>
	<tfoot>
		<tr>
			<th colspan="2">
				<input type="button" value="Enviar" onclick="enviar()" />
				&nbsp;
				<input type="button" value="Fechar" onclick="window.close()" />
			</th>
		</tr>
	</tfoot>
</table>
</form>
</body>
</html>


<? include_once "../../libs/desconectar.php";?>



