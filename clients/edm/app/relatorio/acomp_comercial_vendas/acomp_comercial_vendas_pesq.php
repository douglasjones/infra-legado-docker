<?

include_once "../../libs/maininclude.php";
include_once "../../libs/cla.extras.php";
	include_once "../../libs/cla.combo_relatorios.php";
	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);

$acao = $_REQUEST['acao'];

if(!(($acao == 'cs' && permissao('acomp_comercial_vendas', 'cs')) || ($acao == 'upd' && permissao('acomp_comercial_vendas', 'al')))){
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
    <title>Relatório Acompanhamento 80% 90% e Cliente</title>
<?	include_once "../../libs/head.php";?>

    <!--Comandos Javascript-->
    <script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
        function enviar(){
            
    		this.value='Enviando...';
    		var frm = document.forms[0]
    		if(!validateForm(frm)) return false
    		dtrecebpedidode = document.getElementById('dtrecebpedidode')
    		dtrecebpedidoate = document.getElementById('dtrecebpedidoate')
    		dtativacaode = document.getElementById('dtativacaode')
    		dtativacaoate = document.getElementById('dtativacaoate')
            dtentreagade = document.getElementById('dtentreagade')
    		dtentreagaate = document.getElementById('dtentreagaate') 
                      
    		if(dtrecebpedidode.value != '' && dtrecebpedidoate.value == ''){
    			alert('Valor deve ser especificado!')
    			dtrecebpedidoate.style.borderColor = 'red'
    			dtrecebpedidoate.style.borderWidth = '3px'
    			dtrecebpedidoate.focus()
    			return false
    		}
            
    		if(dtrecebpedidoate.value != '' && dtrecebpedidode.value == ''){
    			alert('Valor deve ser especificado!')
        		dtrecebpedidode.style.borderColor = 'red'
    			dtrecebpedidode.style.borderWidth = '3px'
    			dtrecebpedidode.focus()
    			return false
    		}
    		if(dtativacaode.value != '' && dtativacaoate.value == ''){
    			alert('Valor deve ser especificado!')
    			dtativacaoate.style.borderColor = 'red'
    			dtativacaoate.style.borderWidth = '3px'
    			dtativacaoate.focus()
    			return false
    		}
    		if(dtativacaoate.value != '' && dtativacaode.value == ''){
    			alert('Valor deve ser especificado!')
    			dtativacaoate.style.borderColor = 'red'
    			dtativacaoate.style.borderWidth = '3px'
    			dtativacaoate.focus()
    			return false
    		}
            
    		/*if(dtentreagade.value != '' && dtentreagaate.value == ''){
    			alert('Valor deve ser especificado!')
    			dtentreagaate.style.borderColor = 'red'
    			dtentreagaate.style.borderWidth = '3px'
    			dtentreagaate.focus()
    			return false
    		}           
    		if(dtentreagaate.value != '' && dtentreagade.value == ''){
    			alert('Valor deve ser especificado!')
    			dtentreagade.style.borderColor = 'red'
    			dtentreagade.style.borderWidth = '3px'
    			dtentreagade.focus()
    			return false
    		} */   
               
    		frm.submit()
        	self.close()
    		return true
    	}
    </script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <form name="dados" method="get" action="acomp_comercial_vendas_res.php" id="formula" target="pagina">
<input type="hidden" name="dirrel" value="agendamento">
<input type="hidden" name="pgrel" value="relagendamentores.php">
<table width="100%" align="center"  height="5"  class="topo"  cellpadding="0" cellspacing="0">
	<tr>
		 <td  class="titulo"> 
			Vendas
		</td>
	</tr>
</table>		
<table border="0" width="100%" cellpadding="1" cellspacing="0" class="form">
	<tbody>
        <tr>
            <td colspan="2">
                &nbsp;
            </td>
        </tr>
		<tr>
			<td>
				&nbsp;<label  for="datacadastro">Polo:</label>
			</td>
			<td>
			<?//COMBO DE POLO
				$polo = $_SESSION['cod_polo'];
				combo::polo($polo,'');
			?>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;<label  for="Operador">Operadora:</label>
			</td>
			<td>
			<?
                $sql = "SELECT 
                          op.cod_operador
                          , op.dsc_operador
                        FROM operador op
                        inner join empresa_operador eo on op.cod_operador = eo.cod_operador
                        Order by op.dsc_operador";
                        combo($sql,"cod_operador","","","");
			?>
			</td>
		</tr>        
		<tr>
			<td>&nbsp;<label for="codgerenteconta">Consultor:</&nbsp;<label></td>

		<td>
			<?combo::consultor_equipe($_SESSION['codusuario']);?>
			</td>
		</tr>
		<!--<tr>
			<td>&nbsp;<label for="grupousuariointerno">Atendente:</&nbsp;<label></td>
			<td>
			 <?combo::atendente_equipe($_SESSION['codusuario']);?>
			</td>
		</tr> --> 
		<tr>
			<td>&nbsp;<label for="codequipe">Equipe:</label></td>
			<td>
                <?combo::equipe(@$equipe);?>
			</td>
		</tr>   
		<tr>
			<td>&nbsp;<label for="npedidooperadora">N Pedido:</label></td>
			<td>
			     <input type="text" id="numpvc" name="numpvc" size="25"  maxlength="25" />
			</td>
		</tr>                   
		<tr>
			<td>&nbsp;<label for="datarecebimentopedido">DT Recebimento do Pedido:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="dtrecebimentode">de&nbsp;</&nbsp;<label>
				<input type="text" id="dtrecebpedidode" name="dtrecebpedidode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dtrecebpedidoate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dtrecebpedidoate" name="dtrecebpedidoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>	
		<tr>
			<td>&nbsp;<label for="dataativacao">DT Ativaçãoo do Pedido:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="dtativacaode">de&nbsp;</&nbsp;<label>
				<input type="text" id="dtativacaode" name="dtativacaode" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="dtativacaoate">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dtativacaoate" name="dtativacaoate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr>
		<!--<tr>
			<td>&nbsp;<label for="dataentrega">DT Entrega:</&nbsp;<label></td>
			<td>
				&nbsp;<label for="dtentreagade">de&nbsp;</&nbsp;<label>
				<input type="text" id="dtentreagade" name="dtentreagade" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
				&nbsp;<label for="entregafim">&nbsp;até&nbsp;</&nbsp;<label>
				<input type="text" id="dtentreagaate" name="dtentreagaate" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			</td>
		</tr> -->       			
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



