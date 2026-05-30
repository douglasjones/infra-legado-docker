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
|DATA: 24/07/2008	     			    			|
\____________________G_E_P_R_O_S____________________/
*/

//____________________INCLUDES____________________/
    include_once "../../libs/maininclude.php";
	include_once "../../libs/combo.php";
	if(!permissao('proposta', 'cs')){
		javascriptalert('Você não tem permissão para acessar esta página!!!');
		exit;
	}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>

    <!--Cabeçalho-->
	<title>Pesquisar Proposta</title>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		var frm = document.forms[0]
		if(!validateForm(frm)) return false
		frm.submit()
		self.close()
		return true
	}
	</script>
 	<!--Include CSS-->
    <link rel="stylesheet" href="../../extras/public.css" type="text/css">
    <link rel="stylesheet" href="../../extras/datepicker.css" type="text/css">
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
  	    <form name="dados" method="get" action="propostares.php" target="pagina">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			&nbsp;Pesquisar Proposta
		</td>
	</tr>
</table>			
<table width="100%" height="100%"  align="center" border="0" cellpadding="0" cellspacing="0" class="form">
<tbody>
	   <tr>
           <td>&nbsp;
               
           </td>
      </tr>
	<tr>
		<td width="60%">&nbsp;<label for="razaosocial">Lead:</label></td>
		<td><input type="text" id="razaosocial" name="razaosocial" size="50" maxlength="60" /></td>
	</tr>
	<tr>
		<td>&nbsp;<label for="cpf_cnpj">CNPJ:</label></td>
		<td><input type="text" id="cpf_cnpj" name="cpf_cnpj" size="20" maxlength="20" validate="datatype=cnpj" /></td>
	</tr>
	<tr>
		<td>&nbsp;<label for="datacadastrode">Cadastro de:</label></td>
		<td>
			<input type="text" id="datacadastrode" name="datacadastrode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="datacadastroate">&nbsp;até&nbsp;</label>
			<input type="text" id="datacadastroate" name="datacadastroate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="canceladas">Canceladas:</label></td>
		<td><input type="checkbox" id="canceladas" name="canceladas" value="1" /></td>
	</tr>
	<tr>
		<td>&nbsp;<label for="dataenviode">Envio de:</label></td>
		<td>
			<input type="text" id="dataenviode" name="dataenviode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="dataenvioate">&nbsp;até&nbsp;</label>
			<input type="text" id="dataenvioate" name="dataenvioate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="dataprevisaode">Previsão de recebimento de:</label></td>
		<td>
			<input type="text" id="dataprevisaode" name="dataprevisaode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="dataprevisaoate">&nbsp;até&nbsp;</label>
			<input type="text" id="dataprevisaoate" name="dataprevisaoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="datarecebimentode">Recebimento de:</label></td>
		<td>
			<input type="text" id="datarecebimentode" name="datarecebimentode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="datarecebimentoate">&nbsp;até&nbsp;</label>
			<input type="text" id="datarecebimentoate" name="datarecebimentoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="dataenviofirmade">Envio reconhecimento de Firma de:</label></td>
		<td>
			<input type="text" id="dataenviofirmade" name="dataenviofirmade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="dataenviofirmaate">&nbsp;até&nbsp;</label>
			<input type="text" id="dataenviofirmaate" name="dataenviofirmaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="datarecebimentofirmade">Recebimento reconhecimento de Firma de:</label></td>
		<td>
			<input type="text" id="datarecebimentofirmade" name="datarecebimentofirmade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="datarecebimentofirmaate">&nbsp;até&nbsp;</label>
			<input type="text" id="datarecebimentofirmaate" name="datarecebimentofirmaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="dataenviocontratode">Envio de contrato de:</label></td>
		<td>
			<input type="text" id="dataenviocontratode" name="dataenviocontratode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="dataenviocontratoate">&nbsp;até&nbsp;</label>
			<input type="text" id="dataenviocontratoate" name="dataenviocontratoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="datarecebimentocontratode">Recebimento de contrato de:</label></td>
		<td>
			<input type="text" id="datarecebimentocontratode" name="datarecebimentocontratode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="datarecebimentocontratoate">&nbsp;até&nbsp;</label>
			<input type="text" id="datarecebimentocontratoate" name="datarecebimentocontratoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
		</td>
	</tr>
	<tr>
		<td>&nbsp;<label for="codproduto">Produto:</label></td>
		<td>
<?	$sql = "select CodProduto , Nome from produtos order by nome";

    /* Função combo - localizada na pagina: libs/combo.php */
    
	combo($sql, "codproduto", "", " ", "");?>
					</td>
				</tr>
			</tbody>
			<tfoot>
			<tr>
				<td>&nbsp;
					
				</td>
			</tr>
				<tr>
					<th colspan="2" align="right">
						<input type="button" class="botao"  value="Enviar" onclick="enviar()" />
						&nbsp;
						<input type="button" class="botao" value="Fechar" onclick="window.close()" />&nbsp;
					</th>
				</tr>
			</tfoot>
		</table>
	</form>
</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
