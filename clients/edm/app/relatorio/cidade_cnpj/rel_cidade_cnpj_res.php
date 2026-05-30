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
<script>

function editarCliente(){
	NewWindow('../../vendas/leads/leadnew.php?codlead=<?=$codlead;?>', 700, 500)
}
</script>
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
		<font size="+2">Relatório Cidade x CNPJ</font>
	</td>
</tr>
</table>
<br>
<br>

<table border="0" cellpadding="0" cellspacing="0" class='form'>
	<tr>
		<td class="parametros">
			Parâmetros 
			<br><br>
			
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
			print  "Pólo: ".$polo['n_polo'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codequipe'])){
			$sql = "Select
					Vc_Nome
					from tb_equipesvendas
					where Tk_Equipe=".$_REQUEST['codequipe'];
			$result = mysql_query($sql);
			$equipe = mysql_fetch_array($result);
			echo "Equipe: ".$equipe['Vc_Nome'];
		}
		?>
		</td>
	</tr>		
	<tr>
		<td class="parametros">
		<?	
		if(!empty($_REQUEST['codgerenteconta'])){
			$sql = "Select
					nome
					from usuariosinternos
					where codusuariointerno=".$_REQUEST['codgerenteconta'];
			$result = mysql_query($sql);
			$consultor = mysql_fetch_array($result);
			echo "Consultor: ".$consultor['nome'];
		}
		?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
			<?
			if(!empty($_REQUEST['cidade'])){
				echo "Cidade: ".$_REQUEST['cidade'];
			}
			?>
		</td>
	</tr>
	<tr>
		<td class="parametros">
				<br>
				Relatório gerado em 
				<?
				//Pegade geração do relatório
				$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i') datageracao ";
				$rs_geracao = mysql_query($sql);
				$row_geracao = mysql_fetch_array($rs_geracao);
				echo $row_geracao['datageracao'];
				mysql_free_result($rs_geracao);
				?>				
		</td>
	</tr>	
</table>
<br>
<table width="100%" cellspacing="0" cellpadding="0" align="center" border="0" >	
<?

	$sql = "SELECT l.CodLead,       
				   l.CNPJ_CPF,
				   l.Cidade,
				   l.RazaoSocial	
			  FROM leads l";

	$sql.="	Where l.Cidade is not null ";		
	
	if(!empty($_REQUEST['cidade'])){			
		$sql .= " and l.cidade like '%".$_REQUEST['cidade']."%'";
	}
								
	$sql.="	GROUP BY l.cidade";	

	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){						  			
		echo "<tr>";
		echo 	"<td>";
		echo 		"<b><font face='Arial' >&nbsp;".$row['Cidade']."<font></b>";
		echo 	"</td>";
		echo "</tr>";	
		
		echo "<tr>";
		echo 	"<td>";
		echo 		"<table width='90%' cellspacing='0' cellpadding='0' align='left' border='1' >";
		echo 			"<tr>";
		echo 				"<td width='60%' class=titulo bgcolor=#8080FF align=center >Razão Social</td>";
		echo 				"<td class=titulo bgcolor=#8080FF align=center >CNPJ</td>";
		echo 			"</tr>";
		
		$sql = "";
		$sql .= "Select
				   l.codlead	 
				  ,l.razaosocial
				  ,l.cnpj_cpf
				 from leads l
				 where l.cidade='".$row['Cidade']."' and l.cnpj_cpf is not null order by l.razaosocial ";
		
		$total = 0;
		$result1 = mysql_query($sql);
		while($row1 = mysql_fetch_array($result1)){
			echo 		"<tr>";
			echo 			"<td width='60%' align=center >";
			?>			
				<a href="#" onClick="javascript: NewWindow('../../vendas/leads/leadgerenciamentores.php?codlead=<?=$row1['codlead']; ?>', 800, 600);"><font class="Editar Leads" size="2"><?=$row1['razaosocial'];?></font></a>
			<?
			echo "</td>";
			echo 			"<td  align=center >".$row1['cnpj_cpf']."&nbsp;</td>";			 			
			echo 		"</tr>";	
			$total ++;
		}		
		echo 		"</table>";
		echo 	"</td>";
		echo "</tr>";		
		
				
		

		
		echo "<tr>";
		echo "<th colspan=2>Total de Registros: $total </th>";
		echo "</tr>";
    }  
?> 
</table>
