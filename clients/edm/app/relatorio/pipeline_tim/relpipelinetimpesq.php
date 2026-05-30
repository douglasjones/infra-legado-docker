<?

include_once "../../libs/maininclude.php";
	include_once "../../libs/cla.combo_relatorios.php";
	$codusuario = $_SESSION['codusuario'];
	$result = mysql_query("Select Tk_Equipe from tb_equipesvendas where fk_lider = $codusuario");
	@$equipe = mysql_result($result,0);
	@mysql_free_result($result);

$acao = $_REQUEST['acao'];


if(!(($acao == 'cs' && permissao('rel_pipeline_tim', 'cs')) || ($acao == 'upd' && permissao('rel_pipeline_tim', 'al')))){
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
	<title>Pipeline TIM</title>
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
    <form name="dados" method="get" action="relpipelinetimres_new.php" target="pagina">
<table border="0" cellpadding="0" cellspacing="0" class="form" align="center" width="100%">
	<tr>
		<td class="titulo" bgcolor="#8080FF" colspan="2">
			Pipeline TIM
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
			combo::equipe(@$equipe);
		?>
		</td>
	</tr>
    
	<tr>
		<td valign="top">
			&nbsp;<label>Status:</label>
		</td>
		<td>
		<?
		$sql = "select codstatusclassificacaolead, descricao from statusclassificacaolead where codstatusclassificacaolead  order by 1 ";
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
		<td><label for="atendente">&nbsp;Mailing:</label></td>
		<td>
			<?combo::combo_mailing($mailing_pk);?>
		</td>
	</tr>
    <tr>
        <td>
            &nbsp;Produto:
        </td>
        <td>
            <?
             $sql = "";
             $sql.="SELECT o.cod_operador, o.dsc_operador
                        FROM operador o
                             INNER JOIN empresa_operador op ON o.cod_operador = op.cod_operador
                       WHERE op.dat_canc IS NULL";             
             combo($sql,"cod_operador", "", " ", "");
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
		<td>&nbsp;<label for="codgerenteconta">Tipo Linha:</label></td>
		<td>
		<?	$sql = "";
            $sql.= "Select
                        nptl.pk
                        ,nptl.dsc_tipo_linha
                    from n_produto_tipo_linha nptl
                    where nptl.pk not in (5,6)";
            		$results = mysql_query($sql);
        
		while($row = mysql_fetch_array($results)){

			echo "<input type='checkbox' name='tipo_linha_pk[]' id='tipo_linha_pk[]' value='".$row['pk']."'"; 
			
				
			echo " > "."".$row['dsc_tipo_linha']."<br>"; 
		}
		mysql_free_result($result);
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
		<td>&nbsp;<label for="vencimentocontrato">Data Ultima Ocorrência Consultor:</&nbsp;<label></td>
		<td>
			&nbsp;<label for="dt_ini_oc">de&nbsp;</&nbsp;<label>
			<input type="text" id="dt_ini_oc" name="dt_ini_oc" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
			&nbsp;<label for="dt_fim_oc">&nbsp;até&nbsp;</&nbsp;<label>
			<input type="text" id="dt_fim_oc" name="dt_fim_oc" size="12" maxlength="10" onkeypress="mascara(this,datamask)" validate="datatype=date" />
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

