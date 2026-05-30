<?
$excel = $_REQUEST['excel'];
if($excel == "S"){
	$arquivo = 'planilha.xls';
	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}
include_once( "../../libs/maininclude.php" ) ;
include_once( "../../libs/datas.php" ) ;
include_once( "../../libs/cla.equipes.php" ) ;


//PARAMTROS DE PESQUISA
$cod_polo = $_REQUEST['cod_polo'];
$codequipe = $_REQUEST['codequipe'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$codatendente = $_REQUEST['codatendente'];
$dt_ini = $_REQUEST['dt_ini'];
$dt_fim = $_REQUEST['dt_fim'];
$cod_operador = $_REQUEST['cod_operador'];
$npedido = $_REQUEST['numpvc'];

//$dtentreagade = $_REQUEST['dtentreagade'];
//$dtentreagaate = $_REQUEST['dtentreagaate'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <!--Include CSS-->
<?
if($excel != "S"){
?>
<link rel="stylesheet" href="../../extras/public.css" type="text/css">
<?	include_once "../../libs/head.php";?>
<script src="../../extras/tabela.js"></script>
<?
}
?>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>
<?
}
?>
<br>
<table cellspacing="0" cellpadding="0" align="left" border="0">	
<tr>
	<td class="form" align="center">
		<font size="+2">Relatório de Documentos</font>
	</td>
</tr>
</table>
<br>
<br>
<table width="50%" border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
    	<td class="parametros">
			Parâmetros 
		</td>
	</tr>
	<tr>
		<td class="parametros">
				Relatório gerado em 
				<?
				//Pega a data de geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>				
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_polo'])){
			$sql = "Select 
    				p.cod_polo
					,p.n_polo
					 from polo p";
			$sql .= " where p.cod_polo=".$_REQUEST['cod_polo'];
			$sql .= " Order By p.n_polo ";
			$q = mysql_query($sql);
			$polo = mysql_fetch_array($q);
			echo "Polo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>			
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codatendente)){
			$sql = "select nome from usuariosinternos where codusuariointerno= $codatendente ";
			$q = mysql_query($sql);
			echo "Atendente: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>	
	<tr>
		<td class="parametros">
		<?	
		if(!empty($codgerenteconta)){
			$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
			$q = mysql_query($sql);
			echo "Consultor: ";
			while($row = mysql_fetch_array($q)){
				echo $row['nome']." ";
			}
			mysql_free_result($q);
		}
		?>
		</td>
	</tr>							
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codequipe'])){
			$sql = "Select Vc_Nome from tb_equipesvendas where Tk_Equipe = ".$_REQUEST['codequipe'];
			$q = mysql_query($sql);
			$equipe = mysql_fetch_array($q);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['numpvc'])){
		
			echo "Número Pedido: ".$npedido;
		}
		?>
		</td>
	</tr>    
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['cod_operador'])){
			$sql = "Select dsc_operador from operador where cod_operador = ".$_REQUEST['cod_operador'];
			$q = mysql_query($sql);
			$operador = mysql_fetch_array($q);
			echo "Operadora: ".$operador['dsc_operador'];
		}
		?>
		</td>
	</tr>
	<?	
	if(!empty($dt_ini)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Cadastro Documento:&nbsp;<?=date('d/m/Y', strtotime(dataYMD($dt_ini)));?> até <?=date('d/m/Y', strtotime(dataYMD($dt_fim)));?></dt>
		</td>
	</tr>
	<?	
	}
	?>
	<?	
	if(!empty($ativacaode)){
	?>
	<tr>
		<td class="texto_label">
			<dt>Faixa de Datas de Ativação:&nbsp;<?=date('d/m/Y', strtotime(dataYMD($ativacaode)));?> até <?=date('d/m/Y', strtotime(dataYMD($ativacaoate)));?></dt>
		</td>
	</tr>
	<?	
	}
	?>    
</table>
<br />  
<table id="tbl" name="tbl" border=0 cellpadding="1" cellspacing="1" width="100%">
	<tr>
                <th align="center" class="titulo" bgcolor="#8080FF">
			Lead
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Documento
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Nome Original
		</th>		
		<th align="center" class="titulo" bgcolor="#8080FF">
			Data Cadastro
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Descrição
		</th>
		<th align="center" class="titulo" bgcolor="#8080FF">
			Usuário de Cadastro
		</th>		
		
	</tr>
	<?
	
	$i = 0;
	$total_arquivos=0;
	
	$sql =" select ds_nome_original, pk, ds_nome_documento, ds_documento, date_format(d.datacadastro, '%d/%m/%Y %H:%i:%s') dt_ins, ui.nome,l.razaosocial,l.codlead";
	$sql.="   from documentos d ";
	$sql.="		   inner join usuariosinternos ui on d.codusuariointerno = ui.codusuariointerno ";
        $sql.="		   inner join leads l on d.codlead = l.codlead ";
	$sql.=" where 1=1";
	
        if(!empty($cod_polo)){
            $sql.=" and l.cod_polo=".$cod_polo;
        }
        
        if(!empty($dt_ini))
		$sql.="  and ad.datacadastro >= '".DataYMD($dt_ini)." 00:00:00' ";
	
	if(!empty($dt_fim))
		$sql.="  and al.datahorario <= '".DataYMD($dt_fim)." 23:59:59' ";
	
        if(!empty($codgerenteconta)){
            $sql.=" and l.codgerenteconta=".$codgerenteconta;
        }
        
	$result = sql_query($sql);
	while ($row = mysql_fetch_array($result)){
		if($i == 0){
			$cor = "#DDDDFF";
			$i = 1;
		}
		else{
			$cor = "";
			$i = 0;
		}
			
		echo "<tr>";
                echo "<td class='form' align='center' bgcolor='$cor'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		echo "<td class='form' align='center' bgcolor='$cor'><a href='../../vendas/leads/".$row['ds_nome_documento']."'>".$row['ds_nome_documento']."</a></td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['ds_nome_original']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['dt_ins']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['ds_documento']."</td>";
		echo "<td class='form' align='center' bgcolor='$cor'>".$row['nome']."</td>";
		echo "</tr>";
		$total_arquivos++;
	}
	mysql_free_result($result);
	?>
	<tr>
		<th align="center" class="titulo" bgcolor="#8080FF" colspan="6">
			<?= $total_arquivos?> Arquivo(s)
		</th>
	</tr>
</table>

<br>

</form>

</body>
</html>
<?	include_once "../../libs/desconectar.php";?>
