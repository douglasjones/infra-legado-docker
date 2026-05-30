<?
include_once "../../libs/maininclude.php";
include_once "../../libs/cla.combo.php";
$acao = $_REQUEST['acao'];
if(!(($acao == 'cs' && permissao('propostas_perdidas_pesq.php', 'cs')) || ($acao == 'upd' && permissao('propostas_perdidas_pesq.php', 'al')))){
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
    <title>Relatório Geral</title>
<?	include_once "../../libs/head.php";?>
    <!--Comandos Javascript-->
	<script type="text/javascript" language="JavaScript" src="../../extras/mascaras.js"></script>
	<script type="text/javascript" language="javascript">
	function enviar(){
		this.value='Enviando...';
		var frm = document.forms[0]
		
		frm.submit()
    	self.close()
		return true
	}
	</script>
</head>
<!--HTML-->
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <form name="dados" method="get" action="diretoria_geral_res.php" target="pagina">
	<table width="100%" align="center"  height="5"  class="topo"  cellpadding="2" cellspacing="3">
		<tr>
			 <td  class="titulo"> 
				Relatório Geral
    		</td>
		</tr>
	</table>	
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="form">
	<!--<tr>
            <td width="45%">
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
		<td>&nbsp;<label for="codequipe">Equipe:</label></td>
		<td>
		<? 
			combo::equipe($codequipe);
		?>
		</td>
	</tr>-->
        <tr>
		<td valign="top">&nbsp;Qtde Linha(s):</td>
		<td>
            De&nbsp;<input type="text" name="qtdeli_ini" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/>&nbsp;Até&nbsp;<input type="text" name="qtdeli_fim" size="5" maxlength="=20" onKeyPress="mascara(this,soNumeros)"/> 
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
            <td>
                &nbsp;Classificação Claro:                       
            </td>
            <td>
                <?
                  $sql = "";
                  $sql.="SELECT nco.pk classificacao_claro_pk, nco.dsc_classificacao
                             FROM n_classificacao_operadora nco
                            WHERE nco.operadora_pk = 5";

                  combo($sql, "classificacao_claro_pk", @$_REQUEST['classificacao_claro_pk'], " ", "");
                ?>
            </td>
        </tr>    
        <tr>
		<td>&nbsp;<label for="codgerenteconta">Consultor:</label></td>
		<td>
		<?	combo::consultor_equipe($_SESSION['codusuario']); ?>
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
                <td colspan="2">
                    &nbsp;
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