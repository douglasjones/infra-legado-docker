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
	include_once "../../libs/cla.propostas.php";

	if(!empty($_REQUEST['enviar'])){
		$codproposta = $_REQUEST['codproposta'];
		$versao = $_REQUEST['versao'];
		$codlead = $_REQUEST['codlead'];
		$codmotivo = $_REQUEST['codmotivo'];
		$descricao = $_REQUEST['descricao'];
		//Cancela as propostas
		propostas::alterar($codproposta, $versao, $codlead, array('datacancelamento' => 'SYSDATE()', 'codmotivo' => $codmotivo, 'cancelamento' => $descricao));

		
		javascriptalert('Operação executada com sucesso.');
	}
	include_once "../../libs/combo.php";
	
	$acao = "ins";
	
	$codproposta = null;
	$versao = null;
	$codlead = null;
	$razaosocial = null;

	$codmotivo = null;
	
	if(isset($_REQUEST['codlead']))
		$codlead = $_REQUEST['codlead'];
	
	//Pesquisa os dados do lead.
	$sql = "";
	$sql.="select RazaoSocial, NomeFantasia ";
	$sql.="  from leads ";
	$sql.=" where codlead = $codlead ";
	$result = sql_query($sql);
	if($row = mysql_fetch_array($result)){
		$razaosocial = $row['RazaoSocial'];
	}
	mysql_free_result($result);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <!--Cabeçalho-->
	<title>Cancelamento de Proposta</title>
	
	<!--Comandos Javascript-->
<?	include_once "../../libs/head.php";?>
	<script type="text/javascript" language="javascript">
function validaCampos(){
	if(!validateForm(document.forms[0])) return false;
	return true
}
	</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form name="dados" method="post" action="cancelarproposta.php" onsubmit="return validaCampos(this)">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
		<input type="hidden" id="codproposta" name="codproposta" value="<?=$_REQUEST['codproposta'];?>" />
		<input type="hidden" id="versao" name="versao" value="<?=$_REQUEST['versao'];?>" />
		<table border="0" cellpadding="0" cellspacing="0" class="form">
			<thead>
				<tr>
					<th colspan="3">Cancelamento de Proposta</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Lead:</td>
					<td><?=$razaosocial;?></td>
				</tr>
				<tr>
					<td><label for="codmotivo">Motivo:</label></td>
					<td>
<?	$sql = "";
	$sql.="Select m.* ";
	$sql.="	from motivoslead m";
	$sql.="	Order By m.Descricao";
	combo($sql,"codmotivo","", "", " validate='required'");?>
					</td>
				</tr>
				<tr>
					<td><label for="descricao">Descrição:</label></td>
					<td><textarea id="descricao" name="descricao" rows="5" cols="20"></textarea></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">
						<input type="submit" name="enviar" value="Enviar" />
						&nbsp; &nbsp;
						<input type="reset" name="limpar" value="Limpar" />
						&nbsp; &nbsp;
						<input type="button" name="fechar" value="Fechar" onclick="window.close()" />
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<? include_once "../../libs/desconectar.php";?>
