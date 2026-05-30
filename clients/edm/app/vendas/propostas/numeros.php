<?  
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";
if(!permissao('proposta', 'al')){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

	$codlead = $_REQUEST['codlead'];
	$codproposta = $_REQUEST['codproposta'];
	$versao = $_REQUEST['versao'];

	$acao = $_REQUEST['acao'];

	if($acao == 'save'){
		$numeros = $_REQUEST['numero'];
		$estornado = $_REQUEST['estornado'];
		$codaparelho = $_REQUEST['codaparelho'];
		$vlr_aparelho = $_REQUEST['vlr_aparelho'];
		
		mysql_query("delete from numeros_proposta where CodLead=$codlead and CodProposta=$codproposta and Versao=$versao");
		foreach($numeros as $id => $numero){
			$estornado = $_REQUEST['est'.$id];
			$vlr_aparelho = str_replace(",", ".", $_REQUEST['vlr'.$id]);
			$codaparelho = $_REQUEST['codaparelho'.$id];

			
			$fields = array(
			'CodLead' => $codlead,
			'CodProposta' => $codproposta,
			'Versao' => $versao,
			'Estornado' => $estornado,
			'Numero' => $numero,
			'codaparelho' => $codaparelho,
			'vlr_aparelho' => $vlr_aparelho);			
			$sql = sqlinsert('numeros_proposta', $fields);
			sql_query($sql);
		}
		?><script language="JavaScript" type="text/javascript">
			alert('Números salvos!');
			window.close();
		</script><? 
	}

	$numero = array();
	$codaparelho = array();
	$vlr_aparelho = array();
	$result = mysql_query("select * from numeros_proposta where CodLead=$codlead and CodProposta=$codproposta and Versao=$versao") or die(mysql_error());
	$i=0;
	while($row=mysql_fetch_array($result)){
		$numero[$i] = $row['Numero'];
		$estornado[$i] = $row['Estornado'];
		$codaparelho[$i] = $row['codaparelho'];
		$vlr_aparelho[$i] = $row['vlr_aparelho'];
		$i++;
	}
	@mysql_free_result($result);
	$totnum = $i;
	$sql = "select ID, Valor, Tipo,Calculado from modulosproposta where CodLead=$codlead and CodProposta=$codproposta and Versao=$versao and ID = 'qtdelinhas'";

	$result = mysql_query($sql) or die(mysql_error());
	if($row=mysql_fetch_array($result)){
		$qtdelinhas = ($row['Calculado']?$row['Calculado']:(!empty($row['Valor'])?' ' . number_format($row['Valor'], 0, ',', '.'):null));
	}else{
		$qtdelinhas=0;			
	}
	@mysql_free_result($result);	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<?	include_once "../../libs/head.php";?>
	<title>Leads</title>
    <!--Comandos Javascript-->
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
<script type="text/javascript" language="javascript" src="../../extras/datepicker.js"></script>
<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
<script type="text/javascript" src="../../extras/jquery-1.2.1.pack.js"></script>
<script>
	function Limpar(valor, validos) {
		// retira caracteres invalidos da string
		var result = "";
		var aux;
		for (var i=0; i < valor.length; i++) {
		aux = validos.indexOf(valor.substring(i, i+1));
		if (aux>=0) {
		result += aux;
		}	
	}
		return result;
	}
	function Formata(campo,tammax,teclapres,decimal) {

		var tecla = teclapres.keyCode;

		vr = Limpar(campo.value,"0123456789");
		tam = vr.length;
		dec=decimal
		
		if (tam < tammax && tecla != 8){ tam = vr.length + 1 ; }
		if (tecla == 8 )
		{ tam = tam - 1 ; }
		if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
		{
		if ( tam <= dec )
		{ campo.value = vr ; }
		if ( (tam > dec) && (tam <= 5) ){
		campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; }
		if ( (tam >= 6) && (tam <= 8) ){
		campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
		}
		if ( (tam >= 9) && (tam <= 11) ){
		campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
		if ( (tam >= 12) && (tam <= 14) ){
		campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; }
		if ( (tam >= 15) && (tam <= 17) ){
		campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;}
		} 
	}
</script>
	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
	<form id="dados" method="post" action="numeros.php">
		<input type="hidden" id="codlead" name="codlead" value="<?=$codlead;?>" />
		<input type="hidden" id="codproposta" name="codproposta" value="<?=$codproposta;?>" />
		<input type="hidden" id="versao" name="versao" value="<?=$versao;?>" />
		<input type="hidden" id="acao" name="acao" value="save" />
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Números
		</td>
	</tr>
</table>		
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
	<tbody>
   	<tr>
          <td>&nbsp;</td>
    </tr>
<?	for($i=0;$i<$qtdelinhas;$i++){?>
   	<tr>
          <td>&nbsp;Linha <?=($i+1);?>:</td>
          <td><input type="text" size="20" maxlength="14" name="numero[]" value="<?=$numero[$i];?>" onkeypress="mascara(this,telefone)"></td>
		  <td>&nbsp;Estornado&nbsp;<input type="checkbox" name="est<?=$i;?>" value="1" <?=($estornado[$i]?'checked':'');?>></td>
		  <td>Aparelhos&nbsp;
		  	<?
				$sql = "Select
							a.codaparelho
							,a.NomeAparelho
						from aparelhos a
						where a.Status=1";
				combo($sql,"codaparelho$i", $codaparelho[$i], " ", "");						
			?>
		  </td>
    		<td>&nbsp;R$&nbsp;<input type="text" id="vlr<?=$i;?>" name="vlr<?=$i;?>"  onKeydown="Formata(this,20,event,2)" value="<?=$vlr_aparelho[$i];?>" maxlength="12" size="8"   /></td>
	</tr>
<?	}?>
   	<tr>
          <td>&nbsp;</td>
    </tr>
	</tbody>
	<tfoot>
	<tr>
		<td align="right" colspan="3"><input type="submit" value="Salvar">&nbsp;<input type="reset" value="Limpar">&nbsp;</td>
	</tr>
	</tfoot>
</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>