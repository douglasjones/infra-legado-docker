<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
include_once "../../libs/cla.combo.php";

$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('relaoarelhovendidopesq', 'cs')) || ($acao == 'upd' && permissao('relaoarelhovendidopesq', 'al')))){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="../../extras/datepicker.css" />

    <!--Cabeçalho-->
    <title>Relatório de Aparelhos Vendidos</title>
    <!--Comandos Javascript-->

<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>

	<script type="text/javascript" language="javascript">
	function enviar(){
		
		var frm = document.forms[0]
		frm.submit()
		self.close()
		return true
	}

	function vai_para( id )
	{
		document.forms[0].action = id;
	}
	</script>
</head>

<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form name="dados" method="get" action="rel_aparelhos_venidos_res.php" id="formula" target="pagina">
<input type="hidden" name="dirrel" value="aparelhos">
<input type="hidden" name="pgrel" value="rel_aparelhos_vendidos_res.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Relatório de Agendamentos
		</td>
	</tr>
</table>		
<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
	<tr>
			<td>&nbsp;<label for="codaparelho">Aparelhos:</&nbsp;<label></td>
			<td>
			<?	
			
			$sql = "Select 
					  a.codaparelho
					  ,a.NomeAparelho
					from aparelhos a
					where status = 1
					order by codaparelho";
						
			combo($sql,"codaparelho", "", " ", "");
			?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</&nbsp;<label></td>
			<td>
			<?combo::consultor($GerenteContas, $NomeUsuario);?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;<label for="datacadastrode">Data de Ativação:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="dataativacaode">de&nbsp;</&nbsp;<label>
				<input type="text" id="dataativacaode" name="dataativacaode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dataativacaoate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dataativacaoate" name="dataativacaoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
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
<?	include_once "../../libs/desconectar.php";?>

