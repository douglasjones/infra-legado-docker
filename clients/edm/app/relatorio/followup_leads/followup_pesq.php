<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];


if(!(($acao == 'cs' && permissao('relfollowupleadspesq.php', 'cs')) || ($acao == 'upd' && permissao('relfollowupleadspesq.php', 'al')))){
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
	<title>Follow-up Leads</title>
	<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
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
<form name="dados" method="get" action="followup_res.php" target="pagina">
<table border="0" cellpadding="0" cellspacing="1" class="form" align="center" width="100%">
	<tr>
		<td class="titulo" bgcolor="#8080FF" colspan="2">
			Follow-up Leads
		</td>
	</tr>
	<tr>
		<td colspan="2">
			&nbsp;
		</td>
	</tr>
    <tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<? 
			combo::equipe($codequipe);
		?>
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
		<td valign="top">
			&nbsp;<label>Status:</label>
		</td>
		<td>
		<?
		$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead order by 1 ";
		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result)){
			echo "<input type='checkbox' name='codstatusclassificacaolead[]' id='codstatusclassificacaolead[]' value='".$row['codstatusclassificacaolead']."'"; 
			//if($row['codstatusclassificacaolead'] > 2)
				echo "checked";
			echo " > "."".$row['descricao']."<br>"; 
		}
		mysql_free_result($result);
		?>
		</td>
	</tr>	
    <tr>
	<tr>
		<td>&nbsp;<label for="atendente">Tipo Pessoa:</label></td>
		<td>
			<select name="tipo_pessoa" id="tipo_pessoa">
				<option></option>
				<option value='PJ'>CNPJ</option>
				<option value='PF'>CPF</option>
			</select>
		</td>
	</tr>	
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
		<td>&nbsp;<label for="qtde_dias">Qtde Dias Ult. Ocorrência:</&nbsp;<label></td>
		<td>
			<input type="text" id="qtde_dias" name="qtde_dias" size="12" maxlength="10" onKeyPress="mascara(this,soNumeros)"/>
		</td>	
	</tr>
	<tr>
		<td>&nbsp;<label for="qtde_dias">Cidade:</&nbsp;<label></td>
		<td>
			<input type="text" id="cidade" name="cidade" size="40" />
		</td>	
	</tr>
     <tr>
		<td>
			&nbsp;Bairro: 
		</td>
		<td>
			<input type="Text" name="bairro" id="bairro">
		</td>
	</tr>
    <tr>
		<td><label for="atendente">&nbsp;Mailing:</label></td>
		<td>
			<?combo::combo_mailing($mailing_pk);?>
		</td>
	</tr>
	<tr>
		<td><label for="atendente">&nbsp;Campanha:</label></td>
		<td>
		<?	
			$sql = "select cod_campanha, nome_campanha from campanha order by nome_campanha";
			combo($sql,"cod_campanha", "", " ", "");	
		?>
		</td>
	</tr>    
	<tr>
		<td>
			&nbsp;<label>Operadora:</label>
		</td>
		<td>
			<select name="cod_operadora" id="cod_operadora">
			<option value=""></option>
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
		<td valign="top">&nbsp;Qtde Linha(s):</td>
		<td>
            De&nbsp;<input type="text" name="qtdeli_ini" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>&nbsp;Até&nbsp;<input type="text" name="qtdeli_fim" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/> 
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
		<td>
		<?	combo::consultor_equipe1($_SESSION['codusuario']); ?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="atendente">Atendente:</label></td>
		<td>
		<?	combo::atendente_equipe1($_SESSION['codusuario']);?>
		</td>
	</tr>	
	<tr>
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<?combo::equipe();?>
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

