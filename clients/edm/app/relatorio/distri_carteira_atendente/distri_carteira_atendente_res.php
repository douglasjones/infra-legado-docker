<?

$excel = $_REQUEST['excel'];

if($excel == "S"){
	$arquivo = 'planilha.xls';

	header ("Content-type: application/x-msexcel");
	header ("Cache-control: no-cache,max-age=0,must-revalidate");
	header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
	header ("Content-Description: PHP Generated Data" );
}

include_once "../../libs/maininclude.php";
include_once "../../libs/datas.php";
include_once "../../libs/cla.equipes.php";

$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$usuariocadastro = $_REQUEST['usuariocadastro'];
$dt_cadastro_lead_ini = $_REQUEST['dt_cadastro_lead_ini'];
$dt_cadastro_lead_fim = $_REQUEST['dt_cadastro_lead_fim'];
$mailing_pk = $_REQUEST['mailing_pk'];

?>
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
<!--HTML-->
<body leftmargin="10" topmargin="10" marginwidth="0" marginheight="0">
<?
if($excel != "S"){
?>
<a name="link_excel" id="link_excel" href="<?= $_SERVER['REQUEST_URI'];?>&excel=S" title="Exportar para XLS"><img border="0" src="../../images/Excel-icon.png"></a>
<br>
<br>
<?
}
?>
<table>
	<tr>
		<td class="form"><font size="4">Distribuição Carteira Atendente</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
				Relatório gerado em <?
							$sql = "select date_format(sysdate(), '%d/%m/%Y %H:%i:%s') data_geracao ";
							$rs_geracao = mysql_query($sql);
							$row_geracao = mysql_fetch_array($rs_geracao);
							echo $row_geracao['data_geracao'];
							mysql_free_result($rs_geracao);
						    ?>
		</td>
	</tr>	
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>
			<?
			if(!empty($dt_cadastro_lead_ini) || !empty($dt_cadastro_lead_fim)){
				echo "Data Cadastro Lead: ".$dt_cadastro_lead_ini." à ".$dt_cadastro_lead_fim;
			}

			if(!empty($usuariocadastro)){
			?>
			Usuário Cadastro Lead: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $usuariocadastro ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?><br>			
			<?
			if(!empty($codgerenteconta)){
			?>
			Consultor: <?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codgerenteconta ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?><br>
			<?if(!empty($codatendente)){?>
			Atendente:
			<?
				$sql = "select nome from usuariosinternos where codusuariointerno = $codatendente ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['nome'];
				mysql_free_result($result);
			}?>
			<br>
			<?
		
			if(!empty($mailing_pk)){
			$sql ="";
			$sql.="SELECT m.pk, m.dsc_mailing
						  FROM mailing m
						 WHERE m.dt_cancelamento IS NULL
						
					and pk=".$mailing_pk;
					
			$m = mysql_query($sql);
			$mailing = mysql_fetch_array($m);
			echo "Mailing: ".$mailing['dsc_mailing'];
		}
		?>

			<br>

		</td>
	</tr>
</table>
<?

?>
<table width="90%" border="1" cellpadding="0" cellspacing="0" class="sortable">
	<thead>
	<tr>
		<th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Atendente
		</th>
		<th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Consultor
		</th>		
		<th nowrap=true width=230 class="titulo" bgcolor="#8080FF">
			Qtde Leads
		</th>		

	</tr>
	</thead>
	<tbody>
		<?
		
		$sql ="";
		$sql.="select ui.nome atendente, ui1.nome gerenteconta, count(*) total ";
		$sql.="  from leads l  ";
		$sql.="	    left join usuariosinternos ui on l.codatendente = ui.codusuariointerno  ";
		$sql.="		left join usuariosinternos ui1 on l.codgerenteconta = ui1.codusuariointerno ";
		$sql.=" where 1=1 ";
		
		if(!empty($codatendente))
			$sql.=" and ui.codusuariointerno = $codatendente ";
			
		if(!empty($codgerenteconta))
			$sql.=" and ui1.codusuariointerno = $codgerenteconta ";
			
		if(!empty($mailing_pk))
			$sql.=" and l.mailing_pk = ".$mailing_pk;
			
		if(!empty($dt_cadastro_lead_ini))
			$sql.=" and l.datacadastro >= '".DataYMD($dt_cadastro_lead_ini)." 00:00:00' ";
			
		if(!empty($dt_cadastro_lead_fim))
			$sql.=" and l.datacadastro <= '".DataYMD($dt_cadastro_lead_fim)." 23:59:59' ";
		
		$sql.=" group by ui.nome, ui1.nome ";
		
		$result = mysql_query($sql);
		
		$total = 0;
		
		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td class='form'>".$row['atendente']."&nbsp;</td>";
			echo "<td class='form'>".$row['gerenteconta']."&nbsp;</td>";
			echo "<td class='form' align='center'>".$row['total']."</td>";
			echo "</tr>";
			
			$total += $row['total'];
			
		}
		mysql_free_result($result);
		
		?>
    </tbody>
    <tfoot>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan=2>
			&nbsp;
		</th>	
		<th class="titulo" bgcolor="#8080FF">
			<?= $total;?>
		</th>			
	</tr>
	</tfoot>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>



