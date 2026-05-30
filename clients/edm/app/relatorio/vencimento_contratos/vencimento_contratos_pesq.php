<?

include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo_relatorios.php";
	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);

$acao = $_REQUEST['acao'];


if(!(($acao == 'cs' && permissao('vencimento_contratos_pesq.php', 'cs')) || ($acao == 'upd' && permissao('vencimento_contratos_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
	<link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css">
    <!--Cabeçalho-->
	<title>Oportunidades</title>
	<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		
		if(frm.vencimentocontratode.value == ""){
			
			alert('Data Vencimento Início é obrigatório');
			frm.vencimentocontratode.focus();
			return false;
		}
		
		if(frm.vencimentocontratoate.value == ""){
			alert('Data Vencimento Fim é obrigatório');
			frm.vencimentocontratoate.focus();
			return false;
		}	
		
		
		
		
		frm.submit()
		self.close()
		return true
	}
	function carregar(){
		var frm = document.forms[0];
		frm.mes.value = '<?= date("m")?>';
		frm.ano.value = '<?= date("Y")?>';
	}
	</script>

</head>

<!--HTML-->

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="carregar()">
<form name="dados" method="get" action="vencimento_contratos_res.php" target="pagina">
<table border="0" cellpadding="0" cellspacing="0" class="form" align="center" width="100%">
	<tr>
		<td class="titulo" bgcolor="#8080FF" colspan="2">
			Oportunidades
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;<label  for="cod_polo">Polo:</label>
		</td>
		<td>
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
		</td>
	</tr>
		<tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<? 
			combo::equipe(@$equipe);
		?>
		</td>
	</tr>
		<tr>
			<td>&nbsp;<label for="vencimentocontrato">Data Vencimento Contrato:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="vencimentocontrato">de&nbsp;</&nbsp;<label>
				<input type="text" id="vencimentocontratode" name="vencimentocontratode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="vencimentocontratoate" name="vencimentocontratoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>
	<tr>
		<td>
			&nbsp;<label>Operadora:</label>
		</td>
		<td>
			<select name="cod_operadora" id="cod_operadora">
			<option value="">--- Todos ---</option>
			<?
			$sql ="";
			$sql.="select o.cod_operadora, o.dsc_operadora ";
			$sql.="  from operadoras o ";
			$sql.=" order by 2 ";
			$result = mysql_query($sql);
			while($row = mysql_fetch_array($result)){
				echo "<option value='".$row['cod_operadora']."'>".$row['dsc_operadora']."</option>";
			}
			mysql_free_result($result);
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
		<td>
		<?	combo::consultor_equipe($_SESSION['codusuario'], $_SESSION['codusuario'], " "); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="atendente">Atendente:</label></td>
		<td>
		<?	combo::atendente_equipe($_SESSION['codusuario']);?>
		</td>
	</tr>	
	<tr>
		<th colspan="2">
			<input type="button" value="Enviar" onclick="enviar()" />
			&nbsp;
			<input type="button" value="Fechar" onclick="window.close()" />
		</th>
	</tr>
</table>
</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>

