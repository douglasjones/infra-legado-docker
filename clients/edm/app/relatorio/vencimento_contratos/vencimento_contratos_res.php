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

$cod_polo = $_REQUEST['cod_polo'];
$codatendente = $_REQUEST['codatendente'];
$codgerenteconta = $_REQUEST['codgerenteconta'];
$cod_operadora = $_REQUEST['cod_operadora'];
$vencimentocontratode = $_REQUEST['vencimentocontratode'];
$vencimentocontratoate = $_REQUEST['vencimentocontratoate'];
$codequipe = $_REQUEST['codequipe'];

$acao = 'cs';
if(!(($acao == 'cs' && permissao('vencimento_contratos_pesq.php', 'cs')) || ($acao == 'upd' && permissao('vencimento_contratos_pesq.php', 'al')))){
	javascriptalert('Você não tem permissão para acessar esta página!!!');
	exit;
}

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

<?
}
?>
<table align="center">
	<tr>
		<td class="form"><font size="4">Oportunidades</font></td>
	</tr>
</table>
<table>
	<tr>
		<td class="form">
			<b>Parâmetros:</b><br><br>

			<?if (!empty($cod_polo)){?>
			Pólo <?= $polo;?><br>

			<?}?>
			<?
				if(!empty($codequipe)){
				$sql = "select t.tk_equipe cod_equipe, t.vc_nome nome_equipe from tb_equipesvendas t where tk_equipe = $codequipe ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				?>
					Equipe: <?= $row['nome_equipe'];?><br>	
				<?
				mysql_free_result($result);
			}	
			?>
			
			Data Vencimento Contrato: <?= $vencimentocontratode; ?> à <?= $vencimentocontratoate;?><br>
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

			<?if (!empty($cod_operadora)){?>
			Operadora:
			<?
				$sql = "select dsc_operadora from operadoras where cod_operadora = $cod_operadora ";
				$result = mysql_query($sql);
				$row = mysql_fetch_array($result);
				echo $row['dsc_operadora'];
				mysql_free_result($result);
			}
			?>

			<br>

		</td>
	</tr>
</table>

<table width="100%" border="1" cellpadding="0" cellspacing="0" class="sortable">
	<tr>
		<th class="titulo" bgcolor="#8080FF">
			Pólo
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Consultor
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Atendente
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Equipe
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Cód. Cliente
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Razão Social
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Data Vencimento
		</th>
		<th class="titulo" bgcolor="#8080FF">
			Qtde Linhas
		</th>		
		<th class="titulo" bgcolor="#8080FF">
			Operadora
		</th>
	</tr>
<?
	$total = 0;
	$sql ="";
	$sql.="select 
				p.n_polo,
				 l.codlead,
				 l.razaosocial,
				 date_format(l.vencimentocontrato,'%d/%m/%Y') vencimentocontrato,
				 p.n_polo,
				 ui.nome atendente,
				 ui1.nome consultor, 
				 ifnull(l.qtde_linhas,0) qtde_linhas,
				 tbe.Vc_Nome";
				
				 
				 
	$sql.="  from leads l ";
	$sql.="       left join polo p on l.cod_polo = p.cod_polo ";
	$sql.="       left join usuariosinternos ui on l.codatendente = ui.codusuariointerno ";
	$sql.="	      left join usuariosinternos ui1 on l.codgerenteconta = ui1.codusuariointerno ";
	$sql.=" 	  left join tb_usuarioequipe tbu on l.codgerenteconta = tbu.Fk_Usuario ";
	$sql.="       left join tb_equipesvendas tbe on tbu.Fk_Equipe = tbe.Tk_Equipe";
		
	
	
	$sql.=" where vencimentocontrato between '".DataYMD($vencimentocontratode)."' and '".DataYMD($vencimentocontratoate)."'  ";

	if(!empty($_REQUEST['cod_polo']))
		$sql.=" and l.cod_polo =". $_REQUEST['cod_polo']." ";

	if(!empty($cod_operadora)){
		$sql.=" and l.codlead in (";
		$sql.="  select lo.codlead ";
		$sql.="    from leads_operadoras lo ";
		$sql.="   where lo.cod_operadora = $cod_operadora ";
		$sql.=" ) ";
	}

	if(!empty($codatendente)){
		$sql.= " and l.codatendente = $codatendente ";
	}

	if(!empty($codgerenteconta)){
		$sql.=" and l.codgerenteconta = $codgerenteconta ";
	}
	
	if(!empty($codequipe))
		$sql.=" and tbu.Fk_Equipe=".mysqlnull($codequipe);

	//COLOCA OS DEMAIS PARÂMETROS
	if(!permissao('visualizar_todos_consultores', 'cs'))
		$sql.="   and l.codgerenteconta in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";

	if(!permissao('visualizar_todos_atendentes', 'cs'))
		$sql.="   and l.codatendente in (".equipes::getCodUsuariosEquipe($_SESSION['codusuario']).") ";


	$sql.=" order by l.vencimentocontrato ";

	$result = mysql_query($sql);
	while($row = mysql_fetch_array($result)){

		echo "<tr>";
		echo "<td align='center' class='form'>".$row['n_polo']."</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['consultor']."</td>";
		echo "<td align='center' class='form'>&nbsp;".$row['atendente']."</td>";
		echo "<td align='center' class='form'>".$row['Vc_Nome']."</td>";		
		echo "<td align='center' class='form'>".$row['codlead']."</td>";
		echo "<td align='center' class='form'><a href='../../vendas/leads/leadgerenciamentores.php?codlead=".$row['codlead']."'>".$row['razaosocial']."</a></td>";
		echo "<td align='center' class='form'>&nbsp;".$row['vencimentocontrato']."</td>";
		echo "<td align='center' class='form'>".$row['qtde_linhas']."</td>";

		echo "<td align='center' class='form'>&nbsp;";

		//pesquisa todas as operadoras do lead
		$sql ="";
		$sql.="select o.dsc_operadora ";
		$sql.="  from leads_operadoras lo ";
		$sql.="       inner join operadoras o on o.cod_operadora = lo.cod_operadora ";
		$sql.=" where lo.codlead = ".$row['codlead'];
		$rs_operadora = mysql_query($sql);
		while($row_operadora = mysql_fetch_array($rs_operadora)){
			echo $row_operadora['dsc_operadora']."<br>";
		}
		mysql_free_result($rs_operadora);
		echo "</td>";

		echo "</tr>";

		$total ++;
	}
	mysql_free_result($result);
?>
	<tr>
		<th class="titulo" bgcolor="#8080FF" colspan="9">
			<?= $total;?> registro(s)
		</th>
	</tr>
</table>
</body>
<?
include_once "../../libs/desconectar.php";
?>



